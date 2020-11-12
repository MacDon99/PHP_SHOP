<?php 
session_start();
require("Models/productDto.php");
require("data.php");

if(!isset($_SESSION["totalPrice"]))
{
    $_SESSION["totalPrice"] = 0;
}
if(!isset($_SESSION["totalItemsQuantity"]))
{
    $_SESSION["totalItemsQuantity"] = 0;
}
if(!isset($_POST["productId"]))
{
    header("Location: index.php");
}

$productsQuery = "SELECT * from products where id = \"" . $_POST["productId"] ."\"";

$result = $polaczenie->query($productsQuery);

//get all products from database and map them
$product = null;   
while($row = mysqli_fetch_row($result)) {
    $product = new ProductDto($row[0], $row[1],$row[2],$row[3],$row[4],$row[5]);
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
<div style="min-height: 1000px;"> 
        <?php 
        echo "<div class=\"ui text container\" style=\"background: lightGrey; padding: margin: 50px;\">";
            require("nav.php");
            echo "<form action=\"cart.php\" method=\"post\" class=\"ui form\">";
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
                echo "<b>Available:</b> " . $product->getQuantity();
                echo "<input type=\"number\" min=\"1\" value=\"1\" for =\"productQuantity\" name=\"productQuantity\"";
                echo "max=\"";
                echo $product->getQuantity();
                echo "\">";
                echo "</label>";
                echo "<input type=\"hidden\" value=\"";
                echo $product->getId();
                echo "\" name=\"productId\" for=\"productId\">";
                echo "<input type=\"hidden\" value=\"";
                echo $product->getPrice();
                echo "\" name=\"productPrice\" for=\"productPrice\">";
                echo "<input type=\"hidden\" value=\"";
                echo $product->getQuantity();
                echo "\" name=\"productMaxQuantity\" for=\"productMaxQuantity\">";
                echo "<button class=\"ui button\" type=\"submit\">Add To Cart</button>";
                echo "</div>";
                echo "</div>";
            echo"</form>";
        ?>
    </div>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.4.1/semantic.min.js" integrity="sha512-dqw6X88iGgZlTsONxZK9ePmJEFrmHwpuMrsUChjAw1mRUhUITE5QU9pkcSox+ynfLhL15Sv2al5A0LVyDCmtUw==" crossorigin="anonymous"></script>
</body>
</html>