<?php
session_start();

if(!isset($_SESSION['user_id'])){
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Order Success</title>
<style>
body{
    font-family:Arial;
    text-align:center;
    background:#f4f4f4;
    padding-top:100px;
}
.box{
    background:#fff;
    width:450px;
    margin:auto;
    padding:30px;
    border-radius:10px;
}
a{
    text-decoration:none;
    background:#28a745;
    color:#fff;
    padding:10px 20px;
    border-radius:5px;
}
</style>
</head>
<body>

<div class="box">

<h1>✅ Order Placed Successfully!</h1>

<p>Thank you for shopping with ShopCart.</p>

<p>Your order has been placed successfully.</p>

<br>

<a href="orders.php">📦 View My Orders</a>

<br><br>

<a href="products.php">🛒 Continue Shopping</a>

</div>

</body>
</html>