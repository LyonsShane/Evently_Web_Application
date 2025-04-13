
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
	$Address = $row['Address'];
	$Postalcode = $row['Postalcode'];
	
	$fullName = $rows['Firstname']." ".$rows['Lastname'];;
} 

else {
    
	$Address = "Please Add Your Address";
	$Postalcode = "Please Add Your Postal Code";
}

// Fetch vendor's overall rating
$queryRating = "SELECT SUM(rating) / COUNT(rating) AS average_rating, COUNT(rating) AS total_reviews FROM vendorreviews WHERE VendorID = '$_SESSION[userId]'";
$resultRating = $conn->query($queryRating);
$rowRating = $resultRating->fetch_assoc();
$averageRating = $rowRating['average_rating'] ? number_format($rowRating['average_rating'], 1) : "No Ratings";
$totalReviews = $rowRating['total_reviews'];

// Generate star ratings visually
function generateStars($rating) {
  $fullStars = floor($rating);
  $halfStar = ($rating - $fullStars) >= 0.5 ? 1 : 0;
  $emptyStars = 5 - ($fullStars + $halfStar);

  // Adding the CSS classes for filled and empty stars
  $stars = str_repeat('<span class="filled">★</span>', $fullStars) . 
           ($halfStar ? '<span class="filled">⯪</span>' : '') . 
           str_repeat('<span class="empty">★</span>', $emptyStars);

  return $stars;
}


// Fetch event images
$query = "SELECT Image FROM eventimages WHERE VendorID = '$_SESSION[userId]'";
$result = $conn->query($query);


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
            <h1 class="h3 mb-0 text-gray-800">My Public Profile</h1>
            <ol class="breadcrumb">
              <li class="breadcrumb-item">Settings</li>
              <li class="breadcrumb-item active" aria-current="page">My Public Profile</li>
            </ol>
          </div>

          <div class="row">
            <div class="col-lg-12">
              <!-- Form Basic -->
              <div class="card mb-4">
                
                <div class="card-body" align="center">
						
					<div class="form-group row mb-3 d-flex flex-row align-items-center flex-column gap-2">
						
                        <div class="col-xl-6 flex-column gap-2" align="center">
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
                        
						<br>
							<br>
						<div class="col-xl-6 d-flex flex-column gap-2" align="center">
						<label class="h3 mb-0 text-gray-800"><?php echo $fullName;?></label>
						<label class="h5 mb-0 text-gray-600"><?php echo $Email;?></label>
						</div>
						</div>
						<br>
						<br>
						<div class="col-xl-8 d-flex flex-row align-items-center form-group row mb-3 justify-content-center" align="left">
          
          <?php 
$query1=mysqli_query($conn,"SELECT * from vendorpackages where VendorID = '$_SESSION[userId]'");                       
$packages = mysqli_num_rows($query1);
?>
            <div class="col-xl-4 col-md-5 mb-4">
              <div class="card h-100">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-uppercase mb-1">Total Packages</div>
                      <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800"><?php echo $packages;?></div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
           
             <?php 
$query1=mysqli_query($conn,"SELECT * from hiredvendors where VendorID = '$_SESSION[userId]' And Status = 'Accepted'");                       
$Eventshired = mysqli_num_rows($query1);
?>
            <div class="col-xl-4 col-md-5 mb-4">
              <div class="card h-100">
                <div class="card-body">
                  <div class="row align-items-center">
                    <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-uppercase mb-1">Events Completed</div>
                      <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $Eventshired;?></div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
			  
            
            <div class="col-xl-4 col-md-5 mb-4">
              <div class="card h-100">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-uppercase mb-1">Overall Rating</div>
                      <div class="d-flex align-items-center justify-content-between ">
                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $averageRating . " / 5"; ?></div>
                        <div class="d-flex align-items-center SR">
                      <span class="stars"> 
                      <?php echo generateStars($averageRating); ?> 
                    </span>
                    <small>(<?php echo $totalReviews; ?>)</small>
                </div>
            </div>

        </div>
      </div>
    </div>
  </div>
