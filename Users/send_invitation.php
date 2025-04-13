<?php

error_reporting(0);
include '../Includes/dbcon.php';
include '../Includes/session.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';
include("smtp-config.php");




if(isset($_POST['save'])) {
    $Email = $_POST['Email'];
    $Subject = $_POST['Subject'];
    $Description = $_POST['Description'];
    $InvitedDate = date("Y-m-d");
    $userId = $_SESSION['userId'];
    $eventId = $_POST['EventID'];
    $Attachments = "";

    // File Upload Handling with Security Improvements
$Attachments = "";
if (!empty($_FILES['Attachments']['name'])) {
    $maxFileSize = 5 * 1024 * 1024; // 5MB max
    if ($_FILES["Attachments"]["size"] > $maxFileSize) {
        die("<div class='alert alert-danger'>File too large! Max size is 5MB.</div>");
    }

    $targetDir = "../uploads/Invitation_Attachments/"; // Secure directory
    if (!file_exists($targetDir)) {
        mkdir($targetDir, 0777, true); // Create if not exists
    }

    $fileName = time() . "_" . basename($_FILES["Attachments"]["name"]); // Prevent collisions
    $targetFilePath = $targetDir . $fileName;
    $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);

    $allowTypes = array('jpg', 'png', 'jpeg', 'pdf', 'doc', 'docx');
    if (in_array(strtolower($fileType), $allowTypes)) {
        if (move_uploaded_file($_FILES["Attachments"]["tmp_name"], $targetFilePath)) {
            $Attachments = $targetFilePath;
        } else {
            die("<div class='alert alert-danger'>Error uploading file!</div>");
        }
    } else {
        die("<div class='alert alert-danger'>Invalid file type! Allowed: jpg, png, jpeg, pdf, doc, docx.</div>");
    }
}


    // Insert into Database
    $query = mysqli_query($conn, "INSERT INTO invitedguests (InvitedEmails, Subject, Attachments, Description, InvitedDate, UserID, EventID) 
    VALUES ('$Email', '$Subject', '$Attachments', '$Description', '$InvitedDate', '$userId', '$eventId')");

    if ($query) {
        // **Send Email Notification**
        $mail = new PHPMailer(true);
        try {
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com'; // Replace with SMTP server
            $mail->SMTPAuth = true;
            $mail->Username = 'evently.invite@gmail.com'; // SMTP username
            $mail->Password = 'dvht bdfm snkh glzz'; // SMTP password
            $mail->SMTPSecure = 'tls';
            $mail->Port = 587;

            $mail->setFrom('evently.invite@gmail.com', 'Evently');
            
            // **Handle multiple email recipients**
            $emails = explode(',', $Email);
            foreach ($emails as $email) {
                $mail->addAddress(trim($email));
            }

            $mail->isHTML(true);
            $mail->Subject = $Subject;
            $mail->Body    = "<p>$Description</p>";

            // Attach File
            if (!empty($Attachments)) {
                $mail->addAttachment($Attachments);
            }

            if ($mail->send()) {
                echo "<div class='alert alert-success'>Invitation sent successfully!</div>";
            } else {
                echo "<div class='alert alert-danger'>Email sending failed.</div>";
            }
        } catch (Exception $e) {
            echo "<div class='alert alert-danger'>Mailer Error: {$mail->ErrorInfo}</div>";
        }
    } else {
        echo "<div class='alert alert-danger'>An error occurred while saving invitation!</div>";
    }
}
?>

<script>
    // Function to hide alerts after 3 seconds
    setTimeout(function () {
        let alertBox = document.querySelector(".alert");
        if (alertBox) {
            alertBox.style.transition = "opacity 0.5s";
            alertBox.style.opacity = "0";
            setTimeout(() => {
                alertBox.remove();
                location.reload(); // Refresh the page
            }, 500); // Remove alert and then refresh
        }
    }, 3000);

    // Reset the form after submission
    function resetForm() {
        document.getElementById("inviteForm").reset();
    }
</script>

<style>
    .alert {
        margin-top: 10px; /* Adds gap between button and alert */
    }
</style>

