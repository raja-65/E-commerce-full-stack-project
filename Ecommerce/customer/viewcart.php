<!DOCTYPE html>
<html lang="en">
<head>

   <style>
    .pdt-card{
        width:300px;
        display:inline-block;
        margin:10px;
        border:2px solid grey;
        padding:10px;

    }
    .pdt-img{
       width:100%;
       height:200px;
    }
    .price{
        font-size:24px;
    }
    .price::before{
        content:"Rs."
    }
    .name{
        font-size:22px;
        font-weight:bold;
        color:violet;
    }
   </style>
</head>
<body>
</body>
</html>

<?php
include "../shared/authguard_customer.php";
Include "menu.html";
Include "../shared/connection.php";

$sql_obj=mysqli_query($conn, "select * from cart join product on cart.pid=product.pid where userid=$_SESSION[userid]");
$total=0;
while($row=mysqli_fetch_assoc($sql_obj)){
//print_r($row):
    echo "<div class='pdt-card'>
            <div class='name'>$row[name]</div>
            <div class='price'>$row[price]</div>
            <div class='code'>$row[code]</div>
            <img class='pdt-img' src='$row[imgpath]'>
            <div class='category'>$row[category]</div>
            <div class='details'>$row[details]</div>
            <hr>
            <div class='text-center'>
            <a href='deletecart.php?cartid=$row[cartid]'>
            <button class='btn btn-danger'>Remove Cart</button>
            </a> </div>
        </div>";
        $total=$total+$row['price']; 
    }

 echo "<div class ='bg-primary p-3 d-flex justify-content-around'>
     <h1 class ='text white'>total payable=$total</h1>
     <form action='createorder.php' method='post' class='d-flex'>
         <textarea required name='address' placeholder='delivary address' col='50'></textarea>
         <button class='btn btn-warning'>place order</button>
     </form>
     </div>";

  // Check if the user clicked on the place order button in the view cart page
  if (isset($_POST['place order'])) {
    // Call the PHP code that I provided  to place the order
    include 'createorder.php';
    // Redirect the user to the view order page after placing the order
    header('Location: vieworder.php');
    exit();
 }

?>