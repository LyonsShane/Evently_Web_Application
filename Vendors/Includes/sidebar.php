<?php $currentPage = basename($_SERVER['PHP_SELF']); ?>

  <ul class="navbar-nav sidebar sidebar-light accordion" id="accordionSidebar">
      <a class="sidebar-brand d-flex align-items-center bg-gradient-primary justify-content-center" href="index.php">
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
        Manage Packages
      </div>
      </li>
       <li class="nav-item <?= ($currentPage == 'packages.php') ? 'active' : '' ?>">
        <a class="nav-link collapsed" href="packages.php">
          <i class="fa fa-server"></i>
          <span>Packages</span>
        </a>
      </li>
      <li class="nav-item <?= ($currentPage == 'hiredpackagesapprovals.php') ? 'active' : '' ?>">
		   <a class="nav-link collapsed" href="hiredpackagesapprovals.php">
          <i class="fa fa-window-restore"></i>
          <span>Hired Packages Approvals</span>
        </a>
      </li>
      <li class="nav-item <?= ($currentPage == 'Ongoingpackages.php') ? 'active' : '' ?>">
        <a class="nav-link collapsed" href="Ongoingpackages.php">
          <i class="fa fa-spinner"></i>
          <span>Ongoing Packages</span>
        </a>
      </li>
      <li class="nav-item <?= ($currentPage == 'Completedpackages.php') ? 'active' : '' ?>">
        <a class="nav-link collapsed" href="Completedpackages.php">
          <i class="fa fa-check-square"></i>
          <span>Completed Packages</span>
        </a>
      </li>
      <hr class="sidebar-divider">
      <div class="sidebar-heading">
      Settings
      </div>
      </li>
       <li class="nav-item <?= ($currentPage == 'Eventimages.php') ? 'active' : '' ?>">
        <a class="nav-link collapsed" href="Eventimages.php" >
          <i class="fa fa-film"></i>
          <span>Event Images</span>
        </a>
      </li>
       <li class="nav-item <?= ($currentPage == 'Publicprofileview.php') ? 'active' : '' ?>">
		   <a class="nav-link collapsed" href="Publicprofileview.php" >
          <i class="fa fa-id-card"></i>
          <span>My Public Profile</span>
        </a>
      </li>
       <li class="nav-item <?= ($currentPage == 'Myreviews.php') ? 'active' : '' ?>">
        <a class="nav-link collapsed" href="Myreviews.php" >
          <i class="fa fa-star"></i>
          <span>My Reviews</span>
        </a>
      </li>
       <li class="nav-item <?= ($currentPage == 'Profile.php' || $currentPage == 'Editprofile.php') ? 'active' : '' ?>">
		   <a class="nav-link collapsed" href="Profile.php" >
          <i class="fa fa-user-circle"></i>
          <span>My Profile</span>
        </a>
      </li>

     
      <hr class="sidebar-divider">
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