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

if(isset($_GET['id'])){
      $id = $_GET['id'];
}
$sql = "delete  from users where id='$id' ";
$result = mysqli_query($conn, $sql);

if($result)
    {
        header("Location:viewuser.php");
        exit();
    }
?>

