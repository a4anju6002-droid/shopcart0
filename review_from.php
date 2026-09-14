<?php
session_start();
include("db.php");

if(!isset($_SESSION['user_id'])){
    header("Location: login.php");
    exit();
}

$product_id = $_GET['id'];
?>

<!DOCTYPE html>
<html>
<head>
<title>Write Review</title>
</head>
<body>

<h2>⭐ Write Review</h2>

<form action="review.php" method="POST">

<input type="hidden"
name="product_id"
value="<?php echo $product_id; ?>">

<label>Rating</label>

<select name="rating">

<option value="5">⭐⭐⭐⭐⭐</option>
<option value="4">⭐⭐⭐⭐</option>
<option value="3">⭐⭐⭐</option>
<option value="2">⭐⭐</option>
<option value="1">⭐</option>

</select>

<br><br>

<textarea
name="review"
rows="5"
cols="40"
placeholder="Write your review..."
required></textarea>

<br><br>

<input type="submit"
name="submit"
value="Submit Review">

</form>

</body>
</html>