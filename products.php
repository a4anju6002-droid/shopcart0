<?php
session_start();
include("db.php");

if(!isset($_SESSION['user_id'])){
    header("Location: login.php");
    exit();
}

if(isset($_GET['category']) && $_GET['category']!=""){

    $category = mysqli_real_escape_string($conn,$_GET['category']);

    $result = mysqli_query($conn,
    "SELECT * FROM products WHERE category='$category'");

}
else if(isset($_GET['search']) && $_GET['search']!=""){

    $search = mysqli_real_escape_string($conn,$_GET['search']);

    $result = mysqli_query($conn,
    "SELECT * FROM products
    WHERE name LIKE '%$search%'
    OR description LIKE '%$search%'
    OR category LIKE '%$search%'");

}
else{

    $result = mysqli_query($conn,
    "SELECT * FROM products");

}
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Products - ShopCart</title>

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
}

.container{
width:95%;
margin:auto;
}

.top-bar{
margin:20px 0;
}

.product{
width:260px;
background:white;
border:1px solid #ddd;
border-radius:8px;
padding:15px;
margin:15px;
display:inline-block;
vertical-align:top;
text-align:center;
}

.product img{
width:180px;
height:180px;
object-fit:cover;
}

.btn{
background:#28a745;
color:white;
padding:10px;
text-decoration:none;
border-radius:5px;
display:inline-block;
margin:5px;
}

input,select{
padding:8px;
}

</style>

</head>

<body>

<header>

<h2>🛒 ShopCart</h2>

<p>
Welcome,
<b><?php echo $_SESSION['fullname']; ?></b>
</p>

<a href="cart.php" style="color:white;">🛒 Cart</a> |
<a href="wishlist.php" style="color:white;">❤️ Wishlist</a> |
<a href="orders.php" style="color:white;">📦 Orders</a> |
<a href="logout.php" style="color:white;">Logout</a>
<a href="profile.php" style="color:white;">👤 My Profile</a> |

</header>

<div class="container">

<div class="top-bar">

<form method="GET">

<input type="text"
name="search"
placeholder="Search Products">

<input type="submit"
value="Search">

</form>

<br>

<form method="GET">

<select name="category">

<option value="">All Categories</option>
<option value="Laptop">Laptop</option>
<option value="Mobile">Mobile</option>
<option value="Accessories">Accessories</option>
<option value="Electronics">Electronics</option>
<option value="Others">Others</option>

</select>

<input type="submit"
value="Filter">

</form>

</div>
<?php

if(mysqli_num_rows($result)>0){

while($row=mysqli_fetch_assoc($result)){

?>

<div class="product">

<?php
if($row['image']!=""){
?>
<img src="images/<?php echo $row['image']; ?>">
<?php
}else{
?>
<img src="https://via.placeholder.com/180">
<?php
}
?>

<h3><?php echo $row['name']; ?></h3>

<p><?php echo $row['description']; ?></p>

<p>
<b>Category:</b>
<?php echo $row['category']; ?>
</p>

<h3>₹<?php echo $row['price']; ?></h3>

<p>

<?php echo $row['stock']; ?>
</p>

<a class="btn"
href="cart.php?add=<?php echo $row['id']; ?>">
🛒 Add To Cart
</a>

<br><br>

<a class="btn"
href="wishlist.php?add=<?php echo $row['id']; ?>">
❤️ Wishlist
</a>

<br><br>

<a class="btn"
href="review.php?id=<?php echo $row['id']; ?>">
⭐ Review
</a>

<hr>

<h4>Customer Reviews</h4>

<?php

$reviews = mysqli_query($conn,"
SELECT reviews.rating,
reviews.review,
users.fullname
FROM reviews
JOIN users
ON reviews.user_id = users.id
WHERE reviews.product_id='".$row['id']."'
ORDER BY reviews.id DESC
LIMIT 3");

if(mysqli_num_rows($reviews)>0){

while($r=mysqli_fetch_assoc($reviews)){

?>

<p>

<b><?php echo $r['fullname']; ?></b><br>

⭐ <?php echo $r['rating']; ?>/5

<br>

<?php echo $r['review']; ?>

</p>

<hr>

<?php

}

}else{

echo "No Reviews Yet";

}

?>

</div>

<?php

}

}


else{

?>

<h2 style="text-align:center;">
No Products Found
</h2>

<?php

}

?>

</div>

<footer style="background:#222;color:white;text-align:center;padding:15px;margin-top:30px;">

<p>
© <?php echo date("Y"); ?> ShopCart. All Rights Reserved.
</p>

</footer>

</body>
</html>