<!DOCTYPE html>
<html lang="en">
<?php

$host = "localhost";
$UserName = "root";
$password = "";
$dbName = "WSERS2_R";

$conn = mysqli_connect($host, $UserName, $password, $dbName);


if (isset($_POST['CarType'])) {

    $clientName = $_POST["ClientName"];
    $carTypeId = $_POST["CarType"];
    $howMany = $_POST["HowMany"];


    if (!empty($clientName) && $carTypeId > 0 && $howMany > 0) {

        $sqlSelect = $conn->prepare("INSERT INTO Orders (ClientName, ModelIdOrdered, NumberOfCarsOrdered) VALUES (?, ?, ?)");
        $sqlSelect->bind_param("sii", $clientName, $carTypeId, $howMany);
        $sqlSelect->execute();

        $stmt = $conn->prepare("UPDATE CarsDB SET Available = Available - ? WHERE ModelIdCar = ?");
        $stmt->bind_param("ii", $howMany, $carTypeId);        
        $stmt->execute();
        echo "<p>Order placed successfully!</p>";

    } else {
        echo "<p>Please fill in all fields correctly.</p>";
    }
   /*  $_POST['CarType'] = 0; */
}
?>
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Document</title>
    <style>
        tr,
        td {
            border: 2px solid black;
            text-align: center;
            padding: 10px;
        }

        .lowCars {
            background-color: pink;
        }
    </style>
</head>

<?php


$sqlShow = $conn->prepare("SELECT * FROM carsview;");
$sqlShow->execute();
$result = $sqlShow->get_result();
?>





<body>
    <table>
        <tr>
            <th>Car model</th>
            <th>Price</th>
            <th>Available</th>
            <th>Orders</th>
        </tr>
        <?php
        $tinc = 0;
        while ($row = $result->fetch_assoc()) {
        ?>
            <tr class=<?= $row["Available"] <= $row["Ordered"] ? "lowCars" : "" ?>>
                <td><?= $row["ModelName"] ?></td>
                <td><?= $row["Price"] ?></td>
                <td><?= $row["Available"] ?></td>
                <td><?= $row["Ordered"] ?></td>
            </tr>
        <?php
            $tinc = $tinc + $row["Price"] * $row["Ordered"];
        }
        ?>


        <tr>
            <td>Total income:</td>
            <td></td>
            <td></td>
            <td><?= $tinc ?></td>
        </tr>
    </table>
    <h1>Order cars here</h1>
    <form method="POST">
        <div>Your name<input name="ClientName" /></div>
        <div>
            Please select the car type:
            <select name="CarType">
                <?php
                mysqli_data_seek($result, 0);
                while ($row = $result->fetch_assoc()) {
                ?>
                    <option value=<?= $row["ModelIdCar"] ?>><?= $row["ModelName"] ?></option>
                <?php } ?>
            </select>
        </div>
        <div>How many do you want:<input name="HowMany" /></div>
        <div><input type="submit" name="Order" value="Order" /></div>
    </form>
</body>

</html>