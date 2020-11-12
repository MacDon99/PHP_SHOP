<?php 
session_start();
echo "deleted";
session_unset();
$_SESSION["info"] = "Successfully payed for your items!";
$_SESSION["totalPrice"] = 0;
$_SESSION["totalItemsQuantity"] = 0;
header("Location: index.php");
?>