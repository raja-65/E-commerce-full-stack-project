<?php
include "../shared/authguard_vendor.php";
include "menu.html";
?>

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
    .delete-button {
        background-color: #ff0000; /* Red background color */
        color: #fff; /* White text color */
        border: none; /* Remove border */
        padding: 5px 10px; /* Add padding */
        cursor: pointer; /* Add pointer cursor on hover */
        border-radius: 4px; /* Rounded corners */
    }

    .delete-button:hover {
        background-color: #cc0000; /* Darker red color on hover */
    }
   </style>
</head>
<body>
</body>
</html>

<?php

    include_once "../shared/connection.php";

    $sql_obj=mysqli_query($conn,"select * from product where uploaded_by=$_SESSION[userid]");
    
    while($row=mysqli_fetch_assoc($sql_obj)){        
        //print_r($row);
        echo "<div class='pdt-card'>
                <div class='name'>$row[name]</div>
                <div class='price'>$row[price]</div>    
                <div class='code'>$row[code]</div>            
                <img class='pdt-img' src='$row[imgpath]'>   
                <div class='category'>$row[category]</div>                                 
                <div class='details'>$row[details]</div>
                <form method='POST' action='delete_product.php'>
                      <input type='hidden' name='pid' value='$row[pid]'>
                      <button type='submit' name='delete_product'  class='delete-button'>Delete Product</button>
                </form>
        </div>";
    }
?>