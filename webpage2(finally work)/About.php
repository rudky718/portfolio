<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us</title>
    <link rel="stylesheet" href="Website.css?<?= print(time());?>" />
</head>
<body>
    <?php
        include_once("CommonCode.php");
        NavigationBar("About");
    ?>
    <header>
        <h1><?= $arrayOfStrings["AboutHeader"]?></h1>
        <p><?= $arrayOfStrings["AboutDescription"]?></p>
    </header>
</body>
</html>