</div>

            <style>
            .stars {
                  font-size: 25px;
                  line-height: 10px;
                  margin-right: 8px
              }

              .stars .filled {
                  color:rgb(255, 196, 0); /* Gold for full stars */
              }

              .stars .empty {
                  color: #D3D3D3; /* Light gray for empty stars */
              }

          </style>
         
          
          <!--Row-->


        </div>
						</div>
					  	<br>
					  	<br>
						
                  <div class="form-group row mb-3">
						<div class="col-xl-6" align="left">
						<h1 class="h5 mb-0 text-primary"><b>Vendor Details</b></h1>
						<br>
						<label class="form-control-label"><b>Vendor type</b></label>
						<br>
                        <label class="form-control-label"><?php echo $Vendortype;?></label>
						<br>
						<br>
						<label class="form-control-label"><b>Phone</b></label>
						<br>
                        <label class="form-control-label"><?php echo $Phone;?></label>
						<br>
						<br>
						<label class="form-control-label"><b>Address</b></label>
						<br>
                        <label class="form-control-label"><?php echo $Address;?></label>
						<br>
						<br>
					    <br>
						<br>	
                        </div>
					    
					  <div class="col-xl-6" align="left">
						  
						<h1 class="h5 mb-0 text-primary"><b>Previous Works</b></h1>
						<br>
						
						<div class="gallery" align="left">
							<?php 
								if ($result->num_rows > 0) {
									while ($row = $result->fetch_assoc()) { ?>
										<img src="<?php echo $row['Image']; ?>" alt="Gallery Image">
									<?php } 
								} else { ?>
									<div class="no-images">No images available</div>
								<?php } ?>
						</div>
						<style>
							.gallery {
								display: flex;
								flex-wrap: wrap;
								gap: 10px;
								justify-content: flex-start;
								align-items: flex-start;
								max-width: 100%;
								margin: 0;
							}
							.gallery img {
								width: calc(33.333% - 10px); /* 3 images per row with gap */
								height: 150px;
								object-fit: cover;
								border-radius: 10px;
								border: 2px solid #ddd;
								margin-bottom: 10px;
							}
							
							.no-images {
								width: 100%;
								text-align: center;
								color: #6c757d;
								padding: 20px;
								border: 1px solid #ddd;
								border-radius: 10px;
							}

							/* Responsive adjustments */
							@media (max-width: 768px) {
								.gallery img {
									width: calc(50% - 10px); /* 2 images per row on smaller screens */
								}
							}

							@media (max-width: 480px) {
								.gallery img {
									width: 100%; /* Single column on very small screens */
								}
							}
						</style>
                        </div>
						
						</div>
						<br>
						<br>
					    <br>
						
						<div class="col-xl-12" align="left">
						  
						<h1 class="h5 mb-0 text-primary"><b>Packages</b></h1>
						<br>
							
							<div class="packages-container">
        <?php 
        // Query to fetch all packages for the current vendor
        $packageQuery = mysqli_query($conn, "SELECT * FROM vendorpackages WHERE VendorID = '$_SESSION[userId]'");

        // Check if there are any packages
        if (mysqli_num_rows($packageQuery) > 0) {
            while ($package = mysqli_fetch_assoc($packageQuery)) {
        ?>
            <div class="package-card">
                <div class="card h-100">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col-md-4 mb-2">
                                <div class="text-s font-weight-bold  text-gray-dark mb-1">Package Name</div>
                                <div class="h6 mb-0  text-gray-800"><?php echo htmlspecialchars($package['Packagename']); ?></div>
                            </div>
							<br>
                            <div class="col-md-4 mb-2">
                                <div class="text-s font-weight-bold  text-gray-dark mb-1">Package Type</div>
                                <div class="h6 mb-0  text-gray-800"><?php echo htmlspecialchars($package['Packagetype']); ?></div>
                            </div>
							<br>
                            <div class="col-md-4 mb-2">
                                <div class="text-s font-weight-bold  text-gray-dark mb-1">Package Price</div>
                                <div class="h6 mb-0  text-gray-800">LKR <?php echo htmlspecialchars($package['Amount']); ?></div>
                            </div>
                        </div>
						<br>
						<div class="row no-gutters align-items-center">
						<div class="col-md-12 mb-2">
                                <div class="text-s font-weight-bold  text-gray-dark mb-1">Details</div>
                                <div class="h6 mb-0  text-gray-800"><?php echo htmlspecialchars($package['Details']); ?></div>
                            </div>
						</div>
                    </div>
                </div>
            </div>
        <?php 
            }
        } else {
            // Display a message if no packages are found
        ?>
            <div class="package-card">
                <div class="card h-100">
                    <div class="card-body">
                        <div class="text-center text-muted">No packages available</div>
                    </div>
                </div>
            </div>
        <?php 
        } 
        ?>
    </div>
    
    <style>
        .packages-container {
            display: flex;
            flex-direction: column;
            gap: 20px; /* Adds space between package cards */
            width: 100%;
        }
        
        .package-card {
            width: 100%;
        }
        
        .package-card .card-body {
            padding: 1rem;
        }
        
        @media (max-width: 768px) {
            .package-card .row {
                flex-direction: column;
            }
            
            .package-card .col-md-4 {
                margin-bottom: 10px;
                text-align: left;
            }
        }
    </style>
</div>
						
                        </div>
					
					
                  
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