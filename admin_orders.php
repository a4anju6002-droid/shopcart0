<?php
session_start();
include("db.php");

if(!isset($_SESSION['admin'])){
    header("Location: admin_login.php");
    exit();
}

// Update Order Status & Tracking ID
if(isset($_POST['update_status'])){

    $order_id = $_POST['order_id'];
    $status = mysqli_real_escape_string($conn, $_POST['status']);
    $tracking_id = mysqli_real_escape_string($conn, $_POST['tracking_id']);

    mysqli_query($conn,"
    UPDATE orders
    SET status='$status',
        tracking_id='$tracking_id'
    WHERE id='$order_id'
    ");

    header("Location: admin_orders.php");
    exit();
}

// Get Orders
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

ORDER BY orders.id DESC
");
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Admin Orders</title>

<style>
body{
    font-family:Arial;
    background:#f5f5f5;
    margin:20px;
}

h2{
    text-align:center;
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

select,
input[type=text]{
    padding:6px;
    width:140px;
}

input[type=submit]{
    background:#28a745;
    color:white;
    border:none;
    padding:8px 15px;
    cursor:pointer;
}

input[type=submit]:hover{
    background:#218838;
}

.back{
    display:inline-block;
    margin-top:20px;
    text-decoration:none;
    background:#007bff;
    color:white;
    padding:10px 15px;
}
</style>

</head>

<body>

<h2>📦 All Orders</h2>

<table>

<tr>
<th>Order ID</th>
<th>Customer</th>
<th>Products</th>
<th>Phone</th>
<th>Address</th>
<th>City</th>
<th>Pincode</th>
<th>Total</th>
<th>Payment</th>
<th>Status</th>
<th>Tracking ID</th>
<th>Order Date</th>
<th>Action</th>
</tr>

<?php while($row=mysqli_fetch_assoc($result)){ ?>

<tr>

<td><?php echo $row['id']; ?></td>

<td><?php echo $row['customer_name']; ?></td>

<td><?php echo $row['product_names']; ?></td>

<td><?php echo $row['Phone']; ?></td>

<td><?php echo $row['address']; ?></td>

<td><?php echo $row['city']; ?></td>

<td><?php echo $row['Pincode']; ?></td>

<td>₹<?php echo $row['total']; ?></td>

<td><?php echo $row['payment_method']; ?></td>

<td><?php echo $row['status']; ?></td>

<td><?php echo $row['tracking_id']; ?></td>

<td><?php echo $row['order_date']; ?></td>

<td>

<form method="POST">

<input
type="hidden"
name="order_id"
value="<?php echo $row['id']; ?>">

<select name="status">

<option value="Pending" <?php if($row['status']=="Pending") echo "selected"; ?>>Pending</option>

<option value="Processing" <?php if($row['status']=="Processing") echo "selected"; ?>>Processing</option>

<option value="Shipped" <?php if($row['status']=="Shipped") echo "selected"; ?>>Shipped</option>

<option value="Out for Delivery" <?php if($row['status']=="Out for Delivery") echo "selected"; ?>>Out for Delivery</option>

<option value="Delivered" <?php if($row['status']=="Delivered") echo "selected"; ?>>Delivered</option>

<option value="Cancelled" <?php if($row['status']=="Cancelled") echo "selected"; ?>>Cancelled</option>

</select>

<br><br>

<input
type="text"
name="tracking_id"
placeholder="Tracking ID"
value="<?php echo $row['tracking_id']; ?>">

<br><br>

<input
type="submit"
name="update_status"
value="Update">

</form>

</td>

</tr>

<?php } ?>

</table>

<a href="admin.php" class="back">⬅ Back to Dashboard</a>

</body>
</html>