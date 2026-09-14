<?php
session_start();
include("db.php");

// Admin Login Check
if(!isset($_SESSION['admin'])){
    header("Location: admin_login.php");
    exit();
}

// Get Product ID
if(!isset($_GET['id'])){
    header("Location: admin.php");
    exit();
}

$id = mysqli_real_escape_string($conn, $_GET['id']);

$result = mysqli_query($conn, "SELECT * FROM products WHERE id='$id'");

if(mysqli_num_rows($result)==0){
    die("Product Not Found");
}

$row = mysqli_fetch_assoc($result);

$message = "";

// Update Product
if(isset($_POST['update'])){

    $name = mysqli_real_escape_string($conn,$_POST['name']);
    $description = mysqli_real_escape_string($conn,$_POST['description']);
    $category = mysqli_real_escape_string($conn,$_POST['category']);
    $price = mysqli_real_escape_string($conn,$_POST['price']);
    $stock = mysqli_real_escape_string($conn,$_POST['stock']);

    $image = $row['image'];

    if(!empty($_FILES['image']['name'])){

        $newImage = $_FILES['image']['name'];
        $tmp = $_FILES['image']['tmp_name'];

        move_uploaded_file($tmp,"images/".$newImage);

        if($image != "" && file_exists("images/".$image)){
            unlink("images/".$image);
        }

        $image = $newImage;
    }

    $sql = "UPDATE products SET
            name='$name',
            description='$description',
            category='$category',
            price='$price',
            stock='$stock',
            image='$image'
            WHERE id='$id'";

    if(mysqli_query($conn,$sql)){
        header("Location: admin.php");
        exit();
    }else{
        $message = "Update Failed : ".mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Edit Product</title>

<style>

body{
    font-family:Arial;
    background:#f4f4f4;
}

.container{
    width:500px;
    margin:auto;
    margin-top:40px;
    background:#fff;
    padding:20px;
    border-radius:8px;
    box-shadow:0 0 10px #ccc;
}

input,textarea,select{
    width:100%;
    padding:10px;
    margin-bottom:15px;
}

button{
    background:#007bff;
    color:white;
    border:none;
    padding:10px;
    width:100%;
    cursor:pointer;
}

img{
    width:150px;
    height:150px;
    object-fit:cover;
    margin-bottom:10px;
}

</style>

</head>

<body>

<div class="container">

<h2>Edit Product</h2>

<p style="color:red;"><?php echo $message; ?></p>

<form method="POST" enctype="multipart/form-data">

<label>Product Name</label>
<input type="text" name="name"
value="<?php echo $row['name']; ?>" required>

<label>Description</label>
<textarea name="description" required><?php echo $row['description']; ?></textarea>

<label>Category</label>

<select name="category">

<option value="Laptop"
<?php if($row['category']=="Laptop") echo "selected"; ?>>
Laptop
</option>

<option value="Mobile"
<?php if($row['category']=="Mobile") echo "selected"; ?>>
Mobile
</option>

<option value="Accessories"
<?php if($row['category']=="Accessories") echo "selected"; ?>>
Accessories
</option>

<option value="Electronics"
<?php if($row['category']=="Electronics") echo "selected"; ?>>
Electronics
</option>

Accessories
</option>

<option value="Others"
<?php if($row['category']=="Otherss") echo "selected"; ?>>
Others
</option>

</select>

<label>Price</label>
<input type="number" name="price"
value="<?php echo $row['price']; ?>" required>

<label>Stock</label>
<input type="number" name="stock"
value="<?php echo $row['stock']; ?>" required>

<label>Current Image</label><br>

<?php
if($row['image']!=""){
?>
<img src="images/<?php echo $row['image']; ?>">
<?php
}else{
echo "No Image";
}
?>

<br><br>

<label>Change Image</label>
<input type="file" name="image">

<button type="submit" name="update">
Update Product
</button>

</form>

<br>

<a href="admin.php">⬅ Back to Admin Dashboard</a>

</div>

</body>
</html>