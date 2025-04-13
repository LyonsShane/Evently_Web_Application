
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
	$ProfilePic = !empty($row['ProfilePic']) ? $row['ProfilePic'] : "img/user-icn.png";
	$Address = $row['Address'];
	$Postalcode = $row['Postalcode'];
} 

else {
    
	$Address = "Please Add Your Address";
	$Postalcode = "Please Add Your Postal Code";
}

if (isset($_POST['update'])) {
    $targetDir = "../img/userPP/"; // Folder to store images
    $fileName = basename($_FILES["file"]["name"]);
    $targetFilePath = $targetDir . $fileName;
    $fileType = strtolower(pathinfo($targetFilePath, PATHINFO_EXTENSION));

    $allowedTypes = array("jpg", "jpeg", "png");

    if (in_array($fileType, $allowedTypes)) {
        if (move_uploaded_file($_FILES["file"]["tmp_name"], $targetFilePath)) {
            // Update image path in database
            $query = "UPDATE allusers SET ProfilePic='$targetFilePath' where ID = '$_SESSION[userId]'";
            if ($conn->query($query)) {
                echo "Image uploaded successfully!";
                header("Location: Profile.php"); 
            } else {
                echo "Database error: " . $conn->error;
            }
        } else {
            echo "Error uploading file.";
        }
    } else {
        echo "Only JPG, JPEG & PNG files are allowed.";
    }
}

//--------------------EDIT------------------------------------------------------------

 if (isset($_GET['ID']) && isset($_GET['action']) && $_GET['action'] == "edit")
	{
        $Id= $_GET['ID'];

        $query=mysqli_query($conn,"select * from allusers WHERE ID = '$_SESSION[userId]'");
        $row=mysqli_fetch_array($query);

        //------------UPDATE-----------------------------

        if(isset($_POST['update'])){
    
  $Firstname=$_POST['Firstname'];
  $Lastname=$_POST['Lastname'];
  $Email=$_POST['Email'];
  $Phone=$_POST['Phone'];
  $Address=$_POST['Address'];
  $Postalcode=$_POST['Postalcode'];
			
  

 $query=mysqli_query($conn,"update allusers set Firstname='$Firstname', Lastname='$Lastname', Email='$Email', Phone='$Phone', Address='$Address', Postalcode='$Postalcode' where ID = '$_SESSION[userId]'");
            if ($query) {
                
                $statusMsg = "<div class='alert alert-success' id='statusMsg' style='margin-right:700px;'>Profile Details Updated Successfully!</div>
<script>
    setTimeout(function() {
        var msg = document.getElementById('statusMsg');
        if (msg) {
            msg.style.display = 'none';
        }
        window.location.href = 'Profile.php'; // Redirect to Profile.php
    }, 3000); // 3 seconds
</script>";
            }
            else
            {
                $statusMsg = "<div class='alert alert-danger' style='margin-right:700px;'>An error Occurred!</div>
				<script>
    setTimeout(function() {
        var msg = document.getElementById('statusMsg');
        if (msg) {
            msg.style.display = 'none';
        }
        window.location.href = 'Editprofile.php'; // Redirect to Editprofile.php
    }, 3000); // 3 seconds
</script>";
            }
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
            <h1 class="h3 mb-0 text-gray-800">Edit Profile</h1>
            <ol class="breadcrumb">
              <li class="breadcrumb-item">Settings</li>
              <li class="breadcrumb-item active" aria-current="page">Edit profile</li>
            </ol>
          </div>

          <div class="row">
            <div class="col-lg-12">
              <!-- Form Basic -->
              <div class="card mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                  <h6 class="m-0 font-weight-bold text-primary">Edit Profile Details</h6><?php echo $statusMsg; ?>
                </div>
                <div class="card-body" align="center">
					<form method="Post" action="" enctype="multipart/form-data">
						
					<div class="form-group row mb-3">
						<div class="col-xl-6" align="left">
                        <label class="form-control-label"><b>Click on profile picture to upload new profile picture</b></label>
						<br>
						<label class="form-control-label">Only JPG, JPEG & PNG files are allowed.</label>
						<br>
						<br>
						<style>
							#imagePreview {
								width: 150px;
								height: 150px;
								border-radius: 50%;
								object-fit: cover;
								cursor: pointer;
								border: 2px solid #ddd;
							}
							#imagePreview:hover {
							  border: 3px solid #6777EF;
}
							input[type="file"] {
								display: none; /* Hide the file input */
							}
						</style>
							<input type="file" name="file" id="fileInput" accept="image/*" onchange="previewImage()">
        <label for="fileInput">
            <img id="imagePreview" src="<?php echo $ProfilePic; ?>" alt="Profile Image">
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
    </script>
                        </div>
						</div>
					  	<br>
					  	<br>
						
                  <div class="form-group row mb-3">
						<div class="col-xl-6" align="left">
                        <label class="form-control-label"><b>First Name</b></label>
						<br>
						<input type="text" class="form-control" name="Firstname" id="exampleInputFirstName" value="<?php echo $row['Firstname'];?>" required >
                        </div>
						<br>
					 	<br>
					  	<br>
					  	<br>
						<div class="col-xl-6" align="left">
                        <label class="form-control-label"><b>Last Name</b></label>
						<input type="text" class="form-control" name="Lastname" id="exampleInputFirstName" value="<?php echo $row['Lastname'];?>" required >
                        </div>
						</div>
						<br>
					<div class="form-group row mb-3">
						<div class="col-xl-6" align="left">
                        <label class="form-control-label"><b>Email</b></label>
						<input type="text" class="form-control" name="Email" id="exampleInputFirstName" value="<?php echo $row['Email'];?>" required >
                        </div>
						<br>
					 	<br>
					  	<br>
					  	<br>
						<div class="col-xl-6" align="left">
                        <label class="form-control-label"><b>Phone</b></label>
						<input type="text" class="form-control" name="Phone" id="exampleInputFirstName" value="<?php echo $row['Phone'];?>" required >
                        </div>
						</div>
						<br>
					<div class="form-group row mb-3">
						<div class="col-xl-6" align="left">
                        <label class="form-control-label"><b>Address</b></label>
						<input type="text" class="form-control" name="Address" id="exampleInputFirstName" value="<?php echo $row['Address'];?>" required >
                        </div>
						<br>
					 	<br>
					  	<br>
					  	<br>
						<div class="col-xl-6" align="left">
                        <label class="form-control-label"><b>Postal Code</b></label>
						<input type="text" class="form-control" name="Postalcode" id="exampleInputFirstName" value="<?php echo $row['Postalcode'];?>" required >
                        </div>
						</div>
						<br>
						<button type="submit" name="update" class="btn btn-warning">Update</button>
						<button name="cancel" class="btn btn-cancel" ><a href="Profile.php">Cancel</a></button>
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