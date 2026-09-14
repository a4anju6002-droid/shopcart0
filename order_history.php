<?php
session_start();
include("db.php");

if(!isset($_SESSION['user'])){
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user'];

$result = mysqli_query($conn,"
SELECT *
FROM orders
WHERE user_id='$user_id'
ORDER BY id DESC
");
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>My Orders</title>

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

th,td{
    border:1px solid #ddd;
    padding:10px;
    text-align:center;
}

th{
    background:#007bff;
    color:white;
}

.status{
    font-weight:bold;
}

.pending{color:orange;}
.processing{color:blue;}
.shipped{color:purple;}
.delivered{color:green;}
.cancelled{color:red;}

a{
    text-decoration:none;
}

</style>

</head>

<body>

<h2>📦 My Orders</h2>

<table>

<tr>
<th>Order ID</th>
<th>Total</th>
<th>Payment</th>
<th>Status</th>
<th>Tracking ID</th>
<th>Order Date</th>
</tr>

<?php while($row=mysqli_fetch_assoc($result)){ ?>

<tr>

<td><?php echo $row['id']; ?></td>

<td>₹<?php echo $row['total']; ?></td>

<td><?php echo $row['payment_method']; ?></td>

<td class="status <?php echo strtolower(str_replace(' ','',$row['status'])); ?>">
<?php echo $row['status']; ?>
</td>

<td>
<?php
if(!empty($row['tracking_id'])){
    echo $row['tracking_id'];
}else{
    echo "Not Available";
}
?>
</td>

<td><?php echo $row['order_date']; ?></td>

</tr>

<?php } ?>

</table>

<br>

<a href="index.php">⬅ Continue Shopping</a>

</body>
</html>