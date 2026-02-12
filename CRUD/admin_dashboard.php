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
    <title>ADMIN DASHBOARD</title>
    <link rel="stylesheet" href="../JsCss/style.css">
</head>
<body class="admin">
    
    <header class="header">
        <button class="hamburger" id="hamburger">☰</button>    
        <nav id="nav" class="nav">
          <a id="active" href="admin_dashboard.php">Dashboard</a>
          <a href="admin_tours.php">Tours</a>
          <a href="admin_users.php">Users</a>
          <a href="admin_bookings.php">Bookings</a>
          <a href="admin_reviews.php">Reviews</a>
        </nav>
    </header>
    <div class="space"></div>

            <div class="title">
                <h1>ADMIN DASHBOARD</h1>
                <h2>Welcome, <?php echo $_SESSION['user_name']?></h2>
            </div>

            <!-- Statistikat -->
            <div class="statistics-container">
                <div class="dbname">
                    <h3>Database Name</h3>
                    <h3><?php echo ($dbName); ?></h3>
                </div>
                <div>
                    <h3>Active Users</h3>
                    <h3><?php echo count($users); ?></h3>
                </div>
                <div>
                    <h3>Active Tours</h3>
                    <h3><?php echo count($tours); ?></h3>
                </div>
                <div>
                    <h3>Active Bookings</h3>
                    <h3><?php echo count($bookings); ?></h3>
                </div>
                <div>
                    <h3>Active Reviews</h3>
                    <h3><?php echo count($reviews); ?></h3>
                </div>
            </div>

            <!--Shfaqja dhe editimi i about us(company)-->
            <section class="company">

            <!--Forma per editim te company-->
                <h2>
                    <?php echo $editCompany ? 'Edit' : 'About us'; ?>
                </h2>


                <?php if($editCompany): ?>  
                    <div class="company-edit-form-container">
                    <form method="post" class="company-edit-form">
                    
                    <input type="hidden" name="action" value="update_company">
                    <input type="hidden" name="id" value="<?php echo (int) ($editCompany['id']); ?>">
                    
                    <div class="company-name">
                    <label>Name</label>    
                    <input type="text" name="name" value="<?php echo ($editCompany['name']); ?>" required>
                    </div>
                    
                    <div class="company-location">
                    <label>Location</label>    
                    <input type="text" name="location" value="<?php echo ($editCompany['location']); ?>" required>
                    </div>
                    
                    <div class="company-description">
                    <label>Description</label>    
                    <textarea name="description" rows="2" required><?php echo ($editCompany['description']); ?></textarea>
                    </div>
                    
                    <div class="company-email">
                    <label>Email</label>
                    <input type="text" name="email" value="<?php echo ($editCompany['email']); ?>" required>
                    </div>
                    
                    <div class="company-phone">
                    <label>Phone</label>
                    <input type="text" name="phone" value="<?php echo ($editCompany['phone']); ?>" required>
                    </div>
                    
                    <div class="company-facebook">
                    <label>Facebook</label>
                    <input type="text" name="facebook" value="<?php echo ($editCompany['facebook']); ?>" required>
                    </div>
                    
                    <div class="company-instagram">
                    <label>Instagram</label>
                    <input type="text" name="instagram" value="<?php echo ($editCompany['instagram']); ?>" required>
                    </div>
                    
                    <div class="company-twitter">
                    <label>Twitter</label>
                    <input type="text" name="twitter" value="<?php echo ($editCompany['twitter']); ?>" required>
                    </div>
                    
                    <div class="company-terms">
                    <label>Terms of Service</label>
                    <textarea name="terms_of_service" rows="3" required><?php echo ($editCompany['terms_of_service']); ?></textarea>
                    </div>

                    <div class="company-policy">
                    <label>Privacy Policy</label>
                    <textarea name="privacy_policy" rows="3" required><?php echo ($editCompany['privacy_policy']); ?></textarea>
                    </div>

                    <button type="submit">Save</button> 

                    <a href="admin_dashboard.php">Cancel</a>
                    
                    </form>
                    </div>

                <?php else: ?>
                    <div class="edit-company">
                        <a href="?action=edit_company">
                            >Edit Company Info, Terms of Service and Privacy Policy<
                        </a>
                    </div>
                <?php endif;?>
            </section>


            <!--logout button-->
            <div class="logout">
                <a href="?logout=true" onclick="return confirm('Do you want to Log Out?');">Log Out</a>
            </div>
</body>
</html>
<script src="../JsCss/script.js"></script>