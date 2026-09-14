<?php
session_start();
include("db.php");

// Check Login
if(!isset($_SESSION['user_id'])){
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Check Product ID
if(!isset($_GET['id'])){
    header("Location: products.php");
    exit();
}

$product_id = intval($_GET['id']);

// Check if product already exists in cart
$check = mysqli_query($conn,"
SELECT * FROM cart
WHERE user_id='$user_id'
AND product_id='$product_id'
");

if(mysqli_num_rows($check) > 0){

    // Increase Quantity
    mysqli_query($conn,"
    UPDATE cart
    SET quantity = quantity + 1
    WHERE user_id='$user_id'
    AND product_id='$product_id'
    ");

}else{

    // Insert New Product
    mysqli_query($conn,"
    INSERT INTO cart(user_id,product_id,quantity)
    VALUES('$user_id','$product_id',1)
    ");

}

// Redirect to Checkout
header("Location: checkout.php");
exit();

?>