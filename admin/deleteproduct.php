<?php
session_start();

include "../config.php"; // database connection

if(!isset($_SESSION['role'])){
    header('Location: ../login.php');
    exit();
}

if($_SESSION['role'] != 'admin'){
    header('Location: ../login.php');
    exit();
}

$sql = "SELECT * FROM products";
$result = mysqli_query($conn, $sql);
?>

