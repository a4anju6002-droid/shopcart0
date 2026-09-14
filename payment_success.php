<?php
session_start();
include("db.php");

if(!isset($_SESSION['user_id'])){
    header("Location:login.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Payment Success</title>
</head>
<body>

<h2 style="color:green;">✅ Payment Successful!</h2>

<p>Your payment has been received successfully.</p>

<a href="orders.php">
<button>View My Orders</button>
</a>

<br><br>

<a href="products.php">
<button>Continue Shopping</button>
</a>

</body>
</html>