<?php
session_start();
include("db.php");

if(!isset($_SESSION['user_id'])){
    header("Location: login.php");
    exit();
}

$message = "";
$user_id = $_SESSION['user_id'];

if(isset($_POST['change'])){

    $old = $_POST['old_password'];
    $new = $_POST['new_password'];

    $result = mysqli_query($conn,"SELECT * FROM users WHERE id='$user_id'");
    $user = mysqli_fetch_assoc($result);

    if(password_verify($old,$user['password'])){

        $newPass = password_hash($new,PASSWORD_DEFAULT);

        mysqli_query($conn,
        "UPDATE users
        SET password='$newPass'
        WHERE id='$user_id'");

        $message = "Password Changed Successfully";

    }else{

        $message = "Old Password Incorrect";

    }
}
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Change Password</title>
</head>

<body>

<h2>Change Password</h2>

<p><?php echo $message; ?></p>

<form method="POST">

<input type="password"
name="old_password"
placeholder="Old Password"
required>

<br><br>

<input type="password"
name="new_password"
placeholder="New Password"
required>

<br><br>

<input type="submit"
name="change"
value="Change Password">

</form>

<br>

<a href="profile.php">⬅ Back to Profile</a>

</body>
</html>