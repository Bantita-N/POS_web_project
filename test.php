<?php
include 'condb.php';

// Fetch top-selling products
$product_sql = "SELECT p.pro_id, p.pro_name, SUM(od.orderQty) AS total_sold 
                FROM product p
                JOIN order_detail od ON p.pro_id = od.pro_id
                GROUP BY p.pro_id
                ORDER BY total_sold DESC
                LIMIT 5";

$product_result = $conn->query($product_sql);
if ($product_result === false) {
    echo "Error fetching top-selling products: " . $conn->error;
    exit();
}

// Fetch top-selling categories
$category_sql = "SELECT t.type_name, SUM(od.orderQty) AS total_sold
                 FROM type t
                 JOIN product p ON t.type_id = p.type_id
                 JOIN order_detail od ON p.pro_id = od.pro_id
                 GROUP BY t.type_id
                 ORDER BY total_sold DESC
                 LIMIT 3";

$category_result = $conn->query($category_sql);
if ($category_result === false) {
    echo "Error fetching top-selling categories: " . $conn->error;
    exit();
}

// Fetch sales of the current month
$current_month_start = date('Y-m-01'); // First day of the current month
$current_month_end = date('Y-m-t'); // Last day of the current month

$sales_sql = "SELECT DATE(o.reg_date) AS date, t.type_name, SUM(od.orderQty) AS total_sales
              FROM tb_order o
              JOIN order_detail od ON o.orderID = od.orderID
              JOIN product p ON od.pro_id = p.pro_id
              JOIN type t ON p.type_id = t.type_id
              WHERE o.reg_date BETWEEN ? AND ? AND o.ordder_status IN ('1', '2')
              GROUP BY DATE(o.reg_date), t.type_name
              ORDER BY DATE(o.reg_date), t.type_name";

$stmt = $conn->prepare($sales_sql);
$stmt->bind_param("ss", $current_month_start, $current_month_end);
$stmt->execute();
$sales_result = $stmt->get_result();
if ($sales_result === false) {
    echo "Error fetching sales data: " . $conn->error;
    exit();
}

// Fetch top 3 customers based on total quantity of products ordered
$customer_sql = "SELECT o.cus_name, COUNT(o.orderID) AS total_orders
                FROM tb_order o
                WHERE o.cus_name != '-'
                GROUP BY o.cus_name
                ORDER BY total_orders DESC
                LIMIT 3";

$customer_result = $conn->query($customer_sql);
if ($customer_result === false) {
    echo "Error fetching top customers: " . $conn->error;
    exit();
}

// Process sales data
$sales_data = array();
$types = array();
while ($row = $sales_result->fetch_assoc()) {
    $date = $row['date'];
    $type_name = $row['type_name'];
    $total_sales = $row['total_sales'];

    if (!isset($sales_data[$date])) {
        $sales_data[$date] = array();
    }
    $sales_data[$date][$type_name] = $total_sales;
    if (!in_array($type_name, $types)) {
        $types[] = $type_name;
    }
}
$stmt->close();

// Generate array of all dates in current month
$all_dates = array();
$start_date = new DateTime($current_month_start);
$end_date = new DateTime($current_month_end);

while ($start_date <= $end_date) {
    $date = $start_date->format('Y-m-d');
    $all_dates[] = $date;
    if (!isset($sales_data[$date])) {
        $sales_data[$date] = array();
    }
    foreach ($types as $type) {
        if (!isset($sales_data[$date][$type])) {
            $sales_data[$date][$type] = 0;
        }
    }
    $start_date->modify('+1 day');
}

// Fetch sales of the current year
$current_year_start = date('Y-01-01'); // First day of the current year
$current_year_end = date('Y-12-31'); // Last day of the current year

$saleses_sql = "SELECT DATE_FORMAT(o.reg_date, '%Y-%m') AS month, SUM(o.total_price) AS total_sales
              FROM tb_order o
              WHERE o.reg_date BETWEEN ? AND ? AND o.ordder_status IN ('1', '2')
              GROUP BY DATE_FORMAT(o.reg_date, '%Y-%m')
              ORDER BY DATE_FORMAT(o.reg_date, '%Y-%m')";

$stmt = $conn->prepare($saleses_sql);
$stmt->bind_param("ss", $current_year_start, $current_year_end);
$stmt->execute();
$saleses_result = $stmt->get_result();
if ($saleses_result === false) {
    echo "Error fetching sales data: " . $conn->error;
    exit();
}

// Process sales data
$saleses_data = array();
while ($row = $saleses_result->fetch_assoc()) {
    $month = $row['month'];
    $total_sales = $row['total_sales'];
    $saleses_data[$month] = $total_sales;
}
$stmt->close();

// Generate array of all months in the current year
$all_months = array();
$start_date = new DateTime($current_year_start);
$end_date = new DateTime($current_year_end);

while ($start_date <= $end_date) {
    $month = $start_date->format('Y-m');
    $all_months[] = $month;
    if (!isset($saleses_data[$month])) {
        $saleses_data[$month] = 0;
    }
    $start_date->modify('+1 month');
}

