<?php

session_start();

error_reporting(E_ALL);
ini_set('display_errors',1);

include("db.php");


if(!isset($_SESSION['user_id'])){

    header("Location: login.php");
    exit();

}


$user_id = $_SESSION['user_id'];

$message = "";


// Submit Review

if(isset($_POST['submit'])){


    $product_id = $_POST['product_id'];
    $rating = $_POST['rating'];
    $review = $_POST['review'];



    $stmt = $conn->prepare(
    "INSERT INTO reviews
    (user_id, product_id, rating, review)
    VALUES (?,?,?,?)"
    );


    $stmt->bind_param(
        "iiis",
        $user_id,
        $product_id,
        $rating,
        $review
    );



    if($stmt->execute()){

        $message = "Review submitted successfully ⭐";

    }else{

        $message = "Error submitting review";

    }

}



$product_id = $_GET['id'] ?? $_POST['product_id'] ?? 0;


?>


<!DOCTYPE html>
<html>

<head>

<title>Write Review | ShopCart</title>


<style>

body{

font-family:Arial;
background:#f5f5f5;

}


.box{

width:400px;
background:white;
margin:50px auto;
padding:30px;
border-radius:15px;
box-shadow:0 5px 20px #ccc;

}


h2{

text-align:center;

}


select,
textarea{

width:100%;
padding:10px;
margin:10px 0;

border-radius:8px;
border:1px solid #ccc;

}


button{

width:100%;
padding:12px;
background:#e53935;
color:white;
border:none;
border-radius:8px;
cursor:pointer;

}


.message{

text-align:center;
color:green;
font-weight:bold;

}


</style>


</head>


<body>


<div class="box">


<h2>⭐ Write Review</h2>


<p class="message">

<?php echo $message; ?>

</p>



<form method="POST">



<input type="hidden"
name="product_id"
value="<?php echo $product_id; ?>">



<label>
Rating
</label>


<select name="rating">


<option value="5">
⭐⭐⭐⭐⭐
</option>


<option value="4">
⭐⭐⭐⭐
</option>


<option value="3">
⭐⭐⭐
</option>


<option value="2">
⭐⭐
</option>


<option value="1">
⭐
</option>


</select>



<textarea
name="review"
rows="5"
placeholder="Write your review..."
required></textarea>



<button type="submit" name="submit">

Submit Review

</button>



</form>


</div>


</body>


</html>