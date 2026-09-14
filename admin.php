<?php
session_start();
include("db.php");

if(!isset($_SESSION['admin'])){
    header("Location: admin_login.php");
    exit();
}

// Products
$result = mysqli_query($conn,"SELECT * FROM products");

// Dashboard Statistics
$totalUsers = mysqli_fetch_assoc(mysqli_query($conn,"
SELECT COUNT(*) AS total FROM users
"));

$totalProducts = mysqli_fetch_assoc(mysqli_query($conn,"
SELECT COUNT(*) AS total FROM products
"));

$totalOrders = mysqli_fetch_assoc(mysqli_query($conn,"
SELECT COUNT(*) AS total FROM orders
"));

$totalRevenue = mysqli_fetch_assoc(mysqli_query($conn,"
SELECT SUM(total) AS revenue
FROM orders
WHERE status='Delivered'
"));

$pendingOrders = mysqli_fetch_assoc(mysqli_query($conn,"
SELECT COUNT(*) AS total
FROM orders
WHERE status='Pending'
"));

$todayOrders = mysqli_fetch_assoc(mysqli_query($conn,"
SELECT COUNT(*) AS total
FROM orders
WHERE DATE(order_date)=CURDATE()
"));
?>

<!DOCTYPE html>
<html>
<head>

<meta charset="UTF-8">

<title>Admin Dashboard</title>

<style>

body{
font-family:Arial;
background:#f5f5f5;
margin:0;
}

header{
background:#007bff;
color:#fff;
padding:15px;
}

header a{
color:white;
text-decoration:none;
background:#28a745;
padding:10px 15px;
border-radius:5px;
margin-right:10px;
}

.container{
width:95%;
margin:auto;
margin-top:20px;
}

.cards{
display:flex;
flex-wrap:wrap;
gap:20px;
margin-bottom:30px;
}

.card{
width:180px;
padding:20px;
border-radius:10px;
color:white;
text-align:center;
font-weight:bold;
}

.blue{background:#007bff;}
.green{background:#28a745;}
.orange{background:#ffc107;color:black;}
.red{background:#dc3545;}
.purple{background:#6f42c1;}
.cyan{background:#17a2b8;}

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

img{
width:80px;
height:80px;
object-fit:cover;
}

</style>

</head>

<body>

<header>

<h2>🛒 ShopCart Admin Dashboard</h2>

<a href="add_product.php">➕ Add Product</a>

<a href="admin_orders.php">📦 View Orders</a>

<a href="sales_report.php">📊 Sales Report</a>

<a href="logout.php">Logout</a>




</header>

<a href="users.php" style="text-decoration:none;">
<div class="card blue">
    <h3>Total Users</h3>
    <h2><?php echo $totalUsers['total']; ?></h2>
</div>
</a>

<a href="products_list.php" style="text-decoration:none;">
<div class="card green">
    <h3>Total Products</h3>
    <h2><?php echo $totalProducts['total']; ?></h2>
</div>
</a>

<a href="admin_orders.php" style="text-decoration:none;">
<div class="card orange">
    <h3>Total Orders</h3>
    <h2><?php echo $totalOrders['total']; ?></h2>
</div>
</a>

<a href="sales_report.php" style="text-decoration:none;">
<div class="card cyan">
    <h3>Total Revenue</h3>
    <h2>₹<?php echo $totalRevenue['revenue'] ?? 0; ?></h2>
</div>
</a>





</div>

</div>

<footer style="margin-top:30px;
background:#343a40;
color:white;
text-align:center;
padding:15px;">

<p>&copy; 2026 ShopCart Admin Panel | Developed by Anju</p>

</footer>

</body>
</html>