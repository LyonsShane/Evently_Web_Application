
<?php 
error_reporting(0);
include '../Includes/dbcon.php';
include '../Includes/session.php';

$eventID = $_GET['ID'] ?? ''; // Extract Event ID from URL

$query = "SELECT * FROM allusers WHERE ID = '$_SESSION[userId]'"; 
	$result = $conn->query($query);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
	$Profilepic = $row['Profilepic'];
} 

else {
    
	$Profilepic = "img/user-icn.png";
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
        <div class="col-xl-12 d-flex flex-row align-items-center form-group row mb-3 justify-content-between" align="left">
        <a href="Eventview.php?ID=<?php echo $_GET['ID']; ?>" class="btn btn-cancel">Back</a>


				
            <h1 class="h3 mb-0 text-gray-800">Hire Vendors</h1>
			 
           
          </div>

          <div class="row">
            <div class="col-lg-12">
              

              <!-- Input Group -->
                 <div class="row">
              <div class="col-lg-12">
              <div class="card mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                  <h6 class="m-0 font-weight-bold text-primary">All Vendors</h6>
                </div>
                <div class="table-responsive p-3">
                  <table class="table align-items-center table-flush table-hover" id="dataTableHover">
                    <thead class="thead-light">
                      <tr>
                        <th>#</th>
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Vendor Type</th>
                      </tr>
                    </thead>
                  
                    <tbody>
  <?php
    $query = "SELECT * FROM allusers WHERE Userrole = 'Vendor'";
    $rs = $conn->query($query);
    $num = $rs->num_rows;
    $sn = 0;

    if ($num > 0) { 
      while ($rows = $rs->fetch_assoc()) {
        $sn = $sn + 1;
        echo "
          <tr onclick=\"redirectToVendorProfile(" . $rows['ID'] . ", $eventID)\" style='cursor:pointer;'>
            <td>" . $sn . "</td>
            <td>" . $rows['Firstname'] . "</td>
            <td>" . $rows['Lastname'] . "</td>
            <td>" . $rows['Email'] . "</td>
            <td>" . $rows['Phone'] . "</td>
            <td>" . $rows['Vendortype'] . "</td>
          </tr>";
      }
    } else {
      echo "<div class='alert alert-danger' role='alert'>No Record Found!</div>";
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

<script>
  function redirectToVendorProfile(vendorID, eventID) {
  if (!eventID) {
    alert("Event ID is missing!");
    return;
  }
  window.location.href = `Hirevendorprofile.php?vendorID=${vendorID}&eventID=${eventID}`;
}


  </script>
</body>

</html>