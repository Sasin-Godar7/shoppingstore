<?php

$conn = new mysqli(hostname: 'localhost',username:'root',password:'',database:'shoppingstore');

if(!$conn)
    {
        echo"Error!:{$conn->connect_error}";
    }


?>