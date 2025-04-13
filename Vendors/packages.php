
<?php 
error_reporting(0);
include '../Includes/dbcon.php';
include '../Includes/session.php';


$query = "SELECT vendorpackages.Packagename FROM allusers
    INNER JOIN vendorpackages ON vendorpackages.VendorID = allusers.ID
    Where allusers.ID = '$_SESSION[userId]'";


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
    
  $Packagename=$_POST['Packagename'];
  $Packagetype=$_POST['Packagetype'];
  $Amount=$_POST['Amount'];
  $Details=$_POST['Details'];
  $dateCreated = date("Y-m-d");
  $VendorID = $_SESSION[userId];
   
   

    $query=mysqli_query($conn,"INSERT INTO vendorpackages(Packagename,Packagetype,Amount,Details,Date,VendorID) 
    values ('$Packagename','$Packagetype','$Amount','$Details','$dateCreated','$VendorID')");

    if ($query) {
        
        $statusMsg = "<div class='alert alert-success'  style='margin-right:700px;'>Package Created Successfully!</div>
		<script>
    setTimeout(function() {
        var msg = document.getElementById('statusMsg');
        if (msg) {
            msg.style.display = 'none';
        }
        window.location.href = 'packages.php'; // Redirect to packages.php
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
        window.location.href = 'packages.php'; // Redirect to packages.php
    }, 3000); // 3 seconds
</script>";
    }
  }


//---------------------------------------EDIT-------------------------------------------------------------






