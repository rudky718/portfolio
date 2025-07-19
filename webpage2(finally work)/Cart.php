<?php 
    include_once("CommonCode.php");

    if (!$_SESSION["UserLoggedIn"]) {
        header("Location: Home.php");
        exit();
    }

    if (isset($_POST['BUY_ALL']) && count($_SESSION['cart']) > 0) {
        $sqlNewOrder = $conn->prepare("INSERT INTO Orders (UserID, OrderStatus) VALUES ((SELECT ID FROM Accounts WHERE userName = ?), 'pending')");
        $sqlNewOrder->bind_param("s", $_SESSION["User"]);
        $sqlNewOrder->execute();
        $orderId = $conn->insert_id;

        foreach ($_SESSION["cart"] as $productId) {
            $sqlNewOrderItem = $conn->prepare("INSERT INTO Order_list (OrderID, ProductID) VALUES (?, ?)");
            $sqlNewOrderItem->bind_param("ii", $orderId, $productId);
            $sqlNewOrderItem->execute();
        }

        $_SESSION['cart'] = [];
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $arrayOfStrings["CartTitle"] ?></title>
    <link rel="stylesheet" href="Website.css?<?= print(time()); ?>" />
</head>
<body>
    <?php NavigationBar("Cart"); ?>

    <div class="cart-container">
        <h1 class="cart-title"><?= $arrayOfStrings["CartTitle"] ?></h1>

        <?php
        if (isset($_POST['CLEAR_CART'])) {
            $_SESSION['cart'] = [];
            header("Location: Cart.php");
            exit();
        }

        $totalPrice = 0;
        $productCounts = [];

        if (isset($_SESSION['cart']) && count($_SESSION['cart']) > 0) {
            $currentLang = $_SESSION["language"] === "UA" ? "Ua" : "En";  

            foreach ($_SESSION['cart'] as $productID) {
                if (isset($productCounts[$productID])) {
                    $productCounts[$productID]++;
                } else {
                    $productCounts[$productID] = 1;
                }
            }

            foreach ($productCounts as $productID => $quantity) {
                $sqlSelect = $conn->prepare("SELECT * FROM Products WHERE ID = ?");
                $sqlSelect->bind_param("i", $productID);
                $sqlSelect->execute();
                $result = $sqlSelect->get_result();

                if ($row = $result->fetch_assoc()) {
                    echo "<div class='cart-item'>";
                    echo '<img src="./images/' . $row["ImageFile"] . '" alt="Product Image">';
                    echo "<div class='cart-item-quantity'> {$quantity}</div>";
                    echo "<div class='cart-item-name'>{$row["Name" . $currentLang]}</div>";
                    echo "<div class='cart-item-price'>" . ($row['Price'] * $quantity) . " EUR</div>";
                    echo "</div>";

                    $totalPrice += $row['Price'] * $quantity;
                }
            }
        } else {
            echo "<p>" . $arrayOfStrings["EmptyCartMessage"] . "</p>";
        }
        ?>

        <div class="cart-total">
            <span><?= $arrayOfStrings["TotalPrice"] ?>:</span>
            <span><?= $totalPrice ?> EUR</span>
        </div>

        <div class="clear-cart-form">
            <form method="POST">
                <input type="submit" name="BUY_ALL" value="<?= $arrayOfStrings["BuyButton"] ?>" class="button" />
            </form>

            <form method="POST">
                <input type="submit" name="CLEAR_CART" value="<?= $arrayOfStrings["ClearCartButton"] ?>" class="clear-cart-button" />
            </form>
        </div>

        <h1 class="cart-title"><?= $arrayOfStrings["PreviousOrders"] ?>:</h1>
        <?php
        $sqlOrders = $conn->prepare("SELECT * FROM Orders WHERE UserID = (SELECT ID FROM Accounts WHERE userName = ?) ORDER BY ID DESC");
        $sqlOrders->bind_param("s", $_SESSION["User"]);
        $sqlOrders->execute();
        $resultOrders = $sqlOrders->get_result();

        if ($resultOrders->num_rows > 0) {
            while ($order = $resultOrders->fetch_assoc()) {
                $orderID = $order['ID'];
                $orderStatus = $order['OrderStatus'];

                echo "<div class='order-item'>";
                $statusClass = $orderStatus === "delivered" ? "delivered" : "pending";
                $translatedStatus = $orderStatus === "delivered" ? $arrayOfStrings["Delivered"] : $arrayOfStrings["Pending"];
                echo "<p class='order-status $statusClass'>$translatedStatus</p>";

                $currentLang = $_SESSION["language"] === "UA" ? "Ua" : "En";

                $sqlOrderItems = $conn->prepare("
                    SELECT Products.Name" . $currentLang . ", Order_list.ProductID, Products.Price, COUNT(Order_list.ProductID) AS quantity
                    FROM Order_list
                    JOIN Products ON Order_list.ProductID = Products.ID
                    WHERE Order_list.OrderID = ?
                    GROUP BY Order_list.ProductID
                ");
                $sqlOrderItems->bind_param("i", $orderID);
                $sqlOrderItems->execute();
                $resultOrderItems = $sqlOrderItems->get_result();

                echo "<div class='order-products'>";
                $totalOrderPrice = 0;

                while ($item = $resultOrderItems->fetch_assoc()) {
                    $productName = $item['Name' . $currentLang];
                    $productPrice = $item['Price'];
                    $quantity = $item['quantity'];
                    $totalPriceForItem = $productPrice * $quantity;

                    echo "<div class='order-product'>";
                    echo "<p>$productName</p>";
                    echo "<p>" . $arrayOfStrings["Quantity"] . ": $quantity</p>";
                    echo "<p>" . $arrayOfStrings["Price"] . ": $productPrice EUR</p>";
                    echo "<p>" . $arrayOfStrings["Total"] . ": $totalPriceForItem EUR</p>";
                    echo "</div>";

                    $totalOrderPrice += $totalPriceForItem;
                }

                echo "</div>";
                echo "<p class='order-total'>" . $arrayOfStrings["TotalPrice"] . ": $totalOrderPrice EUR</p>";
                echo "</div>";
            }
        } else {
            echo "<p>" . $arrayOfStrings["NoOrdersPlacedMessage"] . "</p>";
        }
        ?>
    </div>
</body>
</html>
