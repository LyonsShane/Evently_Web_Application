
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

if (!isset($_GET['ID'])) {
  die("Missing required parameters.");
}

$eventId = intval($_GET['ID']);






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


				
            <h1 class="h3 mb-0 text-gray-800">Invite Guests </h1>
			 
           
          </div>

          <div class="row">
            <div class="col-lg-12">
              <!-- Form Basic -->
              <div class="card mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                  <h6 class="m-0 font-weight-bold text-primary">Send Guest Invitations</h6>
                    <?php echo $statusMsg; ?>
                </div>
                <div class="card-body">
    <form id="invitationForm" enctype="multipart/form-data" method="POST" onsubmit="resetForm()">
        <div class="form-group row mb-3">
            <div class="col-xl-6">
                <label class="form-control-label">Email (You can add more than one email & <b> Type an email and press Enter</b>)
                    <span class="text-danger ml-2">*</span></label>
                <input type="text" class="form-control" id="email-input" placeholder="Type an email and press Enter">
                <div id="email-container" class="border p-2 rounded"></div>
                <input type="hidden" name="Email" id="email-hidden">
                <input type="hidden" name="EventID" value="<?php echo $eventId; ?>">
            </div>
            <br>
            <div class="col-xl-6">
                <label class="form-control-label">Subject<span class="text-danger ml-2">*</span></label>
                <input type="text" class="form-control" name="Subject" required>
            </div>
        </div>

        <div class="form-group row mb-3">
            <br>
            <div class="col-xl-6">
                <label class="form-control-label">Attachments<span class="text-danger ml-2">*</span></label>
                <input type="file" class="form-control" name="Attachments">
            </div>

            <div class="col-xl-6">
                <label class="form-control-label">Description<span class="text-danger ml-2">*</span></label>
                <textarea class="form-control" required oninput="resizeTextarea(this)" name="Description"></textarea>
            </div>
        </div>

        <script>
            function resizeTextarea(el) {
                el.style.height = "auto"; 
                el.style.height = (el.scrollHeight) + "px";
            }
        </script>

        <button type="submit" name="save" class="btn btn-primary">Submit & Send</button>
    </form>

    <div id="response"></div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    let emailList = [];

    $('#email-input').keypress(function(event) {
        if (event.key === 'Enter') {
            event.preventDefault();
            let email = this.value.trim();
            if (email && validateEmail(email)) {
                if (!emailList.includes(email)) {
                    emailList.push(email);
                    updateEmailList();
                }
                this.value = '';
            } else {
                alert("Invalid email format.");
            }
        }
    });

    function validateEmail(email) {
        return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email);
    }

    function updateEmailList() {
        let container = $('#email-container');
        container.html('');

        emailList.forEach((email, index) => {
            let emailTag = $('<span class="badge badge-primary m-1 p-2"></span>').html(email + ' <span class="remove-email" onclick="removeEmail(' + index + ')"style="cursor: pointer;">&times;</span>');
            container.append(emailTag);
        });

        $('#email-hidden').val(emailList.join(','));
    }

    function removeEmail(index) {
        emailList.splice(index, 1);
        updateEmailList();
    }

    $('#invitationForm').submit(function(event) {
        event.preventDefault();

        let formData = new FormData(this);
        formData.append("save", "true");

        $.ajax({
            url: "send_invitation.php", 
            type: "POST",
            data: formData,
            processData: false,
            contentType: false,
            beforeSend: function() {
                $('#response').html('<div class="alert alert-info">Sending invitation...</div>');
            },
            success: function(response) {
                $('#response').html(response);
            },
            error: function() {
                $('#response').html('<div class="alert alert-danger">Error sending invitation.</div>');
            }
        });
    });
</script>

              </div>
 
  
  
  
                    
                      

              <!-- Input Group -->
                 <div class="row">
              <div class="col-lg-12">
              <div class="card mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                  <h6 class="m-0 font-weight-bold text-primary">All Sent Invitations</h6>
                </div>
                <div class="table-responsive p-3">
                  <table class="table align-items-center table-flush table-hover" id="dataTableHover">
                    <thead class="thead-light">
                      <tr>
                        <th>#</th>
                        <th>Invited Emails</th>
                        <th>Subject</th>
                        <th>Attchments</th>
                        <th>Description</th>
                        <th>Invited Date</th>
                      </tr>
                    </thead>
                
                    <tbody>

                  <?php
                      $stmt = $conn->prepare("SELECT * FROM invitedguests WHERE UserID = ? AND EventID = ?");
                      $stmt->bind_param("ii", $_SESSION['userId'], $eventId);
                      $stmt->execute();
                      $rs = $stmt->get_result();
                      $num = $rs->num_rows;
                      
                      $sn=0;
                      $status="";
                      if($num > 0)
                      { 
                        while ($rows = $rs->fetch_assoc())
                          {
                             $sn = $sn + 1;
							$Description = strlen($rows['Description']) > 50 ? substr($rows['Description'], 0, 50) . "..." : $rows['Description'];
                            echo"
                              <tr>
                                <td>".$sn."</td>
                                <td>".(strlen($rows['InvitedEmails']) > 50 ? substr($rows['InvitedEmails'], 0, 50) . "..." : $rows['InvitedEmails'])."</td>
                                <td>".$rows['Subject']."</td>
                                <td><img src='".$rows['Attachments']."' style='width:60px; height:auto; border-radius:10%;'></td>
                                <td>".$Description."</td>
                                <td>".$rows['InvitedDate']."</td>
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