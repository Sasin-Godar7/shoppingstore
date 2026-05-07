<?php
session_start();

include "../config.php"; // database connection

if(!isset($_SESSION['user_type'])){
    header('Location: ../login.php');
    exit();
}

if($_SESSION['user_type'] != 'admin'){
    header('Location: ../login.php');
    exit();
}

if(isset($_GET['id']))
    {
        $id=$_GET['id'];
        $sql = "update orders set payment_status='Paid' where id='$id' ";
        $result = mysqli_query($conn,$sql);

        header("Location:vieworder.php");
        exit();
    }



?>