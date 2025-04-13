
<?php 
include 'Includes/dbcon.php';
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <link href="img/logo/logo.png" rel="icon">
  <title>Evently</title>
  <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css">
  <link href="css/ruang-admin.min.css" rel="stylesheet">

</head>

<body class="bg-gradient-login" style="background-image: url('img/logo/loral1.jpe00g');">
  <!-- Login Content -->
  <div class="container-login">
    <div class="row justify-content-center">
      <div class="col-xl-10 col-lg-12 col-md-9">
        <div class="card shadow-sm my-5">
          <div class="card-body p-0">
            <div class="row">
              <div class="col-lg-12">
                <div class="login-form">
                
                  <div class="text-center">
                    <img src="img/logo/logo.png" style="width:100px;height:100px">
                    <br><br>
                    <h1 class="h4 text-gray-900 mb-4">Login</h1>
                  </div>
                  <form class="user" method="Post" action="">
                    <div class="form-group">
                      <input type="text" class="form-control" required name="username" id="exampleInputEmail" placeholder="Enter Email Address">
                    </div>
                    <div class="form-group">
                    <div class="input-group">
                      <input type="password" name="password" required class="form-control" id="exampleInputPassword" placeholder="Enter Password">
                      <div class="input-group-append">
                            <span class="input-group-text">
                                <i class="fas fa-eye-slash" id="eyeIcon" onclick="togglePassword('exampleInputPassword', 'eyeIcon')"></i>
                            </span>
                        </div>
                    </div>
                    </div>
                    <div class="form-group">
                      <div class="custom-control custom-checkbox small" style="line-height: 1.5rem;">
                        <input type="checkbox" class="custom-control-input" id="customCheck">
                      </div>
                    </div>
                    <div class="form-group">
                        <input type="submit"  class="btn btn-success btn-block" value="Login" name="login" />
                    </div>
                    <div class="form-group row mb-3 d-flex flex-row align-items-center flex-column gap-2">
                        <p>Don't have an account ?</p> <a href="user_registration.php"> <p>Register as a user</p> </a> <a href="vendor_registration.php"> <p>Register as a vendor</p> </a>
                    </div>
                     </form>

                     <script>
                      function togglePassword(passwordFieldId, eyeIconId) {
                          var passwordField = document.getElementById(passwordFieldId);
                          var eyeIcon = document.getElementById(eyeIconId);

                          if (passwordField.type === "password") {
                              passwordField.type = "text";
                              eyeIcon.classList.remove("fa-eye-slash");
                              eyeIcon.classList.add("fa-eye");
                          } else {
                              passwordField.type = "password";
                              eyeIcon.classList.remove("fa-eye");
                              eyeIcon.classList.add("fa-eye-slash");
                          }
                      }
                      </script>


<?php
					
  if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['login'])) {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    if (!empty($username) && !empty($password)) {
        $query = "SELECT * FROM allusers WHERE Email = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();
            
            if (password_verify($password, $user['Password'])) { // Assuming passwords are hashed
                $_SESSION['userId'] = $user['ID'];
                $_SESSION['FirstName'] = $user['Firstname'];
                $_SESSION['LastName'] = $user['Lastname'];
                $_SESSION['Email'] = $user['Email'];
                $_SESSION['UserRole'] = $user['Userrole'];

                //echo $user['Userrole'];
                
                // Redirect based on user role
                switch ($user['Userrole']) {
                    case 'Admin':
                        header('Location:' . $base_url. 'Admin/index.php');
                        break;
                    case 'User':
                        //header("Location: Users/index.php");
                        header('Location:' . $base_url. 'Users/index.php');
                        break;
                    case 'Vendor':
                        //header("Location: Vendors/index.php");
                        header('Location:' . $base_url. 'Vendors/index.php');
                        break;
                    default:
                        //header("Location: index.php");
                        break;
                }
                exit();
            } else {
                echo "Invalid Email or Password! ";
            }
        } else {
            echo "Invalid Email or Password!";
        }
    } else {
        echo "Please enter both Email and Password.";
    }
}
?>


                
                  <div class="text-center">
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- Login Content -->
  <script src="vendor/jquery/jquery.min.js"></script>
  <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="vendor/jquery-easing/jquery.easing.min.js"></script>
  <script src="js/ruang-admin.min.js"></script>
</body>

</html>