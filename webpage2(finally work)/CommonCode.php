<?php
session_start();

// Connection to DB
$host = "localhost";
$userName = "root";
$psw = "";
$dbName = "Db4Webpage";
$conn = mysqli_connect($host, $userName, $psw, $dbName);

// Default language
if (!isset($_SESSION["language"])) {
    $_SESSION["language"] = "EN";
}
if (isset($_GET["language"])) {
    $_SESSION["language"] = $_GET["language"];
}

$arrayOfStrings = [];
$lang = $_SESSION["language"] === "UA" ? "Ukrainian" : "English";
$sql = "SELECT Name, $lang FROM Translations";
$result = mysqli_query($conn, $sql);
if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $arrayOfStrings[$row["Name"]] = $row[$lang];
    }
}

// Check if product is added to cart
if (isset($_POST['add_to_cart'])) {
    $productID = $_POST['add_to_cart'];

    // Add product to cart by ID
    $_SESSION['cart'][] = $productID;

    // Optionally: add a success message or confirmation
    $_SESSION['cart_message'] = "Product added to cart!";
}

if (isset($_POST["Logout"])) {
    session_unset();
    session_destroy();
    header("Location: Home.php");
    exit();
}

function isAdmin()
{
    return isset($_SESSION["UserRole"]) && $_SESSION["UserRole"] === "admin";
}

function isUser()
{
    return isset($_SESSION["UserRole"]) && $_SESSION["UserRole"] === "customer";
}

function NavigationBar($buttonToHighlight)
{
    global $arrayOfStrings;
?>
    <div class="NavCenter">
        <div class="NavBar">
            <div class="MainLinks">
                <a href="Home.php" <?php if ($buttonToHighlight == "Home") {
                                        echo "class='active'";
                                    } ?>><?= $arrayOfStrings["HomeTitle"] ?></a>
                <a href="Products.php" <?php if ($buttonToHighlight == "Products") {
                                            echo "class='active'";
                                        } ?>><?= $arrayOfStrings["ProductsTitle"] ?></a>
                <a href="About.php" <?php if ($buttonToHighlight == "About") {
                                        echo "class='active'";
                                    } ?>><?= $arrayOfStrings["AboutTitle"] ?></a>
                <a href="Contact.php" <?php if ($buttonToHighlight == "Contact") {
                                            echo "class='active'";
                                        } ?>><?= $arrayOfStrings["ContactTitle"] ?></a>

                <?php if (isset($_SESSION["UserLoggedIn"]) && $_SESSION["UserLoggedIn"]) { ?>
                    <a href="PasswordChange.php" <?php if ($buttonToHighlight == "PasswordChange") {
                                                        echo "class='active'";
                                                    } ?>>Password Change</a>
                    <?php if (isAdmin()) { ?>
                        <a href="AddProduct.php" <?php if ($buttonToHighlight === "AddProduct") {
                                                        echo "class='active'";
                                                    } ?>><?= $arrayOfStrings["AddProductButton"] ?></a>
                        <a href="AdminOrders.php" <?php if ($buttonToHighlight == "AdminOrders") {
                                                        echo "class='active'";
                                                    } ?>><?= $arrayOfStrings["OrdersTitle"] ?></a>
                    <?php } ?>
                    <?php if (isUser()) { ?>
                        <a href="Cart.php" <?php if ($buttonToHighlight == "Cart") {
                                                echo "class='active'";
                                            }  ?>><?= $arrayOfStrings["CartTitle"] ?></a>
                    <?php } ?>

                   
                    <a href="Logout.php" <?php if ($buttonToHighlight === "Logout") {
                                                echo "class='active'";
                                            } ?>><?= $arrayOfStrings["LogoutTitle"] ?></a>
                <?php } else { ?>
                    <a href="Login.php" <?php if ($buttonToHighlight === "Login") {
                                            echo "class='active'";
                                        } ?>><?= $arrayOfStrings["LoginTitle"] ?></a>
                    <a href="Registration.php" <?php if ($buttonToHighlight === "Registration") {
                                                    echo "class='active'";
                                                } ?>><?= $arrayOfStrings["RegistrationTitle"] ?></a>
                <?php } ?>
            </div>
            <div class="Icons">
                <div class="user-name">
                    <?php
                    if (isset($_SESSION["UserLoggedIn"]) && $_SESSION["UserLoggedIn"]) {
                        echo $_SESSION["User"];
                    } else {
                        echo $arrayOfStrings["User"];
                    }
                    ?>
                </div>
                <div class="logo-container">
                    <img src="./images/logo.png" alt="Logo" class="logo">
                </div>
                <form method="get">
                    <select name="language" onchange="this.form.submit()">
                        <option value="EN" <?= $_SESSION["language"] == "EN" ? "selected" : "" ?>>English</option>
                        <option value="UA" <?= $_SESSION["language"] == "UA" ? "selected" : "" ?>>Ukrainian</option>
                    </select>
                </form>
            </div>
        </div>
    </div>
    <?php
}


function userAlreadyExists($userName)
{
    global $conn;

    $sqlSelect = $conn->prepare("SELECT * from Accounts where userName = ?");
    $sqlSelect->bind_param("s", $userName);
    $sqlSelect->execute();
    $result = $sqlSelect->get_result();
    if ($result->num_rows == 0) {
        return false;
    } else {
        return true;
    }
}

function checkUserPassword($givenUser, $givenPassword)
{
    global $conn;
    $sqlSelect = $conn->prepare("SELECT * from Accounts where userName = ?");
    $sqlSelect->bind_param("s", $givenUser);
    $sqlSelect->execute();
    $result = $sqlSelect->get_result();
    if ($result->num_rows == 0) {
        return false;
    } else {
        $row = $result->fetch_assoc();
        if (password_verify($givenPassword, $row["psw"])) {
            return $row;
        }
    }
    return false;
}


function buildProducts()
{
    global $arrayOfStrings;
    global $conn;
    $sqlSelect = $conn->prepare("SELECT * from Products");
    $sqlSelect->execute();
    $result = $sqlSelect->get_result();
    while ($row = $result->fetch_assoc()) {
    ?>
        <div class="product">
            <div><?= ($_SESSION["language"] == "EN") ? $row["NameEn"] : $row["NameUa"] ?></div>
            <div><?= $row["Price"] ?> EUR</div>
            <img src="./images/<?= $row["ImageFile"] ?>">
            <div><?= ($_SESSION["language"] == "EN") ? $row["DescEn"] : $row["DescUa"] ?></div>

            <?php if (isset($_SESSION["UserRole"]) && $_SESSION["UserRole"] === "customer") { ?>
                <form method="post">
                    <button type="submit" name="add_to_cart" value="<?= $row["ID"] ?>"><?= $arrayOfStrings["BuyButton"] ?></button>
                </form>
            <?php } ?>
        </div>
<?php
    }
}
?>