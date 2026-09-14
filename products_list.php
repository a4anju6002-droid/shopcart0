<?php
session_start();
include("db.php");

// Admin login check
if(!isset($_SESSION['admin'])){
    header("Location: admin_login.php");
    exit();
}

$result = mysqli_query($conn,"SELECT * FROM products");

?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>All Products</title>

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

th,td{
    border:1px solid #ddd;
    padding:10px;
    text-align:center;
}

th{
    background:#007bff;
    color:white;
}

img{
    width:70px;
    height:70px;
    object-fit:cover;
}

a{
    text-decoration:none;
}
</style>

</head>
<body>

<div class="container">

<h2>📦 All Products</h2>

<table>

<tr>
<th>ID</th>
<th>Image</th>
<th>Name</th>
<th>Description</th>
<th>Category</th>
<th>Price</th>
<th>Stock</th>
<TH>Action</th>
</tr>

<?php
while($row = mysqli_fetch_assoc($result)){
?>

<tr>

<td><?php echo $row['id']; ?></td>

<td>

<?php
if($row['image']!=""){
?>

<img src="images/<?php echo $row['image']; ?>" width="80">

<?php
}else{
echo "No Image";
}
?>

</td>

<td><?php echo $row['name']; ?></td>

<td><?php echo $row['description']; ?></td>

<td><?php echo $row['category']; ?></td>

<td>₹<?php echo $row['price']; ?></td>

<td><?php echo $row['stock']; ?></td>

<td>

<a href="edit_product.php?id=<?php echo $row['id']; ?>">
✏️ Edit
</a>

|

<a href="delete_product.php?id=<?php echo $row['id']; ?>"
onclick="return confirm('Are you sure you want to delete this product?');">
❌ Delete
</a>

</td>

</tr>

<?php
}
?>

<?php while($row=mysqli_fetch_assoc($result)){ ?>

<tr>

<td><?php echo $row['id']; ?></td>

<td>
<img src="images/<?php echo $row['image']; ?>">
</td>

<td><?php echo $row['name']; ?></td>

<td><?php echo $row['description']; ?></td>

<td><?php echo $row['category']; ?></td>

<td>₹<?php echo $row['price']; ?></td>

<td><?php echo $row['stock']; ?></td>

</tr>

<?php } ?>

</table>

<br>

<a href="admin.php">⬅ Back to Dashboard</a>

</div>


</body>
</html>