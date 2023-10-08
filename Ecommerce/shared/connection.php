<?php

$conn=new mysqli("localhost","root","","webdev");
if($conn->connect_error){
    echo "Connection Failed";
    die;
}

?>