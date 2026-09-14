<?php
session_start();

$message = "";

if (isset($_POST['login'])) {

    $email = trim($_POST['email']);
    $password = $_POST['password'];

    // Admin credentials
    $admin_email = "admin@shopcart.com";
    $admin_password = "Admin@123";

    if ($email === $admin_email && $password === $admin_password) {

        $_SESSION['admin'] = "Admin";

        header("Location: admin.php");
        exit();

    } else {

        $message = "Invalid Admin Login";

    }
}
?>

<!DOCTYPE html>
<html>

<head>

<title>Admin Login | ShopCart</title>

<meta name="viewport" content="width=device-width, initial-scale=1.0">

<style>

body {
    font-family: Arial;
    background: #f4f4f4;
}

.box {
    width: 350px;
    margin: 100px auto;
    padding: 30px;
    background: white;
    border-radius: 15px;
    box-shadow: 0 5px 20px #ccc;
}

h2 {
    text-align: center;
}

input {
    width: 100%;
    padding: 12px;
    margin: 10px 0;
    box-sizing: border-box;
}

button {
    width: 100%;
    padding: 12px;
    background: #e53935;
    color: white;
    border: none;
    border-radius: 6px;
    font-size: 16px;
    cursor: pointer;
}

button:hover {
    background: #c62828;
}

.error {
    color: red;
    text-align: center;
}

</style>

</head>

<body>

<div class="box">

<h2>Admin Login</h2>

<?php if ($message != "") { ?>

<p class="error"><?php echo $message; ?></p>

<?php } ?>

<form method="post">

<input
type="email"
name="email"
placeholder="Admin Email"
required
autocomplete="off">

<input
type="password"
name="password"
placeholder="Password"
required
autocomplete="new-password">

<button type="submit" name="login">
Login
</button>

</form>

</div>

</body>

</html>