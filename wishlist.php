<?php
session_start();
include("db.php");

// Login Check
if(!isset($_SESSION['user_id'])){
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];


// Add to Wishlist
if(isset($_GET['add'])){

    $product_id = $_GET['add'];

    // Check already exists
    $check = mysqli_query($conn,
    "SELECT * FROM wishlist 
     WHERE user_id='$user_id' 
     AND product_id='$product_id'");

    if(mysqli_num_rows($check)==0){

        mysqli_query($conn,
        "INSERT INTO wishlist(user_id,product_id)
        VALUES('$user_id','$product_id')");
    }

    header("Location: wishlist.php");
    exit();
}


// Remove Wishlist
if(isset($_GET['remove'])){

    $id = $_GET['remove'];

    mysqli_query($conn,
    "DELETE FROM wishlist 
     WHERE id='$id' 
     AND user_id='$user_id'");

    header("Location: wishlist.php");
    exit();
}


// Get Wishlist Products

$result = mysqli_query($conn,

"SELECT wishlist.id,
products.name,
products.description,
products.price,
products.image,
products.stock

FROM wishlist

JOIN products 
ON wishlist.product_id = products.id

WHERE wishlist.user_id='$user_id'");

?>

<!DOCTYPE html>
<html>
<head>

<title>My Wishlist - ShopCart</title>

<style>

body{
    font-family:Arial;
    background:#f4f4f4;
}

header{
    background:#007bff;
    color:white;
    padding:15px;
}

.container{
    width:90%;
    margin:auto;
}

.product{

    background:white;
    width:250px;
    padding:15px;
    margin:15px;
    display:inline-block;
    vertical-align:top;
    text-align:center;
    border-radius:8px;

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

}

.remove{

    background:red;
}

</style>

</head>


<body>


<header>

<h2>❤️ My Wishlist</h2>

<a href="products.php" style="color:white;">
Continue Shopping
</a>

</header>


<div class="container">


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

echo "No Image";

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


<a class="btn"
href="cart.php?add=<?php echo $row['id']; ?>">

🛒 Add Cart

</a>


<br><br>


<a class="btn remove"
href="wishlist.php?remove=<?php echo $row['id']; ?>"
onclick="return confirm('Remove from Wishlist?');">

❌ Remove

</a>


</div>


<?php

}

}
else{

echo "<h2>No Wishlist Products</h2>";

}

?>


</div>


</body>
</html>