<?php

include 'config.php';
session_start();


if(isset($_SESSION['user_id'])){
    $id=$_SESSION['user_id'];
}

if(!isset($_REQUEST['provider_session_id'])) {
    header('location:payment.php?provider_session_id=unsuccesfull');
}



        // Status -> processing
        $process_id = $_SESSION['order_id'];
        mysqli_query($conn, "UPDATE orders SET status = 'Processing' WHERE oId = '$process_id'");

        $sqlcart = "SELECT PId FROM cart WHERE UId = '$id' ";
        $cart = mysqli_query($conn, $sqlcart);
        if (mysqli_num_rows($cart) > 0 ) {
            
            while ($row = mysqli_fetch_assoc($cart)) {
                $pid = $row['PId'];

                $quantitysql =  "SELECT Quantity FROM cart WHERE UId = '$id' AND PId = '$pid' ";
                $quant = mysqli_query($conn, $quantitysql);
                $q = mysqli_fetch_assoc($quant);
                $quantity = $q['Quantity'];

                $stocksql =  "SELECT pQuantity FROM product_info WHERE pId = '$pid' ";
                $sto = mysqli_query($conn, $stocksql);
                $s = mysqli_fetch_assoc($sto);
                $stock = $s['pQuantity'];

                $remain = $stock - $quantity;

                $update = "UPDATE product_info SET pQuantity = '$remain' WHERE pID = '$pid' ";
                mysqli_query($conn, $update);

            }

        }
        // Need to menimize the stock
        $sqlpay = "DELETE FROM cart WHERE UId = '$id' ";
        mysqli_query($conn, $sqlpay);

        
        

header('location: orders.php?provider_session_id=succesfull');
?>