<?php
// Sample connection
include '../Includes/dbcon.php';

$vendorId = $_POST['vendorId'];
$packageId = $_POST['packageId'];

$query = "SELECT PaidAmount FROM hiredvendors WHERE VendorID=? AND PackageID=? AND PaymentStatus='Paid Advance Payment'";
$stmt = $conn->prepare($query);
$stmt->bind_param("ii", $vendorId, $packageId);
$stmt->execute();
$stmt->store_result();

$response = ["advancePaid" => false];

if ($stmt->num_rows > 0) {
    $stmt->bind_result($paidAmount);
    $stmt->fetch();
    $response = [
        "advancePaid" => true,
        "paidAmount" => $paidAmount
    ];
}

echo json_encode($response);
