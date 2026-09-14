<?php
session_start();
include("db.php");

if(!isset($_SESSION['user_id'])){
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

$result = mysqli_query($conn,"SELECT * FROM users WHERE id='$user_id'");
$user = mysqli_fetch_assoc($result);

$message = "";

if(isset($_POST['update'])){

    $fullname = mysqli_real_escape_string($conn,$_POST['fullname']);
    $email = mysqli_real_escape_string($conn,$_POST['email']);

    $sql = "UPDATE users
            SET fullname='$fullname',
                email='$email'
            WHERE id='$user_id'";

    if(mysqli_query($conn,$sql)){
        $_SESSION['fullname'] = $fullname;
        $message = "Profile Updated Successfully";

        $result = mysqli_query($conn,"SELECT * FROM users WHERE id='$user_id'");
        $user = mysqli_fetch_assoc($result);
    }else{
        $message = "Update Failed";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>My Profile</title>

<style>
body{
    font-family:Arial;
    background:#f4f4f4;
}

.box{
    width:400px;
    margin:50px auto;
    background:white;
    padding:20px;
    border-radius:8px;
}

input{
    width:100%;
    padding:10px;
    margin-bottom:15px;
}

button{
    width:100%;
    padding:10px;
    background:#007bff;
    color:white;
    border:none;
}

.success{
    color:green;
}
</style>

</head>

<body>

<div class="box">

<h2>My Profile</h2>

<p class="success"><?php echo $message; ?></p>

<form method="POST">

<label>Full Name</label>
<input type="text"
name="fullname"
value="<?php echo $user['fullname']; ?>">

<label>Email</label>
<input type="email"
name="email"
value="<?php echo $user['email']; ?>">

<button
name="update">
Update Profile
</button>

</form>

<br>

<a href="change_password.php">
🔑 Change Password
</a>

<br><br>

<a href="products.php">
⬅ Back
</a>

</div>

</body>
</html>