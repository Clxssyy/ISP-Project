<?php
    include('db.php');

    if($_SESSION['username'] != "admin")
    {
        header('location: index.php');
        exit;
    }

    if (isset($_GET["item_id"])) {
        $id = $_GET["item_id"];

        $sql = "DELETE FROM items WHERE item_id='$id'";
        $connection->query($sql);
    }

    header("location: items.php");
    exit;
?>