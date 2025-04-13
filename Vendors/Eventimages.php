
<?php 
error_reporting(0);
include '../Includes/dbcon.php';
include '../Includes/session.php';


// Check number of existing images
function getImageCount($conn, $vendorId) {
    $countQuery = "SELECT COUNT(*) as count FROM eventimages WHERE VendorID = '$vendorId'";
    $result = $conn->query($countQuery);
    $row = $result->fetch_assoc();
    return $row['count'];
}

$imageCount = getImageCount($conn, $_SESSION['userId']);
$maxImages = 6;
$canUpload = $imageCount < $maxImages;


$query = "SELECT * FROM eventimages WHERE VendorID = '$_SESSION[userId]'";
$result = $conn->query($query);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $Image = !empty($row['Image']) ? $row['Image'] : "img/image-upload.png";
    $datecreated = $row['Date'];
} else {
    $Image = "img/image-upload.png";
}

$query = "SELECT * FROM allusers WHERE ID = '$_SESSION[userId]'"; 
	$result = $conn->query($query);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
	$Profilepic = $row['ProfilePic'];
} 

else {
    
	$Profilepic = "img/user-icn.png";
}



//------------------------SAVE--------------------------------------------------


if(isset($_POST['save'])) {
    if ($imageCount >= $maxImages) {
        $statusMsg = "<div class='alert alert-danger' id='statusMsg'>Maximum limit of 6 images reached!</div>";
    } else {
        $targetDir = "../img/eventimages/";
        $fileName = basename($_FILES["file"]["name"]);
        $targetFilePath = $targetDir . $fileName;
        $fileType = strtolower(pathinfo($targetFilePath, PATHINFO_EXTENSION));
        $dateCreated = date("Y-m-d");
        $VendorID = $_SESSION['userId'];

        // Validate file type
        $allowedTypes = array("jpg", "jpeg", "png");
        if (!in_array($fileType, $allowedTypes)) {
            $statusMsg = "<div class='alert alert-danger' id='statusMsg'>Only JPG, JPEG & PNG files are allowed.</div>";
        } else {
            // Create directory if it doesn't exist
            if (!file_exists($targetDir)) {
                mkdir($targetDir, 0777, true);
            }

            // Upload file
            if (move_uploaded_file($_FILES["file"]["tmp_name"], $targetFilePath)) {
                // Insert into database
                $query = "INSERT INTO eventimages (Image, Date, VendorID) 
                         VALUES ('$targetFilePath', '$dateCreated', '$VendorID')";
                
                if ($conn->query($query)) {
                    $statusMsg = "<div class='alert alert-success' id='statusMsg'>Image Uploaded Successfully!</div>";
                    // Add JavaScript to reset the image preview
                    $statusMsg .= "
                    <script>
                        document.getElementById('imagePreview').src = 'img/image-upload.png';
                        document.getElementById('fileInput').value = '';
                    </script>";
                } else {
                    $statusMsg = "<div class='alert alert-danger' id='statusMsg'>Database Error: " . $conn->error . "</div>";
                }
            } else {
                $statusMsg = "<div class='alert alert-danger' id='statusMsg'>Error uploading file.</div>";
            }
        }
    }

    $statusMsg .= "
    <script>
        setTimeout(function() {
            var msg = document.getElementById('statusMsg');
            if (msg) {
                msg.style.display = 'none';
            }
            window.location.href = 'Eventimages.php';
        }, 3000);
    </script>";
}



