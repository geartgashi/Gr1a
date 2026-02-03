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
    <title>ADMIN TOURS</title>
    <link rel="stylesheet" href="../JsCss/style.css">
</head>
<body class="admin">
    
    <header class="header">
        <button class="hamburger" id="hamburger">☰</button>    
        <nav id="nav" class="nav">
          <a href="admin_dashboard.php">Dashboard</a>
          <a id="active" href="admin_tours.php">Tours</a>
          <a href="admin_users.php">Users</a>
          <a href="admin_bookings.php">Bookings</a>
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

    <!--Shfaqja e Tours-->
        <section class="tours">

            <!--Forma per krijim apo editim tours-->
            
            <div class="tours-form-container">
                <h2>
                    <?php echo $editTour ? 'Edit tour' : 'Add a new tour'; ?>
                </h2>

                <p>
                    <?php echo $editTour ? 'Insert data for the selected Tour' : 'Insert data for the new Tour'; ?>   
                </p>

                <form method="post" class="tours-form">

                    <!--Kontrollohet a eshte per krijim apo per editim-->
                    <input type="hidden" name="action" value="<?php echo $editTour ? 'update_tour' : 'create_tour'; ?>">

                    <!--Merret id per editim-->
                    <?php if ($editTour): ?>
                        <input type="hidden" name="id" value="<?php echo (int) $editTour['id']; ?>">
                    <?php endif; ?>

                    
                    <label>Location</label>    
                    <input type="text" name="location" value="<?php echo ($editTour['location'] ?? ''); ?>" required>

                    <label>Date</label>    
                    <input type="date" name="date" value="<?php echo ($editTour['date'] ?? ''); ?>" required>
                    
                    <label>Length of Stay (nights)</label>    
                    <input type="number" name="length" step="1" min="0" value="<?php echo ($editTour['length'] ?? '0'); ?>" required>
                    
                    <label>Price per person</label>
                    <input type="number" name="price" step="0.01" min="0" value="<?php echo (($editTour['price'] ?? '0.00')); ?>" required>

                       
                        <label>Image</label>
                        <label class="file-upload">
                            <input type="file" name="image" value="<?php echo ($editTour['image'] ?? ''); ?>" required>
                        <span>Choose file</span>
                        </label>
                    
                        

                    <label>Availability</label>
                    <select name="availability" required>
                            <option value="available" <?= ($editTour['availability'] ?? '') === 'available' ? 'selected' : '' ?>>Available</option>
                            <option value="sold out" <?= ($editTour['availability'] ?? '') === 'sold out' ? 'selected' : '' ?>>Sold Out</option>
                    </select>
                    
                    <button type="submit">
                        <?php echo $editTour ? 'Update Tour' : 'Create Tour'; ?>
                    </button>

                    <?php if ($editTour): ?>
                        <a href="admin_tours.php">Cancel</a>
                    <?php endif; ?>
                </form>
            </div>

            <!--Lista per lexim tours-->
            <div class="tours-list-container">
                <h2>Active Tours</h2>

                <?php if (count($tours) === 0): ?>
                    <p>No tours available.</p>
                <?php else: ?>
                    <?php foreach ($tours as $tour): ?>
                        <div class="tour-list">
                            <h3>
                                <?php echo ($tour['location']); ?>
                                #<?php echo ($tour['id'])?>
                            </h3>
                            <div class="crop">
                                <img src="/GitHub/db/<?php echo ($tour['image']);?>" alt="">
                            </div>

                            <p><?php echo ($tour['date']); ?></p>
                            <p>
                                €<?php echo number_format((float) $tour['price'], 2); ?>
                                | <?php echo (int) $tour['length']; ?> Nights
                            </p>
                            <p><?php echo ($tour['availability']); ?></p>
                            <a href="?action=edit_tour&id=<?php echo (int) $tour['id']; ?>">Edit</a>
                            <a href="?action=delete_tour&id=<?php echo (int) $tour['id']; ?>"
                               onclick="return confirm('Delete this tour?');">
                               Delete
                            </a>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>

        </section>
        <!--logout button-->
            <div class="logout">
                <a href="?logout=true" onclick="return confirm('Do you want to Log Out?');">Log Out</a>
            </div>

</body>
</html>
<script src="../JsCss/script.js"></script>