// Close the database connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Top Selling Products, Categories, and Monthly Sales</title>
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f8f9fa;
            color: #343a40;
        }
        .container {
            max-width: 1250px;
            margin: 20px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
        }
        .content {
            width: 49%;
            margin-bottom: 20px;
        }
        h2 {
            margin-top: 0;
            font-size: 1.5em;
            color: #007bff;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 10px 0;
            background-color: #f8f9fa;
            border-radius: 5px;
            overflow: hidden;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.05);
        }
        th, td {
            padding: 10px;
            border-bottom: 1px solid #dee2e6;
            text-align: left;
        }
        th {
            background-color: #007bff;
            color: #fff;
        }
        tr:hover {
            background-color: #f1f3f5;
        }
        canvas {
            width: 100%;
            border-radius: 5px;
            box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
        }
    </style>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>

<div class="container">
    <div class="content">
        <h2>Top Selling Products</h2>
        <table>
            <tr>
                <th>Product ID</th>
                <th>Product Name</th>
                <th>Total Sold</th>
            </tr>
            <?php while ($product_row = $product_result->fetch_assoc()) { ?>
                <tr>
                    <td><?php echo htmlspecialchars($product_row['pro_id']); ?></td>
                    <td><?php echo htmlspecialchars($product_row['pro_name']); ?></td>
                    <td><?php echo htmlspecialchars($product_row['total_sold']); ?></td>
                </tr>
            <?php } ?>
        </table>
    </div>

    <div class="content">
        <h2>Top Selling Categories</h2>
        <table>
            <tr>
                <th>Category Name</th>
                <th>Total Sold</th>
            </tr>
            <?php while ($category_row = $category_result->fetch_assoc()) { ?>
                <tr>
                    <td><?php echo htmlspecialchars($category_row['type_name']); ?></td>
                    <td><?php echo htmlspecialchars($category_row['total_sold']); ?></td>
                </tr>
            <?php } ?>
        </table>
    </div>

    <div class="content">
        <h2>Top Customers by Total Orders</h2>
        <table>
            <tr>
                <th>Customer Name</th>
                <th>Total Orders</th>
            </tr>
            <?php while ($customer_row = $customer_result->fetch_assoc()) { ?>
                <tr>
                    <td><?php echo htmlspecialchars($customer_row['cus_name']); ?></td>
                    <td><?php echo htmlspecialchars($customer_row['total_orders']); ?></td>
                </tr>
            <?php } ?>
        </table>
    </div>
    <div class="content">
        <h2>Sales of the Current Month</h2>
        <canvas id="salesChartMonth"></canvas>
    </div>
    
    <div class="content">
        <h2>Sales of the Current Year</h2>
        <canvas id="salesChartYear"></canvas>
    </div>


</div>

<script>
var ctxMonth = document.getElementById('salesChartMonth').getContext('2d');

var labelsMonth = <?php echo json_encode($all_dates); ?>;
var datasetsMonth = [];

var colors = [
    'rgba(54, 162, 235, 0.2)', 'rgba(75, 192, 192, 0.2)', 'rgba(255, 206, 86, 0.2)', 
    'rgba(153, 102, 255, 0.2)', 'rgba(255, 159, 64, 0.2)', 'rgba(255, 99, 132, 0.2)'
];
var borderColors = [
    'rgba(54, 162, 235, 1)', 'rgba(75, 192, 192, 1)', 'rgba(255, 206, 86, 1)', 
    'rgba(153, 102, 255, 1)', 'rgba(255, 159, 64, 1)', 'rgba(255, 99, 132, 1)'
];

<?php foreach ($types as $index => $type): ?>
datasetsMonth.push({
    label: <?php echo json_encode($type); ?>,
    data: <?php
        $type_data = array();
        foreach ($all_dates as $date) {
            $type_data[] = $sales_data[$date][$type];
        }
        echo json_encode($type_data);
    ?>,
    backgroundColor: colors[<?php echo $index; ?> % colors.length],
    borderColor: borderColors[<?php echo $index; ?> % borderColors.length],
    borderWidth: 1
});
<?php endforeach; ?>

var salesChartMonth = new Chart(ctxMonth, {
    type: 'bar',
    data: {
        labels: labelsMonth,
        datasets: datasetsMonth
    },
    options: {
        scales: {
            x: {
                title: {
                    display: true,
                    text: 'Date'
                }
            },
            y: {
                title: {
                    display: true,
                    text: 'Total Sales'
                },
                beginAtZero: true,
                max: 6
            }
        }
    }
});

var ctxYear = document.getElementById('salesChartYear').getContext('2d');

var labelsYear = <?php echo json_encode(array_keys($saleses_data)); ?>;
var dataYear = <?php echo json_encode(array_values($saleses_data)); ?>;

var salesChartYear = new Chart(ctxYear, {
    type: 'line',
    data: {
        labels: labelsYear,
        datasets: [{
            label: 'Total Sales',
            data: dataYear,
            backgroundColor: 'rgba(75, 192, 192, 0.2)',
            borderColor: 'rgba(75, 192, 192, 1)',
            borderWidth: 1
        }]
    },
    options: {
        scales: {
            x: {
                title: {
                    display: true,
                    text: 'Month'
                }
            },
            y: {
                title: {
                    display: true,
                    text: 'Total Sales'
                },
                beginAtZero: true
            }
        }
    }
});
</script>

</body>
</html>
