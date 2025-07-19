<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "examWSERS2";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


function userAlreadyExists($userName)
{
    global $conn;

    $sqlSelect = $conn->prepare("SELECT * from people where Name = ?");
    $sqlSelect->bind_param("s", $userName);
    $sqlSelect->execute();
    $result = $sqlSelect->get_result();
    if ($result->num_rows == 0) {
        return false;
    } else {
        return true;
    }
}


if (isset($_POST["userName"])){
if (userAlreadyExists($_POST["userName"])) {

    $sqlSelect = $conn->prepare("SELECT * FROM People where Name = ?;");
    $sqlSelect->bind_param("s", $_POST["userName"]);
    $sqlSelect->execute();
    $result = $sqlSelect->get_result();

    if ($row=$result->fetch_assoc()) {
        
        $_SESSION["userName"] = $row["Name"];
        $_SESSION["Money"] = $row["Money"];
    }
    $sqlSelect->close();

    header("Location: page.php");
} else {

    $sqlInsert = $conn->prepare("INSERT INTO People (name, Money) VALUES (?, 0)");
    $sqlInsert->bind_param("s", $_POST["userName"]);
    $sqlInsert->execute();
    $sqlInsert->close();

    $_SESSION["userName"] = $_POST["userName"];
    $_SESSION["Money"] = 0;

    header("Location: page.php");
}
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
</head>
<body>
    <h2>Login</h2>
    <form method="POST" action="">
        <label>Name:</label><br>
        <input type="text" name="userName" required><br><br>

        <button type="submit">Login</button>
    </form>
</body>
</html>

