<?php
//Perfshirja e CRUD funksioneve
require_once '../CRUD/crud.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About</title>
    <link rel="stylesheet" href="../JsCss/style.css">
</head>
<body>
  <header class="header">

    <button class="hamburger" id="hamburger">☰</button>    

    <nav id="nav" class="nav">
      <a href="index.php">Home</a>
      <a href="tours.php">Tours</a>
      <a id="active" href="about.php">About</a>
      <a href="profile.php">Profile</a>
    </nav>

  </header>
  <div id="top" class="space"></div>

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

  <section class="about-content">
  
    <div class="left">

        <h2>About Us</h2> 
      
        <div class="about-us"> 
          
          <p><?php echo $company['name']?? ''; ?></p>
          <p ><?php echo $company['description']?? ''; ?></p>
          
          <h2>Location</h2>
          <p><?php echo $company['location']?? ''; ?></p>
          
          <h2>Contact</h2>
          <p><?php echo $company['email']?? ''; ?></p>
          <p><?php echo $company['phone']?? ''; ?></p>

          <h2>Social Media</h2>
          <div class="row">
            <img src="../images/facebook.png" alt="">
            <p ><?php echo $company['facebook']?? ''; ?></p>
          </div>
          <div class="row">
            <img src="../images/instagram.png" alt="">
            <p><?php echo $company['instagram']?? ''; ?></p>
          </div>
          <div class="row">
            <img src="../images/twitter.png" alt="">
            <p><?php echo $company['twitter']?? ''; ?></p>
          </div>  

        </div>
    </div>

    <div class="right">

            <!--Forma per krijim te review-->
            
            <div class="review-create">
                <h2>Review Us!</h2>

                <?php if(!isset($_SESSION['user_id'])): ?>
                  <div class="row">
                    <a href="login.php">Log In</a><p>to review us</p>
                  </div>
                <?php else: ?>

                    <form method="post" class="review-create-form">
                        <input type="hidden" name="action" value="create_review">
                        <input type="hidden" name="user_id" value="<?php echo $_SESSION['user_id'];?>">

                        <textarea placeholder="Description" name="description" rows="5" required></textarea>

                      <div class="row">
                        <label>Stars</label>
                        <select name="stars" required>
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4">4</option>
                                <option value="5">5</option>
                        </select>
                      </div>

                        <button type="submit">Submit Review</button>
                    </form>
                <?php endif; ?>  
                
                <?php if(!isset($_SESSION['user_id'])): ?>
                    
                <?php else: ?>
                <div class="my-reviews">
                  <h2>My Reviews</h2>
                  <!--Gjetja e bookings permes email-->
                    <?php $personalReviews = $reviewObj ? $reviewObj->getReviewsByUser($_SESSION['user_id']) : [];?>
                    <?php if(count($personalReviews) === 0):?>
                      <p>No reviews.</p>
                    <?php else: ?>
                      <?php foreach ($personalReviews as $pr): ?>
                            <div class="personal-reviews"> 
                                
                                <p><?php echo ($pr['description']); ?></p>
                                <p><?php for ($i = 0; $i < (int)$pr['stars']; $i++) {echo '🌟';}?></p>
                                
                                <button id="del-review">
                                  <a href="?action=delete_review&id=<?php echo (int) $pr['id']; ?>"
                                    onclick="return confirm('Delete this review?');">
                                    Delete
                                  </a>
                                </button>
                      
                            </div>
                      <?php endforeach; ?>
                    <?php endif;?>
                </div>
                <?php endif; ?> 

            </div>
    </div>
  
  
  </section>

  <div class="space"></div>
<footer>
  <div class="footer-left">
    <p><?php echo $company['email']?></p>
    <p><?php echo $company['location']?></p>

    <div class="socials">
      <img src="../images/instagram.png" alt="">
      <img src="../images/facebook.png" alt="">
      <img src="../images/twitter.png" alt="">
    </div>
  </div>

  <div class="footer-right">
    <p><a href="../Optional/termsOfService.php">Terms of services</a> | <a href="../Optional/privacyPolicy.php">Privacy policy</a></p>
    <p><?php echo $company['name']?></p>
    <p><a href="#top">Back to top ↑</a></p>
  </div>
</footer>
  
</body>
</html>
<script src="../JsCss/script.js"></script>