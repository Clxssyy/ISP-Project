<?php
    include('db.php');
    $status = "";

    if (isset($_POST['username']) && (empty($_POST['username']) || empty($_POST['password']))) {
        $status = "<p>All fields required!</p>";
    }
    if (!empty($_POST['username']) && !empty($_POST['password'])) {
        $sql = "SELECT * FROM users";
        $result = mysqli_query($connection, $sql);

        if (!$result) {
            die("Invalid query: " . $connection->error);
        }

        while($row = mysqli_fetch_assoc($result)) {
            if(($_POST['username'] == $row['username'] || $_POST['username'] == $row['email']) && $_POST['password'] == $row['password'])
            {
                session_destroy();
                session_start();
                $_SESSION["username"] = $row['username'];
                header('location: index.php');
                exit;
            } else {
                $status = "<p>Wrong info!</p>";
            }
        };
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
    <title>Fancy Shop - Login</title>
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
                <a href="login.php" class="pages">Login</a>
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
                <h3 class="page-header">Login</h3>
                <form action="" method="post">
                    <input type="text" name="username" placeholder="Username">
                    <input type="password" name="password" placeholder="Password">
                    <input type="submit">
                </form>
                <a href="sign-up.php">Sign up?</a>
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