<?php
    include('db.php');
    
    if (isset($_GET['category'])) {
        $category = ucfirst($_GET['category']);
        $sql = "SELECT * FROM items WHERE category='$category' ORDER BY item ASC";
    }
    else
    {
        $category = "Items";
        $sql = "SELECT * FROM items ORDER BY category, item ASC";
    }

    $result = $connection->query($sql);

    if (!$result) {
        die("Invalid query: " . $connection->error);
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fancy Shop - <?php echo "$category" ?></title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,400,0,0" />
    <link rel="icon" type="image/ico" href="logo/favicon.ico">
    <script src="scripts.js"></script>
    <style>
        #<?php echo "$category" ?> {
            color: white;
        }
    </style>
</head>
<body>
    <div class="website">
        <div class="header">
            <div class="nav">
                <h2>Shop</h2>
                <hr class="vertical">
                <a href="./" class="pages home">Home</a>
                <a href="items.php" class="pages active-page">Items</a>
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
            <div class="sidebar">
                <div class="categories">
                    <h3 class="sidebar-header">Categories</h3>
                    <hr class="divider">
                    <a class="category" id="Food" href="items.php?category=food">Food</a>
                    <a class="category" id="Clothing" href="items.php?category=clothing">Clothing</a>
                    <a class="category" id="Electronics" href="items.php?category=electronics">Electronics</a>
                    <a class="category" id="Books" href="items.php?category=books">Books</a>
                </div>
                <?php
                    if(isset($_SESSION["username"]) && $_SESSION["username"] == "admin") {
                        echo "<div>
                                <h3 class='sidebar-header'>Admin Options</h3>
                                <hr class='divider'>
                                <a class='btn' href='add-item.php'>Add item</a>
                             </div>";
                    }
                ?>
            </div>
            <div class="main">
                <h3 class="page-header">For Sale - <?php echo "$category" ?></h3>
                <div class='items'>
                    <?php
                        while ($row = $result->fetch_assoc()) {
                            echo "
                                <a href='item.php?item_id=$row[item_id]'>
                                    <div class='item' id='$row[item_id]'>
                                        <p class='item-name'>$row[item]</p>
                                        <img width='100px' height='100px' src='item-imgs/$row[item_img]'>
                                        <p class='item-price'>$ $row[price]</p>
                                    </div>
                                </a>
                            ";
                        }
                    ?>
                </div>
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