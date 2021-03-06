<?php 
/**
 * This file contains both view and logic for displaying main shop view and adding items to cart.
 *
 * @author Bartosz Wiśniewski
 */
session_start();
$connect = mysqli_connect("localhost", "klient", "klient", "minishop");
/**
 * It will manage adding items to shopping cart.
 */
if(isset($_POST["add_to_cart"]))
{
    if(isset($_SESSION["shopping_cart"]))
    {
        $item_array_id = array_column($_SESSION["shopping_cart"], "item_id");
        if(!in_array($_GET["id"], $item_array_id))
        {
            $count = count($_SESSION["shopping_cart"]);
            $item_array = array(
                'item_id' => $_GET["id"],
                'item_name' => $_POST["hidden_name"],
                'item_price' => $_POST["hidden_price"],
                'item_quantity' => $_POST["quantity"]
            );
            $wanted = $_POST["quantity"];
            $instock = $_POST["hidden_quantity"];
            if($wanted <= $instock)
            {
                $_SESSION["shopping_cart"][$count] = $item_array;
            } 
            else {
                echo '<script>alert("Not enough items in stock!")</script>';
                echo '<script>window.location="index.php"</script>';
            }
        }
        else
        {
            echo '<script>alert("Item already in shopping cart")</script>';
            echo '<script>window.location="index.php"</script>';
        }
    }
    else
    {
        $item_array = array(
            'item_id' => $_GET["id"],
            'item_name' => $_POST["hidden_name"],
            'item_price' => $_POST["hidden_price"],
            'item_quantity' => $_POST["quantity"]
        );
        $wanted = $_POST["quantity"];
        $instock = $_POST["hidden_quantity"];
        if($wanted <= $instock)
        {
            $_SESSION["shopping_cart"][0] = $item_array;
        } 
        else {
            echo '<script>alert("Not enough items in stock!")</script>';
            echo '<script>window.location="index.php"</script>';
        }
    }
}

/**
 * It will manage removing items from shopping cart.
 */
if(isset($_GET["action"]))
{
    if($_GET["action"] == "delete")
    {
        foreach($_SESSION["shopping_cart"] as $keys => $values)
        {
            if($values["item_id"] == $_GET["id"])
            {
                unset($_SESSION["shopping_cart"][$keys]);
                echo '<script>alert("Item removed")</script>';
                echo '<script>window.location="index.php"</script>';
            }
        }
    } else if ($_GET["action"] == "buy")
    {
        foreach($_SESSION["shopping_cart"] as $keys => $values)
        {
            unset($_SESSION["shopping_cart"][$keys]); 
        }
        header("Location: transaction_details.php");
        exit();
    } else if($_GET["action"] == "details")
    {
        header("Location: item_details.php?id=".$_GET["id"]);
        exit();
    }
}
?>
<!DOCTYPE html>
<html>
	<head>
		<title>Shop</title>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
	</head>
	<body>
        <br />
        <div class="container" style="width:700px;">
            <h3 align="center">Shops for sale!</h3><br />
            <?php
            /**
             * query variable contains an sql query
             *
             * @var String
             */
            $query = "SELECT * FROM products ORDER BY id ASC";
            /**
             * result variable contains result of an sql query which returns all products table
             *
             * @var String
             */
            $result = mysqli_query($connect, $query);

            /**
             * It will show every item on the list of the items that van be bought
             */
            if(mysqli_num_rows($result) > 0)
            {
                while($row = mysqli_fetch_array($result))
                {
                    ?>
                    <div class="col-md-4">
                        <form method="post" action="index.php?action=add&id=<?php echo $row["id"]; ?>">
                            <div style="border:1px solid #333; background-color:#f1f1f1; border-radius:5px; padding:16px;" align="center">
						        <img width="200px" height="auto" src="images/<?php echo $row["image"]; ?>" class="img-responsive" /><br />
                                <h4 class="text-info"><a href="index.php?action=details&id=<?php echo $row["id"]; ?>"><?php echo $row["name"]; ?></a></h4>
                                <h4 class="text-info">In stock: <?php echo $row["quantity"]; ?></h4>
                                <h4 class="text-danger">$ <?php echo $row["price"]; ?></h4>
						        <input type="text" name="quantity" value="1" class="form-control" />
						        <input type="hidden" name="hidden_name" value="<?php echo $row["name"]; ?>" />
                                <input type="hidden" name="hidden_price" value="<?php echo $row["price"]; ?>" />
                                <input type="hidden" name="hidden_quantity" value="<?php echo $row["quantity"]; ?>" />
						        <input type="submit" name="add_to_cart" style="margin-top:5px;" class="btn btn-success" value="Add to Cart" />
                            </div>
                        </form>    
                    </div>
                    <?php

                }
            }
            ?>
            <div style="clear:both"></div>
            <br />
            <h3>Order Details</h3>
            <div class="table-responsive">
                <table class="table table-bordered">
                    <tr>
                        <th width=="40%">Item Name</th>
                        <th width=="10%">Quantity</th>
                        <th width=="20%">Price</th>
                        <th width=="15%">Total</th>
                        <th width=="5%">Action</th>
                    </tr>
                    <?php 
                    /**
                    * It will show items added to the shopping cart in a form of a table
                    */
                    if(!empty($_SESSION["shopping_cart"]))
                    {
                        $total = 0; //store total of item price
                        foreach($_SESSION["shopping_cart"] as $keys => $values)
                        {
                            ?>
                            <tr>
                                <td><?php echo $values["item_name"]; ?></td>
                                <td><?php echo $values["item_quantity"]; ?></td>
                                <td>$ <?php echo $values["item_price"]; ?></td>
                                <td><?php echo number_format($values["item_quantity"] * $values["item_price"], 2); ?></td>
                                <td><a href="index.php?action=delete&id=<?php echo $values["item_id"]; ?>"><span class="text-danger">Remove</span></a></td>
                            </tr>
                            <?php
                                $total = $total + ($values["item_quantity"] * $values["item_price"]);
                        }
                        ?>
                            <td colspan="3" align="right">Total</td>
                            <td align="right">$ <?php echo number_format($total, 2); ?></td>
                            <td><a href="index.php?action=buy"><span class="text-danger">Buy</span></a></td>
                        <?php 
                    }
                    ?>
                </table>
            </div>
        </div>
        <br />
	</body>
</html>