<?php
    include('db.php');

    if (isset($_GET['item_id'])) {
        $item_id = $_GET['item_id'];
        $sql = "SELECT * FROM items WHERE item_id='$item_id'";
    }

    $result = $connection->query($sql);

    if (!$result) {
        die("Invalid query: " . $connection->error);
    }

    $item_id = $_GET['item_id'];
    $result = mysqli_query($connection, "SELECT * FROM items WHERE item_id='$item_id'");
    $row = mysqli_fetch_assoc($result);
    $name = $row['item'];
    $item_id = $row['item_id'];
    $price = $row['price'];
    $image = $row['item_img'];
    $category = $row['category'];
    $quantity = 1;

    if (isset($_POST['item_id']) && $_POST['item_id']!=""){
        $item_id = $_POST['item_id'];
        $quantity = $_POST['quantity'];
        $result = mysqli_query($connection, "SELECT * FROM items WHERE item_id='$item_id'");
        $row = mysqli_fetch_assoc($result);
        $name = $row['item'];
        $item_id = $row['item_id'];
        $price = $row['price'];
        $image = $row['item_img'];
        $category = $row['category'];

        $cartArray = array(
            $item_id=>array(
            'name'=>$name,
            'item_id'=>$item_id,
            'price'=>$price,
            'quantity'=>$quantity,
            'image'=>$image)
        );

        if(empty($_SESSION["shopping_cart"])) {
            $_SESSION["shopping_cart"] = $cartArray;
            $status = "<div class='status'><strong>Product has been added to your cart!</strong></div>";
        } else {
            $array_keys = array_keys($_SESSION["shopping_cart"]);
            if(in_array($item_id,$array_keys)) {
                $status = "<div class='status' style='color:red;'><strong>Product is already in your cart!</strong></div>";	
            } else {
                $_SESSION["shopping_cart"] = array_merge($_SESSION["shopping_cart"], $cartArray);
                $status = "<div class='status'><strong>Product has been added to your cart!</strong></div>";
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
    <title>Fancy Shop - <?php echo ucfirst($name) ?></title>
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
            <div class="sidebar">
                <div class="categories">
                    <h3 class='sidebar-header'>Categories</h3>
                    <hr class="divider">
                    <a class="category" id="food" href="items.php?category=food">Food</a>
                    <a class="category" id="clothing" href="items.php?category=clothing">Clothing</a>
                    <a class="category" id="electronics" href="items.php?category=electronics">Electronics</a>
                    <a class="category" id="books" href="items.php?category=books">Books</a>
                </div>
            </div>
            <div class="main">
                <div class="item-display">
                    <?php
                        echo "
                            <div class='main-item $item_id'>
                                <img src='item-imgs/$image'>
                                <div class='item-info'>
                                    <div class='wrapper'>
                                        <h3 class='item-name'>$name</h3>
                                        <p class='item-desc'> Description: $row[item_desc]</p>
                                        <p name='price'>Price: $ $price</p>";
                        echo $status . "
                                        <form method='post' action=''>
                                            <p>Quantity: </p>
                                            <input type='number' class='quantity' name='quantity' value=$quantity min=1>
                                            <input type='hidden' name='item_id' value=".$row['item_id']." />
                                            <input type='submit' value='Add to cart'>
                                        </form>";

                        if (isset($_SESSION["username"]) && $_SESSION["username"] == "admin") {
                            echo "<h3 class='page-header'>Admin Options</h3>
                                    <form action='edit-item.php' method='get'>
                                        <input type='hidden' name='item_id' value='$item_id'>
                                        <input class='btn' type='submit' value='Edit Item'>
                                    </form>
                                    <form action='remove-item.php' method='get'>
                                        <input type='hidden' name='item_id' value='$item_id'>
                                        <input class='btn' type='submit' value='Remove Item'>
                                    </form>
                                    ";
                        }

                        echo "      </div>
                                </div>
                            </div>
                        ";
                    ?>
                    <div class="suggested-section">
                        <div class="small-header">
                            <h3 class="display-header">Suggested Items</h3>
                        </div>
                        <div class="suggested-items">
                            <?php
                                $sql = "SELECT * FROM items WHERE category='$category' AND item_id!='$item_id' ORDER BY item ASC";
                                $result = $connection->query($sql);
                                while ($row = $result->fetch_assoc()) {
                                    echo "
                                        <a href='item.php?item_id=$row[item_id]'>
                                            <div class='item $row[item_id]'>
                                                <p class='item-name'>$row[item]</p>
                                                <img width='100px' height='100px' src='item-imgs/$row[item_img]'>
                                                <p class='price'>$ $row[price]</p>
                                            </div>
                                        </a>
                                    ";
                                }
                            ?>
                        </div>
                    </div>
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