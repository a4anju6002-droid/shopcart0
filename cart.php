<?php

session_start();
include("db.php");


if(!isset($_SESSION['user_id'])){

    header("Location: login.php");
    exit();

}


$user_id = $_SESSION['user_id'];


// Remove Product

if(isset($_GET['remove'])){

    $cart_id = $_GET['remove'];

    mysqli_query($conn,"
    DELETE FROM cart
    WHERE id='$cart_id'
    AND user_id='$user_id'
    ");

    header("Location: cart.php");
    exit();

}


if(isset($_GET['add'])){

    $product_id = $_GET['add'];

    mysqli_query($conn,
    "INSERT INTO cart(user_id, product_id, quantity)
    VALUES('$user_id','$product_id',1)"
    );

    header("Location: cart.php");
    exit();

}

// Coupon

$discount = 0;


if(isset($_POST['apply_coupon'])){


    $coupon = mysqli_real_escape_string(
        $conn,
        $_POST['coupon']
    );


    $check = mysqli_query($conn,"
    SELECT * FROM coupons
    WHERE code='$coupon'
    AND status='Active'
    ");


    if(mysqli_num_rows($check)>0){


        $data = mysqli_fetch_assoc($check);

        $_SESSION['discount'] = $data['discount'];

        echo "<script>
        alert('Coupon Applied');
        </script>";


    }else{


        $_SESSION['discount']=0;

        echo "<script>
        alert('Invalid Coupon');
        </script>";

    }

}



if(isset($_SESSION['discount'])){

    $discount = $_SESSION['discount'];

}




// Get Cart Products

$result = mysqli_query($conn,"

SELECT 
cart.id,
products.name,
products.price,
products.image,
cart.quantity

FROM cart

JOIN products

ON cart.product_id = products.id

WHERE cart.user_id='$user_id'

");



?>


<!DOCTYPE html>
<html>

<head>

<title>My Cart | ShopCart</title>


<style>

body{

font-family:Arial;
background:#f5f5f5;

}


.container{

width:90%;
margin:auto;

}


h1{

text-align:center;

}


table{

width:100%;
background:white;
border-collapse:collapse;

}


th{

background:#e53935;
color:white;

}


td,th{

padding:12px;
text-align:center;
border:1px solid #ddd;

}


img{

width:70px;

}


.qty-btn{

background:#e53935;
color:white;
padding:5px 12px;
text-decoration:none;
border-radius:5px;

}


.remove{

background:black;
color:white;
padding:8px;
text-decoration:none;

}


.box{

background:white;
padding:20px;
margin-top:20px;

}


button,input[type=submit]{

background:#e53935;
color:white;
border:none;
padding:10px;
cursor:pointer;

}


</style>

</head>


<body>


<div class="container">


<h1>🛒 My Cart</h1>


<a href="products.php">
Continue Shopping
</a>


<br><br>


<table>


<tr>

<th>Image</th>
<th>Product</th>
<th>Price</th>
<th>Quantity</th>
<th>Remove</th>

</tr>



<?php


$total=0;


while($row=mysqli_fetch_assoc($result)){


$subtotal =
$row['price']*$row['quantity'];


$total += $subtotal;


?>


<tr>


<td>

<img src="uploads/<?php echo $row['image']; ?>">

</td>


<td>

<?php echo $row['name']; ?>

</td>



<td>

₹<?php echo $row['price']; ?>

</td>



<td>


<a class="qty-btn"
href="update_cart.php?id=<?php echo $row['id']; ?>&action=minus">

−

</a>



<b>

<?php echo $row['quantity']; ?>

</b>



<a class="qty-btn"
href="update_cart.php?id=<?php echo $row['id']; ?>&action=plus">

+

</a>


</td>



<td>


<a class="remove"
href="cart.php?remove=<?php echo $row['id']; ?>">

Remove

</a>


</td>


</tr>



<?php } ?>


</table>




<div class="box">


<h3>Apply Coupon</h3>


<form method="POST">


<input type="text"
name="coupon"
placeholder="Enter Coupon Code">


<input type="submit"
name="apply_coupon"
value="Apply">


</form>



<?php


$discount_amount =
($total*$discount)/100;


$final_total =
$total-$discount_amount;


?>


<h2>
Total : ₹<?php echo $total; ?>
</h2>


<h2>
Discount : <?php echo $discount; ?>%
</h2>


<h2>
Final Total : ₹<?php echo $final_total; ?>
</h2>



<a href="checkout.php">

<button>
Proceed To Checkout
</button>

</a>


</div>


</div>


</body>

</html>