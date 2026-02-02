<?php
//Perfshirja e objekteve dhe startimi i sesionit
require_once '../CRUD/crud.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <link rel="stylesheet" href="../JsCss/style.css">
</head>
<body>
<section id="top" class="slider">

  <video id="video" autoplay muted loop></video>
  <video id="video2" autoplay muted loop></video>

  <header class="header">

    <button class="hamburger" id="hamburger">☰</button>    

    <nav id="nav" class="nav">
      <a id="active" href="index.php">Home</a>
      <a href="tours.php">Tours</a>
      <a href="about.php">About</a>
      <a href="profile.php">Profile</a>
    </nav>

  </header>

    <div id="box1">
        <h3 class="travel">TRAVEL ANY SEASON</h3>
        <h1 id="season"></h1>


        <?php if (isset($_SESSION['user_role'])): ?>
          <h3 class="travel">Welcome, <?php echo $_SESSION['user_name'];?></h3>
        <?php else: ?>
          <a id="login" href="login.php">Log In</a>
        <?php endif;?>
    </div>
  
</section>

<hr class="hr1">

<div class="content">
  
    <!--Lista per lexim reviews-->
    
        <h2>Feedback from Our Valued Customers</h2>

        <?php if (count($reviews) === 0): ?>
            <p>No reviews available.</p>
        <?php else: ?>
          <?php foreach ($reviews as $review): ?>
                <div class="review-show">
                    <?php ($user = $userObj->findUser($review['user_id'])); ?>
                    <p><?php echo ($user['email']); ?></p>  
                    <p><?php echo ($review['description']); ?></p>
                    <p><?php for ($i = 0; $i < (int)$review['stars']; $i++) {echo '🌟';}?></p>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    

</div>






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
<script>

  
  //SLIDER
//KRIJIMI I ARRAY (ELEMENTET)
const slides = 
[
  { video: "../images/spring.mp4"  , season: "SPRING"},
  { video: "../images/summer.mp4" , season: "SUMMER"},
  { video: "../images/autumn.mp4" , season: "AUTUMN"},
  { video: "../images/winter.mp4", season: "WINTER"},
];

//KRIJIMI I VARIABLAVE PER QASJE TE ELEMENTEVE
const video = document.getElementById("video");
const video2 = document.getElementById("video2");
const season = document.getElementById("season");

//INDEX PER PERDITESIM, ACTIVE PER VIDEON MOMENTALE
let index = 0;
let active = 1; 

//DEKLARIMI I FUNKSIONIT
function changeSlide() {

//MERR VLERAT SIPAS INDEX TE ARRAY
  const nextSlide = slides[index];

//ZGJEDH VIDEON MOMENTALE DHE TE ARDHSHME PER TE SHMANGUR VONESAT
  const currentVideo = active === 1 ? video : video2;
  const nextVideo = active === 1 ? video2 : video;

//LARGIMI I VIDEOS PARAPRAKE DHE TEKSTIT
  currentVideo.style.opacity = 0;
  season.style.opacity = 0;
  

  //TIMEOUT I VENDOSUR PER SHFAQJE TE ELEMENTEVE TE RRADHES
  setTimeout(() => {
    
    //NGARKIMI I VIDEOS SE RRADHES
    nextVideo.src = nextSlide.video;
    nextVideo.load();

    //FUNKSION QE TREGON SE VIDEO E RRADHES ESHTE E GATSHME
    nextVideo.oncanplaythrough = () => {


    //SHFAQJA E VIDEOS SE RRADHES
      nextVideo.play();
      nextVideo.style.opacity = 1;

    //SHFAQJA E TEKSTIT TE RRADHES
      season.innerText = nextSlide.season;
      requestAnimationFrame(() => {
        season.style.opacity = 1;
      });

      //PERDITESIMI I "ACTIVE" DHE "INDEX" DUKE KONTROLLUAR KUSHTET
      active = active === 1 ? 2 : 1;
      index = (index + 1) % slides.length;

      nextVideo.oncanplaythrough = null;
    };
  }, 300); //300 MS KOHA E SHFAQJES SE ELEMENTEVE
}

//THIRRJA E PARE E SLIDER
changeSlide();

//AUTOMATIZIMI, CDO 6000MS THIRR FUNKSIONIN
setInterval(changeSlide, 6000);
//END OF SLIDER

</script>
<script src="../JsCss/script.js"></script>