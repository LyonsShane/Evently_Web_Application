
<?php 
error_reporting(0);
include '../Includes/dbcon.php';
include '../Includes/session.php';
include 'Includes/check.php';


//--------------------------------DELETE------------------------------------------------------------------

  if (isset($_GET['ID']) && isset($_GET['action']) && $_GET['action'] == "delete")
	{
        $Id= $_GET['ID'];

        $query = mysqli_query($conn,"DELETE FROM allusers WHERE ID='$Id'");

        if ($query == TRUE) {
			
			$statusMsg = "<div class='alert alert-success' id='statusMsg' style='margin-right:700px;'>User Deleted Successfully!</div>
<script>
    setTimeout(function() {
        var msg = document.getElementById('statusMsg');
        if (msg) {
            msg.style.display = 'none';
        }
        window.location.href = 'AllVendors.php'; // Redirect to AllVendors.php
    }, 3000); // 3 seconds
</script>";
                 
			
        }
        else{

            $statusMsg = "<div class='alert alert-danger' style='margin-right:800px;'>An error Occurred!</div>"; 
         }
      
  }


  //--------------------------------CSV Generate------------------------------------------------------------------


  if (isset($_GET['ID']) && isset($_GET['action']) && $_GET['action'] == "edit") {
    $userId = $_GET['ID'];

    // Fetch user's full name from allusers table
    $userQuery = "SELECT CONCAT(Firstname, ' ', Lastname) AS Fullname FROM allusers WHERE ID = '$userId'";
    $userResult = $conn->query($userQuery);
    $user = $userResult->fetch_assoc();
    $userFullName = $user['Fullname']; // Get the full name dynamically

    // Get vendor's hired data
    $hireQuery = "SELECT * FROM hiredvendors WHERE VendorID = '$userId'";
    $hireResult = $conn->query($hireQuery);
    $hiredData = [];
    while ($hire = $hireResult->fetch_assoc()) {
        $hiredData[] = [
            'Package ID' => $hire['PackageID'],
            'Package Name' => $hire['Packagename'],
            'Package Type' => $hire['Packagetype'],
            'Package Amount' => $hire['Packageamount'],
            'Hired Date' => $hire['HiredDate'],
            'Status' => $hire['Status'],
            'Payment Status' => $hire['PaymentStatus']
        ];
    }

    // Define the filename
    $filename = "{$userFullName}_Report.csv";

    // Set headers for CSV file download
    header('Content-Type: text/csv; charset=UTF-8');
    header('Content-Disposition: attachment; filename="' . $filename . '"');

    // Open output stream
    $output = fopen('php://output', 'w');

   // Write title as "John Doe's Report" (dynamically based on user's full name)
   fputcsv($output, ["{$userFullName}'s Report"]);

   // Add empty row for spacing
   fputcsv($output, []);
   fputcsv($output, []);

    // Write the "All Events Created" section
    fputcsv($output, ['All hired Packages']); // Section title
    fputcsv($output, []);
    fputcsv($output, ['Package ID', 'Package Name', 'Package Type', 'Package Amount', 'Hired Date', 'Status', 'Payment Status']); // Table headers

    foreach ($hiredData as $hire) {
        fputcsv($output, $hire);
    }

    
    // Close output stream
    fclose($output);
    exit; // Stop further execution
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
            <h1 class="h3 mb-0 text-gray-800">Vendors</h1>
            <ol class="breadcrumb">
              <li class="breadcrumb-item">Manage Users</li>
              <li class="breadcrumb-item active" aria-current="page">Vendors</li>
            </ol>
          </div>

          <div class="row">
            <div class="col-lg-12">
              

              <!-- Input Group -->
                 <div class="row">
              <div class="col-lg-12">
              <div class="card mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                  <h6 class="m-0 font-weight-bold text-primary">All Vendors</h6>  <?php echo $statusMsg; ?>
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
                        <th>Delete</th>
                        <th>Vendor Report</th>
                      </tr>
                    </thead>
                  
                    <tbody>

                  <?php
                      $query = "SELECT * FROM allusers WHERE Userrole = 'Vendor'";
                      $rs = $conn->query($query);
                      $num = $rs->num_rows;
                      $sn=0;
                      if($num > 0)
                      { 
                        while ($rows = $rs->fetch_assoc())
                          {
                             $sn = $sn + 1;
                            echo"
                              <tr onclick=\"window.location='Vendorprofile.php?ID=" . $rows['ID'] . "'\" style='cursor:pointer;'>
                                <td>".$sn."</td>
                                <td>".$rows['Firstname']."</td>
                                <td>".$rows['Lastname']."</td>
                                <td>".$rows['Email']."</td>
                                <td>".$rows['Phone']."</td>
                                <td>".$rows['Vendortype']."</td>
                                <td><a href='?action=delete&ID=".$rows['ID']."'><i class='fas fa-fw fa-trash'></i></a></td>
                                <td><a href='?action=edit&ID=".$rows['ID']."'><i class='fa fa-download'></i> Download Report</a></td>
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