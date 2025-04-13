
<?php 
error_reporting(0);
include '../Includes/dbcon.php';
include '../Includes/session.php';
include 'Includes/check.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

require '../vendor/autoload.php';


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
        window.location.href = 'AllUsers.php'; // Redirect to AllUsers.php
    }, 3000); // 3 seconds
</script>";
                 
			
        }
        else{

            $statusMsg = "<div class='alert alert-danger' style='margin-right:700px;'>An error Occurred!</div>"; 
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

    // Get user's events data
    $eventQuery = "SELECT * FROM events WHERE UserID = '$userId'";
    $eventResult = $conn->query($eventQuery);
    $eventsData = [];
    while ($event = $eventResult->fetch_assoc()) {
        $eventsData[] = [
            'Event ID' => $event['ID'],
            'Event Name' => $event['Eventname'],
            'Event Date' => $event['EventDate'],
            'Event Time' => $event['EventTime'],
            'Location' => $event['Location'],
            'Event Description' => $event['Description'],
            'Event Created Date' => $event['EventCreated']
        ];
    }

    // Get user's hired vendors data with vendor details from 'allusers' table
    $vendorQuery = "
        SELECT hv.VendorID as VendorID, hv.Packagename, hv.Packageamount, hv.HiredDate, 
               CONCAT(au.Firstname, ' ', au.Lastname) as Vendorname, 
               au.Vendortype
        FROM hiredvendors hv
        LEFT JOIN allusers au ON hv.VendorID = au.ID
        WHERE hv.UserID = '$userId' AND hv.Status = 'Accepted'
    ";
    $vendorResult = $conn->query($vendorQuery);
    $vendorsData = [];
    $totalPackageAmount = 0;
    while ($vendor = $vendorResult->fetch_assoc()) {
        $vendorsData[] = [
            'Vendor ID' => $vendor['VendorID'],
            'Vendor Name' => $vendor['Vendorname'],
            'Vendor Type' => $vendor['Vendortype'],
            'Package Name' => $vendor['Packagename'],
            'Package Amount' => $vendor['Packageamount'],
            'Hired Date' => $vendor['HiredDate']
        ];
        $totalPackageAmount += $vendor['Packageamount'];
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
    fputcsv($output, ['All Events Created']); // Section title
    fputcsv($output, []);
    fputcsv($output, ['Event ID', 'Event Name', 'Event Date', 'Event Time', 'Location', 'Event Description', 'Event Created Date']); // Table headers

    foreach ($eventsData as $event) {
        fputcsv($output, $event);
    }

    // Add empty row for spacing
    fputcsv($output, []);
    fputcsv($output, []);

    // Write the "All Vendors Hired" section
    fputcsv($output, ['All Vendors Hired']); // Section title
    fputcsv($output, []);
    fputcsv($output, ['Vendor ID', 'Vendor Name', 'Vendor Type', 'Package Name', 'Package Amount', 'Hired Date']); // Table headers

    foreach ($vendorsData as $vendor) {
        fputcsv($output, $vendor);
    }

    fputcsv($output, []);

    // Add total package amount row
    fputcsv($output, ['Total Package Amount', '', '', '', $totalPackageAmount, '']);

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
            <h1 class="h3 mb-0 text-gray-800">Users</h1>
            <ol class="breadcrumb">
              <li class="breadcrumb-item">Manage Users</li>
              <li class="breadcrumb-item active" aria-current="page">Users</li>
            </ol>
          </div>

          

          <div class="row">
            <div class="col-lg-12">
              

              <!-- Input Group -->
                 <div class="row">
              <div class="col-lg-12">
              <div class="card mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                  <h6 class="m-0 font-weight-bold text-primary">All Users</h6>  <?php echo $statusMsg; ?>
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
                        <th>Delete</th>
                        <th>User Report</th>
                      </tr>
                    </thead>
                  
                    <tbody>

                  <?php
                      $query = "SELECT * FROM allusers WHERE Userrole = 'User'";
                      $rs = $conn->query($query);
                      $num = $rs->num_rows;
                      $sn=0;
                      if($num > 0)
                      { 
                        while ($rows = $rs->fetch_assoc())
                          {
                             $sn = $sn + 1;
                            echo"
                              <tr onclick=\"window.location='UserProfile.php?ID=" . $rows['ID'] . "'\" style='cursor:pointer;'>
                                <td>".$sn."</td>
                                <td>".$rows['Firstname']."</td>
                                <td>".$rows['Lastname']."</td>
                                <td>".$rows['Email']."</td>
                                <td>".$rows['Phone']."</td>
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