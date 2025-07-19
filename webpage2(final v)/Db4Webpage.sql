drop database if exists Db4Webpage;
create database Db4Webpage;
use Db4Webpage;

CREATE TABLE Products (
    ID INT PRIMARY KEY AUTO_INCREMENT,
    NameEn CHAR(50),
    Price DECIMAL(10, 2),
    DescEn VARCHAR(5000),
    ImageFile CHAR(50),
    NameUa CHAR(50),
    DescUa VARCHAR(5000)
);

CREATE TABLE Translations (
    Name CHAR(50) PRIMARY KEY,
    English VARCHAR(5000),
    Ukrainian VARCHAR(5000)
);

CREATE TABLE Accounts (
    ID INT PRIMARY KEY AUTO_INCREMENT,
    userName VARCHAR(100),
    psw VARCHAR(250), 
    role CHAR(50),
    age INT,
    nationality VARCHAR(100)
);

CREATE TABLE Orders (
    ID INT PRIMARY KEY AUTO_INCREMENT,
    UserID int,
    OrderStatus VARCHAR(100),
    FOREIGN KEY (UserID) REFERENCES Accounts(ID)
);

CREATE TABLE Order_list (
    ID INT PRIMARY KEY AUTO_INCREMENT,
    OrderID INT,
    ProductID INT,
    FOREIGN KEY (OrderID) REFERENCES Orders(ID),
    FOREIGN KEY (ProductID) REFERENCES Products(ID)
);



INSERT INTO Products (ID, NameEn, Price, DescEn, ImageFile, NameUa, DescUa) VALUES 
(1, "Notebook", 1.00, "Ntbk", "notebook.jpg", "Tetrad", "Ttrd"),
(2, "Eraser", 4.50, "Pzz1", "eraser.jpg", "Stirachka", "Strchka"),
(3, "Pen", 3.99, "Pz2z", "pen.jpg", "Ruchka", "Rchka"),
(4, "Pencil", 10.00, "P3zz", "pencil.jpg", "Olivec", "Lvc"),
(5, "Pencil sharpener", 5.50, "P9zz", "pencil sharpener.jpg", "Tochilka", "Tchlk"),
(6, "Ruler", 12.00, "Prwwzz", "ruler.jpg", "Liniyka", "Lnk"),
(7, "Chalk", 1000.00, "Pzdwez", "chalk.jpg", "Mel", "Ml"),
(8, "Marker pen", 10.00, "Pzfwez", "marker pen.jpg", "Flomaster", "Flmstr"),
(9, "Correction pen", 10.00, "P6zz", "correction pen.jpg", "Korector", "Krctr");


