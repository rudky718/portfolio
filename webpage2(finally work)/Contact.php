<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact</title>
    <link rel="stylesheet" href="Website.css?<?= print(time());?>" />
</head>
<body>
    <?php
        include_once("CommonCode.php");
        NavigationBar("Contact");
    ?>
    <header>
        <h1><?= $arrayOfStrings["ContactHeader"]?></h1>
        <p><?= $arrayOfStrings["ContactDescription"]?></p>
    </header>
</body>
</html>