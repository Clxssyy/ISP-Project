<?php
    include('db.php');
    $status = "";
    
    if (isset($_POST['username']) && isset($_POST['email']) && isset($_POST['password']) && isset($_POST['passwordrepeat'])){
        if ((empty($_POST['username']) || empty($_POST['email']) || empty($_POST['password']) || empty($_POST['passwordrepeat']))) {
            $status = "<p>All fields required!</p>";
        } else if ($_POST['password'] != $_POST['passwordrepeat']) {
            $status = "<p>Passwords don't match!</p>";
        } else {
            $username = $_POST['username'];
            $email = $_POST['email'];
            $password = $_POST['password'];
            
            $sql = "SELECT * FROM users";
            $result = mysqli_query($connection, $sql);

            if (!$result) {
                die("Invalid query: " . $connection->error);
            }

            while($row = mysqli_fetch_assoc($result)) {
                if(($username == $row['username'] || $email == $row['email']))
                {
                    $status = "<p>Username/Email taken!</p>";
                    break;
                }
            };

            if($status == "") {
                $sql = "INSERT INTO users (username, email, password) VALUES ('$username', '$email', '$password')";
                $result = $connection->query($sql);

                if (!$result) {
                    $errorMessage = "Invalid query: " . $connection->error;
                }
                $status = "<p>Sign up complete!</p>";
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
    <title>Fancy Shop - Sign up</title>
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
                <h3 class="page-header">Sign-up</h3>
                <form action="" method="post">
                    <input type="text" name="username" placeholder="Username">
                    <input type="text" name="email" placeholder="Email">
                    <input type="password" name="password" placeholder="Password">
                    <input type="password" name="passwordrepeat" placeholder="Repeat Password">
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