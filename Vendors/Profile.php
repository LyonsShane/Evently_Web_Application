
<?php 
error_reporting(0);
include '../Includes/dbcon.php';
include '../Includes/session.php';

$query = "SELECT * FROM allusers WHERE ID = '$_SESSION[userId]'"; 
$result = $conn->query($query);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $Firstname = $row['Firstname'];
	$Lastname = $row['Lastname'];
	$Email = $row['Email'];
	$Phone = $row['Phone'];
	$Vendortype = $row['Vendortype'];
	$Profilepic = $row['ProfilePic'];
	$Address = !empty($row['Address']) ? $row['Address'] : '-';
	$Postalcode = !empty($row['Postalcode']) ? $row['Postalcode'] : '-';
} 

else {
    
	$Address = "Please Add Your Address";
	$Postalcode = "Please Add Your Postal Code";
}

?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <link href="img/logo/attnlg.png" rel="icon">
<?php include 'includes/title.php';?>
  <link href="../vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css">
  <link href="css/ruang-admin.min.css" rel="stylesheet">


</head>

<body id="page-top">
  <div id="wrapper">
    <!-- Sidebar -->
      <?php include "Includes/sidebar.php";?>
    <!-- Sidebar -->
    <div id="content-wrapper" class="d-flex flex-column">
      <div id="content">
        <!-- TopBar -->
       <?php include "Includes/topbar.php";?>
        <!-- Topbar -->

        <!-- Container Fluid-->
        <div class="container-fluid" id="container-wrapper">
          <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">My Profile</h1>
            <ol class="breadcrumb">
              <li class="breadcrumb-item">Settings</li>
              <li class="breadcrumb-item active" aria-current="page">My profile</li>
            </ol>
          </div>

          <div class="row">
            <div class="col-lg-12">
              <!-- Form Basic -->
              <div class="card mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                  <h6 class="m-0 font-weight-bold text-primary">My Profile Details</h6>
					<a href="Editprofile.php?action=edit&ID=".$rows['ID'].""><button type="submit" name="save" class="btn btn-primary">Edit Profile Details</button></a>
                </div>
				  
                <div class="card-body" align="center">
					<form method="Post" action="">
						
					<div class="form-group row mb-3">
						<div class="col-xl-6" align="left">
                        <label class="form-control-label"><b>Profile Picture</b></label>
						<br>
						<br>
						<img src="<?php echo ($Profilepic) ? $Profilepic : 'img/user-icn.png'; ?>" class="profile-pic">
							<style>
							.profile-pic {
							width: 150px;
							height: 150px;
							border-radius: 50%;
							object-fit: cover;
							border: 2px solid #ddd;
							}
							</style>
                        </div>
						</div>
					  	<br>
					  	<br>
						
                  <div class="form-group row mb-3">
						<div class="col-xl-6" align="left">
                        <label class="form-control-label"><b>First Name</b></label>
						<br>
						<label class="form-control-label"><?php echo $Firstname;?></label>
                        </div>
						<br>
					 	<br>
					  	<br>
					  	<br>
						<div class="col-xl-6" align="left">
                        <label class="form-control-label"><b>Last Name</b></label>
						<br>
                        <label class="form-control-label"><?php echo $Lastname;?></label>
                        </div>
						</div>
						<br>
					<div class="form-group row mb-3">
						<div class="col-xl-6" align="left">
                        <label class="form-control-label"><b>Email</b></label>
						<br>
                        <label class="form-control-label"><?php echo $Email;?></label>
                        </div>
						<br>
					 	<br>
					  	<br>
					  	<br>
						<div class="col-xl-6" align="left">
                        <label class="form-control-label"><b>Phone</b></label>
						<br>
                        <label class="form-control-label"><?php echo $Phone;?></label>
                        </div>
						</div>
						<br>
					<div class="form-group row mb-3">
						<div class="col-xl-6" align="left">
                        <label class="form-control-label"><b>Vendor Type</b></label>
						<br>
                        <label class="form-control-label"><?php echo $Vendortype;?></label>
                        </div>
						<br>
					 	<br>
					  	<br>
					  	<br>
						<div class="col-xl-6" align="left">
                        <label class="form-control-label"><b>Address</b></label>
						<br>
                        <label class="form-control-label"><?php echo $Address;?></label>
                        </div>
						</div>
						<br>
					<div class="form-group row mb-3">
						<div class="col-xl-6" align="left">
                        <label class="form-control-label"><b>Postal Code</b></label>
						<br>
                        <label class="form-control-label"><?php echo $Postalcode;?></label>
                        </div>
						</div>
						
						
					</form>
						
					
					
                  
                </div>
              </div>

          </div>
        </div>
        <!---Container Fluid-->
      </div>
      <!-- Footer -->
       <?php include "Includes/footer.php";?>
      <!-- Footer -->
    </div>
  </div>

  <!-- Scroll to top -->
  <a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
  </a>

  <script src="../vendor/jquery/jquery.min.js"></script>
  <script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="../vendor/jquery-easing/jquery.easing.min.js"></script>
  <script src="js/ruang-admin.min.js"></script>
   <!-- Page level plugins -->
  <script src="../vendor/datatables/jquery.dataTables.min.js"></script>
  <script src="../vendor/datatables/dataTables.bootstrap4.min.js"></script>

  <!-- Page level custom scripts -->
  <script>
    $(document).ready(function () {
      $('#dataTable').DataTable(); // ID From dataTable 
      $('#dataTableHover').DataTable(); // ID From dataTable with Hover
    });
  </script>
</body>

</html>