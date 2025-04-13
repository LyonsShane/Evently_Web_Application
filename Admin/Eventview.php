
<?php 
error_reporting(0);
include '../Includes/dbcon.php';
include '../Includes/session.php';

$query = "SELECT * FROM allusers WHERE ID = '$_SESSION[userId]'"; 
	$result = $conn->query($query);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
	  $ProfilePic = $row['ProfilePic'];
} 

else {
    
	$ProfilePic = "img/user-icn.png";
}

$userId = $_SESSION['userId'];

$eventId = isset($_GET['ID']) ? $_GET['ID'] : null;

// Check if a valid event ID is provided
if (!$eventId) {
    die("No event selected");
}

$query = "SELECT * FROM events WHERE ID = '$eventId'"; 
$result = $conn->query($query);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $Eventname = $row['Eventname'];
    $Eventtype = $row['Eventtype'];
    $EventDate = $row['EventDate'];
    $EventTime = $row['EventTime'];
    $Location = $row['Location'];
    $Description = $row['Description'];
    $EventCreated = $row['EventCreated'];
} 

else {
    
	die("Event not found");
}

$query1 = $conn->prepare("
    SELECT hv.*, au.Firstname, au.Lastname, au.Vendortype, au.ProfilePic
    FROM hiredvendors hv
    JOIN allusers au ON hv.VendorID = au.ID
    WHERE hv.EventID = ?
");
$query1->bind_param("i", $eventId);
$query1->execute();
$result1 = $query1->get_result();



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
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>


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
			<a href="AllEvents.php"><button type="submit" name="save" class="btn btn-cancel">Back</button></a>
				
            <h1 class="h3 mb-0 text-gray-800">Event View</h1>
			 
           
          </div>

          <div class="row">
            <div class="col-lg-12">
              <!-- Form Basic -->
              <div class="card mb-4">
                
                <div class="card-body" align="center">
						
					        
						
                  <div class="form-group row mb-3">
						<div class="col-xl-12" align="left">
            <div class=" d-flex flex-row align-items-center justify-content-between">
						<h1 class="h5 mb-0 text-primary"><b>Event Details</b></h1>

                        <div>
                        <label class="form-control-label"><b>Event Created By</b></label>
                        <br>
                            <?php
                            // Fetch event details, including the UserID of the creator
                            $query = "SELECT * FROM events WHERE ID = '$eventId'"; 
                            $result = $conn->query($query);

                            if ($result->num_rows > 0) {
                                $row = $result->fetch_assoc();
                                $Eventname = $row['Eventname'];
                                $Eventtype = $row['Eventtype'];
                                $EventDate = $row['EventDate'];
                                $EventTime = $row['EventTime'];
                                $Location = $row['Location'];
                                $Description = $row['Description'];
                                $EventCreated = $row['UserID']; // Get the event creator's UserID
                            } else {
                                die("Event not found");
                            }

                            // Fetch event creator details from allusers table
                            $queryCreator = "SELECT ID, Firstname, Lastname, ProfilePic FROM allusers WHERE ID = '$EventCreated'";
                            $resultCreator = $conn->query($queryCreator);

                            if ($resultCreator->num_rows > 0) {
                                $creator = $resultCreator->fetch_assoc();
                                $creatorUserID = $creator['ID'];
                                $creatorFullName = htmlspecialchars($creator['Firstname'] . " " . $creator['Lastname']);
                                $creatorProfilePic = !empty($creator['ProfilePic']) ? htmlspecialchars($creator['ProfilePic']) : "img/user-icn.png";
                            } else {
                                $creatorUserID = "Unknown"; 
                                $creatorFullName = "Unknown User";
                                $creatorProfilePic = "img/user-icn.png";
                            }

                            ?>
                        <div class="row no-gutters align-items-center">
                                <img src="<?php echo $creatorProfilePic; ?>" class="profile-pic">
                                <style>
                                  .profile-pic {
                                  width: 40px;
                                  height: 40px;
                                  border-radius: 50%;
                                  object-fit: cover;
                                  border: 2px solid #ddd;
                                  margin-right: 10px;
                                  }
                                  </style>
                                  
                                  <a href="UserProfile.php?ID=<?php echo $creatorUserID; ?>">
                                        <div class="h6 mb-0 text-gray-800"><?php echo $creatorFullName; ?></div>
                                    </a>

                                </div>
            <!-- <div>
    <a href="Inviteguests.php?ID=<?php echo $eventId; ?>" class="btn btn-success">Invite Guests</a>
    <a href="Hirevendors.php?ID=<?php echo $eventId; ?>" class="btn btn-primary">Hire Vendors</a>
</div> -->
                                </div>
          </div>
            <br>
            
            <div class="row no-gutters align-items-center">
            <div class="col-md-2 mb-2">
						<label class="form-control-label"><b>Event Name</b></label>
						<br>
                        <label class="form-control-label"><?php echo $Eventname;?></label>
                        </div>
						<br>
						<br>
            <div class="col-md-2 mb-2">
						<label class="form-control-label"><b>Event Type</b></label>
						<br>
                        <label class="form-control-label"><?php echo $Eventtype;?></label>
                        </div>
						<br>
						<br>
            <div class="col-md-2 mb-2">
						<label class="form-control-label"><b>Event Date</b></label>
						<br>
                        <label class="form-control-label"><?php echo $EventDate;?></label>
                        </div>
						<br>
						<br>
            <div class="col-md-2 mb-2">
            <label class="form-control-label"><b>Event Time</b></label>
						<br>
                        <label class="form-control-label"><?php echo $EventTime;?></label>
                        </div>
                        <br>
						<br>
            <div class="col-md-2 mb-2">
            <label class="form-control-label"><b>Location</b></label>
						<br>
                        <label class="form-control-label"><?php echo $Location;?></label>
                        </div>
                        
                      
            </div>
            <br>
            <div class="row no-gutters align-items-center">
            <div class="col-md-12 mb-2">
						<label class="form-control-label"><b>Description</b></label>
						<br>
                        <label class="form-control-label"><?php echo $Description;?></label>
                        </div>
            </div>
				<br>
				<br>	
                        </div>
					    
					 
						
						
						<div class="col-xl-12" align="left">
            <div class=" d-flex flex-row align-items-center justify-content-between">
						<h1 class="h5 mb-0 text-primary"><b>Hired Vendors</b></h1> 
            <?php 
$query1=mysqli_query($conn,"SELECT SUM(Packageamount) AS total_amount FROM hiredvendors where EventID = '$eventId' AND Status = 'Accepted'");                       
$row = mysqli_fetch_assoc($query1);
$totalamount = $row['total_amount'];
?>
						<h1 class="h5 mb-0 text-primary"><b>Total Budget (LKR <?php echo $totalamount;?>)</b></h1>
            </div>
						<br>
							
							<div class="packages-container">
              <?php if ($result1->num_rows > 0) { 
                      while ($package = $result1->fetch_assoc()) { ?>
            <div class="package-card">
                <div class="card h-100 position-relative">
                    <div class="card-body">
                    <div class="row no-gutters align-items-center">
                            <div class="col-md-3 mb-2">
                                <div class="text-s font-weight-bold  text-gray-dark mb-1">Vendor Name</div>
                                <div class="row no-gutters align-items-center">
                                <img src="<?php echo !empty($package['ProfilePic']) ? htmlspecialchars($package['ProfilePic']) : 'img/user-icn.png'; ?>" class="profile-pic">
                                <style>
                                  .profile-pic {
                                  width: 40px;
                                  height: 40px;
                                  border-radius: 50%;
                                  object-fit: cover;
                                  border: 2px solid #ddd;
                                  margin-right: 10px;
                                  }
                                  </style>
                                  
                                <div class="h6 mb-0 text-gray-800"><?php echo htmlspecialchars($package['Firstname'] . " " . $package['Lastname']); ?></div>
                                </div>
                              </div>
							<br>
                            <div class="col-md-3 mb-2">
                                <div class="text-s font-weight-bold  text-gray-dark mb-1">Vendor Type</div>
                                <div class="h6 mb-0 text-gray-800"><?php echo htmlspecialchars($package['Vendortype']); ?></div>
                                </div>
            </div>
            <div class="position-absolute top-0 end-0 mt-2 me-3">
            <span class="text-s font-weight-bold text-primary addReview" 
      data-vendorid="<?php echo $package['VendorID']; ?>" 
      data-vendorname="<?php echo htmlspecialchars($package['Firstname'] . ' ' . $package['Lastname']); ?>"
      data-vendorpic="<?php echo !empty($package['ProfilePic']) ? htmlspecialchars($package['ProfilePic']) : 'img/user-icn.png'; ?>">
</span>

</div>
 

              
            <br>
                        <div class="row no-gutters align-items-center">
                            <div class="col-md-3 mb-2">
                                <div class="text-s font-weight-bold  text-gray-dark mb-1">Package Name</div>
                                <div class="h6 mb-0  text-gray-800"><?php echo htmlspecialchars($package['Packagename']); ?></div>
                            </div>
							<br>
                            <div class="col-md-3 mb-2">
                                <div class="text-s font-weight-bold  text-gray-dark mb-1">Package Type</div>
                                <div class="h6 mb-0  text-gray-800"><?php echo htmlspecialchars($package['Packagetype']); ?></div>
                            </div>
							<br>
                            <div class="col-md-3 mb-2">
                                <div class="text-s font-weight-bold  text-gray-dark mb-1">Package Price</div>
                                <div class="h6 mb-0  text-gray-800">LKR <?php echo htmlspecialchars($package['Packageamount']); ?></div>
                            </div>

             <br>
                            <div class="col-md-3 mb-2">
                                <div class="text-s font-weight-bold  text-gray-dark mb-1">Status</div>
                                <?php 
                                    $status = htmlspecialchars($package['Status']); 
                                    $statusColor = ($status == "Pending") ? "text-warning" : 
                                                  (($status == "Accepted") ? "text-success" : 
                                                  ($status == "Completed") ? "text-success" :
                                                  (($status == "Rejected") ? "text-danger" : "text-gray-800"));
                                ?>
                                    <div class="h6 mb-0 font-weight-bold <?php echo $statusColor; ?>"><?php echo $status; ?>
                                </div>                            
                            </div>
                            <br>
                        <br>
                            <div class="col-md-3 mt-3">
                                <div class="text-s font-weight-bold  text-gray-dark mb-1">Payment Status</div>
                                <?php 
                                    $status = htmlspecialchars($package['PaymentStatus']); 
                                    $statusColor = ($status == "Pending") ? "text-danger" : 
                                                  (($status == "Paid Full Payment") ? "text-success" :
                                                  (($status == "Paid Advance Payment") ? "text-warning" : "text-gray-800"));
                                ?>
                                    <div class="h6 mb-0 font-weight-bold <?php echo $statusColor; ?>"><?php echo $status; ?>
                                </div>                            
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
                        <div class="text-center text-muted">Packages have not been hired yet.</div>
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
        .position-absolute {
    position: absolute;
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