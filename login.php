<?php
session_start();
include("db.php");

$message = "";

if(isset($_POST['login'])){

    $email = $_POST['email'];
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT * FROM users WHERE email=?");
    $stmt->bind_param("s",$email);
    $stmt->execute();

    $result = $stmt->get_result();

    if($result->num_rows > 0){

        $user = $result->fetch_assoc();

        if(password_verify($password,$user['password'])){

            $_SESSION['user_id'] = $user['id'];
            $_SESSION['fullname'] = $user['fullname'];

            header("Location: products.php");
            exit();

        }else{
            $message = "❌ Incorrect password";
        }

    }else{
        $message = "❌ Account not found";
    }
}
?>


<!DOCTYPE html>
<html>
<head>

<meta charset="UTF-8">
<title>Login | ShopCart</title>

<link rel="stylesheet" href="css/style.css">

<style>

body{
    background:#f2f2f2;
    font-family: Arial, sans-serif;
}

.form-box{

    width:350px;
    margin:80px auto;
    background:white;
    padding:30px;
    border-radius:15px;
    box-shadow:0 5px 20px rgba(0,0,0,0.15);
}


h2{
    text-align:center;
    color:#333;
}


input{

    width:100%;
    padding:12px;
    margin:8px 0;
    border:1px solid #ccc;
    border-radius:8px;
    font-size:15px;

}


.btn{

    width:100%;
    background:#e53935;
    color:white;
    border:none;
    cursor:pointer;
    font-weight:bold;
}


.btn:hover{

    background:#c62828;

}


.message{

    color:red;
    text-align:center;

}


a{

    text-decoration:none;
    color:#e53935;

}


.password-box{

position:relative;

}


.show{

position:absolute;
right:10px;
top:18px;
cursor:pointer;

}


</style>


</head>


<body>


<div class="form-box">


<h2>Welcome Back 👋</h2>

<p class="message">
<?php echo $message; ?>
</p>


<form method="POST">


<input type="email"
name="email"
placeholder="Enter Email"
required>


<div class="password-box">

<input type="password"
id="password"
name="password"
placeholder="Enter Password"
required>


<span class="show" onclick="showPassword()">
👁
</span>

</div>


<input type="submit"
name="login"
value="Login"
class="btn">


</form>


<br>

<center>

Don't have an account?

<a href="register.php">
Register Now
</a>

</center>


</div>


<script>

function showPassword(){

let pass=document.getElementById("password");

if(pass.type==="password"){
    pass.type="text";
}
else{
    pass.type="password";
}

}

</script>


</body>
</html>