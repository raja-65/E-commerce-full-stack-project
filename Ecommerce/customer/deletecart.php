<?php
include "../shared/authguard_customer.php";
include_once "../shared/connection.php";

$cartid=$_GET['cartid'];

$status=mysqli_query($conn, "delete from cart where cartid=$cartid");

if($status){
echo "Product removed from cart";
header("location:viewcart.php");
}
else{
    echo "Failed to remove from Cart";
    echo mysqli_error($conn);
    }
?>