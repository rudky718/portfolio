<?php
include_once("CommonCode.php");

if (!isset($_SESSION["UserLoggedIn"]) || !isAdmin()) {
    header("Location: Home.php");
    exit();
}

if (isset($_POST["productName"], $_POST["productPrice"], $_POST["productDescription"], $_POST["productImageName"], $_POST["productNameUkr"], $_POST["productDescriptionUkr"])) {
    $NameEn = $_POST["productName"];
    $Price = $_POST["productPrice"];
    $DescEn = $_POST["productDescription"];
    $ImageFile = $_POST["productImageName"];
    $NameUa = $_POST["productNameUkr"];
    $DescUa = $_POST["productDescriptionUkr"];

    global $conn;
    $sqlInsert = $conn->prepare("Insert into Products(ID, NameEn, Price, DescEn, ImageFile, NameUa, DescUa) values(?,?,?,?,?,?,?);");
    $sqlInsert->bind_param("isissss", $ID, $NameEn, $Price, $DescEn, $ImageFile, $NameUa, $DescUa);
    $sqlInsert->execute();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $arrayOfStrings["AddProduct"] ?></title>
    <link rel="stylesheet" href="Website.css?<?= print(time());?>" />
</head>
<body>
    <?php NavigationBar("AddProduct"); ?>

    <div class="add-product-container">
        <h1><?= $arrayOfStrings["AddANewProduct"] ?></h1>
        <?php if (isset($successMessage)) { ?>
            <p style="color: #2a9d8f;"><?= $successMessage ?></p>
        <?php } ?>
        <form method="POST">
            <input type="text" name="productName" placeholder="<?= $arrayOfStrings["ProductName"] ?>" required>
            <input type="text" name="productNameUkr" placeholder="<?= $arrayOfStrings["ProductNameInUkrainian"] ?>" required>
            <input type="text" name="productPrice" placeholder="<?= $arrayOfStrings["ProductPrice"] ?>" required>
            <textarea name="productDescription" placeholder="<?= $arrayOfStrings["ProductDescription"] ?>" required></textarea>
            <textarea name="productDescriptionUkr" placeholder="<?= $arrayOfStrings["ProductDescriptionInUkrainian"] ?>" required></textarea>
            <input type="text" name="productImageName" placeholder="<?= $arrayOfStrings["ImageFileName"] ?>" required>
            <input type="submit" value="<?= $arrayOfStrings["AddProduct"] ?>">
        </form>
    </div>
</body>
</html>
