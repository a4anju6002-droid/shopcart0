<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();
include("db.php");
echo "DB OK <br>";
?>

<!DOCTYPE html>
<html lang="en">

<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>ShopCart - Home</title>

<link rel="stylesheet" href="css/style.css">

<style>

*{
margin:0;
padding:0;
box-sizing:border-box;
font-family:Arial,sans-serif;
}

body{
background:#f4f4f4;
}

header{
background:#007bff;
color:white;
display:flex;
justify-content:space-between;
align-items:center;
padding:15px 40px;
position:sticky;
top:0;
z-index:1000;
}

.logo h1{
font-size:30px;
}

nav a{
color:white;
text-decoration:none;
margin-left:20px;
font-weight:bold;
transition:.3s;
}

nav a:hover{
color:yellow;
}

.hero{

background:linear-gradient(to right,#007bff,#00bfff);

color:white;

text-align:center;

padding:80px 20px;

}

.hero h2{

font-size:48px;

margin-bottom:20px;

}

.hero p{

font-size:20px;

margin-bottom:30px;

}

.btn{

display:inline-block;

background:white;

color:#007bff;

padding:12px 25px;

border-radius:5px;

text-decoration:none;

font-weight:bold;

}

.btn:hover{

background:#f1f1f1;

}

.slider{

width:100%;

margin-top:20px;

}

.slider img{

width:100%;

height:350px;

object-fit:cover;

}

.products{

display:flex;

flex-wrap:wrap;

justify-content:center;

gap:20px;

padding:30px;

}

.product{

background:white;

width:240px;

padding:15px;

border-radius:10px;

box-shadow:0 0 10px rgba(0,0,0,.2);

text-align:center;

}

.product img{

width:180px;

height:180px;

object-fit:cover;

}

</style>

</head>

<body>

<header>

<div class="logo">

<h1>🛒 ShopCart</h1>

</div>

<nav>

<a href="index.php">Home</a>

<a href="products.php">Products</a>

<a href="cart.php">Cart</a>

<a href="wishlist.php">Wishlist</a>

<a href="login.php">Login</a>

<a href="register.php">Register</a>

</nav>

</header>

<section class="hero">

<h2>Welcome to ShopCart</h2>

<p>

Buy the Best Electronics, Mobiles & Accessories

at Affordable Prices

</p>

<a href="products.php" class="btn">

🛍 Shop Now

</a>

</section>
<!-- Image Slider -->

<div class="slider">

<img id="slide"

src="images/banner1.jpg"

alt="Banner">

</div>

<!-- Featured Products -->

<h2 align="center" style="margin-top:40px;">

⭐ Featured Products

</h2>

<div class="products">

<?php

$result = mysqli_query($conn,

"SELECT * FROM products LIMIT 8");

while($row=mysqli_fetch_assoc($result)){

?>

<div class="product">

<?php
if(!empty($row['image'])){
?>

<img src="images/<?php echo $row['image']; ?>">

<?php
}else{
?>

<img src="https://via.placeholder.com/180">

<?php
}
?>

<h3>

<?php echo $row['name']; ?>

</h3>

<p>

<?php echo $row['description']; ?>

</p>

<h3>

₹<?php echo $row['price']; ?>

</h3>

<p>

Stock :
<?php echo $row['stock']; ?>

</p>

<a href="products.php"

class="btn">

View Product

</a>

</div>

<?php

}

?>

</div>

<script>

var images=[

"images/banner1.jpg",

"images/banner2.jpg",

"images/banner3.jpg"

];

var i=0;

setInterval(function(){

i++;

if(i>=images.length){

i=0;

}

document.getElementById("slide").src=images[i];

},3000);

</script>
<!-- Shop by Category -->

<h2 align="center" style="margin-top:40px;">
📂 Shop by Category
</h2>

<div class="products">

<div class="product">
<h3>💻 Laptop</h3>
<p>Latest laptops at best prices</p>
<a href="products.php?category=Laptop" class="btn">
View
</a>
</div>

<div class="product">
<h3>📱 Mobile</h3>
<p>Top smartphones from popular brands</p>
<a href="products.php?category=Mobile" class="btn">
View
</a>
</div>

<div class="product">
<h3>🎧 Accessories</h3>
<p>Headphones, Mouse, Keyboard & More</p>
<a href="products.php?category=Accessories" class="btn">
View
</a>
</div>

<div class="product">
<h3>📺 Electronics</h3>
<p>Electronic gadgets & devices</p>
<a href="products.php?category=Electronics" class="btn">
View
</a>
</div>

</div>

<!-- Best Selling Products -->

<h2 align="center" style="margin-top:50px;">
🔥 Best Selling Products
</h2>

<div class="products">

<?php

$best = mysqli_query($conn,"
SELECT * FROM products
ORDER BY stock ASC
LIMIT 4
");

while($row=mysqli_fetch_assoc($best)){

?>

<div class="product">

<?php
if(!empty($row['image'])){
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

<h3>₹<?php echo $row['price']; ?></h3>

<a href="products.php" class="btn">
Buy Now
</a>

</div>

<?php } ?>

</div>

<!-- Today's Offer -->

<section style="background:#ff9800;color:white;padding:40px;margin-top:40px;text-align:center;">

<h2>🎉 Today's Special Offer</h2>

<h3>Up to 50% OFF on Selected Products</h3>

<p>Limited Time Offer - Shop Now!</p>

<a href="products.php" class="btn">
Grab Offer
</a>

</section>
<!-- Customer Testimonials -->

<section style="padding:50px;background:#ffffff;">

<h2 align="center">⭐ Customer Testimonials</h2>

<div class="products">

<div class="product">

<h3>⭐⭐⭐⭐⭐</h3>

<p>

"Excellent products and very fast delivery."

</p>

<b>- Rahul</b>

</div>

<div class="product">

<h3>⭐⭐⭐⭐⭐</h3>

<p>

"Affordable prices and genuine quality."

</p>

<b>- Anjali</b>

</div>

<div class="product">

<h3>⭐⭐⭐⭐</h3>

<p>

"Customer support is really helpful."

</p>

<b>- Akhil</b>

</div>

</div>

</section>

<!-- Contact Us -->

<section style="background:#007bff;color:white;padding:50px;text-align:center;">

<h2>📞 Contact Us</h2>

<p>📍 Thrissur, Kerala, India</p>

<p>📞 +91 9876543210</p>

<p>✉ support@shopcart.com</p>

<p>🕒 Monday - Saturday : 9:00 AM - 6:00 PM</p>

</section>

<!-- Footer -->

<footer style="background:#222;color:white;padding:30px;text-align:center;">

<h2>🛒 ShopCart</h2>

<p>Your Trusted Online Shopping Store</p>

<br>

<p>

<a href="index.php" style="color:white;text-decoration:none;">Home</a> |

<a href="products.php" style="color:white;text-decoration:none;">Products</a> |

<a href="login.php" style="color:white;text-decoration:none;">Login</a> |

<a href="register.php" style="color:white;text-decoration:none;">Register</a>

</p>

<br>

<p>

Follow Us

</p>

<p style="font-size:24px;">

📘 Facebook &nbsp;

📷 Instagram &nbsp;

🐦 Twitter &nbsp;

▶ YouTube

</p>

<hr>

<p>

© 2026 ShopCart | All Rights Reserved

</p>

</footer>
<!-- Dark Mode Button -->

<button id="darkBtn"
style="
position:fixed;
bottom:20px;
right:20px;
padding:12px 18px;
border:none;
border-radius:50px;
background:#007bff;
color:white;
cursor:pointer;
font-size:18px;
">

🌙

</button>

<!-- Back To Top -->

<button onclick="topFunction()"
id="topBtn"
style="
display:none;
position:fixed;
bottom:80px;
right:20px;
padding:12px 18px;
border:none;
border-radius:50px;
background:#28a745;
color:white;
cursor:pointer;
font-size:18px;
">

⬆

</button>

<script>

// Auto Slider
var images=[
"images/banner1.jpg",
"images/banner2.jpg",
"images/banner3.jpg"
];

var i=0;

setInterval(function(){

i++;

if(i>=images.length){
i=0;
}

var slide=document.getElementById("slide");

if(slide){
slide.src=images[i];
}

},3000);

// Dark Mode

document.getElementById("darkBtn").onclick=function(){

document.body.classList.toggle("dark");

};

// Back To Top

var topBtn=document.getElementById("topBtn");

window.onscroll=function(){

if(document.body.scrollTop>200 ||
document.documentElement.scrollTop>200){

topBtn.style.display="block";

}else{

topBtn.style.display="none";

}

};

function topFunction(){

window.scrollTo({

top:0,

behavior:"smooth"

});

}

</script>

<style>

.dark{

background:#121212;

color:white;

}

.dark header{

background:#111;

}

.dark .product{

background:#222;

color:white;

}

.dark footer{

background:black;

}

</style>

</body>
</html>