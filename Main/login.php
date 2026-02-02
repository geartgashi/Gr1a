<?php
//Perfshirja e objekteve dhe startimi i sesionit
require_once '../CRUD/crud.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LogIn</title>
    <link rel="stylesheet" href="../JsCss/style.css">
</head>
<body id="signup">

<div class="signup-container">

    <h2>Log In</h2>

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

    <form class="signup-form" method="post">
        <input type="hidden" name="action" value="login_user">
        <input type="email" name="email" placeholder="Email" required><br>
        <input type="password" name="password" placeholder="Password" required><br>
        <button type="submit">Log In</button>
    </form>

<a  class="login" href="signup.php">Don't have an account</a>

</div>
    
</body>
</html>
<script src="../Js/Css/script.js"></script>