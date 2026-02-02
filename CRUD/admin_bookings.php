<?php

//Perfshirja e CRUD funksioneve
require_once 'crud.php';

//Kontrolli i roleve
    if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
        header('Location: ../Main/index.php');
    exit;
    }

$totalRevenue = 0;
foreach ($bookings as $booking){
    $revenue = (((int)$booking['guests']) * ($tourObj->findTour((int)$booking['tour_id'])['price']));
    $totalRevenue += $revenue;
}
                        
                            
            

?>

<!DOCTYPE html>
<html lang="en">
<head class="admin">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ADMIN BOOKINGS</title>
    <link rel="stylesheet" href="../JsCss/style.css">
</head>
<body class="admin">

    <header class="header">
        <button class="hamburger" id="hamburger">☰</button>    
        <nav id="nav" class="nav">
          <a href="admin_dashboard.php">Dashboard</a>
          <a href="admin_tours.php">Tours</a>
          <a href="admin_users.php">Users</a>
          <a id="active" href="admin_bookings.php">Bookings</a>
          <a href="admin_reviews.php">Reviews</a>
        </nav>
    </header>
    <div class="space"></div>

    <!-- Shfaqja e erroreve dhe suksesit-->
        <?php if ($message !== ''): ?>
            <div class="notice success">
                <?php echo ($message); ?>
            </div>
        <?php endif; ?>

        <?php if ($error !== ''): ?>
            <div class="notice error">
                <?php echo ($error); ?>
            </div>
        <?php endif; ?>


    <!--Lista per lexim bookings-->
            
            <div class="bookings-list-container">

                <div class="title-div">
                    <h2>Active Bookings</h2> <h2>Total revenue : <?php echo $totalRevenue?>€</h2>
                </div>

                <?php if (count($bookings) === 0): ?>
                    <p>No bookings available.</p>
                <?php else: ?>
                    <div class="bookings-middleman">
                    <?php foreach ($bookings as $booking): ?>
                        <div class="booking-list">
                            <?php ($user = $userObj->findUser($booking['user_id'])); ?>
                            <p><?php echo ($user['email']); ?></p>
                            <p>
                                #<?php echo ($booking['tour_id']); ?>
                                <?php echo ($tourObj->findTour((int)$booking['tour_id'])['location']); ?>
                            </p>
                            <p><?php echo ($booking['guests']); ?> guests</p>

                            <p>Revenue : 
                            <?php 
                            $revenue = (((int)$booking['guests']) * ($tourObj->findTour((int)$booking['tour_id'])['price']));
                            echo $revenue; 
                            ?> €</p>

                            <a href="?action=delete_booking&id=<?php echo (int) $booking['id']; ?>"
                               onclick="return confirm('Delete this booking?');">
                               Delete
                            </a>
                        </div>
                    <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>
            <!--logout button-->
            <div class="logout">
                <a href="?logout=true" onclick="return confirm('Do you want to Log Out?');">Log Out</a>
            </div>
</body>
</html>
<script src="../JsCss/script.js"></script>