<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="Website.css?<?= print(time());?>" />
</head>
<body>
<?php
include_once("CommonCode.php");
NavigationBar("Login");
 
$message = "";
 
if (isset($_POST["userName"], $_POST["psw"])) {
    $userRole = null;

    if (userAlreadyExists($_POST["userName"])) {
        if ($userData = checkUserPassword($_POST["userName"], $_POST["psw"])) {
            $userRole = $userData["role"];
        }
 
        if ($userRole) {
            $_SESSION["UserLoggedIn"] = true;
            $_SESSION["User"] = $_POST["userName"];
            $_SESSION["UserRole"] = $userRole;
            $message = $arrayOfStrings["LoginMessageSuccess"];
            header("Location: Home.php"); 
            exit();
        } else {
            $message = $arrayOfStrings["LoginMessagePasswordError"];
        }
    } else {
        $message = $arrayOfStrings["LoginMessageNameError"];
    }
}
?>
 
<header>
    <h1><?= $arrayOfStrings["LoginHeader"]?></h1>
    <?php if ($message) echo $message; ?>
    <form method="POST">
        <input type="text" name="userName" placeholder="<?= $arrayOfStrings["LoginNamePlaceHolder"]?>" /> 
        <input type="password" name="psw" placeholder="<?= $arrayOfStrings["LoginPasswordPlaceHolder"]?>" /> <br>
        <input type="submit" class="button" value="<?= $arrayOfStrings["LoginButton"]?>">
    </form>
</header>
 
</body>
</html>
