<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Logout</title>
    <link rel="stylesheet" href="Website.css?<?= print(time());?>" />
</head>
<body>
<?php
include_once("CommonCode.php");
NavigationBar("Logout");
?>
<header>
<h1><?= $arrayOfStrings["LogoutHeader"]?></h1>
<form method="POST">   
<input type="submit" class="button" value="<?= $arrayOfStrings["LogoutButton"]?>" name="Logout">
</form>
</header>
</body>
</html>
