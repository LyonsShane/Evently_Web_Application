<?php
include '../Includes/dbcon.php';
include '../Includes/session.php';

// cancel_hire.php
if (isset($_GET['vendorID'], $_GET['eventID'], $_GET['packageID'])) {
    $vendorId = intval($_GET['vendorID']);
    $eventId = intval($_GET['eventID']);
    $packageId = intval($_GET['packageID']);

    // Process the cancel hire request here
    $query = "DELETE FROM hiredvendors WHERE VendorID = '$vendorId' AND EventID = '$eventId' AND PackageID = '$packageId'";
    if (mysqli_query($conn, $query)) {
        echo "Hire request canceled.";
        exit;
    } else {
        echo "Failed to cancel hire request.";
        exit;
    }
}

?>
