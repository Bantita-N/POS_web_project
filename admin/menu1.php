<!-- Page Wrapper -->
<div id="wrapper">

<!-- Sidebar -->
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
        <div class="sidebar-brand-icon rotate-n-15">
            <i class="fas fa-laugh-wink"></i>
        </div>
        <div class="sidebar-brand-text mx-3">DATABASE </div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item active">
        <a class="nav-link" href="index.php">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>หน้าหลัก</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        ระบบคลังสินค้า
    </div>

    <li class="nav-item">
    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseSale" aria-expanded="true" aria-controls="collapseSale">
        <i class="fas fa-fw fa-folder"></i>
        <span>ตรวจสอบSTOCK</span>
    </a>
    <div id="collapseSale" class="collapse" aria-labelledby="headingSale" data-parent="#accordionSidebar">
        <div class="bg-white py-2 collapse-inner rounded">
            <a class="collapse-item" href="report_product.php">สินค้าคงเหลือ</a>
            <div class="collapse-divider"></div>
            <a class="collapse-item" href="add_product.php">แก้ไขสินค้า</a>
            <div class="collapse-divider"></div>
        </div>
    </div>
</li>
    
    <!-- Divider -->
    <hr class="sidebar-divider">

     <!-- Heading -->
<div class="sidebar-heading">
    ระบบขาย
</div>

<li class="nav-item">
    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseOrderSystem" aria-expanded="true" aria-controls="collapseOrderSystem">
        <i class="fas fa-fw fa-folder"></i>
        <span>ออเดอร์</span>
    </a>
    <div id="collapseOrderSystem" class="collapse" aria-labelledby="headingOrderSystem" data-parent="#accordionSidebar">
        <div class="bg-white py-2 collapse-inner rounded">
            <a class="collapse-item" href="report_order.php">การสั่งซื้อสินค้า</a>
            <div class="collapse-divider"></div>
        </div>
    </div>
</li>

<!-- Divider -->
<hr class="sidebar-divider">

<!-- Heading -->
<div class="sidebar-heading">
    ระบบบัญชี
</div>

<li class="nav-item">
    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseAccountingSystem" aria-expanded="true" aria-controls="collapseAccountingSystem">
        <i class="fas fa-fw fa-folder"></i>
        <span>ตรวจสอบสถานะ</span>
    </a>
    <div id="collapseAccountingSystem" class="collapse" aria-labelledby="headingAccountingSystem" data-parent="#accordionSidebar">
        <div class="bg-white py-2 collapse-inner rounded">
            <a class="collapse-item" href="fb_order.php">ตรวจสอบยอดชำระ</a>
            <div class="collapse-divider"></div>
            <a class="collapse-item" href="fb_order2.php">ตรวจสอบใบเสร็จ</a>
            <div class="collapse-divider"></div>
        </div>
    </div>
</li>

<!-- Divider -->
<hr class="sidebar-divider">

<!-- Heading -->
<div class="sidebar-heading">
    ระบบฐานข้อมูล
</div>

   <!-- Nav Item - Pages members Menu -->
<li class="nav-item">
    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseMember" aria-expanded="true" aria-controls="collapseMember">
        <i class="fas fa-fw fa-folder"></i>
        <span>Members</span>
    </a>
    <div id="collapseMember" class="collapse" aria-labelledby="headingMember" data-parent="#accordionSidebar">
        <div class="bg-white py-2 collapse-inner rounded">
            <!--<a class="collapse-item" href="report_user.php">User</a>-->
            <a class="collapse-item" href="report_stock.php">Stock</a>
            <a class="collapse-item" href="report_seller.php">Seller</a>
            <a class="collapse-item" href="Check member.php">Check member</a>
            <div class="collapse-divider"></div>
        </div>
    </div>
</li>


    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>


</ul>
<!-- End of Sidebar -->