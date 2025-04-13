<?php
include '../Includes/dbcon.php';

if (isset($_POST['VendorID'])) {
    $vendorId = $_POST['VendorID'];

    // Fetch reviews with user details
    $query = "SELECT v.*, au.Firstname, au.Lastname, au.ProfilePic 
              FROM vendorreviews v
              JOIN allusers au ON v.UserID = au.ID
              WHERE v.VendorID = '$vendorId'";
    
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $fullname = $row['Firstname'] . " " . $row['Lastname'];
            $profilePic = $row['ProfilePic'] ? $row['ProfilePic'] : 'img/user-icn.png';
            $ratingStars = generateStars($row['Rating']);
            $reviewText = htmlspecialchars($row['ReviewText']);

            echo "
            <div class='review-card'>
                <img src='$profilePic' alt='Profile Picture'>
                <div class='review-details'>
                    <div class='review-user'>$fullname</div>
                    <div class='review-stars'>$ratingStars</div>
                    <div class='review-text'>$reviewText</div>
                </div>
            </div>";
        }
    } else {
        echo "<div class='text-center text-muted'>No reviews available</div>";
    }
}

function generateStars($rating) {
    $fullStars = floor($rating);
    $halfStar = ($rating - $fullStars) >= 0.5 ? 1 : 0;
    $emptyStars = 5 - ($fullStars + $halfStar);

    return str_repeat('<span class="filled">★</span>', $fullStars) . 
           ($halfStar ? '<span class="filled">⯪</span>' : '') . 
           str_repeat('<span class="empty">★</span>', $emptyStars);
}
?>
