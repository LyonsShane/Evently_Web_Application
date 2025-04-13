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
  <link href="img/logo/logo.png" rel="icon">
  <title>Evently</title>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
  <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet">
  <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="css/ruang-admin.min.css" rel="stylesheet">
  <style>
      #passwordMessage {
          font-size: 14px;
          margin-top: 5px;
      }
      .match {
          color: green;
      }
      .nomatch {
          color: red;
      }

      .password-container {
        position: relative;
        width: 100%;
    }
    .password-container input {
        width: 100%;
        padding-right: 40px; /* Make space for the eye icon */
    }
    .password-container .eye-icon {
        position: absolute;
        right: 10px;
        top: 50%;
        transform: translateY(-50%);
        cursor: pointer;
        color: #aaa;
    }
    .password-container .eye-icon:hover {
        color: #333;
    }
  </style>
</head>

<body class="bg-gradient-login" style="background-image: url('img/logo/loral1.jpg');">
  <div class="container-login">
    <div class="row justify-content-center">
      <div class="col-xl-10 col-lg-12 col-md-9">
        <div class="card shadow-sm my-5">
          <div class="card-body p-0">
            <div class="row">
              <div class="col-lg-12">
                <div class="login-form">
                  <div class="text-center">
                    <img src="img/logo/logo.png" style="width:100px;height:100px"><br><br>
                    <h1 class="h4 text-gray-900 mb-4">Vendor Registration</h1>
                  </div>
                  
                  <form class="user" method="POST">
                    <div class="form-group">
                      <input type="text" class="form-control" required name="fname" placeholder="Enter First Name">
                    </div>
                    <div class="form-group">
                      <input type="text" class="form-control" required name="lname" placeholder="Enter Last Name">
                    </div>
                    <div class="form-group">
                      <input type="email" class="form-control" required name="email" id="email" placeholder="Enter Email Address">
                      <span id="emailMessage"></span>
                    </div>
                    <div class="form-group">
                      <input type="number" class="form-control" required name="phone" placeholder="Enter Phone Number">
                    </div>
                    <div class="form-group">
                  	<select required name="vendorType" class="form-control mb-3">
                          <option value="">--Select Vendor Type--</option>
                          <option value="Hotel">Hotel</option>
                          <option value="Florist">Florist</option>
					      <option value="Photographer">Photographer</option>
						  <option value="Videographer">Videographer</option>
                          <option value="Dj_Artist">Dj Artist</option>
					      <option value="Music_Band">Music Band</option>
						  <option value="Catering">Catering</option>
					      <option value="Cake_Baker">Cake Baker</option>
                        </select>
                    </div>

                    <div class="form-group password-container">
                    <div class="input-group">
                      <input type="password" name="password" required class="form-control" id="password" placeholder="Enter Password">
                      <div class="input-group-append">
                            <span class="input-group-text">
                                <i class="fas fa-eye-slash" id="eyeIcon1" onclick="togglePassword('password', 'eyeIcon1')"></i>
                            </span>
                        </div>
                    </div>                        
                    </div>
                    <div class="form-group password-container">
                    <div class="input-group">
                      <input type="password" name="confirmpassword" required class="form-control" id="confirmPassword" placeholder="Confirm Password">
                      <div class="input-group-append">
                              <span class="input-group-text">
                                  <i class="fas fa-eye-slash" id="eyeIcon2" onclick="togglePassword('confirmPassword', 'eyeIcon2')"></i>
                              </span>
                          </div>
                      </div>
                      <span id="passwordMessage"></span>
                    </div>
                    <div class="form-group">
                        <input type="submit" class="btn btn-success btn-block" value="Register" name="Register" />
                    </div>
                    <div class="form-group row mb-3 d-flex flex-row align-items-center flex-column gap-2">
                        <p>Already have an account ?</p> <a href="login.php"> <p>Log in</p> </a>
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
                  
                  <script>
                    $(document).ready(function() {
                        $("#email").on("keyup", function() {
                            var email = $(this).val();
                            if (email.length > 3) {
                                $.ajax({
                                    url: "check_email.php", // This script checks if the email exists
                                    method: "POST",
                                    data: { email: email },
                                    success: function(response) {
                                        if (response == "exists") {
                                            $("#emailMessage").text("❌ This email is already in use. Try another one.").css("color", "red");
                                        } else {
                                            $("#emailMessage").text("✅ Email is available!").css("color", "green");
                                        }
                                    }
                                });
                            } else {
                                $("#emailMessage").text("");
                            }
                        });
                    });
                    </script>

                  <script>
                  $(document).ready(function() {
                      $("#confirmPassword, #password").on("keyup", function() {
                          var password = $("#password").val();
                          var confirmPassword = $("#confirmPassword").val();
                          
                          if (confirmPassword === "") {
                              $("#passwordMessage").text("").removeClass("match nomatch");
                          } else if (password === confirmPassword) {
                              $("#passwordMessage").text("✅ Password match!").removeClass("nomatch").addClass("match");
                          } else {
                              $("#passwordMessage").text("❌ Password do not match!").removeClass("match").addClass("nomatch");
                          }
                      });
                  });
                  </script>

                  <?php
                  if (isset($_POST['Register'])) {
                      include 'Includes/dbcon.php'; // Ensure database connection is included
                      
                      $email = $_POST['email'];

                      // Check if email exists in the database
                      $checkQuery = $conn->prepare("SELECT * FROM allusers WHERE Email = ?");
                      $checkQuery->bind_param("s", $email);
                      $checkQuery->execute();
                      $checkQuery->store_result();

                      if ($checkQuery->num_rows > 0) {
                          echo "<script>alert('This email is already in use. Try another one!');</script>";
                          exit();
                      }

                      $checkQuery->close();
                      
                    

                      $fname = $_POST['fname'];
                      $lname = $_POST['lname'];
                      $email = $_POST['email'];
                      $phone = $_POST['phone'];
                      $vendortype = $_POST['vendorType'];
                      $userrole = "Vendor";
                      $password = $_POST['password'];
                      $confirmpassword = $_POST['confirmpassword'];

                      // Check if passwords match
                      if ($password !== $confirmpassword) {
                          echo "<script>alert('Passwords do not match!');</script>";
                          exit();
                      }

                      // Hash the password before storing
                      $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

                      // Use prepared statements for security
                      $query = $conn->prepare("INSERT INTO allusers (Firstname, Lastname, Email, Phone, Vendortype, Userrole, Password) VALUES (?, ?, ?, ?, ?, ?, ?)");
                      $query->bind_param("sssssss", $fname, $lname, $email, $phone, $vendortype, $userrole, $hashedPassword);

                      if ($query->execute()) {
                          echo "<script>alert('Vendor Successfully Registered!'); window.location.href='login.php';</script>";
exit();
                      } else {
                          echo "<script>alert('Vendor Registration Failed!');</script>";
                      }

                      // Close the statement
                      $query->close();
                      $conn->close();
                  }
                  ?>

                  <div class="text-center"></div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <script src="vendor/jquery/jquery.min.js"></script>
  <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="vendor/jquery-easing/jquery.easing.min.js"></script>
  <script src="js/ruang-admin.min.js"></script>
</body>
</html>
