<?php

//Perfshirja e CRUD funksioneve
require_once 'crud.php';

//Kontrolli i roleve
    if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
        header('Location: ../Main/index.php');
    exit;
    }


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ADMIN REVIEWS</title>
    <link rel="stylesheet" href="../JsCss/style.css">
</head>
<body class="admin">
    
    <header class="header">
        <button class="hamburger" id="hamburger">☰</button>    
        <nav id="nav" class="nav">
          <a href="admin_dashboard.php">Dashboard</a>
          <a href="admin_tours.php">Tours</a>
          <a href="admin_users.php">Users</a>
          <a href="admin_bookings.php">Bookings</a>
          <a id="active" href="admin_reviews.php">Reviews</a>
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



     <!--Lista per lexim reviews-->
            <div class="content admin-content">
                <h2 id="tit">Active Reviews</h2>

                <?php if (count($reviews) === 0): ?>
                    <p>No reviews available.</p>
                <?php else: ?>
                    <?php foreach ($reviews as $review): ?>
                        <div class="review-show">
                            <?php ($user = $userObj->findUser($review['user_id'])); ?>
                            <p><?php echo ($user['email']); ?></p>  
                            <p><?php echo ($review['description']); ?></p>
                            <p><?php for ($i = 0; $i < (int)$review['stars']; $i++) {echo '🌟';}?></p>
                            <a href="?action=delete_review&id=<?php echo (int) $review['id']; ?>"
                               onclick="return confirm('Delete this review?');">
                               Delete
                            </a>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
            <!--logout button-->
            <div class="logout">
                <a href="?logout=true" onclick="return confirm('Do you want to Log Out?');">Log Out</a>
            </div>
</body>
</html>
<script src="../JsCss/script.js"></script>