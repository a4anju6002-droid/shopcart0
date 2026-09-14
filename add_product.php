<?php
session_start();
include("db.php");

if(!isset($_SESSION['admin'])){
    header("Location: admin_login.php");
    exit();
}

$message = "";

if(isset($_POST['save'])){

    $name = mysqli_real_escape_string($conn,$_POST['name']);
    $description = mysqli_real_escape_string($conn,$_POST['description']);
    $category = mysqli_real_escape_string($conn,$_POST['category']);
    $price = mysqli_real_escape_string($conn,$_POST['price']);
    $stock = mysqli_real_escape_string($conn,$_POST['stock']);

    $image = $_FILES['image']['name'];
    $temp = $_FILES['image']['tmp_name'];

    move_uploaded_file($temp,"images/".$image);

    $sql = "INSERT INTO products(name,description,category,price,image,stock)
    VALUES('$name','$description','$category','$price','$image','$stock')";

    if(mysqli_query($conn,$sql)){
        $message = "✅ Product Added Successfully!";
    }else{
        $message = "❌ Error : ".mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Add Product - ShopCart</title>

<style>

body{
font-family:Arial;
background:#f5f5f5;
}

.container{
width:450px;
margin:auto;
margin-top:40px;
background:white;
padding:20px;
border-radius:8px;
box-shadow:0 0 10px #ccc;
}

input,textarea,select{
width:100%;
padding:10px;
margin-top:5px;
margin-bottom:15px;
}

button{
background:#28a745;
color:white;
padding:10px;
border:none;
width:100%;
cursor:pointer;
}

button:hover{
background:green;
}

a{
text-decoration:none;
}

</style>

</head>

<body>

<div class="container">

<h2>➕ Add Product</h2>

<p style="color:green;">
<?php echo $message; ?>
</p>

<form method="POST" enctype="multipart/form-data">

<label>Product Name</label>

<input type="text" name="name" required>

<label>Description</label>

<textarea name="description" required></textarea>

<label>Category</label>

<select name="category" required>

<option value="">Select Category</option>

<option value="Laptop">Laptop</option>

<option value="Mobile">Mobile</option>

<option value="Accessories">Accessories</option>

<option value="Electronics">Electronics</option>

<option value="Others">Others</option>

</select>

<label>Price</label>

<input type="number" name="price" required>

<label>Stock</label>

<input type="number" name="stock" required>

<label>Product Image</label>

<input type="file" name="image" required>

<button type="submit" name="save">
Add Product
</button>

</form>

<br>

<a href="admin.php">⬅ Back to Dashboard</a>

</div>

</body>
</html>