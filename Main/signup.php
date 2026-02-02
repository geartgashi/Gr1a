<?php

//Perfshirja e objekteve dhe startimi i sesionit
require_once '../CRUD/crud.php';


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SignUp</title>
    <link rel="stylesheet" href="../JsCss/style.css">
</head>

<body id="signup">

    
<div class="signup-container">

    <h2>Sign Up</h2>

    <!-- Shfaqja e erroreve dhe suksesit-->
    <?php if ($message !== ''): ?>
        <div class="notice success">
            <?php echo ($message); ?>
        </div>
    <?php endif; ?>

    <?php if ($errors !== []): ?>
        <div class="notice error">
            <?php foreach ($errors as $e) echo ($e) . '<br>'; ?>
        </div>
    <?php endif; ?>

    

    <form class="signup-form" method="post">
        <input type="hidden" name="action" value="create_user">
        <input name="name" placeholder="Name" required><br>
        <input name="surname" placeholder="Surname" required><br>
        <input name="email" type="email" placeholder="Email" required><br>
        <input name="phone" placeholder="Phone" required><br>
        <input name="password" type="password" placeholder="Password" required><br>
        <input name="confirm_password" type="password" placeholder="Confirm Password" required><br>
        <button type="submit">Sign Up</button>
    </form>

<a  class="login" href="login.php">I have an account</a>

</div>

</body>
</html>
<script src="../Js/Css/script.js"></script>
<!--Shfaqja e pyetjes per login-->
<?php if ($LogInPopUp): ?>
<script>
    // Pyet përdoruesin
    if (confirm("Account created successfully. Do you want to log in now?")) {
        window.location.href = "login.php"; 
    } else {
        alert("You can log in anytime from login page.");
    }
    
</script>
<?php endif; ?>

