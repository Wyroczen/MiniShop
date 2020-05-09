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

            ?>
            <div class="table-responsive">
                <table class="table table-bordered">
                <tr>
                    <th width=="30%">Item Name</th>
                    <th width=="60%">Description</th>
                    <th width=="10%">Action</th>
                </tr>
            <?php
            if(mysqli_num_rows($resultDetails) > 0)
            {

                while($row = mysqli_fetch_array($resultProduct))
                {
                    ?>
                        <tr>
                            <td><p class="text-info"><?php echo $row["name"]?></td>
                    <?php
                }


                while($row = mysqli_fetch_array($resultDetails))
                {
                    ?>
                        
                            <td><p class="text-info"><?php echo $row["description"]?></p><td>
                            <td><a href="index.php?action=return"><span class="text-danger">Return</span></a><td>
                        </tr>
                    </table>
                    <?php
                }

                
            }
            ?>
    </body>
<html>