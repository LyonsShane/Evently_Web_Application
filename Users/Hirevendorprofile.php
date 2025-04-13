
<?php 
error_reporting(0);
include '../Includes/dbcon.php';
include '../Includes/session.php';




if (!isset($_GET['vendorID'], $_GET['eventID'])) {
  die("Missing required parameters.");
}

$vendorId = intval($_GET['vendorID']);
$eventId = intval($_GET['eventID']);
$userId = $_SESSION['userId'];

$query = "SELECT * FROM allusers WHERE ID = '$vendorId' AND Userrole = 'Vendor'"; 
$result = $conn->query($query);

if ($result->num_rows === 0) {
  die("Vendor not found");
}
$vendor = $result->fetch_assoc();

$query = "SELECT * FROM vendorpackages WHERE VendorID = '$vendorId'";
$packages = $conn->query($query);

$query = "SELECT * FROM allusers WHERE ID = '$_SESSION[userId]'"; 
	$result = $conn->query($query);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
	$ProfilePic = $row['ProfilePic'];
} 

else {
    
	$ProfilePic = "img/user-icn.png";
}

$vendorId = isset($_GET['vendorID']) ? intval($_GET['vendorID']) : null;

if (!$vendorId || empty($vendorId)) {
    die("No vendor selected");
}


$query = "SELECT * FROM allusers WHERE ID = '$vendorId' AND Userrole = 'Vendor'"; 

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
	
	$Fullname = $row['Firstname']." ".$row['Lastname'];
} 

else {
    
	die("Vendor not found");
}


// Fetch vendor's overall rating
$queryRating = "SELECT SUM(rating) / COUNT(rating) AS average_rating, COUNT(rating) AS total_reviews FROM vendorreviews WHERE VendorID = '$vendorId'";
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


$query = "SELECT Image FROM eventimages WHERE VendorID = '$vendorId'";
$result = $conn->query($query);



$buttons = '';

                    

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
  <script>
    function sendHireRequest(vendorId, packageId, eventId) {
    if (confirm("Are you sure you want to hire this vendor?")) {
        fetch(`hire_process.php?vendorID=${vendorId}&eventID=${eventId}&packageID=${packageId}`, {
            method: "GET"
        }).then(response => response.text()).then(data => {
            alert(data);
            location.reload();
        });
    }
}

function cancelHireRequest(vendorId, packageId, eventId) {
    if (confirm("Are you sure you want to cancel this request?")) {
        fetch(`cancel_hire.php?vendorID=${vendorId}&eventID=${eventId}&packageID=${packageId}`, {
            method: "GET"
        }).then(response => response.text()).then(data => {
            alert(data);
            location.reload();
        });
    }
}



</script>


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
        <a href="Hirevendors.php?ID=<?php echo $_GET['eventID']; ?>" class="btn btn-cancel">Back</a>


				
            <h1 class="h3 mb-0 text-gray-800">Vendor Profile</h1>
			 
           
          </div>

          <div class="row">
            <div class="col-lg-12">
              <!-- Form Basic -->
              <div class="card mb-4 position-relative">

              <!-- Chat Button -->
  <button class="btn btn-primary position-absolute" 
          style="top: 15px; right: 15px; width: 150px; height: 40px;" 
          onclick="openChat(<?php echo $vendorId; ?>)">
    <i class="fas fa-comments  mr-3"></i> Chat
  </button>
                
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
						<label class="h3 mb-0 text-gray-800"><?php echo $Fullname;?></label>
						<label class="h5 mb-0 text-gray-600"><?php echo $Email;?></label>
						</div>
						</div>
						<br>
						<br>
						<div class="col-xl-8 d-flex flex-row align-items-center form-group row mb-3 justify-content-center" align="left">
          
          <?php 
$query1 = mysqli_query($conn, "SELECT * from vendorpackages where VendorID = '$vendorId'");                       
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
$query1 = mysqli_query($conn, "SELECT * from hiredvendors where VendorID = '$vendorId' And Status = 'Accepted'");                      
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
              <div class="card h-100" onclick="fetchReviews(<?php echo $vendorId; ?>)" style='cursor:pointer;'>
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
            
         
            <!-- Reviews Modal -->
