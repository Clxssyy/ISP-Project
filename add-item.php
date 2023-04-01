<?php
    include('db.php');
    $status = "";

    if($_SESSION['username'] != "admin")
    {
        header('location: index.php');
        exit;
    }
    
    if (isset($_POST['item_id']) && isset($_POST['item_name']) && isset($_POST['item_desc']) && isset($_POST['item_img']) && isset($_POST['item_price']) && isset($_POST['category']) && isset($_POST['flag'])){
        if ((empty($_POST['item_id']) || empty($_POST['item_name']) || empty($_POST['item_desc']) || empty($_POST['item_img']) || empty($_POST['item_price']) || empty($_POST['category']) || empty($_POST['flag'])) && $_POST['flag'] != 0) {
            $status = "<p>All fields required!</p>";
        } else {
            $item_id = $_POST['item_id'];
            $item_name = $_POST['item_name'];
            $item_desc = $_POST['item_desc'];
            $item_img = $_POST['item_img'];
            $price = $_POST['item_price'];
            $category = $_POST['category'];
            $flag = $_POST['flag'];
            
            $sql = "SELECT * FROM items";
            $result = mysqli_query($connection, $sql);

            if (!$result) {
                die("Invalid query: " . $connection->error);
            }

            while($row = mysqli_fetch_assoc($result)) {
                if(($item_id == $row['item_id'] || $item_name == $row['item']))
                {
                    $status = "<p>Item ID / Name taken!</p>";
                    break;
                }
            };

            if($status == "") {
                $sql = "INSERT INTO items (item_id, item, item_desc, item_img, price, category, flag) VALUES ('$item_id', '$item_name', '$item_desc', '$item_img', '$price', '$category', '$flag')";
                $result = $connection->query($sql);

                if (!$result) {
                    $errorMessage = "Invalid query: " . $connection->error;
                }
                $status = "<p>Item Added!</p>";
            }
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,400,0,0" />
    <link rel="icon" type="image/ico" href="logo/favicon.ico">
    <script src="scripts.js"></script>
    <title>Fancy Shop</title>
</head>
<body>
    <div class="website">
        <div class="header">
            <div class="nav">
                <h2>Shop</h2>
                <hr class="vertical">
                <a href="./" class="pages home active-page">Home</a>
                <a href="items.php" class="pages">Items</a>
                <a href="cart.php" class="pages">Cart</a>
                <a href="reviews.php" class="pages">Reviews</a>
                <a href="faq.php" class="pages">FAQ</a>
            </div> 
            <div class="search">
                <input class="search-bar" type="search" placeholder="Search">
                <button class="material-symbols-outlined search-btn">search</button>
            </div>
            <div class='right'>
                <?php
                    if (isset($_SESSION["username"])) {
                        echo "<a href='logout.php' class='pages'>Logout</a>";
                    } else {
                        echo "<a href='login.php' class='pages'>Login</a>";
                    }
                ?>
                <div class="cart">
                    <?php
                        if(!empty($_SESSION["shopping_cart"])) {
                            $cart_count = count(array_keys($_SESSION["shopping_cart"]));
                        }
                        else {
                            $cart_count = 0;
                        }
                    ?>
                    <a href="cart.php" class="material-symbols-outlined cart-icon">shopping_cart</a>
                    <div id="cart-count" class="cart-count"><?php echo $cart_count ?></div>
                </div>
            </div>
        </div>
        <div class="body">
            <div class="main">
                <h3 class="page-header">Add Item</h3>
                <form action="" method="post">
                    <input type="text" name="item_id" placeholder="Item Id">
                    <input type="text" name="item_name" placeholder="Item name">
                    <input type="text" name="item_desc" placeholder="Description">
                    <input type="text" name="item_img" placeholder="Image file name">
                    <input type="text" name="item_price" placeholder="Item price">
                    <input type="text" name="category" placeholder="Category">
                    <input type="text" name="flag" placeholder="Most popular (1 or 0)">
                    <input type="submit">
                </form>
                <?php
                    echo $status;
                ?>
            </div>
        </div>
        <div class="footer">
            <p>Michael Connolly</p>
            <p> 
                &copy; <?php echo date("Y"); ?>
            </p>
        </div>
    </div>
</body>
</html>