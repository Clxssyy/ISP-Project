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
    <title>Fancy Shop - FAQ</title>
</head>
<body>
    <div class="website">
        <div class="header">
            <div class="nav">
                <h2>Shop</h2>
                <hr class="vertical">
                <a href="./" class="pages home">Home</a>
                <a href="items.php" class="pages">Items</a>
                <a href="cart.php" class="pages">Cart</a>
                <a href="reviews.php" class="pages">Reviews</a>
                <a href="faq.php" class="pages active-page">FAQ</a>
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
                <h3 class="page-header">FAQ</h3>
                <div class="questions">
                    <div class="question">
                        <h4>Is the fruit sold here fresh?</h4>
                        <hr class="divider">
                        <p>All the fruit sold here is grow locally.</p>
                    </div>
                    <div class="question">
                        <h4>What's the refund policy?</h4>
                        <hr class="divider">
                        <p>All purchases are final.</p>
                    </div>
                    <div class="question">
                        <h4>How often is the shop restocked?</h4>
                        <hr class="divider">
                        <p>The shop is restocked every friday.</p>
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