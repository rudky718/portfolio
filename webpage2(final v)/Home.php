<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <link rel="stylesheet" href="Website.css?<?= print(time());?>" />
</head>
<body>
    <?php
        include_once("CommonCode.php");
        NavigationBar("Home");
    ?>
    <header>
        <h1><?= $arrayOfStrings["HomeHeader"]?></h1>
        <p><?= $arrayOfStrings["HomeDescription"]?></p>
    </header>
</body>
</html>
