
<?php 
error_reporting(0);
include '../Includes/dbcon.php';
include '../Includes/session.php';

$query = "SELECT * FROM allusers WHERE ID = '$_SESSION[userId]'"; 
	$result = $conn->query($query);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
	$Profilepic = $row['ProfilePic'];
} 

else {
    
	$Profilepic = "img/user-icn.png";
}

if (isset($_GET['Id']) && isset($_GET['action'])) {
    $Id = intval($_GET['Id']); // Ensure ID is an integer
    $action = $_GET['action'];
    $userId = $_SESSION['userId'];

  if ($action == 'accept') {
      // Update status to 'Approved'
      $query = mysqli_query($conn, "UPDATE hiredvendors SET Status='Accepted' WHERE Id='$Id'");

      if ($query) {
          $statusMessage = "<div class='alert alert-success' id='statusMessage' style='margin-right:700px;'>Hire request has been accepted!</div>";
      } else {
          $statusMessage = "<div class='alert alert-danger' id='statusMessage' style='margin-right:700px;'>An error occurred while processing your request.</div>";
      }
  } elseif ($action == 'reject') {
      // Update status to 'Rejected'
      $query = mysqli_query($conn, "UPDATE hiredvendors SET Status='Rejected' WHERE Id='$Id'");

      if ($query) {
          $statusMessage = "<div class='alert alert-warning' id='statusMessage' style='margin-right:700px;'>Hire request has been rejected!</div>";
      } else {
          $statusMessage = "<div class='alert alert-danger' id='statusMessage' style='margin-right:700px;'>An error occurred while processing your request.</div>";
      }
  }else{
    echo "Invalid action parameter.";
  }
}

?>

<script>
    setTimeout(function() {
        var statusMessage = document.getElementById("statusMessage");
        if (statusMessage) {
            statusMessage.style.display = "none"; // Hide the message
        }
    }, 3000); // Hide after 3 seconds
</script>

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
            <h1 class="h3 mb-0 text-gray-800">Hired Packages Approvals</h1>
            <ol class="breadcrumb">
              <li class="breadcrumb-item">Manage Packages</li>
              <li class="breadcrumb-item active" aria-current="page">Hired Packages Approvals</li>
            </ol>
          </div>

          <div class="row">
            <div class="col-lg-12">
              

              <!-- Input Group -->
                 <div class="row">
              <div class="col-lg-12">
              <div class="card mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                  <h6 class="m-0 font-weight-bold text-primary">All Approvals</h6>
                </div>
                <?php echo $statusMessage; ?>
                <div class="table-responsive p-3">
                  <table class="table align-items-center table-flush table-hover" id="dataTableHover">
                    <thead class="thead-light">
                      <tr>
                        <th>#</th>
                        <th>Package Name</th>
                        <!-- <th>Package Type</th> -->
                        <th>Package Amount (LKR)</th>
                        <!-- <th>Hired Date</th> -->
                        <th>Hired By</th>
                        <th>Hired For</th>
                        <th>Event Date</th>
                        <th>Event Time</th>
                        <th>Event Location</th>
                        <th>Actions</th>
                      </tr>
                    </thead>
                  
                    <tbody>

                  <?php
                       $query = "SELECT hv.*, 
                       CONCAT(u.Firstname, ' ', u.Lastname) AS HiredByName, e.EventType, e.Eventdate, e.Eventtime, e.Location 
                       FROM hiredvendors hv
                       LEFT JOIN allusers u ON hv.UserID = u.ID
                       LEFT JOIN events e ON hv.EventID = e.ID
                       WHERE hv.VendorID = '$_SESSION[userId]' AND hv.Status = 'Pending'";
                      $rs = $conn->query($query);
                      $num = $rs->num_rows;
                      $sn=0;
                      if($num > 0)
                      { 
                        while ($rows = $rs->fetch_assoc())
                          {
                             $sn = $sn + 1;
                            echo"
                              <tr>
                                <td>".$sn."</td>
                                <td>".$rows['Packagename']."</td>
                               <!-- <td>".$rows['Packagetype']."</td> -->
                                <td>".$rows['Packageamount']."</td>
                                <!--<td>".$rows['HiredDate']."</td>-->
                                <td>".$rows['HiredByName']."</td>
                                <td>".$rows['EventType']."</td>
                                <td>".$rows['Eventdate']."</td>
                                <td>".$rows['Eventtime']."</td>
                                <td>".$rows['Location']."</td>
                                <td>
                              <a href='?action=accept&Id=" . $rows['ID'] . "' onclick='return confirm(\"Are you sure you want to accept this hire request?\");'>
                                  <button class='btn btn-success'>Accept</button>
                              </a>
                              <a href='?action=reject&Id=" . $rows['ID'] . "' onclick='return confirm(\"Are you sure you want to reject this hire request?\");'>
                                  <button class='btn btn-danger'>Reject</button>
                              </a>
                          </td>
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