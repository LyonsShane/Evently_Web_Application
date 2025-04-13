
<?php 
include '../Includes/dbcon.php';
include '../Includes/session.php';


   $query = "SELECT vendorpackages.Packagename FROM allusers
    INNER JOIN vendorpackages ON vendorpackages.VendorID = allusers.ID
    Where allusers.ID = '$_SESSION[userId]'";


    $rs = $conn->query($query);
    $num = $rs->num_rows;
    $rrw = $rs->fetch_assoc();

$query = "SELECT * FROM allusers WHERE ID = '$_SESSION[userId]'"; 
	$result = $conn->query($query);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
	$Profilepic = $row['ProfilePic'];
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
  <title>Evently</title>
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
            <h1 class="h3 mb-0 text-gray-800">Vendor Dashboard</h1>
            <ol class="breadcrumb">
              <li class="breadcrumb-item">Home</li>
              <li class="breadcrumb-item active" aria-current="page">Vendor Dashboard</li>
            </ol>
          </div>

          <div class="row mb-3">
          
          <?php 
$query1=mysqli_query($conn,"SELECT * from vendorpackages where VendorID = '$_SESSION[userId]'");                       
$packages = mysqli_num_rows($query1);
?>
            <div class="col-xl-3 col-md-6 mb-4">
              <div class="card h-100">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-uppercase mb-1">Total Packages</div>
                      <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800"><?php echo $packages;?></div>
                      <div class="mt-2 mb-0 text-muted text-xs">
                      </div>
                    </div>
                    <div class="col-auto">
                      <i class="fa fa-server fa-2x text-info"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>
           
             <?php 
$query1=mysqli_query($conn,"SELECT * from hiredvendors where VendorID = '$_SESSION[userId]' And Status = 'Completed'");                       
$Eventshired = mysqli_num_rows($query1);
?>
            <div class="col-xl-3 col-md-6 mb-4">
              <div class="card h-100">
                <div class="card-body">
                  <div class="row align-items-center">
                    <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-uppercase mb-1">Total Events Completed</div>
                      <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $Eventshired;?></div>
                      <div class="mt-2 mb-0 text-muted text-xs">
                      </div>
                    </div>
                    <div class="col-auto">
                      <i class="fa fa-tasks fa-2x text-primary"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>
			  
             <?php 
$query1=mysqli_query($conn,"SELECT SUM(PaidAmount) AS total_amount FROM hiredvendors where VendorID = '$_SESSION[userId]'");                       
$row = mysqli_fetch_assoc($query1);
$totalamount = $row['total_amount'];
?>
            <div class="col-xl-3 col-md-6 mb-4">
              <div class="card h-100">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-uppercase mb-1">Total Revenue</div>
                      <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $totalamount;?></div>
                      <div class="mt-2 mb-0 text-muted text-xs">
                      </div>
                    </div>
                    <div class="col-auto">
                      <i class="fa fa-university fa-2x text-success"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            
         
          
          <!--Row-->


        </div>
          <div class="row">
              <div class="col-lg-12">
              <div class="card mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                  <h6 class="m-0 font-weight-bold text-primary">Recently Hired Packages</h6>
                </div>
                <div class="table-responsive p-3">
                  <table class="table align-items-center table-flush table-hover" id="dataTableHover">
                    <thead class="thead-light">
                      <tr>
                        <th>#</th>
                        <th>Package Name</th>
                        <th>Package Amount (LKR)</th>
                        <th>Hired Date</th>
                        <th>Hired By</th>
                        <th>Hired For</th>
                      </tr>
                    </thead>
                   
                    <tbody>

                  <?php
                      $query = "SELECT hv.*, 
                      CONCAT(u.Firstname, ' ', u.Lastname) AS HiredByName, e.EventType 
                      FROM hiredvendors hv
                      LEFT JOIN allusers u ON hv.UserID = u.ID
                      LEFT JOIN events e ON hv.EventID = e.ID
                      WHERE hv.VendorID = '$_SESSION[userId]' And Status = 'Pending' 
                      ORDER BY hv.ID DESC 
                      LIMIT 5";                      
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
                                <td>".$rows['Packagename']."</td>
                                <td>".$rows['Packageamount']."</td>
                                <td>".$rows['HiredDate']."</td>
                                <td>".$rows['HiredByName']."</td>
                                <td>".$rows['EventType']."</td>
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
      <!-- Footer -->
      <?php include 'includes/footer.php';?>
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
  <script src="../vendor/chart.js/Chart.min.js"></script>
  <script src="js/demo/chart-area-demo.js"></script>  
</body>

</html>