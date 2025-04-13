
<?php 
error_reporting(0);
include '../Includes/dbcon.php';
include '../Includes/session.php';

date_default_timezone_set('Asia/Colombo');


$query = "SELECT * FROM allusers WHERE ID = '$_SESSION[userId]'"; 
	$result = $conn->query($query);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
	$Profilepic = $row['Profilepic'];
} 

else {
    
	$Profilepic = "img/user-icn.png";
}

//------------------------SAVE--------------------------------------------------


if(isset($_POST['save'])){
  $Ename = $_POST['EventName'];
  $Etype = $_POST['EventType'];
  $EventDate = $_POST['EventDate'];
  $EventTime = $_POST['EventTime'];
  $Location = $_POST['Location'];
  $Description = $_POST['Description'];
  $UserID = $_SESSION['userId'];
  $EventCreated = date("Y-m-d H:i:s");

  $stmt = $conn->prepare("INSERT INTO events (Eventname, Eventtype, EventDate, EventTime, Location, Description, UserID, EventCreated) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
  $stmt->bind_param("ssssssis", $Ename, $Etype, $EventDate, $EventTime, $Location, $Description, $UserID, $EventCreated);

  if($stmt->execute()){
      echo "<script>alert('Event Successfully Created!');</script>";
  } else {
      echo "<script>alert('Error!');</script>";
  }
  $stmt->close();
  header('refresh:0;url=Myevents.php');
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
            <h1 class="h3 mb-0 text-gray-800">Create An Event</h1>
            <ol class="breadcrumb">
              <li class="breadcrumb-item">Event Management</li>
              <li class="breadcrumb-item active" aria-current="page">Create An Event</li>
            </ol>
          </div>

          <div class="row">
            <div class="col-lg-12">
              <!-- Form Basic -->
              <div class="card mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                  <h6 class="m-0 font-weight-bold text-primary">Create An Event</h6>
                    <?php echo $statusMsg; ?>
                </div>
                <div class="card-body" align="center">
					<form method="Post" action="">
                  
						<div class="col-xl-6" align="left">
                        <label class="form-control-label">Event Name<span class="text-danger ml-2">*</span></label>
                        <input type="text" class="form-control" name="EventName" id="exampleInputFirstName" required >
                        </div>
						<br>
						<div class="col-xl-6"align="left">
                        <label class="form-control-label">Event Type<span class="text-danger ml-2">*</span></label>
							<select required name="EventType" class="form-control">
                          <option value="" disabled selected>--Select Event Type--</option>
                          <option value="Wedding">Wedding</option>
						              <option value="Engagement">Engagement </option>
                          <option value="Corporate Conferences">Corporate Conferences</option>
					                <option value="Community Gatherings">Community Gatherings</option>
						              <option value="Party">Party</option>
                          <option value="Birthday Party">Birthday Party</option>
						              <option value="Get Together">Get Together</option>
                        </select>
                        </div>
                        
						<br>
						<div class="col-xl-6"align="left">
                        <label class="form-control-label">Date<span class="text-danger ml-2">*</span></label>
                        <input type="Date" class="form-control" name="EventDate" id="exampleInputFirstName" required >
                        </div>
                        <br>
						<div class="col-xl-6"align="left">
                        <label class="form-control-label">Time<span class="text-danger ml-2">*</span></label>
                        <input type="Time" class="form-control" name="EventTime" id="exampleInputFirstName" required >
                        </div>
						<br>
						<div class="col-xl-6"align="left">
                        <label class="form-control-label">Location<span class="text-danger ml-2">*</span></label>
                        <input type="text" class="form-control" name="Location" id="exampleInputFirstName" required >
                        </div>
						<br>
						<div class="col-xl-6"align="left">
                        <label class="form-control-label">Description<span class="text-danger ml-2">*</span></label>
						<textarea class="form-control" required oninput="resizeTextarea(this)" name="Description" id="exampleInputFirstName"></textarea>
                        </div>
						<script>
							function resizeTextarea(el) {
								el.style.height = "auto"; // Reset height
								el.style.height = (el.scrollHeight) + "px"; // Set new height
							}
						</script>
						
						<br>
						
						<button type="submit" name="save" class="btn btn-primary">Create</button>
						
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