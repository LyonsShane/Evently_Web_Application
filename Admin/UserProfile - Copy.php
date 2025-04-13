
<?php 
error_reporting(0);
include '../Includes/dbcon.php';
include '../Includes/session.php';

$userId = isset($_GET['ID']) ? $_GET['ID'] : null;

// Check if a valid user ID is provided
if (!$userId) {
    die("No user selected");
}

$query = "SELECT * FROM allusers WHERE ID = '$userId'"; 
$result = $conn->query($query);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $Firstname = $row['Firstname'];
    $Lastname = $row['Lastname'];
    $Email = $row['Email'];
    $Phone = $row['Phone'];
    $Profilepic = $row['ProfilePic'];
    $Address = !empty($row['Address']) ? $row['Address'] : '-';
	  $Postalcode = !empty($row['Postalcode']) ? $row['Postalcode'] : '-';
} 

else {
    
	die("user not found");
}

// Fetch user reports
$reportQuery = "SELECT r.*, u.Firstname AS VendorFirstname, u.Lastname AS VendorLastname, u.ProfilePic AS VendorProfilePic 
                FROM userreports r 
                JOIN allusers u ON r.VendorID = u.ID 
                WHERE r.UserID = '$userId' 
                ORDER BY r.AddedDate DESC";
$reportResult = $conn->query($reportQuery);
$reportCount = $reportResult->num_rows;

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
  <style>
    .profile-pic {
      width: 150px;
      height: 150px;
      border-radius: 50%;
      object-fit: cover;
      border: 2px solid #ddd ;
    }
    .report-card {
      display: flex;
      align-items: flex-start;
      background: #fff;
      padding: 15px;
      border-radius: 10px;
      box-shadow: 0px 2px 4px rgba(0, 0, 0, 0.2);
      margin-bottom: 15px;
    }
    .report-card img {
      width: 50px;
      height: 50px;
      border-radius: 50%;
      object-fit: cover;
      margin-right: 15px;
    }
  </style>

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
        <div class="col-xl-12 d-flex flex-row align-items-center form-group row mb-3 justify-content-between" align="left">
			<a href="javascript:history.back();"><button type="submit" name="save" class="btn btn-cancel">Back</button></a>
				
            <h1 class="h3 mb-0 text-gray-800">User Profile</h1>
			 
           
          </div>

          <div class="row">
            <div class="col-lg-12">
              <!-- Form Basic -->
              <div class="card mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary"><?php echo $Firstname; ?>'s Profile Details</h6>
                </div>
                <div class="card-body" align="center">
					<form method="Post" action="">
						
					<div class="form-group row mb-3">
						<div class="col-xl-6" align="left">
                        <label class="form-control-label"><b>Profile Picture</b></label>
						<br>
						<br>
            <img src="<?php echo ($Profilepic && file_exists($Profilepic)) ? $Profilepic : 'img/user-icn.png'; ?>" class="profile-pic">
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
                        <label class="form-control-label"><b>Address</b></label>
						<br>
                        <label class="form-control-label"><?php echo $Address;?></label>
                        </div>
						<br>
					 	<br>
					  	<br>
					  	<br>
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

        <!-- Reports Section -->
        <div class="row">
            <div class="col-lg-12">
              <div class="card mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                  <h6 class="m-0 font-weight-bold text-primary">Reports (<?php echo $reportCount; ?>)</h6>
                </div>
                <div class="card-body">
                  <?php if ($reportResult->num_rows > 0) { ?>
                    <?php while ($report = $reportResult->fetch_assoc()) { ?>
                      <div class="report-card">
                        <img src="<?php echo ($report['VendorProfilePic'] && file_exists($report['VendorProfilePic'])) ? $report['VendorProfilePic'] : 'img/user-icn.png'; ?>">
                        <div>
                          <h6><?php echo $report['VendorFirstname'] . ' ' . $report['VendorLastname']; ?></h6>
                          <p><strong>Reason:</strong> <?php echo $report['Reason']; ?></p>
                          <p><small><strong>Added Date:</strong> <?php echo $report['AddedDate']; ?></small></p>
                        </div>
                      </div>
                    <?php } ?>
                  <?php } else { ?>
                    <p>No reports found.</p>
                  <?php } ?>
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