<div class="modal fade" id="reviewsModal" tabindex="-1" role="dialog" aria-labelledby="reviewsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Vendor Reviews</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div id="reviewsContainer" class="reviews-container">
                    <!-- Reviews will be loaded here -->
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .reviews-container {
        max-height: 400px;
        overflow-y: auto;
        padding: 10px;
    }

    .review-card {
        background: #fff;
        padding: 15px;
        border-radius: 10px;
        box-shadow: 0px 2px 4px rgba(0, 0, 0, 0.1);
        margin-bottom: 15px;
        display: flex;
        align-items: flex-start;
        gap: 15px;
    }

    .review-card img {
        width: 50px;
        height: 50px;
        border-radius: 50%;
        object-fit: cover;
        border: 1px solid #ddd;
    }

    .review-details {
        flex: 1;
    }

    .review-stars {
    font-size: 20px;
    display: flex;
    }

    .review-stars .filled {
        color: rgb(255, 196, 0); /* Gold for full stars */
    }

    .review-stars .empty {
        color: #D3D3D3; /* Light gray for empty stars */
    }


    .review-text {
        font-size: 14px;
        color: #333;
    }

    .review-user {
        font-weight: bold;
        color: #007bff;
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
            <div class="row no-gutters align-items-center justify-content-between"> 
						<h1 class="h5 mb-0 text-primary"><b>Packages</b></h1>
            <h6 class="h5 mb-0 text-dark"> (You can send only one package hire request at once for same vendor)</h6>
            </div>
						<br>
							
							<div class="packages-container">
        <?php 
        // Query to fetch all packages for the current vendor
        $query1 = mysqli_query($conn, "SELECT * from vendorpackages where VendorID = '$vendorId'");

        // Check if there are any packages
        if (mysqli_num_rows($query1) > 0) {
            while ($package = mysqli_fetch_assoc($query1)) {
              $packageID = $package['ID'];
              $hireCheckQuery = "SELECT * FROM hiredvendors WHERE VendorID = '$vendorId' AND EventID = '$eventId' AND PackageID = '$packageID'";
              $hireCheckResult = mysqli_query($conn, $hireCheckQuery);
              $isHired = (mysqli_num_rows($hireCheckResult) > 0);
        ?>
            <div class="package-card">
    <div class="card h-100">
        <div class="card-body d-flex flex-column">
            <div class="row">
                <div class="col-md-4 mb-2">
                    <div class="text-s font-weight-bold text-gray-dark mb-1">Package Name</div>
                    <div class="h6 mb-0 text-gray-800"><?php echo htmlspecialchars($package['Packagename']); ?></div>
                </div>

                <div class="col-md-4 mb-2">
                    <div class="text-s font-weight-bold text-gray-dark mb-1">Package Type</div>
                    <div class="h6 mb-0 text-gray-800"><?php echo htmlspecialchars($package['Packagetype']); ?></div>
                </div>

                <div class="col-md-4 mb-2">
                    <div class="text-s font-weight-bold text-gray-dark mb-1">Package Price</div>
                    <div class="h6 mb-0 text-gray-800">LKR <?php echo htmlspecialchars($package['Amount']); ?></div>
                </div>
            </div>

            <br>

            <div class="row">
                <div class="col-md-12 mb-2">
                    <div class="text-s font-weight-bold text-gray-dark mb-1">Details</div>
                    <div class="h6 mb-0 text-gray-800"><?php echo htmlspecialchars($package['Details']); ?></div>
                </div>
            </div>

            <!-- Button: Show 'Hire' or 'Cancel Request' based on the hired status -->
            <div class="mt-auto d-flex justify-content-end">
                   
                    <?php
                      $cehck_hire_query = "SELECT * FROM hiredvendors WHERE VendorID = '$vendorId' AND EventID = '$eventId' AND Status = 'Pending' ";
                      $cehck_hire_result = mysqli_query($conn, $cehck_hire_query);
                      if (mysqli_num_rows($cehck_hire_result) > 0) {
                        if (isset($isHired)) {
                          if ($isHired) {
                            echo '<button class="btn btn-danger" id="cancel-btn-'.$package['ID'].'" onclick="cancelHireRequest('.$vendorId.', '.$package['ID'].', '.$eventId.')">Cancel Request</button>';
                          }
                        }
                      }else{
                        $cehck_hire_query = "SELECT * FROM hiredvendors WHERE VendorID = '$vendorId' AND EventID = '$eventId' AND Status = 'Accepted' ";
                        $cehck_hire_result = mysqli_query($conn, $cehck_hire_query);
                        if (mysqli_num_rows($cehck_hire_result) > 0) {
                          if (isset($isHired)) {
                            if ($isHired) {
                              echo '<label class="text-success"><b>Hired</b></label>';                            }
                          }
                        }else{
                          $cehck_hire_query = "SELECT * FROM hiredvendors WHERE VendorID = '$vendorId' AND EventID = '$eventId' AND Status = 'Completed' ";
                          $cehck_hire_result = mysqli_query($conn, $cehck_hire_query);
                          if (mysqli_num_rows($cehck_hire_result) > 0) {
                            if (isset($isHired)) {
                              if ($isHired) {
                                echo '<label class="text-success"><b>Completed</b></label>';                           
                               }
                            }
                              
                          }else{
                            echo '<button class="btn btn-primary" id="hire-btn-'.$package['ID'].'" onclick="sendHireRequest('.$vendorId.', '.$package['ID'].', '.$eventId.')">Send Hire Request</button>';
                          }
                        }
                      }
                      
                      
                    ?>
            </div>
        </div>
    </div>
</div>



        <?php 
            }
        } else {
            // end while loop
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
          display: flex;
    flex-direction: column;
    width: 100%;
        }

        .button-container {
            position: absolute;
            bottom: 10px;
            right: 10px;
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
            .mt-auto {
        justify-content: center !important; /* Center button on small screens */
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

<script>
    function fetchReviews(vendorId) {
        $.ajax({
            url: "fetch_reviews.php",
            type: "POST",
            data: { VendorID: vendorId },
            success: function (response) {
                $("#reviewsContainer").html(response);
                $("#reviewsModal").modal("show");
            }
        });
    }
</script>

<script>
  function openChat(vendorId) {
    // Redirect to chat page or open modal (customize as needed)
    window.location.href = "chat_with_vendor.php?ID=" + vendorId;
  }
</script>

</body>

</html>