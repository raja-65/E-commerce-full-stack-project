<?php
include "../shared/authguard_customer.php";
include "menu.html";
?>

<!DOCTYPE html>
<html lang="en">
<head>

   <style>
       .btn {
            background-color: #007bff;
            color: #fff;
            border: none;
            padding: 10px 20px;
            font-size: 16px;
            cursor: pointer;
        }
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

    include_once "../shared/connection.php";

    $sql_obj=mysqli_query($conn,"select * from product");
    
   // <!-- Modify your home page loop to create links -->
    while ($row = mysqli_fetch_assoc($sql_obj)) {
        echo "<div class='pdt-card'>
                <div class='name'>$row[name]</div>
                <div class='price'>$row[price]</div>    
                <div class='code'>$row[code]</div>            
                <a href='product_detail.php?pid=$row[pid]'> <!-- Link to product_detail.php -->
                    <img class='pdt-img' src='$row[imgpath]'>   
                </a>
                <div class='category'>$row[category]</div>                                 
                <div class='details'>$row[details]</div>
                <hr>
                <div class='text center'>
                  <a href='addcart.php?pid=$row[pid]'>
                    <button class='btn'>Add to Cart</button>
                  </a>
                </div>
            </div>";
    }    

?>