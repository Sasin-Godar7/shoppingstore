<?php

$conn = new mysqli('localhost','root','sasin@123','shoppingstore');

if(!$conn)
    {
        echo"Error!:{$conn->connect_error}";
    }


?>