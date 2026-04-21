<?php
session_start();
include "config.php";

// user login check
if(!isset($_SESSION['user_id'])){
    header("location:login.php");
    exit();
}

// check if data exists in URL
if(!isset($_GET['data'])){
    die("Invalid access!");
}

// decode data from eSewa
$data_json = base64_decode($_GET['data']);
$data = json_decode($data_json, true);

if(!$data){
    die("Invalid access - could not decode data");
}

// check required fields
if(!isset($data['total_amount'], $data['transaction_uuid'], $data['transaction_code'], $data['status'])){
    die("Invalid payment data");
}

// extract data
$amt    = $data['total_amount'];
$oid    = $data['transaction_uuid'];
$refID  = $data['transaction_code'];
$status = $data['status'];

// session data (safe)
$name              = $_SESSION['name'] ?? '';
$email             = $_SESSION['email'] ?? '';
$phone             = $_SESSION['phone'] ?? '';
$address           = $_SESSION['address'] ?? '';
$transaction_uuid  = $_SESSION['transaction_uuid'] ?? '';
$total_amount      = $_SESSION['total_amount'] ?? '';
$user_id           = $_SESSION['user_id'] ?? '';

// match check
if($amt != $total_amount || $oid != $transaction_uuid){
    die("Transaction mismatched!");
}

// duplicate order check
$check = "SELECT * FROM orders WHERE transaction_uuid='$oid'";
$check_result = mysqli_query($conn, $check);

if(mysqli_num_rows($check_result) > 0){
    die("Order already exists");
}

// payment info
$payment_method = "eSewa";
$payment_status = "Paid";

// insert order
$sql = "INSERT INTO orders(user_id,name,email,phone,address,total_amount,transaction_uuid,payment_method,payment_status)
VALUES('$user_id','$name','$email','$phone','$address','$total_amount','$transaction_uuid','$payment_method','$payment_status')";

$result = mysqli_query($conn, $sql);

if(!$result){
    die("Order insert failed: " . mysqli_error($conn));
}

// get order id
$order_id = mysqli_insert_id($conn);

// get cart items
$sql1 = "SELECT * FROM carts WHERE user_id='$user_id'";
$result1 = mysqli_query($conn, $sql1);

// OPTIONAL: insert cart items into order_items table
while($row = mysqli_fetch_assoc($result1)){
    $product_id = $row['product_id'];
    $quantity   = $row['quantity'];

    $sql2 = "INSERT INTO order_items(order_id, product_id, quantity)
             VALUES('$order_id','$product_id','$quantity')";
    mysqli_query($conn, $sql2);
}

// clear cart after order
$delete_cart = "DELETE FROM carts WHERE user_id='$user_id'";
mysqli_query($conn, $delete_cart);

// success message
echo "<h2>Payment Successful 🎉</h2>";
echo "<p>Your Order ID: $order_id</p>";
?>