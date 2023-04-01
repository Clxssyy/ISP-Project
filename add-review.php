<?php
    include('db.php');

    $review = "";
    $stars = "";
    $flag = "";

    $errorMessage = "";

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $review = $_POST["review"];
        $stars = $_POST["stars"];

        if ($stars > 3) { 
            $flag = 1;
        } else {
            $flag = 0;
        }

        do {
            if (empty($review) || empty($stars) && $stars != 0) {
                $errorMessage = "All fields are required";
                break;
            }

            $sql = "INSERT INTO reviews (review, stars, flag) VALUES ('$review', '$stars', '$flag')";
            $result = $connection->query($sql);

            if (!$result) {
                $errorMessage = "Invalid query: " . $connection->error;
                break;
            }

            $review = "";
            $stars = "";
            $flag = "";

            header("location: reviews.php");
            exit;

        } while (false);
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
    <title>Fancy Shop - Add Review</title>
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
                <a href="reviews.php" class="pages active-page">Reviews</a>
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
                <h3 class="page-header">Add a Review</h3>
                <form method="post">
                    <div>
                        <label>Review</label>
                        <div>
                            <textarea class="text-box" type="text" name="review" placeholder="Type your review..."></textarea>
                        </div>
                    </div>
                    <div>
                        <label>Stars</label>
                        <div>
                            <input type="number" min=0 max=5 name="stars" value=0>
                        </div>
                    </div>

                    <?php
                    if (!empty($errorMessage)) {
                        echo "<p class='error'>$errorMessage</p>";
                    }
                    ?>

                    <div>
                        <div>
                            <button type="submit" class='btn'>Submit</button>
                            <a class='btn' href="reviews.php">Cancel</a>
                        </div>
                    </div>
                </form>
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