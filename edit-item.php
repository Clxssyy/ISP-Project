<?php 
    include('db.php');

    if($_SESSION['username'] != "admin")
    {
        header('location: index.php');
        exit;
    }

    if ($_SERVER['REQUEST_METHOD'] == 'GET') {
        $item_id = $_GET["item_id"];

        $sql = "SELECT * FROM items WHERE item_id='$item_id'";
        $result = $connection->query($sql);
        $row = $result->fetch_assoc();

        if (!$row) {
            header("location: items.php");
            exit;
        }

        $name = $row["item"];
        $desc = $row["item_desc"];
        $item_img = $row["item_img"];
        $price = $row["price"];
        $category = $row["category"];
        $flag = $row["flag"];
    } else {
        $item_id = $_POST["item_id"];
        $name = $_POST["name"];
        $desc = $_POST["item_desc"];
        $item_img = $_POST["item_img"];
        $price = $_POST["price"];
        $category = $_POST["category"];
        $flag = $_POST["flag"];
    
        if ((empty($item_id) || empty($name) || empty($desc) || empty($item_img) || empty($price) || empty($category) || empty($flag)) && $flag != 0) {
            $errorMessage = "All fields are required";
            header("location: item.php?item_id=$item_id");
            exit;
        }

        $sql = "UPDATE items SET item_id='$item_id', item='$name', item_desc='$desc', item_img='$item_img', price='$price', category='$category', flag='$flag' WHERE item_id='$item_id'";

        $result = $connection->query($sql);

        header("location: item.php?item_id=$item_id");
        exit;
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
                <h3 class="page-header">Edit Item</h3>
                <form method="post">
                    <input type="hidden" name="id" value="<?php echo $item_id; ?>">
                    <div>
                        <label>ID</label>
                        <div>
                            <input type="text" name="item_id" value="<?php echo $item_id; ?>">
                        </div>
                    </div>
                    <div>
                        <label>Name</label>
                        <div>
                            <input type="text" name="name" value="<?php echo $name; ?>">
                        </div>
                    </div>
                    <div>
                        <label>Description</label>
                        <div>
                            <input type="text" name="item_desc" value="<?php echo $desc; ?>">
                        </div>
                    </div>
                    <div>
                        <label>Image</label>
                        <div>
                            <input type="text" name="item_img" value="<?php echo $item_img; ?>">
                        </div>
                    </div>
                    <div>
                        <label>Price</label>
                        <div>
                            <input type="text" name="price" value="<?php echo $price; ?>">
                        </div>
                    </div>
                    <div>
                        <label>Category</label>
                        <div>
                            <input type="text" name="category" value="<?php echo $category; ?>">
                        </div>
                    </div>
                    <div>
                        <label>Flag</label>
                        <div>
                            <input type="text" name="flag" value="<?php echo $flag; ?>">
                        </div>
                    </div>
                    <br>
                    <div>
                        <div>
                            <button type="submit" class="btn">Update Item</button>
                            <a href='item.php?item_id=<?php echo $item_id; ?>' class="btn">Cancel</a>
                        </div>
                    </div>
                    <br>
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