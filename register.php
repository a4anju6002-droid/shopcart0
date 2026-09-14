<?php

session_start();

error_reporting(E_ALL);
ini_set('display_errors',1);

include("db.php");

$message = "";
$type = "";


if(isset($_POST['register'])){


    $fullname = trim($_POST['fullname']);
    $email = trim($_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);



    // Check email already exists

    $check = $conn->prepare(
        "SELECT id FROM users WHERE email=?"
    );

    $check->bind_param("s",$email);
    $check->execute();

    $result = $check->get_result();



    if($result->num_rows > 0){


        $message = "Email already registered!";
        $type = "error";


    }else{


        // Insert User

        $insert = $conn->prepare(
            "INSERT INTO users(fullname,email,password)
             VALUES(?,?,?)"
        );


        $insert->bind_param("sss",
            $fullname,
            $email,
            $password
        );



        if($insert->execute()){


            $_SESSION['user_id'] = $insert->insert_id;
            $_SESSION['fullname'] = $fullname;


            header("Location: products.php");
            exit();


        }else{


            $message = "Registration failed!";
            $type = "error";


        }

    }

}

?>


<!DOCTYPE html>
<html>

<head>

<title>Register | ShopCart</title>

<meta name="viewport" content="width=device-width, initial-scale=1.0">


<style>

body{

    margin:0;
    background:#f4f4f4;
    font-family:Arial;

}


.header{

    background:#e53935;
    color:white;
    text-align:center;
    padding:15px;

}


.box{

    width:350px;
    background:white;
    margin:60px auto;
    padding:30px;
    border-radius:15px;
    box-shadow:0 5px 20px #ccc;

}


h2{

    text-align:center;

}


input{

    width:100%;
    padding:12px;
    margin:10px 0;
    border:1px solid #ccc;
    border-radius:8px;

}


button{

    width:100%;
    padding:12px;
    background:#e53935;
    color:white;
    border:none;
    border-radius:8px;
    cursor:pointer;
    font-size:16px;

}


button:hover{

    background:#c62828;

}


.error{

    color:red;
    text-align:center;

}


.success{

    color:green;
    text-align:center;

}


a{

    color:#e53935;
    text-decoration:none;

}

</style>


</head>


<body>


<div class="header">

<h1>🛒 ShopCart</h1>

</div>



<div class="box">


<h2>Create Account</h2>


<?php

if($message!=""){

echo "<p class='$type'>$message</p>";

}

?>


<form method="POST">


<input type="text"
name="fullname"
placeholder="Full Name"
required>



<input type="email"
name="email"
placeholder="Email Address"
required>



<input type="password"
name="password"
placeholder="Password"
required>



<button type="submit" name="register">

Register

</button>


</form>


<br>


<center>

Already have account?

<a href="login.php">
Login
</a>

</center>


</div>


</body>

</html>