//--------------------------------DELETE------------------------------------------------------------------

  if (isset($_GET['ID']) && isset($_GET['action']) && $_GET['action'] == "delete")
	{
        $Id= $_GET['ID'];

        $query = mysqli_query($conn,"DELETE FROM eventimages WHERE ID='$Id'");

        if ($query == TRUE) {
			
			$statusMsg = "<div class='alert alert-danger' id='statusMsg' style='margin-right:700px;'>Image Deleted Successfully!</div>
<script>
    setTimeout(function() {
        var msg = document.getElementById('statusMsg');
        if (msg) {
            msg.style.display = 'none';
        }
        window.location.href = 'Eventimages.php'; // Redirect to Eventimages.php
    }, 3000); // 3 seconds
</script>";

        }
        else{

            $statusMsg = "<div class='alert alert-danger' style='margin-right:700px;'>An error Occurred!</div>
			<script>
    setTimeout(function() {
        var msg = document.getElementById('statusMsg');
        if (msg) {
            msg.style.display = 'none';
        }
        window.location.href = 'Eventimages.php'; // Redirect to Eventimages.php
    }, 3000); // 3 seconds
</script>"; 
			
         }
      
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
            <h1 class="h3 mb-0 text-gray-800">Event Images</h1>
            <ol class="breadcrumb">
              <li class="breadcrumb-item">Settings</li>
              <li class="breadcrumb-item active" aria-current="page">Event Images</li>
            </ol>
          </div>

          <div class="row">
            <div class="col-lg-12">
              <!-- Form Basic -->
              <div class="card mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                  <h6 class="m-0 font-weight-bold text-primary">Click on image to upload image</h6>
                    <?php echo $statusMsg; ?>
                </div>
                <div class="card-body">
                  <form method="post" class="justify-content-center" enctype="multipart/form-data">
                   <div class="form-group row mb-3 justify-content-center"  align="center">
                        <div class="col-xl-4">
							<label class="form-control-label">Only JPG, JPEG & PNG files are allowed.</label>
							<br>
                <label class="form-control-label"><?php echo "($imageCount/6) Only 06 images can be uploaded"; ?></label>
						<br>
						<br>
						<style>
							#imagePreview {
								width:400px;
								height: 300px;
								border-radius: 10%;
								object-fit: cover;
								cursor: pointer;
								border: 2px solid #ddd;
								max-width: 100%;
							}
							#imagePreview:hover {
							  border: 3px solid #6777EF;
}
							input[type="file"] {
								display: none; /* Hide the file input */
							}
							.btn-primary:disabled {
								background-color: #cccccc;
								border-color: #cccccc;
								cursor: not-allowed;
							}
							 @media screen and (max-width: 500px) {
								#imagePreview {
									width: 300px;
									height: 225px;
								}
							}
						</style>
							<input type="file" name="file" id="fileInput" accept="image/*" onchange="previewImage()" <?php echo !$canUpload ? 'disabled' : ''; ?>>
								<label for="fileInput">
									<img id="imagePreview" src="img/image-upload.png" alt="Profile Image" style="<?php echo !$canUpload ? 'opacity: 0.5; cursor: not-allowed;' : ''; ?>">
								</label>
							<script>
								function previewImage() {
									var file = document.getElementById("fileInput").files[0];
									var reader = new FileReader();

									reader.onload = function (e) {
										document.getElementById("imagePreview").src = e.target.result;
									};

									if (file) {
										reader.readAsDataURL(file);
									}
								}
								function resetImageUploader() {
    document.getElementById('imagePreview').src = 'img/image-upload.png';
    document.getElementById('fileInput').value = '';
}

// Add this to your form submit handler if you want to reset after form submission
document.querySelector('form').addEventListener('submit', function(e) {
    // The form will submit normally, and after success, the PHP code will trigger the reset
});
							</script>
                        
                        </div>
                    </div>
                     
                    <div align="center">
                    
                    
                    <button type="submit" name="save" class="btn btn-primary" <?php echo !$canUpload ? 'disabled' : ''; ?>>
                <?php echo $canUpload ? 'Save' : 'Maximum Images Reached (6)'; ?>
            </button>
                   
					</div>
                  </form>
                </div>
              </div>

              <!-- Input Group -->
                 <div class="row">
              <div class="col-lg-12">
              <div class="card mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                  <h6 class="m-0 font-weight-bold text-primary">Images Of Events</h6>
                </div>
                <div class="table-responsive p-3">
                  <table class="table align-items-center table-flush table-hover" id="dataTableHover">
                    <thead class="thead-light">
                      <tr>
                        <th>#</th>
                        <th>Image</th>
                        <th>Added Date</th>
                        <th>Delete</th>
                      </tr>
                    </thead>
                
                    <tbody>

                  <?php
                      $query = "SELECT * FROM eventimages where VendorID = '$_SESSION[userId]'";
                      $rs = $conn->query($query);
                      $num = $rs->num_rows;
                      $sn=0;
                      $status="";
                      if($num > 0)
                      { 
                        while ($rows = $rs->fetch_assoc())
                          {
                             $sn = $sn + 1;
							
                            echo"
                              <tr>
                                <td>".$sn."</td>
                                <td><img src='".$rows['Image']."' style='width:100px; height:auto; border-radius:10%;'></td>
                                <td>".$rows['Date']."</td>
                                <td><a href='?action=delete&ID=".$rows['ID']."'><i class='fas fa-fw fa-trash'></i></a></td>
                              </tr>";
                          }
                      }
                      else
                      {
                           echo   
                           "<div class='alert alert-danger' role='alert'>
                            No Record Found!
                            </div>";
                      }
                      
                      ?>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
            </div>
          </div>
          <!--Row-->

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