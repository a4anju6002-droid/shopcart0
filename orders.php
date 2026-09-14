<?php
session_start();
include("db.php");

if(!isset($_SESSION['user_id'])){
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

$result = mysqli_query($conn,"
SELECT *
FROM orders
WHERE user_id='$user_id'
ORDER BY id DESC
");
?>

<!DOCTYPE html>
<html lang="en">
<head>

<meta charset="UTF-8">

<title>My Orders - ShopCart</title>

<style>

body{
font-family:Arial;
background:#f4f4f4;
margin:0;
}

header{
background:#007bff;
color:white;
padding:15px;
text-align:center;
}

.container{
width:95%;
margin:auto;
padding:20px;
}

.order{
background:white;
padding:20px;
margin-bottom:20px;
border-radius:8px;
box-shadow:0 0 5px #ccc;
}

.product{
padding:10px;
margin-top:10px;
border-top:1px solid #ddd;
}

.btn{
background:#007bff;
color:white;
padding:10px 15px;
text-decoration:none;
border-radius:5px;
}

</style>

</head>

<body>

<header>

<h2>📦 My Orders</h2>


</header>

<div class="container">

<?php

if(mysqli_num_rows($result)>0){

while($row=mysqli_fetch_assoc($result)){

?>

<div class="order">

<h3>Order #<?php echo $row['id']; ?></h3>

<p><b>Total :</b> ₹<?php echo $row['total']; ?></p>

<p><b>Payment :</b> <?php echo $row['payment_method']; ?></p>

<p><b>Status :</b>

<?php

if($row['status']=="Pending"){

echo "<span style='color:red;font-weight:bold;'>⏳ Pending</span>";

}
else if($row['status']=="Shipped"){

echo "<span style='color:orange;font-weight:bold;'>🚚 Shipped</span>";

}
else if($row['status']=="Delivered"){

echo "<span style='color:green;font-weight:bold;'>✅ Delivered</span>";

}
else{

echo $row['status'];

}

?>

</p>

<p><b>Date :</b> <?php echo $row['order_date']; ?></p>

<h4>Ordered Products</h4>

<?php

$items = mysqli_query($conn,"
SELECT order_items.*,
products.name,
products.image
FROM order_items
JOIN products
ON order_items.product_id = products.id
WHERE order_items.order_id='".$row['id']."'
");

if(mysqli_num_rows($items)>0){

while($item=mysqli_fetch_assoc($items)){

?>

<div class="product">

<?php
if(!empty($item['image'])){
?>
<img src="images/<?php echo $item['image']; ?>"
width="80"
height="80">
<?php
}
?>

<p>
<b>Product:</b>
<?php echo $item['name']; ?>
</p>

<p>
<b>Quantity:</b>
<?php echo $item['quantity']; ?>
</p>

<p>
<b>Price:</b>
₹<?php echo $item['price']; ?>
</p>

<td>
<a href="order_details.php?id=<?php echo $row['id']; ?>">
<button>View Details</button>
</a>
</td>


</div>

<?php

}

}else{

echo "<p>No products found.</p>";

}

?>

</div>

<?php

}

}else{

echo "<h3>No Orders Found</h3>";

}

?>

<br>

<a href="products.php" class="btn">
🛒 Continue Shopping
</a>

</div>

</body>
</html>