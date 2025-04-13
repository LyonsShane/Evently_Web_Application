<?php
include '../Includes/dbcon.php';
include '../Includes/session.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $vendorID = $_POST['vendorID'];
    $eventID = $_POST['eventID'];
    $rating = $_POST['rating'];
    $reviewText = $_POST['reviewText'];
    $userID = $_SESSION['userId'];
    $AddedDate = date('Y-m-d');

    $stmt = $conn->prepare("INSERT INTO vendorreviews (UserID, VendorID, EventID, Rating, ReviewText, AddedDate) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("iiiiss", $userID, $vendorID, $eventID, $rating, $reviewText, $AddedDate);

    if ($stmt->execute()) {
        echo "Review added successfully!";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>
