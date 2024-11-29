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
            --   เอาทั้งยังไม่จ่ายเงินและจ่ายเงินแล้ว (1,2)  ถ้าเอาจ่ายแล้วก็เอาแค่เลข (2)
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
        table {
            width: 50%;
            border-collapse: collapse;
            margin: 25px 0;
            font-size: 18px;
            text-align: left;
        }
        th, td {
            padding: 12px;
            border-bottom: 1px solid #ddd;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>

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

<h2>Sales of the Current Month</h2>
<canvas id="salesChart"></canvas>


<script>
var ctx = document.getElementById('salesChart').getContext('2d');

var labels = <?php echo json_encode($all_dates); ?>;
var datasets = [];

<?php foreach ($types as $type): ?>
datasets.push({
    label: <?php echo json_encode($type); ?>,
    data: <?php
        $type_data = array();
        foreach ($all_dates as $date) {
            $type_data[] = $sales_data[$date][$type];
        }
        echo json_encode($type_data);
    ?>,
    backgroundColor: 'rgba(54, 162, 235, 0.2)',
    borderColor: 'rgba(54, 162, 235, 1)',
    borderWidth: 1
});
<?php endforeach; ?>

var salesChart = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: labels,
        datasets: datasets
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
                max: 10
            }
        }
    }
});
</script>


</body>
</html>