<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $arrayOfStrings["PasswordChangeTitle"] ?></title>
    <link rel="stylesheet" href="Website.css?<?= print(time()); ?>" />
</head>
<body>
    <?php
        include_once("CommonCode.php");
        NavigationBar("PasswordChange");

        $message = "";

        if (isset($_SESSION["User"], $_POST["oldPsw"])) {
            if ($userData = checkUserPassword($_SESSION["User"], $_POST["oldPsw"])) {
                if ($_POST["newPsw"] == $_POST["newPswAgain"]) {
                    $user = $_SESSION["User"];
                    $hashedPassword = password_hash($_POST["newPsw"], PASSWORD_DEFAULT);
                    $sqlInsert = $conn->prepare("UPDATE Accounts SET psw = ? WHERE userName = '$user';");
                    $sqlInsert->bind_param("s", $hashedPassword);
                    $sqlInsert->execute();
                    $message = $arrayOfStrings["PasswordChangedSuccessfullyMessage"];
                } else {
                    $message = $arrayOfStrings["NewPasswordsDoNotMatchMessage"];
                }
            } else {
                $message = $arrayOfStrings["IncorrectOldPasswordMessage"];
            }
        }
    ?>
    <header>
        <h1><?= $arrayOfStrings["PasswordChangeTitle"] ?></h1>
        <?php if ($message) echo "<p>$message</p>"; ?>
        <form method="POST">
            <input type="password" name="oldPsw" placeholder="<?= $arrayOfStrings["OldPasswordPlaceholder"] ?>" /> <br><br>
            <input type="password" name="newPsw" placeholder="<?= $arrayOfStrings["NewPasswordPlaceholder"] ?>" /> <br>
            <input type="password" name="newPswAgain" placeholder="<?= $arrayOfStrings["RepeatNewPasswordPlaceholder"] ?>" /> <br>
            <input type="submit" class="button" value="<?= $arrayOfStrings["ChangeButton"] ?>">
        </form>
    </header>
</body>
</html>
