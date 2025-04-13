
<?php 
date_default_timezone_set('Asia/Colombo');

error_reporting(0);
include '../Includes/dbcon.php';
include '../Includes/session.php';

$query = "SELECT events.Eventname FROM users
    INNER JOIN events ON events.UserID = users.ID
    Where users.ID = '$_SESSION[userId]'";

$query = "SELECT * FROM allusers WHERE ID = '$_SESSION[userId]'"; 
	$result = $conn->query($query);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
	$ProfilePic = $row['ProfilePic'];
} 

else {
    
	$ProfilePic = "img/user-icn.png";
}


// Function to display "time ago" format
function timeAgo($timestamp) {
  // First, make sure we have a valid timestamp
  if (empty($timestamp)) {
      return "unknown time";
  }
  
  // Try to convert to timestamp if it's not already
  if (!is_numeric($timestamp)) {
      $timestamp = strtotime($timestamp);
      
      // If conversion failed
      if ($timestamp === false) {
          // Debug the input format
          return "Invalid date format: $timestamp";
      }
  }
    
    $currentTime = time();
    $timeDifference = $currentTime - $timestamp;

    if ($timeDifference < 60) {
        return "just now";
    } elseif ($timeDifference < 3600) {
        return floor($timeDifference / 60) . " min ago";
    } elseif ($timeDifference < 86400) {
        return floor($timeDifference / 3600) . " hours ago";
    } elseif ($timeDifference < 604800) {
        return floor($timeDifference / 86400) . " days ago";
    } elseif ($timeDifference < 2419200) {
        return floor($timeDifference / 604800) . " weeks ago";
    } elseif ($timeDifference < 29030400) {
        return floor($timeDifference / 2419200) . " months ago";
    } else {
        return floor($timeDifference / 29030400) . " years ago";
    }
}




//--------------------------------DELETE------------------------------------------------------------------

  if (isset($_GET['ID']) && isset($_GET['action']) && $_GET['action'] == "delete")
	{
        $Id= $_GET['ID'];

        $query = mysqli_query($conn,"DELETE FROM events WHERE ID='$Id'");

        if ($query == TRUE) {
			
			$statusMsg = "<div class='alert alert-success' id='statusMsg' style='margin-right:700px;'>Event Deleted Successfully!</div>
<script>
    setTimeout(function() {
        var msg = document.getElementById('statusMsg');
        if (msg) {
            msg.style.display = 'none';
        }
        window.location.href = 'Myevents.php'; // Redirect to Myevents.php
    }, 3000); // 3 seconds
</script>";
                 
			
        }
        else{

            $statusMsg = "<div class='alert alert-danger' style='margin-right:700px;'>An error Occurred!</div>"; 
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
            <h1 class="h3 mb-0 text-gray-800">My Events</h1>
            <ol class="breadcrumb">
              <li class="breadcrumb-item">Manage Events</li>
              <li class="breadcrumb-item active" aria-current="page">My Events</li>
            </ol>
          </div>

          <div class="row">
            <div class="col-lg-12">
              

              <!-- Input Group -->
                 <div class="row">
              <div class="col-lg-12">
              <div class="card mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                  <h6 class="m-0 font-weight-bold text-primary">My Events</h6>  <?php echo $statusMsg; ?>
                </div>
                <div class="table-responsive p-3">
                  <table class="table align-items-center table-flush table-hover" id="dataTableHover">
                    <thead class="thead-light">
                      <tr>
                        <th>#</th>
                        <th>Event Name</th>
                        <th>Event type</th>
                        <th>Event Date</th>
                        <th>Event Time</th>
                        <th>Location</th>
                        <th>Description</th>
                        <th>Event Created</th>
                        <th>Edit</th>
                        <th>Delete</th>
                      </tr>
                    </thead>
                  
                    <tbody>

                  <?php
                      $query = "SELECT * FROM events where UserID = '$_SESSION[userId]'";
						
                      $rs = $conn->query($query);
                      $num = $rs->num_rows;
                      $sn=0;
                      if($num > 0)
                      { 
                        while ($rows = $rs->fetch_assoc())
                          {
                            $sn = $sn + 1;
							              $Description = strlen($rows['Description']) > 30 ? substr($rows['Description'], 0, 30) . "..." : $rows['Description'];
                            echo"
                              <tr onclick=\"window.location='Eventview.php?ID=" . $rows['ID'] . "'\" style='cursor:pointer;'>
                                <td>".$sn."</td>
                                <td>".$rows['Eventname']."</td>
                                <td>".$rows['Eventtype']."</td>
                                <td>".$rows['EventDate']."</td>
                                <td>".$rows['EventTime']."</td>
                                <td>".$rows['Location']."</td>
                                <td>".$Description."</td>
                                <td>".timeAgo($rows['EventCreated'])."</td>
                                <td><a href='Editevent.php?action=edit&ID=".$rows['ID']."'><i class='fas fa-fw fa-edit'></i></a></td>
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