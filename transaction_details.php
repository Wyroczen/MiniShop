<?php
/**
 * This file contains both view and logic for displaying details of the transaction.
 *
 * @author Bartosz Wiśniewski
 */
/**
 * It will check whether you want to return to the main page, and if yes it will redirect to it.
 */
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
    <title>Transaction details</title>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
    </head>
    <body>
    <br />
        <div class="container" style="width:700px;">
            <h3 align="center">Transaction details</h3><br />
            <div class="table-responsive">
                <table class="table table-bordered">
                <tr>
                    <th width=="60%">Account number:</th>
                    <th width=="30%">Delivery time:</th>
                    <th width=="10%">Contact:</th>
                </tr>
                <tr>
                  <td>9870-5263-1239</td>
                  <td>7days</td>
                  <td>sklepsklepy@shop.com</td>
                </tr>
                </table>
            </div>
            <a href="index.php?action=return"><span class="text-danger">Return</span></a>
        </div>
    </body>
</html>