<?php
session_start();
include "config.php";
$name = $_POST['user_name'];
$email = $_POST['user_email'];
$phone = $_POST['user_phone'];
$address = $_POST['user_address'];
$transaction_uuid = $_POST['transaction_uuid'];
$total_amount =$_POST['total_amount'];
$payment = $_POST['payment'];
$user_id = $_SESSION['user_id'];

$_SESSION['name']=$name;
$_SESSION['email']=$email;
$_SESSION['phone']=$phone;
$_SESSION['address']=$address;
$_SESSION['transaction_uuid']=$transaction_uuid;
$_SESSION['total_amount'] = $total_amount;

if($payment =="cod")
    {
        $payment_status="pending";

        // insert order
      $sql = "INSERT INTO orders(user_id,name,email,phone,address,total_amount,transaction_uuid,payment_method,payment_status)
      VALUES('$user_id','$name','$email','$phone','$address','$total_amount','$transaction_uuid','cod','$payment_status')";
     
     $result = mysqli_query($conn, $sql);
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

//clear cart 
$sql3 = "delete from carts where user_id = '$user_id'";
$result3 = mysqli_query($conn,$sql3);

echo"<h1>Order placed succesfully (COD)</h1>";
echo"<p>Order Id :$order_id</p>";
echo"<a href='index.php'> Go HOME </a>";
exit();
    }

$product_code = "EPAYTEST";
$message="total_amount=$total_amount,transaction_uuid=$transaction_uuid,product_code=$product_code";
$secret="8gBm/:&EnhH.1/q";
$hash=hash_hmac('sha256',$message,$secret,true);
//true nalekheko vaye hash_hmac le string vanni bujthyo tara aaba true le binary ma bujayo 0101010101001010110

$signature = base64_encode($hash);

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>

    <form id="esewa_form" action="https://rc-epay.esewa.com.np/api/epay/main/v2/form" method="POST">
        <input type="hidden" id="amount" name="amount" value="<?php echo $total_amount ?>" required>
        <input type="hidden" id="tax_amount" name="tax_amount" value="0" required>
        <input type="hidden" id="total_amount" name="total_amount" value="<?php echo $total_amount ?>" required>
        <input type="hidden" id="transaction_uuid" name="transaction_uuid" value="<?php echo $transaction_uuid ?>" required>
        <input type="hidden" id="product_code" name="product_code" value="EPAYTEST" required>
        <input type="hidden" id="product_service_charge" name="product_service_charge" value="0" required>
        <input type="hidden" id="product_delivery_charge" name="product_delivery_charge" value="0" required>
        <input type="hidden" id="success_url" name="success_url" value="http://localhost/shoppingstore/success.php"
            required>
        <input type="hidden" id="failure_url" name="failure_url" value="http://localhost/shoppingstore/failure.php"
            required>
        <input type="hidden" id="signed_field_names" name="signed_field_names"
            value="total_amount,transaction_uuid,product_code" required>
        <input type="hidden" id="signature" name="signature" value="<?php echo $signature ?>"
            required>
        
        </form>

    <script>
        document.getElementById('esewa_form').submit();
    </script>

</body>

</html>