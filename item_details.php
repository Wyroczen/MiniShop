<?php 
session_start();
$connect = mysqli_connect("localhost", "klient", "klient", "minishop");

if(isset($_GET["action"]))
{
    if($_GET["action"] == "return")
    { 
        header("Location: index.php");
        exit();
    }
}
?>
<!DOCTYPE html>
<html>
	<head>
		<title>Item Detais</title>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
	</head>
	<body>
    <br />
        <div class="container" style="width:700px;">
            <h3 align="center">Details:</h3><br />
            <?php
            $idforquery = $_GET["id"];
            $query = "SELECT * FROM products_details WHERE id=$idforquery";
            $resultDetails = mysqli_query($connect, $query);
            $query = "SELECT * from products WHERE id=$idforquery";
            $resultProduct = mysqli_query($connect, $query);
            if(mysqli_num_rows($resultDetails) > 0)
            {
                while($row = mysqli_fetch_array($resultDetails))
                {
                    ?>
                    </div class="col-md-4">
                        <form>
                            <p class="text-info"><?php echo $row["description"]?></p>
                            <a href="index.php?action=return"><span class="text-danger">Return</span></a>
                        </form>
                    </div>
                    <?php
                }
            }
            ?>
    </body>
<html>