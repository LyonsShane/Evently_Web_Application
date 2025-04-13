
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
<style>
    .review-card {
        background: #fff;
        padding: 15px;
        border-radius: 10px;
        box-shadow: 2px 2px 15px rgba(0, 0, 0, 0.1);
        margin-bottom: 15px;
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
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
        color: rgb(255, 196, 0); 
    }

    .review-stars .empty { 
        color: #D3D3D3; 
    }

    .review-text { 
        font-size: 14px; color: #333; 
    }

    .review-user { 
        font-weight: bold; color: #007bff; 
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
         
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">My Reviews</h1>
            <ol class="breadcrumb">
              <li class="breadcrumb-item">Settings</li>
              <li class="breadcrumb-item active" aria-current="page">My Reviews</li>
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
                        <h6 class="m-0 font-weight-bold text-primary">All My Reviews</h6> 
            
            </div>
						<br>
							
							<div class="reviews-container">
                            <?php 

                            $reviewQuery = $conn->prepare("
                            SELECT vr.*, au.Firstname, au.Lastname, au.ProfilePic 
                            FROM vendorreviews vr
                            JOIN allusers au ON vr.UserID = au.ID
                            WHERE vr.VendorID = $userId
                            ");
                           
                            $reviewQuery->execute();
                            $reviewResult = $reviewQuery->get_result();
                            if ($reviewResult->num_rows > 0) {
                                while ($review = $reviewResult->fetch_assoc()) {
                                    $fullName = htmlspecialchars($review['Firstname'] . " " . $review['Lastname']);
                                    $profilePic = !empty($review['ProfilePic']) ? htmlspecialchars($review['ProfilePic']) : 'img/user-icn.png';
                                    echo "<div class='review-card'>
                                                <img src='" . $profilePic . "'>                                            
                                                <div class='review-details'>
                                                <div class='d-flex justify-content-between align-items-center'>
                                                    <span class='review-user'>" . $fullName . "</span>
                                                </div>
                                                <div class='review-stars'>";
                                    for ($i = 1; $i <= 5; $i++) {
                                        echo $i <= $review['Rating'] ? "<span class='filled'>&#9733;</span>" : "<span class='empty'>&#9733;</span>";
                                    }
                                    echo "</div>
                                                <p class='review-text'>" . htmlspecialchars($review['ReviewText']) . "</p>
                                            </div>
                                        </div>";
                                }
                            } else {
                                echo "<p class='text-muted'>No reviews found.</p>";
                            }
                            ?>
           
        
    
  
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