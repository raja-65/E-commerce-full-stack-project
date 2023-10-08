<?php
//include "menu.html";
include "../shared/authguard_customer.php";
//include "search.php";
$pid=$_GET['pid'];
$userid=$_SESSION["userid"];

echo "Recived Pid=$pid";

include "../shared/connection.php";

$status=mysqli_query($conn, "insert into cart(userid,pid) values ($userid,$pid)");
if($status){
    echo "Adder to Cart Successfully";
    header("location:viewcart.php");
        }
else{ 
     echo "Failed to add cart";
     echo mysqli_error($conn);
    }
?>
