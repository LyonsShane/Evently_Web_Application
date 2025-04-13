
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
    WHERE hv.UserID = ? AND hv.EventID = ?
");
$query1->bind_param("ii", $userId, $eventId);
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
			<a href="Myevents.php"><button type="submit" name="save" class="btn btn-cancel">Back</button></a>
				
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
    <a href="Inviteguests.php?ID=<?php echo $eventId; ?>" class="btn btn-success">Invite Guests</a>
    <a href="Hirevendors.php?ID=<?php echo $eventId; ?>" class="btn btn-primary">Hire Vendors</a>
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
$query1=mysqli_query($conn,"SELECT SUM(Packageamount) AS total_amount FROM hiredvendors where UserID = '$_SESSION[userId]' AND EventID = '$eventId' AND Status = 'Accepted'");                       
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
    Add Review
</span>
       <?php if ($package['PaymentStatus'] != 'Paid Full Payment') { 
              echo '<button class="btn btn-primary btn-sm paynow" 
                      data-package-id="'.$package['PackageID'].'"	
                      data-user-id="'. $userId.'"
                      data-vendor-id="'. $package['VendorID'].'"
                      data-event-id="'. $eventId.'"
                      data-paidamount="'. $package['PaidAmount'].'"
                      data-paymentstatus="'. $package['PaymentStatus'].'"
                      data-packageamount="'. $package['PackageAmount'].'"
                      data-toggle="modal" data-target="#paymentModal">
              Pay Now
          </button>';
        } 
        
        ?>                           
    

    <style>
        .paynow {
            margin-left: 20px;
        }
    </style>
</div>
 
<!-- Payment Modal -->
<div class="modal fade" id="paymentModal" tabindex="-1" role="dialog" aria-labelledby="paymentModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title text-primary font-weight-bold w-100 text-center" id="paymentModalLabel">Make a Payment</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <!-- Vendor Details -->
        <div class="text-center mb-3">
          <img id="payVendorPic" src="img/user-icn.png" class="profile-pic-p mb-2">
          <div class="h5 font-weight-bold" id="payVendorName">Vendor Name</div>
        </div>

        <!-- Package Details -->
        <div class="mb-3 text-center">
          <div><b>Package Name:</b> <span id="payPackageName"></span></div>
          <!-- <div><b>Package Type:</b> <span id="payPackageType"></span></div> -->
        </div>

        

        <!-- Payment Amount -->
        <div class="mb-3 text-center fullamount">
          <div><b>Total Amount: <br>
          <div class="LKR text-primary"> LKR <span class="text-primary" id="payFullAmount"></span></div></b></div>
          <div id="balanceAmountContainer" class="text-danger font-weight-bold d-none">
            Balance Amount: LKR <span id="balanceAmount">0</span>
          </div>
        </div>

        <style>
          #payFullAmount {
            font-size: 24px;
          }

          .LKR  {
            font-size: 24px;
          }
        </style>

<br>

        <!-- Payment Options -->
        <div id="paymentOptionSection" class="form-group">
          <label><b>Select Payment Type:</b></label><br>
          <div class="form-check">
            <input class="form-check-input" type="radio" name="paymentOption" id="fullPayment" value="full" checked>
            <label class="form-check-label" for="fullPayment">Pay Full Payment</label>
          </div>
          <div class="form-check">
            <input class="form-check-input" type="radio" name="paymentOption" id="advancePayment" value="advance">
            <label class="form-check-label" for="advancePayment">Pay Advance Payment (20%)</label>
          </div>
        </div>
        <div id="advancePaidNotice" class="alert alert-info d-none">
          You have already paid an advance. Please pay the remaining balance.
        </div>

       
        <br>

        <!-- Advance Amount Display -->
        <div class="form-group d-none" id="advanceAmountContainer">
          <label><b>Advance Amount (20%):</b></label>
          <div>LKR <span id="advanceAmount">0</span></div>
        </div>

        <!-- Card Details -->
        <div class="form-group">
          <label><b>Card Number</b></label>
          <input type="text" class="form-control" placeholder="Enter card number">
        </div>
        <div class="form-group">
          <label><b>Card Holder Name</b></label>
          <input type="text" class="form-control" placeholder="Card holder name">
        </div>
        <div class="form-group">
          <label><b>Expiry Date</b></label>
          <input type="text" class="form-control" placeholder="MM/YY">
        </div>
        <div class="form-group">
          <label><b>CVV</b></label>
          <input type="text" class="form-control" placeholder="CVV">
        </div>
        

        <!-- Submit Button -->
        <button class="btn btn-success btn-block">Pay Now</button>
      </div>
    </div>
  </div>
</div>



                
                <!-- Review Modal -->
<div class="modal fade" id="reviewModal" tabindex="-1" role="dialog" aria-labelledby="reviewModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-primary font-weight-bold" id="reviewModalLabel">Add Review</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="reviewForm">
                    <input type="hidden" id="vendorID" name="vendorID">
                    <input type="hidden" id="eventID" name="eventID" value="<?php echo $eventId; ?>">

                    <div class="form-group text-center">
                    <label for="vendorName" class="d-block">Vendor Name</label>
                    <div class="d-flex flex-column align-items-center">
                <img id="vendorProfilePic" src="img/user-icn.png" class="profile-pic-p mb-2">
                 <div class="h6 mb-0 text-gray font-weight-bold" id="vendorNameText">Vendor Name</div>
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
              <div class="form-group">
    <div id="starRating">
        <i class="fas fa-star star" data-value="1"></i>
        <i class="fas fa-star star" data-value="2"></i>
        <i class="fas fa-star star" data-value="3"></i>
        <i class="fas fa-star star" data-value="4"></i>
        <i class="fas fa-star star" data-value="5"></i>
        <span id="ratingValue">0/5</span>
    </div>
    <input type="hidden" id="rating" name="rating" required>
