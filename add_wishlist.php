<?php
session_start();
include("db.php");

// Login check
if(!isset($_SESSION['user_id'])){
    header("Location: login.php");
    exit();
}


$user_id = $_SESSION['user_id'];

$product_id = $_GET['id'];


// Check already added

$check = mysqli_query($conn,
"SELECT * FROM wishlist 
WHERE user_id='$user_id' 
AND product_id='$product_id'");


if(mysqli_num_rows($check) > 0)
{
    header("Location:wishlist.php");
    exit();
}


// Insert wishlist

$query = mysqli_query($conn,
"INSERT INTO wishlist(user_id,product_id)
VALUES('$user_id','$product_id')");


if($query)
{
    header("Location:wishlist.php");
}
else
{
    echo "Error Adding Wishlist";
}

?>