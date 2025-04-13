
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

$query1 = $conn->prepare("
    SELECT hv.*, 
           au.Firstname, 
           au.Lastname, 
           au.ProfilePic,
           e.eventtype, 
           e.eventdate, 
           e.eventtime, 
           e.location 
    FROM hiredvendors hv
    JOIN allusers au ON hv.UserID = au.ID
    JOIN events e ON hv.EventID = e.ID
    WHERE hv.VendorID = ?
    AND hv.Status = 'Accepted'
");
$query1->bind_param("i", $_SESSION['userId']);
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
         
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">On Going Packages</h1>
            <ol class="breadcrumb">
              <li class="breadcrumb-item">Manage Packages</li>
              <li class="breadcrumb-item active" aria-current="page">On Going Packages</li>
            </ol>
          </div> 
          

          <div class="row">
            <div class="col-lg-12">
              <!-- Form Basic -->
              <div class="card mb-4">
                
                <div class="card-body" align="center">
						
					        
						
                  <div class="form-group row mb-3">
						
						<div class="col-xl-12" align="left">
            <div class=" d-flex flex-row align-items-center justify-content-between">
                        <h6 class="m-0 font-weight-bold text-primary">All On Going Packages</h6> 
            
            </div>
						<br>
							
							<div class="packages-container">
                            <?php 
        // Query to fetch all packages for the current vendor
        $packageQuery = mysqli_query($conn, "SELECT * FROM hiredvendors WHERE VendorID = '$_SESSION[userId]' AND Status = 'Accepted'");

        // Check if there are any packages
        if ($result1->num_rows > 0) {
            while ($package = $result1->fetch_assoc()) {
                $fullName = htmlspecialchars($package['Firstname'] . " " . $package['Lastname']);
                $profilePic = !empty($package['ProfilePic']) ? htmlspecialchars($package['ProfilePic']) : 'img/user-icn.png';
        ?>
            <div class="package-card">
                <div class="card h-100 position-relative">
                    <div class="card-body">
                    <div class="row no-gutters align-items-center">
                            <div class="col-md-3 mb-2">
                                <div class="text-s font-weight-bold  text-gray-dark mb-1">Hired By</div>
                                <div class="row no-gutters align-items-center">
                                <img src="<?php echo $profilePic; ?>" class="profile-pic">
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
                                  
                                  <a href="UserProfile.php?ID=<?php echo $package['UserID']; ?>">
                                        <div class="h6 mb-0 text-gray-800"><?php echo $fullName; ?></div>
                                    </a>

                                </div>
                              </div>
							
            </div>
            <div class="position-absolute top-0 end-0 mt-2 me-3">
            <span class="text-s font-weight-bold text-primary addReview" 
      data-vendorid="<?php echo $package['UserID']; ?>" 
      data-vendorname="<?php echo htmlspecialchars($package['Firstname'] . ' ' . $package['Lastname']); ?>"
      data-vendorpic="<?php echo !empty($package['ProfilePic']) ? htmlspecialchars($package['ProfilePic']) : 'img/user-icn.png'; ?>">
    Report User
</span>
<br>
<br>
<button class="btn btn-primary btn-sm completeOrder" 
            data-hireid="<?php echo $package['ID']; ?>">
        Complete Order
    </button>

</div>
 
                
                <!-- Review Modal -->
<div class="modal fade" id="reviewModal" tabindex="-1" role="dialog" aria-labelledby="reviewModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-primary font-weight-bold" id="reviewModalLabel">Report User</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="reviewForm">
                    <input type="hidden" id="vendorID" name="vendorID">

                    <div class="form-group text-center">
                    <label for="vendorName" class="d-block">User Name</label>
                    <div class="d-flex flex-column align-items-center">
                <img id="vendorProfilePic" src="img/user-icn.png" class="profile-pic-p mb-2">
                 <div class="h6 mb-0 text-gray font-weight-bold" id="vendorNameText">User Name</div>
            <style>
              .profile-pic-p {
                width: 80px;
                height: 80px;
                border-radius: 50%;
                object-fit: cover;
                border: 2px solid #ddd;
            }
            </style>
            
              </div>
              <br>
              
                    </div>


                    <div class="form-group">
                        <label for="reviewText">Reason</label>
                        <select required name="reason" id="reason" class="form-control">
                          <option value="" disabled selected>--Select Reason--</option>
                          <option value="Fraudulent Activities">Fraudulent Activities</option>
						  <option value="Harassment or Misconduct">Harassment or Misconduct </option>
                          <option value="Spam or Unwanted Promotions">Spam or Unwanted Promotions</option>
					      <option value="Violation of Event Policies">Violation of Event Policies</option>
						  <option value="Fake Profiles or Impersonation">Fake Profiles or Impersonation</option>
                        </select>
                    </div>

                    <div class=" d-flex flex-row align-items-center justify-content-between">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<br>
                       

                            <div class="row no-gutters align-items-center">
                            <div class="col-md-3 mb-2">
                                <div class="text-s font-weight-bold  text-gray-dark mb-1">Hired For</div>
                                <div class="h6 mb-0  text-gray-800"><?php echo htmlspecialchars($package['eventtype']); ?></div>
                            </div>
							<br>
                            <div class="col-md-3 mb-2">
                                <div class="text-s font-weight-bold  text-gray-dark mb-1">Event Date</div>
                                <div class="h6 mb-0  text-gray-800"><?php echo htmlspecialchars($package['eventdate']); ?></div>
                            </div>
							<br>
                            <div class="col-md-3 mb-2">
                                <div class="text-s font-weight-bold  text-gray-dark mb-1">Event Time</div>
                                <div class="h6 mb-0  text-gray-800"><?php echo htmlspecialchars($package['eventtime']); ?></div>
                            </div>
                            <br>
                            <div class="col-md-3 mb-2">
                                <div class="text-s font-weight-bold  text-gray-dark mb-1">Event Location</div>
                                <div class="h6 mb-0  text-gray-800"><?php echo htmlspecialchars($package['location']); ?></div>
                            </div>
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
                                                  (($status == "Rejected") ? "text-danger" : "text-gray-800"));
                                ?>
                                    <div class="h6 mb-0 font-weight-bold <?php echo $statusColor; ?>"><?php echo $status; ?></div>                            </div>
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
                        <div class="text-center text-muted">No ongoing packages found.</div>
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

.top-0 {
    top: 10px;
}

.end-0 {
    right: 10px;
}

.mt-2 {
    margin-top: 8px;
}

.me-3 {
    margin-right: 12px;
}

.addReview {
    cursor: pointer;
    color: blue;
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
$(document).ready(function () {
    $(document).on("click", ".addReview", function () {
        var vendorID = $(this).data("vendorid");
        var vendorName = $(this).data("vendorname");
        var vendorProfilePic = $(this).data("vendorpic"); // Get profile picture

        // Update modal fields
        $("#vendorID").val(vendorID);
        $("#vendorNameText").text(vendorName); // Set text
        $("#vendorProfilePic").attr("src", vendorProfilePic); // Set image

        // Show the modal
        $("#reviewModal").modal("show");
    });

    $("#reviewForm").submit(function (e) {
        e.preventDefault();

        $.ajax({
            type: "POST",
            url: "submit_report.php",
            data: $(this).serialize(),
            success: function (response) {
                alert(response);
                $("#reviewForm")[0].reset();
                $("#reviewModal").modal("hide");
            }
        });
    });
});


</script>


<script>

$(document).ready(function () {
    $(document).on("click", ".completeOrder", function () {
        var hireID = $(this).data("hireid"); // Get the hire package ID

        if (confirm("Are you sure you want to complete this order?")) {
            $.ajax({
                type: "POST",
                url: "complete_order.php",
                data: { hireID: hireID },
                success: function (response) {
                    alert(response); // Show success or error message
                    location.reload(); // Reload page to update status
                }
            });
        }
    });
});

</script>




</body>

</html>