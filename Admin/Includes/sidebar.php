<?php $currentPage = basename($_SERVER['PHP_SELF']); ?>

 <ul class="navbar-nav sidebar sidebar-light accordion " id="accordionSidebar">
      <a class="sidebar-brand d-flex align-items-center bg-gradient-primary  justify-content-center" href="index.php">
        <div class="sidebar-brand-icon" >
          <img src="img/logo/attnlg.png">
        </div>
        <div class="sidebar-brand-text mx-3">Evently</div>
      </a>
      <hr class="sidebar-divider my-0">
      <li class="nav-item <?= ($currentPage == 'index.php') ? 'active' : '' ?>">
        <a class="nav-link" href="index.php">
          <i class="fas fa-fw fa-tachometer-alt"></i>
          <span>Dashboard</span></a>
      </li>
	 
	 <hr class="sidebar-divider">
      <div class="sidebar-heading">
        Manage Events
      </div>
      <li class="nav-item <?= ($currentPage == 'AllEvents.php' || $currentPage == 'Eventview.php') ? 'active' : '' ?>">
        <a class="nav-link collapsed" href="AllEvents.php" >
          <i class="fa fa-calendar"></i>
          <span>Events</span>
        </a>
      </li>
	 <li class="nav-item <?= ($currentPage == 'HiredVendors.php') ? 'active' : '' ?>">
        <a class="nav-link collapsed" href="HiredVendors.php" >
          <i class="fa fa-address-card"></i>
          <span>Hired Vendors</span>
        </a>
      </li>
	 
      <hr class="sidebar-divider">
      <div class="sidebar-heading">
        Manage Users
      </div>
      <li class="nav-item <?= ($currentPage == 'AllUsers.php'|| $currentPage == 'UserProfile.php') ? 'active' : '' ?>">
        <a class="nav-link collapsed" href="AllUsers.php" >
          <i class="fas fa-user"></i>
          <span>Users</span>
        </a>
      </li>
	 <li class="nav-item <?= ($currentPage == 'AllVendors.php' || $currentPage == 'Vendorprofile.php') ? 'active' : '' ?>">
        <a class="nav-link collapsed" href="AllVendors.php" >
          <i class="fas fa-user-tie"></i>
          <span>Vendors</span>
        </a>
      </li>
	 
      
    </ul>

    <style>
  .nav-item.active > .nav-link {
    color: #4C60DA !important; 
    font-weight: 600;
  }

  .nav-item.active > .nav-link i {
    color: #4C60DA !important;
  }
</style>