<?php

session_start();
include("db.php");


if(!isset($_SESSION['user_id'])){
    header("Location: login.php");
    exit();
}


$user_id = $_SESSION['user_id'];


$id = $_GET['id'];
$action = $_GET['action'];


// Get current quantity

$result = mysqli_query($conn,"
SELECT quantity FROM cart
WHERE id='$id'
AND user_id='$user_id'
");


$row = mysqli_fetch_assoc($result);


$quantity = $row['quantity'];



if($action=="plus"){

    $quantity++;

}


if($action=="minus"){

    if($quantity>1){
        $quantity--;
    }

}



mysqli_query($conn,"
UPDATE cart
SET quantity='$quantity'
WHERE id='$id'
AND user_id='$user_id'
");


header("Location: cart.php");
exit();


?>