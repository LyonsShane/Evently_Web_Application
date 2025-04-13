<?php
include '../Includes/dbcon.php';
include '../Includes/session.php';

// Check if required parameters are set
if (!isset($_GET['vendorID'], $_GET['eventID'], $_GET['packageID'])) {
    die("Missing required parameters.");
}

$vendorId = intval($_GET['vendorID']);
$eventId = intval($_GET['eventID']);
$packageId = intval($_GET['packageID']);
$userId = $_SESSION['userId'];

// Check if the package exists for the given vendor
$query = "SELECT * FROM vendorpackages WHERE ID = '$packageId' AND VendorID = '$vendorId'";
$result = $conn->query($query);

if ($result->num_rows === 0) {
    die("Package not found.");
}

// Fetch package details
$package = $result->fetch_assoc();
$packageName = $package['Packagename'];
$packageType = $package['Packagetype'];
$packageAmount = $package['Amount'];
$hiredDate = date("Y-m-d");
$status = "Pending";
$paymentstatus = "Pending";

// Check if the vendor has already been hired for this event and package
$checkQuery = "SELECT * FROM hiredvendors WHERE VendorID = '$vendorId' AND EventID = '$eventId' AND PackageID = '$packageId' AND Status = 'Pending' OR 'Accepted' OR 'Completed'";
$checkResult = $conn->query($checkQuery);

if ($checkResult->num_rows > 0) {
    // Vendor has already been hired for this event and package
    echo "This package has been already hired";
} else {
    // Insert the vendor hire into the database
    $query = "INSERT INTO hiredvendors (PackageID, UserID, VendorID, EventID, PackageName, PackageType, PackageAmount, HiredDate, Status, PaymentStatus) 
                    VALUES ('$packageId', '$userId', '$vendorId', '$eventId', '$packageName', '$packageType', '$packageAmount', '$hiredDate', '$status', '$paymentstatus')";

if (mysqli_query($conn, $query)) {
    echo "Vendor hired successfully.";
    exit;
} else {
    echo "Failed to hire vendor.";
    exit;
}
}
?>
