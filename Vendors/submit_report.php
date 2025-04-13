<?php
include '../Includes/dbcon.php';
include '../Includes/session.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $userID = $_POST['vendorID'];
    $reason = $_POST['reason'];
    $vendorID = $_SESSION['userId'];
    $AddedDate = date('Y-m-d');

    $stmt = $conn->prepare("INSERT INTO userreports (VendorID, UserID, Reason, AddedDate) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("iiss", $vendorID, $userID, $reason, $AddedDate);

    if ($stmt->execute()) {
        echo "Report submitted successfully!";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>
