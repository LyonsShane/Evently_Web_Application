<?php
include '../Includes/dbcon.php';
include '../Includes/session.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['hireID'])) {
        $hireID = $_POST['hireID'];

        // Update status to "Completed"
        $updateQuery = "UPDATE hiredvendors SET Status = 'Completed' WHERE ID = ?";
        $stmt = $conn->prepare($updateQuery);
        $stmt->bind_param("i", $hireID);

        if ($stmt->execute()) {
            echo "Order marked as Completed.";
        } else {
            echo "Error updating order.";
        }

        $stmt->close();
    }
}

$conn->close();
?>
