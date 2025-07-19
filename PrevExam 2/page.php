<?php
session_start();

if (!isset($_SESSION['userName'])) {
    header("Location: login.php");
    exit;
}

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "examWSERS2";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

function promCodeExist($Code)
{
    global $conn;

    $sqlSelect = $conn->prepare("SELECT * from promotions where Code = ?");
    $sqlSelect->bind_param("s", $Code);
    $sqlSelect->execute();
    $result = $sqlSelect->get_result();
    if ($result->num_rows == 0) {
        return false;
    } else {
        return true;
    }
}

function promCodeAvalible($Code)
{
    global $conn;

    $sqlSelect = $conn->prepare("SELECT Available from promotions where Code = ?");
    $sqlSelect->bind_param("s", $Code);
    $sqlSelect->execute();
    $result = $sqlSelect->get_result();
    $row = $result->fetch_assoc(); 
        if($row['Available'] > 0) {
            return true;
        } else {
            return false;
        }
}

function promCodeValue($Code)
{
    global $conn;

    $sqlSelect = $conn->prepare("SELECT Value from promotions where Code = ?");
    $sqlSelect->bind_param("s", $Code);
    $sqlSelect->execute();
    $result = $sqlSelect->get_result();
    $row = $result->fetch_assoc(); 
        return $row['Value'];
}

if (isset($_POST["Code"])){
    if (!promCodeExist($_POST["Code"])) {
        print "Code doesn't exist!";
    } else {

        if(promCodeAvalible($_POST["Code"])){
        $code = promCodeValue($_POST["Code"]);
        $sqlUpdate = $conn->prepare("UPDATE People SET Money = Money + ? WHERE Name = ?");
        $sqlUpdate->bind_param("is",$code, $_SESSION["userName"]);
        $sqlUpdate->execute();
        $sqlUpdate->close();

        $sqlUpdate = $conn->prepare("UPDATE Promotions SET Available = Available - 1 WHERE Code = ?");
        $sqlUpdate->bind_param("s", $_POST["Code"]);
        $sqlUpdate->execute();
        $sqlUpdate->close();
        
        $_SESSION["Money"] += $code;
        } else {
            print "You just missed our promotion :(";
        }
    }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    Welcome <?=$_SESSION["userName"]?>! Your money: <?=$_SESSION["Money"]?>
    <form method="POST" action="">
    <br><input name="Code" placeholder="Write your promotional code here..."></input><br>
        <button type="submit">Submit</button><br><br>
    </form>
<a href="logout.php">Logout</a>
</body>
</html>