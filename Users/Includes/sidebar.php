<?php $currentPage = basename($_SERVER['PHP_SELF']); ?>

<ul class="navbar-nav sidebar sidebar-light accordion" id="accordionSidebar">
  <a class="sidebar-brand d-flex align-items-center bg-gradient-primary justify-content-center" href="index.php">
    <div class="sidebar-brand-icon">
      <img src="img/logo/attnlg.png">
    </div>
    <div class="sidebar-brand-text mx-3">Evently</div>
  </a>

  <hr class="sidebar-divider my-0">
  <li class="nav-item <?= ($currentPage == 'index.php') ? 'active' : '' ?>">
    <a class="nav-link" href="index.php">
      <i class="fas fa-fw fa-tachometer-alt"></i>
      <span>Dashboard</span>
    </a>
  </li>

  <hr class="sidebar-divider">
  <div class="sidebar-heading">Manage Events</div>

  <li class="nav-item <?= ($currentPage == 'Createevent.php') ? 'active' : '' ?>">
    <a class="nav-link collapsed" href="Createevent.php">
      <i class="fa fa-calendar-alt"></i>
      <span>Create An Event</span>
    </a>
  </li>

  
  <li class="nav-item <?= ($currentPage == 'Myevents.php' || $currentPage == 'Eventview.php' || $currentPage == 'Inviteguests.php' || $currentPage == 'Hirevendors.php' || $currentPage == 'Hirevendorprofile.php') ? 'active' : '' ?>">
    <a class="nav-link collapsed" href="Myevents.php">
      <i class="fa fa-calendar"></i>
      <span>My Events</span>
    </a>
  </li>

  <hr class="sidebar-divider">
  <div class="sidebar-heading">Vendors</div>

  <li class="nav-item <?= ($currentPage == 'AllVendors.php' || $currentPage == 'Vendorprofile.php') ? 'active' : '' ?>">
    <a class="nav-link collapsed" href="AllVendors.php">
      <i class="fas fa-user-tie"></i>
      <span>All vendors</span>
    </a>
  </li>

  <hr class="sidebar-divider">
  <div class="sidebar-heading">Settings</div>

  <li class="nav-item <?= ($currentPage == 'Profile.php' || $currentPage == 'Editprofile.php') ? 'active' : '' ?>">
    <a class="nav-link collapsed" href="Profile.php">
      <i class="fa fa-user-circle"></i>
      <span>My Profile</span>
    </a>
  </li>

  <hr class="sidebar-divider">
</ul>

<style>
  .nav-item.active > .nav-link {
    color: #4C60DA !important; 
  }

  .nav-item.active > .nav-link i {
    color: #4C60DA !important; 
  }
</style>

