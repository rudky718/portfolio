<?php
include_once("CommonCode.php");

if (!isset($_SESSION["UserLoggedIn"]) || !isAdmin()) {
    header("Location: Home.php");
    exit();
}

// Обработка кнопки изменения статуса
foreach ($_POST as $key => $value) {
    if (str_starts_with($key, "MARK_DELIVERED_")) {
        $orderId = intval(str_replace("MARK_DELIVERED_", "", $key));
        $stmt = $conn->prepare("UPDATE Orders SET OrderStatus = 'delivered' WHERE ID = ?");
        $stmt->bind_param("i", $orderId);
        $stmt->execute();
        header("Location: AdminOrders.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $arrayOfStrings["AllOrdersTitle"] ?></title>
    <link rel="stylesheet" href="Website.css?<?= print(time()); ?>" />
</head>

<body>

    <?php NavigationBar("AdminOrders"); ?>

    <div class="orders-container">
        <h1 class="cart-title"><?= $arrayOfStrings["AllOrdersTitle"] ?></h1>

        <?php
        $sqlOrders = $conn->query("SELECT Orders.ID AS OrderID, Orders.OrderStatus, Accounts.userName 
                                   FROM Orders 
                                   JOIN Accounts ON Orders.UserID = Accounts.ID 
                                   ORDER BY Orders.ID DESC");

        if ($sqlOrders->num_rows > 0) {
            while ($order = $sqlOrders->fetch_assoc()) {
                $orderID = $order['OrderID'];
                $orderStatus = $order['OrderStatus'];
                $userName = $order['userName'];

                echo "<div class='order-item'>";
                echo "<h3>{$arrayOfStrings["Order"]} #$orderID {$arrayOfStrings["User"]}: $userName</h3>";

                $statusClass = $orderStatus === "delivered" ? "delivered" : "pending";
                $statusText = $orderStatus === "delivered" ? $arrayOfStrings["Delivered"] : $arrayOfStrings["Pending"];
                echo "<p class='order-status $statusClass'>$statusText</p>";

                $currentLang = $_SESSION["language"] === "UA" ? "Ua" : "En";

                $sqlItems = $conn->prepare("SELECT Products.Name$currentLang AS ProductName, Products.Price, COUNT(*) AS Quantity
                                            FROM Order_list
                                            JOIN Products ON Order_list.ProductID = Products.ID
                                            WHERE Order_list.OrderID = ?
                                            GROUP BY Order_list.ProductID");
                $sqlItems->bind_param("i", $orderID);
                $sqlItems->execute();
                $resultItems = $sqlItems->get_result();

                echo "<div class='order-products'>";
                $totalOrderPrice = 0;

                while ($item = $resultItems->fetch_assoc()) {
                    $productName = htmlspecialchars($item['ProductName']);
                    $price = $item['Price'];
                    $quantity = $item['Quantity'];
                    $total = $price * $quantity;
                    $totalOrderPrice += $total;

                    echo "<div class='order-product'>";
                    echo "<p>$productName</p>";
                    echo "<p>{$arrayOfStrings["Quantity"]}: $quantity</p>";
                    echo "<p>{$arrayOfStrings["Price"]}: $price EUR</p>";
                    echo "<p>{$arrayOfStrings["Total"]}: $total EUR</p>";
                    echo "</div>";
                }

                echo "</div>";
                echo "<p class='order-total'>{$arrayOfStrings["TotalPrice"]}: $totalOrderPrice EUR</p>";

                if ($orderStatus === "pending") {
                    echo "<form method='POST'>";
                    echo "<button class='order-action-button' type='submit' name='MARK_DELIVERED_$orderID'>{$arrayOfStrings["MarkAsDeliveredButton"]}</button>";
                    echo "</form>";
                }

                echo "</div>";
            }
        } else {
            echo "<p>{$arrayOfStrings["NoOrdersFoundMessage"]}</p>";
        }
        ?>
    </div>

</body>

</html>
