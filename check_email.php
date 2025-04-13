<?php
include 'Includes/dbcon.php'; // Database connection

if (isset($_POST['email'])) {
    $email = $_POST['email'];
    
    $query = $conn->prepare("SELECT * FROM allusers WHERE Email = ?");
    $query->bind_param("s", $email);
    $query->execute();
    $query->store_result();
    
    if ($query->num_rows > 0) {
        echo "exists"; // Email already exists
    } else {
        echo "available"; // Email is available
    }
    
    $query->close();
}
?>