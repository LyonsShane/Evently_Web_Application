<?php

//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

//Load Composer's autoloader
require 'vendor/autoload.php';
require_once "smtp-config.php";
$response = array();
$mail = new PHPMailer(true);

try {

    $mail->SMTPOptions = array(
        'ssl' => array('verify_peer' => false, 'verify_peer_name' => false, 'allow_self_signed' => true)
    );                                                    //Server settings
    $mail->isSMTP('true');                                //Send using SMTP
    $mail->Host = $smtp_host;                             //Set the SMTP server to send through
    $mail->SMTPAuth = true;                               //Enable SMTP authentication
    $mail->Username = $smtp_username;                     //SMTP username
    $mail->Password = $smtp_password;                     //SMTP password
    $mail->SMTPSecure = $smtp_secure;                     //Enable implicit TLS encryption//TLS or SSL
    $mail->Port = $smtp_port;                             //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

    //Recipients
    $mail->setFrom($smtp_email, $sender);

    $mail->addAddress($user_email); //Name is optional (Recipient/S)

    //Content
    $mail->isHTML(true);

    $mail->Subject = $subject;
    $mail->Body = '
    <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Wineyard - Account Deletion Confirmation</title>
    <style>
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        @keyframes pulse {
            0% { transform: scale(1); }
            50% { transform: scale(1.05); }
            100% { transform: scale(1); }
        }
        @keyframes gradientFlow {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }
        body {
            font-family: \'Arial\', sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            line-height: 1.6;
        }
        .email-container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            border-radius: 15px;
            box-shadow: 0 8px 20px rgba(0,0,0,0.1);
            overflow: hidden;
            animation: fadeIn 1s ease-out;
        }
        .email-header {
            background: linear-gradient(135deg, #8A2387, #E94057, #F27121);
            background-size: 400% 400%;
            color: white;
            text-align: center;
            padding: 20px;
            animation: gradientFlow 10s ease infinite;
        }
        .email-body {
            padding: 30px;
            text-align: center;
        }
        .otp-code {
            background-color: #f0f0f0;
            border-radius: 12px;
            padding: 15px;
            font-size: 28px;
            letter-spacing: 8px;
            margin: 20px 0;
            display: inline-block;
            color: #333;
            font-weight: bold;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            animation: pulse 2s infinite;
        }
        .warning-text {
            color: #D8000C;
            font-weight: bold;
            margin-bottom: 20px;
            animation: fadeIn 1s ease-out;
        }
        .email-footer {
            background-color: #f4f4f4;
            text-align: center;
            padding: 15px;
            font-size: 12px;
            color: #888;
        }
        .logo {
            max-width: 120px;
            margin: 10px 0;
            animation: pulse 3s infinite;
        }
        .recovery-info {
            background-color: #F9F9F9;
            border-left: 6px solid #E94057;
            padding: 15px;
            margin: 20px 0;
            text-align: left;
            border-radius: 8px;
            animation: fadeIn 1.5s ease-out;
        }
        .recovery-info ul {
            padding-left: 20px;
        }
        .heart-icon {
            color: #E94057;
            font-size: 24px;
            margin-bottom: 10px;
            animation: pulse 2.5s infinite;
            display: inline-block;
        }
    </style>
</head>
<body>
    <table cellpadding="0" cellspacing="0" border="0" width="100%">
        <tr>
            <td align="center" style="padding: 20px;">
                <div class="email-container">
                    <div class="email-header">
                        <img src="' . $image_url . 'logo.png" alt="Wineyard Logo" class="logo">
                        <h1>Account Deletion Confirmation</h1>
                    </div>
                    <div class="email-body">
                        <div class="heart-icon">🍇</div>
                        <p class="warning-text">IMPORTANT: Account Deletion Request</p>
                        <p>You\'ve requested to delete your Wineyard account. To confirm this irreversible action, please use the following One-Time Password (OTP):</p>
                        <div class="otp-code">
                            ' . $otp_code . '
                        </div>
                        <div class="recovery-info">
                            <strong>Before You Delete:</strong>
                            <p>Once your account is deleted, you cannot recover:</p>
                            <ul>
                                <li>Your profile information</li>
                                <li>Conversation history</li>
                                <li>Matches and connections</li>
                            </ul>
                        </div>
                        <p>This OTP will expire in 15 minutes. If you did not request account deletion, please contact our support team immediately.</p>
                    </div>
                    <div class="email-footer">
                        © ' . date("Y") . ' Wineyard. All rights reserved.
                    </div>
                </div>
            </td>
        </tr>
    </table>
</body>
</html>
    ';

    $mail->send();
//    $response["value"] = 1;
//    $response["message"] = "Message has been sent successfully";
//    header('Content-Type: application/json; charset=utf-8');
//    echo json_encode($response);
} catch (Exception $e) {
//    $response["value"] = 0;
//    $response["message"] = "Mailer Error" . $mail->ErrorInfo;
//    header('Content-Type: application/json; charset=utf-8');
//    echo json_encode($response);
}
?>