INSERT INTO Translations (Name, English, Ukrainian) VALUES
("HomeTitle", "Home", "Dim"),
("HomeHeader", "Welcome to Our Stationery Store", "Laskavo prosymo do nashoho magazynu kantselyars'kykh tovariv"),
("HomeDescription", "Your one-stop shop for quality stationery products", "Vasha odna zupynka dlya yakisnykh kantselyars'kykh tovariv"),
("ContactTitle", "Contact Us", "Kontakty"),
("ContactHeader", "Contact Information", "Kontakty"),
("ContactDescription", "Telephone numbers and other contact details", "telefonnye nomera i inshiya detali kontaktu"),
("AboutTitle", "About Us", "Pro nas"),
("AboutHeader", "About Our Store", "Pro Nash Mahazyn"),
("AboutDescription", "We provide a wide range of stationery products for students, professionals, and enthusiasts. Quality and affordability are our top priorities", "My nadayemo shyrokyy asortyment kantselyarsʹkykh tovariv dlya studentiv, profesiynaliv ta entuziastiv. Yakistʹ ta dostupnistʹ ye nashymy holovnymy pryyorytetamy"),
("LoginTitle", "Login", "Uviyty"),
("LoginHeader", "Login", "Uviyty"),
("LoginButton", "Login", "Uviyty"),
("LoginNamePlaceHolder", "Enter your username", "Im'ya suda"),
("LoginPasswordPlaceHolder", "Enter your password", "Vvedit' sviy parol"),
("LoginMessageSuccess", "Ok, your password is correct. Redirecting...", "Ok, vash parol virnyy. Perekhodymo..."),
("LoginMessageNameError", "Your username is not in our database", "Vashe im'ya ne znaydeno v nasiy bazy danykh"),
("LoginMessagePasswordError", "Invalid password", "Nevirnyy parol"),
("LogoutTitle", "Logout", "Viyty"),
("LogoutButton", "Logout", "Viyty"),
("LogoutHeader", "Logout", "Viyty"),
("LogoutButtonLabel", "Logout", "Viyty"),
("RegistrationTitle", "Registration", "Reyestraciya"),
("RegistrationHeader", "Registration", "Reyestraciya"),
("RegistrationNamePlaceHolder", "Enter your username", "Im'ya"),
("RegistrationPasswordPlaceHolder", "Enter your password", "Vvedit' sviy parol"),
("RegistrationPasswordPlaceHolder2", "Retype your password", "Povtorit' parol"),
("RegistrationButton", "Create account", "Stvoryty akaunt"),
("RegistrationMessageSuccess", "Registration successful!", "Reyestraciya uspishno zavershena!"),
("RegistrationMessageNameError", "User already exists. Please choose a different username.", "Im'ya vje isnuye. Bud' laska, obyrity inshyy variant."),
("RegistrationMessagePasswordError", "Passwords do not match. Please try again!", "Paroly ne spivpadayut. Sprobujte znovu!"),
("ProductsTitle", "Products", "Producty"),
("AddProductButton", "Add Product", "Dobavyty produkt"),
("BuyButton", "Buy", "Kupyty"),
("CartTitle", "Your Cart", "Vash Koshyk"),
("CartSuccessMessage", "Your order has been placed successfully!", "bla"),
("EmptyCartMessage", "Your cart is empty!", "Vash koshyk pustyy!"),
("ClearCartButton", "Clear Cart", "Ochystyty Koshyk"),
("OrdersTitle", "Orders", "Zakazy"),
("OrdersLoginMessage", "You need to log in to view your orders.", "Vam neobkhidno uviyty, shchob pereglyanuty vashi zakazy."),
("OrderDate", "Order Date", "Data Zakazu"),
("Product", "Product", "Produkt"),
("Quantity", "Quantity", "Kilkist"),
("Price", "Price", "Tsina"),
("TotalPrice", "Total Price", "Zahal'na Tsina"),
("Total", "Total", "Zagalom"),
("Delivered", "Delivered", "Dostavleno"),
("Pending", "Pending", "V dorozi"),
("MarkAsDeliveredButton", "Mark as delivered", "Poznachyty yak dostavleno"),
("PreviousOrders", "Previous Orders", "Mynuli zakazy"),
("NoOrdersPlacedMessage", "No orders have been placed yet.", "Shche ne bylo zrobyleno zakaziv."),
("User", "User", "Korysnyk"),
("AllOrdersTitle", "All Orders", "Vsi zakazy"),
("Order", "Order", "Zakaz"),
("NoOrdersFoundMessage", "No orders found.", "Zakaziv ne znaydeno."),
("AddProduct", "Add Product", "Dobavyty produkt"),
("AddANewProduct", "Add a New Product", "Dobavyty novyy produkt"),
("ProductName", "Product Name", "Nazva produktu"),
("ProductNameInUkrainian", "Product Name in Ukrainian", "Nazva produktu ukrayinskoyu"),
("ProductPrice", "Product Price", "Tsina produktu"),
("ProductDescription", "Product Description", "Opis produktu"),
("ProductDescriptionInUkrainian", "Product Description in Ukrainian", "Opis produktu ukrayinskoyu"),
("ImageFileName", "Image File Name", "Im'ya faylu zobrazhennya"),
("ProductAddedSuccessfully", "Product Added Successfully", "Produkt uspishno dobavleno"),
("PasswordChangeTitle", "Password change", "Zmina parolia"),
("PasswordChangedSuccessfullyMessage", "Password changed successfully", "Parol uspishno zminenyi"),
("NewPasswordsDoNotMatchMessage", "New passwords do not match. Please try again!", "Novi paroli ne spivpadaiut. Bud laska, sprobuite shche raz!"),
("IncorrectOldPasswordMessage", "Incorrect old password", "Nepravylnyi staryi parol"),
("OldPasswordPlaceholder", "Old password", "Staryi parol"),
("NewPasswordPlaceholder", "New password", "Novyi parol"),
("RepeatNewPasswordPlaceholder", "Repeat new password", "Povtorit novyi parol"),
("ChangeButton", "Change", "Zminyty"),
("AgePlaceholder", "Age", "Vik"),
("NationalityPlaceholder", "Nationality", "Natsionalnist");