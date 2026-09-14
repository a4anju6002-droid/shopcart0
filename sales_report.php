<?php
session_start();
include("db.php");

if(!isset($_SESSION['admin'])){
    header("Location: admin_login.php");
    exit();
}

$result = mysqli_query($conn,"
SELECT
orders.*,
users.fullname,
GROUP_CONCAT(products.name SEPARATOR ', ') AS product_names
FROM orders
JOIN users
ON orders.user_id = users.id
LEFT JOIN order_items
ON orders.id = order_items.order_id
LEFT JOIN products
ON order_items.product_id = products.id
GROUP BY orders.id
ORDER BY orders.order_date DESC
");

$total = mysqli_fetch_assoc(mysqli_query($conn,"
SELECT SUM(total) AS revenue
FROM orders
"));

?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Sales Report</title>

<style>

body{
font-family:Arial;
background:#f4f4f4;
}

.container{
width:95%;
margin:auto;
}

table{
width:100%;
border-collapse:collapse;
background:white;
}

table th,
table td{
border:1px solid #ddd;
padding:10px;
text-align:center;
}

th{
background:#007bff;
color:white;
}

</style>

</head>

<body>

<div class="container">

<h2>📊 Sales Report</h2>

<h3>Total Revenue :
₹<?php echo $total['revenue'] ?? 0; ?>
</h3>

<table>

<tr>

<th>Order ID</th>
<th>Customer</th>
<th>Products</th>
<th>Total</th>
<th>Payment</th>
<th>Status</th>
<th>Date</th>

</tr>

<?php

while($row=mysqli_fetch_assoc($result)){

?>

<tr>

<td><?php echo $row['id']; ?></td>

<td><?php echo $row['fullname']; ?></td>

<td><?php echo $row['product_names']; ?></td>

<td>₹<?php echo $row['total']; ?></td>

<td><?php echo $row['payment_method']; ?></td>

<td><?php echo $row['status']; ?></td>

<td><?php echo $row['order_date']; ?></td>

</tr>

<?php

}

?>

</table>

<br>

<a href="admin.php">⬅ Back to Dashboard</a>

</div>

</body>
</html>