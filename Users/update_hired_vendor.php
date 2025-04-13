<?php
// Assuming you have a database connection file included
include '../Includes/dbcon.php';
include '../Includes/session.php';

// Check if the POST request contains all necessary fields
if (isset($_POST['packageID']) && isset($_POST['userID']) && isset($_POST['vendorID']) && isset($_POST['eventID']) && isset($_POST['paymentStatus']) && isset($_POST['paidAmount'])) {
    // Get data from the AJAX request
    $packageID = (int) $_POST['packageID'];
    $userID = (int) $_POST['userID'];
    $vendorID = (int) $_POST['vendorID'];
    $eventID  = (int) $_POST['eventID'];
    $paymentStatus = $_POST['paymentStatus'];
    $paidAmount = (int) $_POST['paidAmount'];

    



    // Update the hired_vendors table based on matching criteria
    $sql = "UPDATE hiredvendors 
            SET PaymentStatus = ?, PaidAmount = ? 
            WHERE PackageID = ? AND UserID = ? AND VendorID = ? AND EventID = ?";

    // Prepare the query
    if ($stmt = $conn->prepare($sql)) {
        // Bind the parameters
        $stmt->bind_param("siiiii", $paymentStatus, $paidAmount, $packageID, $userID, $vendorID, $eventID);
        $stmt->execute();
        // Execute the query
        if ($stmt->affected_rows > 0) {
            echo "Payment Successfully Done!";
        } else {
            echo "No rows matched the update. Check your IDs.";
        }

        // Close the statement
        $stmt->close();
    } else {
        echo "Error: " . $conn->error;
    }
} else {
    echo "Error: Missing required fields";
}

// Close the database connection
$conn->close();
?>
