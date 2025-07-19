<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration</title>
    <link rel="stylesheet" href="Website.css?<?= print(time());?>" />
</head>
<body>
 
<?php
include_once("CommonCode.php");
NavigationBar("Registration");
 
$message = "";

if (isset($_POST["userName"], $_POST["psw"], $_POST["pswAgain"])) {
    
    if ($_POST["psw"] == $_POST["pswAgain"]) {
        $username = $_POST["userName"];
        $age = isset($_POST["age"]) && $_POST["age"] !== "" ? (int)$_POST["age"] : null;
        $nationality = isset($_POST["nationality"]) && $_POST["nationality"] !== "" ? $_POST["nationality"] : null;
        
        
        if (userAlreadyExists($username)) {
            $message = $arrayOfStrings["RegistrationMessageNameError"];
        } else {
            $hashedPassword = password_hash($_POST["psw"], PASSWORD_DEFAULT);
            $sqlInsert = $conn->prepare("Insert into Accounts(userName, psw, role, age, nationality) values(?,?, 'customer',?,?);");
            $sqlInsert->bind_param("ssis", $username, $hashedPassword, $age, $nationality);
            $sqlInsert->execute();
            $message = $arrayOfStrings["RegistrationMessageSuccess"];
        }
    } else {
        $message = $arrayOfStrings["RegistrationMessagePasswordError"];
    }
}
?>
 
<header>
    <h1><?= $arrayOfStrings["RegistrationHeader"]?></h1>
    <?php if ($message) echo $message; ?> 
    <form method="POST">
        <input type="text" name="userName" placeholder="<?= $arrayOfStrings["RegistrationNamePlaceHolder"]?>" required /> 
        <input type="password" name="psw" placeholder="<?= $arrayOfStrings["RegistrationPasswordPlaceHolder"]?>" required /> 
        <input type="password" name="pswAgain" placeholder="<?= $arrayOfStrings["RegistrationPasswordPlaceHolder2"]?>" required /> 
        <input type="number" name="age" placeholder="<?= $arrayOfStrings["AgePlaceholder"]?>" /> 
        <input type="text" name="nationality" placeholder="<?= $arrayOfStrings["NationalityPlaceholder"]?>" /> <br>
        <input type="submit" class="button" value="<?= $arrayOfStrings["RegistrationButton"]?>">
    </form>
</header>
 
</body>
</html>