//--------------------EDIT------------------------------------------------------------

 if (isset($_GET['ID']) && isset($_GET['action']) && $_GET['action'] == "edit")
	{
        $Id= $_GET['ID'];
	 
	 

        $query=mysqli_query($conn,"select * from vendorpackages where ID ='$Id'");
        $row=mysqli_fetch_array($query);
	 
	 
	 

        //------------UPDATE-----------------------------

        if(isset($_POST['update'])){
    
  $Packagename=$_POST['Packagename'];
  $Packagetype=$_POST['Packagetype'];
  $Amount=$_POST['Amount'];
  $Details=$_POST['Details'];
  $dateCreated = date("Y-m-d");

 $query=mysqli_query($conn,"update vendorpackages set Packagename='$Packagename', Packagetype='$Packagetype',
    Amount='$Amount', Details='$Details' where ID='$Id'");
            if ($query) {
                
                $statusMsg = "<div class='alert alert-success' id='statusMsg' style='margin-right:700px;'>Package Updated Successfully!</div>
<script>
    setTimeout(function() {
        var msg = document.getElementById('statusMsg');
        if (msg) {
            msg.style.display = 'none';
        }
        window.location.href = 'packages.php'; // Redirect to packages.php
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
        window.location.href = 'packages.php'; // Redirect to packages.php
    }, 3000); // 3 seconds
</script>";
            }
        }
    }



//--------------------------------DELETE------------------------------------------------------------------

  if (isset($_GET['ID']) && isset($_GET['action']) && $_GET['action'] == "delete")
	{
        $Id= $_GET['ID'];

        $query = mysqli_query($conn,"DELETE FROM vendorpackages WHERE ID='$Id'");

        if ($query == TRUE) {
			
			$statusMsg = "<div class='alert alert-danger' id='statusMsg' style='margin-right:700px;'>Package Deleted Successfully!</div>
<script>
    setTimeout(function() {
        var msg = document.getElementById('statusMsg');
        if (msg) {
            msg.style.display = 'none';
        }
        window.location.href = 'packages.php'; // Redirect to packages.php
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
        window.location.href = 'packages.php'; // Redirect to packages.php
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
            <h1 class="h3 mb-0 text-gray-800">Packages</h1>
            <ol class="breadcrumb">
              <li class="breadcrumb-item">Manage Packages</li>
              <li class="breadcrumb-item active" aria-current="page">Packages</li>
            </ol>
          </div>

          <div class="row">
            <div class="col-lg-12">
              <!-- Form Basic -->
              <div class="card mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                  <h6 class="m-0 font-weight-bold text-primary">Create Packages</h6>
                    <?php echo $statusMsg; ?>
                </div>
                <div class="card-body">
                  <form method="post">
                   <div class="form-group row mb-3">
                        <div class="col-xl-4">
                        <label class="form-control-label">Package Name<span class="text-danger ml-2">*</span></label>
                        <input type="text" class="form-control" name="Packagename" value="<?php echo $row['Packagename'];?>" id="exampleInputFirstName" required>
                        </div>
					   <br>
                        <div class="col-xl-4">
                        <label class="form-control-label">Package Type<span class="text-danger ml-2">*</span></label>
                      <input type="text" class="form-control" name="Packagetype" value="<?php echo $row['Packagetype'];?>" id="exampleInputFirstName" required>
                        </div>
					   <br>
					    <div class="col-xl-4">
                        <label class="form-control-label">Amount<span class="text-danger ml-2">*</span></label>
                        <input type="text" class="form-control" name="Amount" value="<?php echo $row['Amount'];?>" id="exampleInputFirstName" required>
                        </div>
                    </div>
                     <div class="form-group row mb-3">
                        <div class="col-xl-12">
                        <label class="form-control-label">Details<span class="text-danger ml-2">*</span></label>
                      <textarea class="form-control" required oninput="resizeTextarea(this)" 
        name="Details" id="exampleInputFirstName"><?php echo htmlspecialchars($row['Details']); ?></textarea>
                        </div>
						 <script>
							function resizeTextarea(el) {
								el.style.height = "auto"; // Reset height
								el.style.height = (el.scrollHeight) + "px"; // Set new height
							}
						</script>
                    </div>
                    
                      <?php
                    if (isset($Id))
                    {
                    ?>
                    <button type="submit" name="update" class="btn btn-warning">Update</button>
					<button name="cancel" class="btn btn-cancel" ><a href="packages.php">Cancel</a></button>
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    <?php
                    } else {           
                    ?>
                    <button type="submit" name="save" class="btn btn-primary">Create</button>
                    <?php
                    }         
                    ?>
                  </form>
                </div>
              </div>

              <!-- Input Group -->
                 <div class="row">
              <div class="col-lg-12">
              <div class="card mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                  <h6 class="m-0 font-weight-bold text-primary">My All Packages</h6>
                </div>
                <div class="table-responsive p-3">
                  <table class="table align-items-center table-flush table-hover" id="dataTableHover">
                    <thead class="thead-light">
                      <tr>
                        <th>#</th>
                        <th>Package Name</th>
                        <th>Package Type</th>
                        <th>Amount (LKR)</th>
                        <th>Details</th>
                        <th>Date Created</th>
                         <th>Edit</th>
                        <th>Delete</th>
                      </tr>
                    </thead>
                
                    <tbody>

                  <?php
                      $query = "SELECT * FROM vendorpackages where VendorID = '$_SESSION[userId]'";
                      $rs = $conn->query($query);
                      $num = $rs->num_rows;
                      $sn=0;
                      $status="";
                      if($num > 0)
                      { 
                        while ($rows = $rs->fetch_assoc())
                          {
                             $sn = $sn + 1;
							$details = strlen($rows['Details']) > 50 ? substr($rows['Details'], 0, 50) . "..." : $rows['Details'];
                            echo"
                              <tr>
                                <td>".$sn."</td>
                                <td>".$rows['Packagename']."</td>
                                <td>".$rows['Packagetype']."</td>
                                <td>".$rows['Amount']."</td>
                                <td>".$details."</td>
                                <td>".$rows['Date']."</td>
                                <td><a href='?action=edit&ID=".$rows['ID']."'><i class='fas fa-fw fa-edit'></i></a></td>
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