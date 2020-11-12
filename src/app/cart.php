<?php 
session_start();
require("data.php");
require("Models/productDto.php");

if(!isset($_SESSION["products"]))
{
    $_SESSION["products"] = [];
}

if(!isset($_SESSION["totalPrice"]))
{
    $_SESSION["totalPrice"] = 0;
}

if(!isset($_SESSION["totalItemsQuantity"]))
{
    $_SESSION["totalItemsQuantity"] = 0;
}

if(isset($_POST["productId"]) && isset($_POST["productQuantity"]))
{
    $productExist = false;
    //check i there already is product with given ID in cart
    foreach($_SESSION["products"] as &$productItem)
    {
        //if there are is, increase its' quantity
        if($productItem["id"] == $_POST["productId"])
        {
            $productExist = true;
            if($productItem["quantity"] < $_POST["productMaxQuantity"])
            {
                $productItem["quantity"] += $_POST["productQuantity"];
                $_SESSION["totalPrice"] += $_POST["productQuantity"] * $_POST["productPrice"];
                $_SESSION["totalItemsQuantity"] += $_POST["productQuantity"];
            }
        }
    }
    //if there is no product in cart with given ID, add one
    if(!$productExist)
    {
        $_SESSION["products"][] = [ "id" => $_POST["productId"], "quantity" => $_POST["productQuantity"] ];
        $_SESSION["totalPrice"] += $_POST["productQuantity"] * $_POST["productPrice"];
        $_SESSION["totalItemsQuantity"] += $_POST["productQuantity"];
    }
    
    //important function!!
    // print_r( array_values( $_SESSION["products"]));
    
    
}
if(isset($_POST["produtToRemoveId"]) && isset($_POST["productToRemovePrice"]) && isset($_POST["productToRemoveQuantity"]))
{
    foreach($_SESSION["products"] as &$productInCartItem)
    {
        if($productInCartItem["id"] == $_POST["produtToRemoveId"])
        {
            unset($_SESSION["products"][array_search($productInCartItem, $_SESSION["products"])]);
            $_SESSION["totalPrice"] -= $_POST["productToRemovePrice"] * $_POST["productToRemoveQuantity"];
            $_SESSION["totalItemsQuantity"] -= $_POST["productToRemoveQuantity"];
        }
    }
}

$productsInCart=[];
if(count($_SESSION["products"]) != 0)
foreach($_SESSION["products"] as $product)
{
    $productsQuery = "SELECT * from products where id = \"" . $product["id"] ."\"";

    $result = $polaczenie->query($productsQuery);
    
    while($row = mysqli_fetch_row($result)) {
        
        $productsInCart[] = new ProductDto($row[0], $row[1],$row[2],$row[3],$product["quantity"],$row[5]);
    }
}



?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.4.1/semantic.min.css" integrity="sha512-8bHTC73gkZ7rZ7vpqUQThUDhqcNFyYi2xgDgPDHc+GXVGHXq+xPjynxIopALmOPqzo9JZj0k6OqqewdGO3EsrQ==" crossorigin="anonymous" />
    <link rel="stylesheet" href="style.css">
    <title>Document</title>
</head>
<body style="background: grey;">
<div class="ui">
        <?php
            echo "<div class=\"ui text container\" style=\"background: lightGrey; padding: margin: 50px;\">";
            require("nav.php");
            if(count($_SESSION["products"]) == 0)
            {
                echo "<div class=\"myCentered\">
                <div class=\"ui green compact tiny message centered grid\">
                <div class=\"header\">
                    Cart is empty!
                </div>
                </div>
                </div>";
            }
            else
            { 
            foreach($productsInCart as $product)
            {
                echo "<form action = \"cart.php\" method=\"post\" class=\"ui form\">";
                echo "<div class=\"ui field myfield\">";
                echo "<h3 class=\"ui myHeader\">";
                echo $product->getName();
                echo"</h3>";
                echo "<img  class=\"ui circular image myImage\" src=\"";
                echo $product->getImgPath();
                echo "\">";
                echo "<div class=\"textItems\">";
                echo "<label class=\"myLabel\">";
                echo "<b>Author:</b> " . $product->getAuthor();
                echo "</label>";
                echo "<label class=\"myLabel\">";
                echo "<b>Price:</b> " . $product->getPrice();
                echo "</label>";
                echo "<label class=\"myLabel\">";
                echo "<b>Quantity in the cart:</b> " . $product->getQuantity();
                echo "</label>";
                echo "<input type=\"hidden\" value=\"";
                echo $product->getId();
                echo "\" name=\"produtToRemoveId\" for=\"produtToRemoveId\">";
                echo "<input type=\"hidden\" value=\"";
                echo $product->getPrice();
                echo "\" name=\"productToRemovePrice\" for=\"productToRemovePrice\">";
                echo "<input type=\"hidden\" value=\"";
                echo $product->getQuantity();
                echo "\" name=\"productToRemoveQuantity\" for=\"productToRemoveQuantity\">";
                echo "<button class=\"ui inverted red button\" type=\"submit\">Delete</button>";
                echo "</div>";
                echo "</div>";
                echo"</form>";
            }
            echo "<form action=\"buy.php\" method=\"post\" class=\"ui form buyform\">";
            echo "<label><h4>Quantity</h4></label>";
            echo "<label><h4>";
            echo $_SESSION["totalItemsQuantity"];
            echo "</h4></label>";
            echo "<label><h4>Total Price</h4></label>";
            echo "<label><h4>";
            echo $_SESSION["totalPrice"] . " PLN";
            echo "</h4></label>";
                echo "<button class=\"ui button\" type=\"submit\">Buy</button>";
                echo"</form>";
    }
        ?>
    </div>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.4.1/semantic.min.js" integrity="sha512-dqw6X88iGgZlTsONxZK9ePmJEFrmHwpuMrsUChjAw1mRUhUITE5QU9pkcSox+ynfLhL15Sv2al5A0LVyDCmtUw==" crossorigin="anonymous"></script>
</body>
</html>