</div>
<style>
    .star {
        font-size: 25px;
        color:rgb(175, 175, 175);
        cursor: pointer;
    }

    .star.selected,
    .star:hover {
        color: gold;
    }
</style>
                    </div>


                    <div class="form-group">
                        <label for="reviewText">Review</label>
                        <textarea class="form-control" id="reviewText" name="reviewText" rows="3" required placeholder="Write your review here..."></textarea>
                    </div>

                    <div class=" d-flex flex-row align-items-center justify-content-between">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Add Review</button>
                    </div>
                </form>
            </div>
        </div>
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
            url: "save_review.php",
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
        $(".star").hover(function () {
            let value = $(this).data("value");
            $(".star").each(function () {
                $(this).css("color", $(this).data("value") <= value ? "gold" : "rgb(175, 175, 175)");
            });
        });

        $(".star").click(function () {
            let value = $(this).data("value");
            $("#rating").val(value);
            $("#ratingValue").text(value + "/5");

            $(".star").each(function () {
                $(this).toggleClass("selected", $(this).data("value") <= value);
            });
        });

        $(".addReview").click(function () {
            $("#rating").val(0);
            $("#ratingValue").text("0/5");
            $(".star").removeClass("selected").css("color", "rgb(175, 175, 175)");
        });
    });
</script>

<script>
$(document).ready(function () {
    $(".paynow").click(function () {
        let card = $(this).closest(".card-body");
        let vendorName = card.find(".h6.mb-0.text-gray-800").first().text().trim();
        let vendorPic = card.find("img.profile-pic").attr("src");
        let packageName = card.find(".text-s:contains('Package Name')")
                            .closest(".col-md-3")
                            .find(".h6.mb-0.text-gray-800")
                            .text()
                            .trim();

        let packageType = card.find(".text-s:contains('Package Type')")
                            .closest(".col-md-3")
                            .find(".h6.mb-0.text-gray-800")
                            .text()
                            .trim();

        let amountText = card.find("div:contains('Package Price')").next().text().replace(/[^\d]/g, '');
        let fullAmount = parseFloat(amountText);

        let packageID = $(this).data("package-id");
        let userID = $(this).data("user-id");
        let vendorID = $(this).data("vendor-id");
        let eventID = $(this).data("event-id");
        let paidAmount = parseFloat($(this).data("paidamount")); // <- added
        let paymentStatus = $(this).data("paymentstatus"); // <- added

        // Fill modal with vendor details
        $("#payVendorName").text(vendorName);
        $("#payVendorPic").attr("src", vendorPic);
        $("#payPackageName").text(packageName);
        $("#payPackageType").text(packageType);

        let balanceAmount = fullAmount - paidAmount; // <- added

        // Set payment info
        if (paymentStatus === "Paid Advance Payment") {
            // Hide payment options and show balance notice
            $("#paymentOptionSection").addClass("d-none");
            $("#advancePaidNotice").removeClass("d-none");
            $("#balanceAmountContainer").removeClass("d-none");
            $("#amountLabel").text("Balance Amount:");
            $("#payFullAmount").text(balanceAmount.toFixed(2));
            $("#balanceAmount").text(balanceAmount.toFixed(2));
        } else {
            // Show normal payment options
            $("#paymentOptionSection").removeClass("d-none");
            $("#advancePaidNotice").addClass("d-none");
            $("#balanceAmountContainer").addClass("d-none");
            $("#amountLabel").text("Total Amount:");
            $("#payFullAmount").text(fullAmount.toFixed(2));
        }

        $("#advanceAmount").text((fullAmount * 0.2).toFixed(2));
        $("#fullPayment").prop("checked", true);
        $("#advanceAmountContainer").addClass("d-none");

        $("#paymentModal").modal("show");

        $("#paymentModal").off("click", ".btn-success").on("click", ".btn-success", function () {
            let selectedOption = $("input[name='paymentOption']:checked").val();
            let updatedStatus = "";
            let updatedPaidAmount = 0;

            if (paymentStatus === "Paid Advance Payment") {
                updatedStatus = "Paid Full Payment";
                updatedPaidAmount = fullAmount;
            } else {
                if (selectedOption === "full") {
                    updatedStatus = "Paid Full Payment";
                    updatedPaidAmount = fullAmount;
                } else if (selectedOption === "advance") {
                    updatedStatus = "Paid Advance Payment";
                    updatedPaidAmount = fullAmount * 0.2;
                }
            }

            // Send AJAX request to update hired vendor table
            $.ajax({
                url: 'update_hired_vendor.php',
                method: 'POST',
                data: {
                    packageID: packageID,
                    userID: userID,
                    vendorID: vendorID,
                    eventID: eventID,
                    paymentStatus: updatedStatus,
                    paidAmount: updatedPaidAmount
                },
                success: function (response) {
                    alert('Payment Successfully Done!');
                    $("#paymentModal").modal("hide");
                    location.reload();
                },
                error: function (xhr, status, error) {
                    console.error("AJAX error:", xhr.responseText, error);
                    alert('Error updating payment details');
                }
            });
        });
    });

    // Toggle advance amount visibility
    $("input[name='paymentOption']").change(function () {
        if ($("#advancePayment").is(":checked")) {
            $("#advanceAmountContainer").removeClass("d-none");
        } else {
            $("#advanceAmountContainer").addClass("d-none");
        }
    });
});

</script>



</body>

</html>