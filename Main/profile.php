<?php
//Perfshirja e CRUD funksioneve
require_once '../CRUD/crud.php';

//Kontrolli i sesionit
    if (!isset($_SESSION['user_id'])) {
        header('Location: ../Main/index.php');
    exit;
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
    <link rel="stylesheet" href="../JsCss/style.css">
</head>
<body>
  <header class="header">

    <button class="hamburger" id="hamburger">☰</button>    

    <nav id="nav" class="nav">
      <a href="index.php">Home</a>
      <a href="tours.php">Tours</a>
      <a href="about.php">About</a>
      <a id="active" href="profile.php">Profile</a>
    </nav>

  </header>
  <div class="space"></div>

<!-- Mesazhe error / success -->
  <?php if ($errors !== []): ?>
      <div class="notice error"> 
          <?php foreach ($errors as $e) echo ($e) . '<br>'; ?>
      </div>
  <?php endif; ?>

  <?php if ($message !== ''): ?>
        <div class="notice success">
            <?php echo ($message); ?>
        </div>
    <?php endif; ?>

<section class="profile-content">
  
    <div class="left">
      <!--Forma per editim te profile-->
      <h2>
          <?php echo $editUser ? 'Edit Profile' : 'My Profile'; ?>
      </h2> 
      <?php if($editUser): ?>
        <div class="profile-edit"> 
          <form method="post">

          <input type="hidden" name="action" value="update_user">
          <input type="hidden" name="id" value="<?php echo (int) ($_SESSION['user_id'] ?? 0); ?>">

          <label>Name</label>    
          <p class="data"><input type="text" name="name" value="<?php echo ($_SESSION['user_name'] ?? ''); ?>" required></p>
          
          <label>Surname</label>    
          <p class="data"><input type="text" name="surname" value="<?php echo $_SESSION['user_surname']?? ''; ?>" required></p>
          
          <label>Email</label>    
          <p class="data"><input type="text" name="email" value="<?php echo $_SESSION['user_email']?? ''; ?>" required></p>
          
          <label>Phone</label>
          <p class="data"><input type="text" name="phone" value="<?php echo ($_SESSION['user_phone'])?? ''; ?>" required></p>
             
          <div class="column">
          <button type="submit">Save</button>   
          <button><a href="profile.php">Cancel</a></button>
          </div>

          </form>
        </div>
      <?php elseif($editPassword): ?>
        <div class="password-edit">
          <form method="post">

            <input type="hidden" name="action" value="update_user_password">
            <input type="hidden" name="id" value="<?php echo (int) ($_SESSION['user_id'] ?? 0); ?>">

            <label>Current Password</label>
            <p class="data"><input type="password" name="current_password" required></p>
              
            <label>New Password</label>
            <p class="data"><input type="password" name="password" required></p>
              
            <label>Confirm New Password</label>
            <p class="data"><input type="password" name="confirm_password" required></p>
            
            <div class="column">
            <button type="submit">Change Password</button>
            <button><a href="profile.php">Cancel</a></button>
            </div>

          </form>
        </div>
      <?php else: ?>
        <div class="profile-view">
            <label>Name</label>    
            <p class="data"><?php echo ($_SESSION['user_name'] ?? ''); ?></p>
          
            <label>Surname</label>    
            <p class="data"><?php echo ($_SESSION['user_surname'] ?? ''); ?></p>
          
            <label>Email</label>    
            <p class="data"><?php echo ($_SESSION['user_email'] ?? ''); ?></p>
          
            <label>Phone</label>    
            <p class="data"><?php echo ($_SESSION['user_phone'] ?? ''); ?></p>
          
            <button>
              <a href="?action=update_user&id=<?php echo (int) $_SESSION['user_id']; ?>">Edit Profile</a>
            </button>
            <button>
              <a href="?action=update_user_password&id=<?php echo (int) $_SESSION['user_id']; ?>">Change Password</a>
            </button>
        </div>
      <?php endif;?>   
      
      <button id="del-acc">
        <a href="?action=delete_account&id=<?php echo (int) $_SESSION['user_id']; ?>"
         onclick="return confirm('Delete your account?');">
         Delete Account
        </a>
      </button>

    </div>

    <div class="right">
      <h2>My Bookings</h2>
      <!--Gjetja e bookings permes email-->
        <?php $personalBookings = $bookingObj ? $bookingObj->getBookingsByUser($_SESSION['user_id']) : [];?>
        <?php if(count($personalBookings) === 0):?>
          <p>No bookings available.</p>
          <button id="booknow">
          <a href="tours.php">Book now!</a>
          </button>
        <?php else: ?>
          <?php foreach ($personalBookings as $pb): ?>
                <div class="personal-bookings"> 
                    <?php ($tour = $tourObj->findTour($pb['tour_id'])); ?>
                    <img src="/GitHub/db/<?php echo ($tour['image']);?>" alt="">

                    <div class="column2">
                      <p><?php echo ($tour['location']);?></p>
                      <p><?php echo ($tour['date']);?></p>
                      <p>Price:  <?php 
                        echo ($pb['guests'])
                        . ' x ' . ($tour['price'])
                        . ' = ' . (($tour['price'])
                        * $pb['guests']);
                      ?>€</p>
                    </div>

                    <button>
                      <a href="?action=delete_booking&id=<?php echo (int) $pb['id']; ?>"
                        onclick="return confirm('Delete this booking?');">
                        Delete
                      </a>
                    </button>

                </div>
          <?php endforeach; ?>
        <?php endif;?>
    </div>
  
  
</section>




  <div class="review-us">
    <a href="about.php">Review Us!</a>
  </div>
  <div class="logout">
      <a class="transit" href="?logout=true" onclick="return confirm('Do you want to Log Out?');">Log Out</a>
  </div>

</body>
</html>
<script src="../JsCss/script.js"></script>