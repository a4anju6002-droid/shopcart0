<?php
session_start();
include("db.php");

// Admin Login Check
if(!isset($_SESSION['admin'])){
    header("Location: admin_login.php");
    exit();
}

// Get Pending Orders
$result = mysqli_query($conn,"
SELECT orders.*, users.fullname
FROM orders
JOIN users ON orders.user_id = users.id
WHERE orders.status='Pending'
ORDER BY orders.order_date DESC
");
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Pending Orders - ShopCart</title>

<style>

body{
    font-family:Arial;
    background:#f4f4f4;
    margin:0;
}

header{
    background:#dc3545;
    color:white;
    padding:15px;
    text-align:center;
}

.container{
    width:95%;
    margin:20px auto;
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

table th{
    background:#dc3545;
    color:white;
}

.btn{
    display:inline-block;
    margin-top:20px;
    padding:10px 20px;
    background:#007bff;
    color:white;
    text-decoration:none;
    border-radius:5px;
}

.btn:hover{
    background:#0056b3;
}

</style>

</head>

<body>

<header>

<h2>⏳ Pending Orders</h2>

</header>

<div class="container">

<?php
if(mysqli_num_rows($result)>0){
?>

<table>

<tr>
<th>Order ID</th>
<th>Customer Name</th>
<th>Total Amount</th>
<th>Payment Method</th>
<th>Status</th>
<th>Order Date</th>
</tr>

<?php
while($row=mysqli_fetch_assoc($result)){
?>

<tr>

<td><?php echo $row['id']; ?></td>

<td><?php echo $row['fullname']; ?></td>

<td>₹<?php echo $row['total']; ?></td>

<td><?php echo $row['payment_method']; ?></td>

<td><?php echo $row['status']; ?></td>

<td><?php echo $row['order_date']; ?></td>

</tr>

<?php
}
?>

</table>

<?php
}else{
?>

<h3 style="text-align:center;color:red;">
No Pending Orders Found
</h3>

<?php
}
?>

<br>

<a href="admin.php" class="btn">
⬅ Back to Dashboard
</a>

</div>

</body>
</html>ll