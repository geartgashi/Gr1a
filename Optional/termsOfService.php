<?php
//Perfshirja e objekteve per lexim ne db
require_once '../CRUD/crud.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Terms of Service</title>
</head>
<body>
    <textarea readonly rows="50" style="width:100%;"><?php echo ($company['terms_of_service']); ?></textarea>
</body>
</html>