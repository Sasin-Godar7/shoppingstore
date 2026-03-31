<?php
session_start();
include "config.php";

if(!isset($_SESSION["user_id"])){
    header('Location:login.php');
    exit();
}

if(!isset($_GET['product_id']))
    {
        $product_id=$_GET['product_id'];
        $user_id = $_SESSION['user_id'];

        $sql = "select * from products where id='$product_id' ";

        $result = mysqli_query($conn,$sql);
        $row=mysqli_fetch_assoc($result);

        $check_sql  = "select *from carts where user_id='$user_id' AND product_id='$product_id' ";
        
        $result_sql = mysqli_query($conn,$check_sql);

        if(mysqli_num_rows($result_sql)>0)
            {
                $update_sql = "update carts set quantity = quantity + 1 where user_id=$user_id' AND
                product_id='$product_id'";

                $update_result = mysqli_query($conn,$update_sql);
            }

            else{
                 $insert_sql = "INSERT INTO cart (user_id, product_id, product_name, product_image, product_price, quantity) VALUES ('$user_id', '$product_id', '".$row[name]."', '".$row[image]."', '".$row[price]."', 1)";
                 $insert_result =mysqli_query($conn, $insert_sql);
            }

            header("Location:index.php");
            exit();
    }



    echo"hello";    


?>