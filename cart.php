<?php
    include('db.php');

    $sql = "SELECT * FROM items";
    $result = $connection->query($sql);

    if (!$result) {
        die("Invalid query: " . $connection->error);
    }

    if (isset($_POST['action']) && $_POST['action']=="remove"){
    if(!empty($_SESSION["shopping_cart"])) {
        foreach($_SESSION["shopping_cart"] as $key => $value) {
            if($_POST["item_id"] == $key){
                unset($_SESSION["shopping_cart"][$key]);
                $status = "<div class='status' style='color:red;'>
                <strong>Product was removed from your cart!</strong></div>";
            }
            if(empty($_SESSION["shopping_cart"])){
                unset($_SESSION["shopping_cart"]);
            }
        }		
    }
    }

    if (isset($_POST['action']) && $_POST['action']=="minus"){
    foreach($_SESSION["shopping_cart"] as &$value){
            if($value['item_id'] === $_POST["item_id"]){
                if($value['quantity'] == 1) {
                    $status = "<div class='status' style='color:red;'>
                    <strong>To remove a product click remove!</strong></div>";
                    break;
                };
                $value['quantity'] -= $_POST["quantity"];
                break; // Stop the loop after we've found the product
            }
        }
    }

    if (isset($_POST['action']) && $_POST['action']=="plus"){
        foreach($_SESSION["shopping_cart"] as &$value){
            if($value['item_id'] === $_POST["item_id"]){
                $value['quantity'] += $_POST["quantity"];
                break; // Stop the loop after we've found the product
            }
        }   
    }

    if (isset($_POST['action']) && $_POST['action']=="checkout"){
        if(!isset($_SESSION["shopping_cart"])){
            $status = "<div class='status'><strong>Please add an item to checkout.</strong></div>";
        } else {
            unset($_SESSION["shopping_cart"]);
            $status = "<div class='status'><strong>Payment successful!</strong></div>";
        }
    }

    if (isset($_POST['action']) && $_POST['action']=="empty"){
        if(!isset($_SESSION["shopping_cart"])){
            $status = "<div class='status'><strong>Your cart is already empty!</strong></div>";
        } else {
            unset($_SESSION["shopping_cart"]);
            $status = "<div class='status'><strong>Your cart was emptied!</strong></div>";
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
    <title>Fancy Shop - Cart</title>
</head>
<body>
    <div class="website">
        <div class="header">
            <div class="nav">
                <h2>Shop</h2>
                <hr class="vertical">
                <a href="./" class="pages home">Home</a>
                <a href="items.php" class="pages">Items</a>
                <a href="cart.php" class="pages active-page">Cart</a>
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
                <div class="cart-items">
                    <?php
                        if(isset($_SESSION["shopping_cart"])){
                        $total_price = 0;
                    ?>	
                    <h3 class="sec-header">Cart</h3>
                    <table class="cart-table">
                        <tbody class="cart-display">
                            <tr>
                                <td></td>
                                <td>ITEM</td>
                                <td>QUANTITY</td>
                                <td>UNIT PRICE</td>
                                <td>ITEM TOTAL</td>
                            </tr>	
                            <?php		
                                foreach ($_SESSION["shopping_cart"] as $product){
                            ?>
                            <tr>
                                <td>
                                    <a href='item.php?item_id=<?php echo $product["item_id"]; ?>'>
                                        <div class="item">
                                            <img src=item-imgs/<?php echo $product["image"]; ?> width="50" height="40" />
                                        </div>
                                    </a>
                                </td>
                                <td>
                                    <div class='cart-item'>
                                        <?php echo $product["name"]; ?>
                                        <form method='post' action=''>
                                            <input type='hidden' name='item_id' value="<?php echo $product["item_id"]; ?>" />
                                            <input type='hidden' name='action' value="remove" />
                                            <button type='submit' class='remove'>Remove Item</button>
                                        </form>
                                    </div>
                                </td>
                                <td class='quantity-tb'>
                                    <form method='post' action=''>
                                        <input type='hidden' name='item_id' value="<?php echo $product["item_id"]; ?>" />
                                        <input type='hidden' name='action' value="minus" />
                                        <button name='quantity' onclick="this.form.submit()" value='1'>-</button>
                                    </form>
                                    <?php echo $product["quantity"]; ?>
                                    <form method='post' action=''>
                                        <input type='hidden' name='item_id' value="<?php echo $product["item_id"]; ?>" />
                                        <input type='hidden' name='action' value="plus" />
                                        <button name='quantity' onclick="this.form.submit()" value='1'>+</button>
                                    </form>
                                </td>
                                <td>
                                    <?php echo "$".$product["price"]; ?>
                                </td>
                                <td>
                                    <?php echo "$".$product["price"]*$product["quantity"]; ?>
                                </td>
                            </tr>
                            <?php
                                $total_price += ($product["price"]*$product["quantity"]);
                                }
                            ?>
                            <tr>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td>
                                    <strong>TOTAL: <?php echo "$".$total_price; ?></strong>
                                </td>
                            </tr>
                        </tbody>
                    </table>		
                    <?php
                    }else{
                        echo "<h3 class='sec-header'>Cart</h3><h4>Your cart is empty!</h4>";
                    }
                    echo $status; ?>
                    <div class="cart-options">
                        <form method='post' action=''>
                            <input type='hidden' name='action' value="checkout" />
                            <input type="submit" value='Checkout' class='btn'>
                        </form>
                        <form method='post' action=''>
                            <input type='hidden' name='action' value="empty" />
                            <input type="submit" value='Empty Cart' class='btn'>
                        </form>
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