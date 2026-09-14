<?php
session_start();
include("db.php");

// Admin Login Check
if(!isset($_SESSION['admin'])){
    header("Location: admin_login.php");
    exit();
}

// Check Product ID
if(isset($_GET['id'])){

    $id = mysqli_real_escape_string($conn, $_GET['id']);

    // Get image name
    $result = mysqli_query($conn, "SELECT image FROM products WHERE id='$id'");

    if(mysqli_num_rows($result) > 0){

        $row = mysqli_fetch_assoc($result);

        // Delete image file
        if($row['image'] != "" && file_exists("images/".$row['image'])){
            unlink("images/".$row['image']);
        }

        // Delete product from database
        mysqli_query($conn, "DELETE FROM products WHERE id='$id'");
    }
}

// Redirect to Admin Dashboard
header("Location: admin.php");
exit();
?>