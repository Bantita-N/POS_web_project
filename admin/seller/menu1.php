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
        ระบบขาย
    </div>

    <li class="nav-item">
    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseOrder" aria-expanded="true" aria-controls="collapseOrder">
        <i class="fas fa-fw fa-folder"></i>
        <span>ออเดอร์</span>
    </a>
    <div id="collapseOrder" class="collapse" aria-labelledby="headingOrder" data-parent="#accordionSidebar">
        <div class="bg-white py-2 collapse-inner rounded">
            <a class="collapse-item" href="report_order.php">ออเดอร์ที่สั่ง</a>
            <div class="collapse-divider"></div>
        </div>
    </div>
</li>

<!-- Divider -->
<hr class="sidebar-divider">

<!-- Heading -->
<div class="sidebar-heading">
    ระบบคลังสินค้า
</div>

<li class="nav-item">
    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseStock" aria-expanded="true" aria-controls="collapseStock">
        <i class="fas fa-fw fa-folder"></i>
        <span>ตรวจสอบSTOCK</span>
    </a>
    <div id="collapseStock" class="collapse" aria-labelledby="headingStock" data-parent="#accordionSidebar">
        <div class="bg-white py-2 collapse-inner rounded">
            <a class="collapse-item" href="report_product.php">สินค้าคงเหลือ</a>
            <div class="collapse-divider"></div>
        </div>
    </div>
</li>

    
    <!-- Divider -->
    <hr class="sidebar-divider">

     <!-- Heading -->
<div class="sidebar-heading">
    ระบบแก้ไขสถานะ
</div>

<li class="nav-item">
    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseOrderSystem" aria-expanded="true" aria-controls="collapseOrderSystem">
        <i class="fas fa-fw fa-folder"></i>
        <span>แก้ไขสถานะสั่งซื้อ</span>
    </a>
    <div id="collapseOrderSystem" class="collapse" aria-labelledby="headingOrderSystem" data-parent="#accordionSidebar">
        <div class="bg-white py-2 collapse-inner rounded">
            <a class="collapse-item" href="fb_order.php">แก้ไขสถานะ</a>
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

<li class="nav-item">
    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseDatabaseSystem" aria-expanded="true" aria-controls="collapseDatabaseSystem">
        <i class="fas fa-fw fa-folder"></i>
        <span>Member</span>
    </a>
    <div id="collapseDatabaseSystem" class="collapse" aria-labelledby="headingDatabaseSystem" data-parent="#accordionSidebar">
        <div class="bg-white py-2 collapse-inner rounded">
            <a class="collapse-item" href="report_seller.php">Seller</a>
            <a class="collapse-item" href="Check member.php">Check member</a>
            <div class="collapse-divider"></div>
        </div>
    </div>
</li>

</li>
    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>


</ul>
<!-- End of Sidebar -->