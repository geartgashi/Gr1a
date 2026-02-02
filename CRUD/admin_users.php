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
    <title>ADMIN USERS</title>
    <link rel="stylesheet" href="../JsCss/style.css">
    <style>
        
    </style>
</head>
<body class="admin">
    
    <header class="header">
        <button class="hamburger" id="hamburger">☰</button>    
        <nav id="nav" class="nav">
          <a href="admin_dashboard.php">Dashboard</a>
          <a href="admin_tours.php">Tours</a>
          <a id="active" href="admin_users.php">Users</a>
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

    <!--Shfaqja e Users-->
        <section class="users">

            <?php if($editUser):?>
            <!--Forma editim user role-->
            <div class="users-form-container">
                <h2>Edit user role</h2>


                <form method="post" class="users-form">

                    <!--Kontrollohet action-->
                    <input type="hidden" name="action" value="update_user_role">

                    <!--Merret id per editim-->
                    <?php if ($editUser): ?>
                        <input type="hidden" name="id" value="<?php echo (int) $editUser['id']; ?>">
                    <?php endif; ?>

                    
                    <label>Email</label>    
                    <p><?php echo ($editUser['email'] ?? ''); ?></p>

                    <label>Select role</label>
                    <select name="role" required>
                            <option value="user" <?= ($editUser['role'] ?? '') === 'user' ? 'selected' : '' ?>>User</option>
                            <option value="admin" <?= ($editUser['role'] ?? '') === 'admin' ? 'selected' : '' ?>>Admin</option>
                    </select>
                    
                    <button type="submit">Update role</button>

                    <?php if ($editUser): ?>
                        <a href="admin_users.php">Cancel</a>
                    <?php endif; ?>
                </form>
            </div>
            <?php endif;?>

            <!--Lista per lexim users-->
            <div class="users-list-container">
                <h2>Active Users</h2>

                <?php if (count($users) === 0): ?>
                    <p>No users available.</p>
                <?php else: ?>
                    <div class="user-list-1">
                        <p>Name</p>  
                        <p>Surname</p>
                        <p>Email</p>
                        <p>Phone</p>
                        <p>Role</p>
                        <p>Edit</p>
                        <p>[-]</p>
                        <p>Delete</p>
                    </div>
                            
                    <?php foreach ($users as $user): ?>
                        <div class="user-list">
                            <p><?php echo ($user['name']); ?></p>  
                            <p><?php echo ($user['surname']); ?></p>
                            <p><?php echo ($user['email']); ?></p>
                            <p><?php echo ($user['phone']); ?></p>
                            <p><?php echo ($user['role']); ?></p>
                            <a href="?action=edit_user&id=<?php echo (int) $user['id']; ?>">Edit</a>
                            <a href="?action=delete_user&id=<?php echo (int) $user['id']; ?>"
                               onclick="return confirm('Delete this user?');">
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