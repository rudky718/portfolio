<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Our Products</title>
    <link rel="stylesheet" href="Website.css?<?= print(time());?>" />
</head>
<body>
    <?php
        include_once("CommonCode.php");
        NavigationBar("Products");
    ?>
    <section class="product-gallery">
 
 <?php
buildProducts();
 ?>
 
    </section>
</body>
</html>
