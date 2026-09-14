<?php
session_start();
include("db.php");

if(!isset($_SESSION['user_id'])){
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

if(!isset($_GET['id'])){
    header("Location: orders.php");
    exit();
}

$order_id = intval($_GET['id']);

// Verify the order belongs to this user
$check = mysqli_query($conn,"
SELECT * FROM orders
WHERE id='$order_id'
AND user_id='$user_id'
");

if(mysqli_num_rows($check)==0){
    die("Invalid Order!");
}

$result = mysqli_query($conn,"
SELECT oi.*, p.image
FROM order_items oi
LEFT JOIN products p
ON oi.product_id = p.id
WHERE oi.order_id='$order_id'
");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Order Details</title>
</head>
<body>

<h2>📦 Order Details</h2>

<table border="1" cellpadding="10">
<tr>
    <th>Image</th>
    <th>Product</th>
    <th>Price</th>
    <th>Quantity</th>
    <th>Subtotal</th>
</tr>

<?php
$total = 0;

while($row=mysqli_fetch_assoc($result)){

$subtotal = $row['price'] * $row['quantity'];
$total += $subtotal;
?>

<tr>

<td>
<img src="images/<?php echo $row['image']; ?>"
width="80">
</td>

<td><?php echo $row['product_name']; ?></td>

<td>₹<?php echo $row['price']; ?></td>

<td><?php echo $row['quantity']; ?></td>

<td>₹<?php echo $subtotal; ?></td>

</tr>

<?php } ?>

<tr>
<td colspan="4" align="right">
<b>Total</b>
</td>

<td>
<b>₹<?php echo $total; ?></b>
</td>

</tr>

</table>

<br>

<a href="orders.php">
<button>⬅ Back to Orders</button>
</a>

</body>
</html>