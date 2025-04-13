<?php 

if($_SESSION['UserRole'] != 'Admin'){
    header("Location: index.php");
    exit();
}
?>