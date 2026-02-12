<?php
//Perfshirja e CRUD funksioneve
require_once '../CRUD/crud.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=, initial-scale=1.0">
    <title>Tours</title>
    <link rel="stylesheet" href="../JsCss/style.css">
</head>
<body>
  <header class="header">

    <button class="hamburger" id="hamburger">☰</button>    

    <nav id="nav" class="nav">
      <a href="index.php">Home</a>
      <a id="active" href="tours.php">Tours</a>
      <a href="about.php">About</a>
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

  <section class="tour-show">
            <!--Lista per lexim tours-->
            <div class="tours-cards-container">

                <?php if (count($tours) === 0): ?>
                  <div class="content">
                    <p>No tours available.</p>
                  </div>
                <?php else: ?>
                    <?php foreach ($tours as $tour): ?>
                        <div class="tour-card">
                            <h3>
                                <?php echo ($tour['location']); ?>
                            </h3>
                            
                            <img src="/GitHub/db/<?php echo ($tour['image']);?>" alt="">

                            <p><?php echo ($tour['date']); ?></p>
                            <p>
                                €<?php echo number_format((float) $tour['price'], 2); ?>
                                | <?php echo (int) $tour['length']; ?> Nights
                            </p>

                            
                            
                          <?php if(!isset($_SESSION['user_id'])): ?>
                              <div class="row">
                                <a href="login.php">Log In to book</a>
                              </div>
                          <?php else: ?>
                            <form method="post">
                              <input type="hidden" name="action" value="create_booking">
                              <input type="hidden" name="user_id" value="<?php echo $_SESSION['user_id'];?>">
                              <input type="hidden" name="tour_id" value="<?php echo $tour['id'];?>">

                            <?php if($tour['availability'] === 'available'):?>
                              
                              <p><?php echo ($tour['availability']); ?></p>

                              <div class="row">
                              <p id="idk">Guests</p>
                              <select class="guest-nr" name="guests" required>
                                <option value=1>1</option>
                                <option value=2>2</option>
                                <option value=3>3</option>
                                <option value=4>4</option>
                                <option value=5>5</option>
                                <option value=6>6</option>
                                <option value=7>7</option>
                                <option value=8>8</option>
                              </select>
                              </div>
                            
                              <button onclick="return confirm('Book this tour?');" 
                                      type="submit">BOOK NOW</button>
                            <?php else:?>
                                <p id="soldout"><?php echo ($tour['availability']); ?></p>
                            <?php endif;?>
                                
                            </form>
                          <?php endif; ?>
                            
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
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