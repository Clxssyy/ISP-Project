<?php
    include('db.php');
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
                <?php
                    if(isset($_SESSION['username'])) {
                        $name = ucfirst($_SESSION['username']);
                        echo "<h3 class='page-header'>Welcome to the Fancy Shop, $name</h3>";
                    }
                ?>
                <div class="video">
                    <iframe width="500px" height="250" src="https://www.youtube.com/embed/03jWJydHE4A"></iframe>
                    <p class="video-desc">Quick overview of the website and its features.</p>
                    <a href="ISP.pptx" download>PowerPoint</a>
                    <a href="ISP-Project-Final-Report.pdf" download>Final Report</a>
                </div>
                <h3 class="sec-header">Most Popular</h3>
                <div class="most-popular">
                    <?php
                        $sql = "SELECT * FROM items WHERE flag=1 ORDER BY item ASC";
                        $result = $connection->query($sql);

                        if (!$result) {
                            die("Invalid query: " . $connection->error);
                        }

                        while ($row = $result->fetch_assoc()) {
                            echo "
                                <a href='item.php?item_id=$row[item_id]'>
                                    <div class='item' id='$row[item_id]'>
                                        <img width='100px' height='100px' src='item-imgs/$row[item_img]'>
                                        <p class='item-name'>$row[item]</p>
                                        <p class='item-price'>$ $row[price]</p>
                                    </div>
                                </a>
                            ";
                        }
                    ?>
                </div> 
                <h3 class="sec-header">Top Reviews</h3>
                <div class="reviews">
                    <?php
                        $sql = "SELECT * FROM reviews WHERE flag=1 ORDER BY stars DESC";
                        $result = $connection->query($sql);

                        if (!$result) {
                            die("Invalid query: " . $connection->error);
                        }

                        while ($row = $result->fetch_assoc()) {
                                echo "
                                <div class='review'>
                                    <div class='review-header'>
                                        <h4>Review</h4>
                                        <p>★ $row[stars]/5</p>
                                    </div>
                                    <hr class='divider'>
                                    <p>$row[review]</p>
                                </div>
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