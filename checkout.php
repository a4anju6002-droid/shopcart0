<?php
session_start();
include("db.php");

if(!isset($_SESSION['user_id'])){
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Calculate Total
$result = mysqli_query($conn,"
SELECT products.price, cart.quantity
FROM cart
JOIN products ON cart.product_id = products.id
WHERE cart.user_id='$user_id'
");

$total = 0;

while($row = mysqli_fetch_assoc($result)){
    $total += $row['price'] * $row['quantity'];
}

if($total == 0){
    echo "<h2>Your Cart is Empty!</h2>";
    echo "<a href='products.php'>Continue Shopping</a>";
    exit();
}

// Place Order
if(isset($_POST['place_order'])){

    $customer_name = mysqli_real_escape_string($conn, $_POST['customer_name']);
    $phone         = mysqli_real_escape_string($conn, $_POST['phone']);
    $address       = mysqli_real_escape_string($conn, $_POST['address']);
    $city          = mysqli_real_escape_string($conn, $_POST['city']);
    $pincode       = mysqli_real_escape_string($conn, $_POST['pincode']);
    $payment       = mysqli_real_escape_string($conn, $_POST['payment_method']);

    // Get cart items with current stock
    $cart = mysqli_query($conn,"
        SELECT cart.product_id,
               cart.quantity,
               products.name,
               products.price,
               products.stock
        FROM cart
        JOIN products
        ON cart.product_id = products.id
        WHERE cart.user_id='$user_id'
    ");

    // Check stock before creating order
    while($item = mysqli_fetch_assoc($cart)){

        if($item['quantity'] > $item['stock']){

            echo "<h3 style='color:red;'>Not enough stock!</h3>";
            echo "<p>".$item['name']." has only ".$item['stock']." item(s) available.</p>";
            echo "<a href='cart.php'>Go Back to Cart</a>";
            exit();
        }
    }

    // Start transaction
    mysqli_begin_transaction($conn);

    try {

        // Create order
        $order_query = mysqli_query($conn,"
            INSERT INTO orders
            (
                user_id,
                total,
                payment_method,
                status,
                customer_name,
                phone,
                address,
                city,
                pincode
            )
            VALUES
            (
                '$user_id',
                '$total',
                '$payment',
                'Pending',
                '$customer_name',
                '$phone',
                '$address',
                '$city',
                '$pincode'
            )
        ");

        if(!$order_query){
            throw new Exception(mysqli_error($conn));
        }

        $order_id = mysqli_insert_id($conn);

        // Get cart items again
        $cart = mysqli_query($conn,"
            SELECT cart.product_id,
                   cart.quantity,
                   products.name,
                   products.price
            FROM cart
            JOIN products
            ON cart.product_id = products.id
            WHERE cart.user_id='$user_id'
        ");

        while($item = mysqli_fetch_assoc($cart)){

            $product_id = $item['product_id'];
            $quantity   = $item['quantity'];
            $name       = mysqli_real_escape_string($conn, $item['name']);
            $price      = $item['price'];

            // Save order item
            $item_query = mysqli_query($conn,"
                INSERT INTO order_items
                (
                    order_id,
                    product_id,
                    product_name,
                    quantity,
                    price
                )
                VALUES
                (
                    '$order_id',
                    '$product_id',
                    '$name',
                    '$quantity',
                    '$price'
                )
            ");

            if(!$item_query){
                throw new Exception(mysqli_error($conn));
            }

            // Reduce stock
            $stock_query = mysqli_query($conn,"
                UPDATE products
                SET stock = stock - $quantity
                WHERE id='$product_id'
                AND stock >= $quantity
            ");

            if(!$stock_query || mysqli_affected_rows($conn) == 0){
                throw new Exception("Stock update failed.");
            }
        }

        // Clear cart
        $clear_cart = mysqli_query($conn,"
            DELETE FROM cart
            WHERE user_id='$user_id'
        ");

        if(!$clear_cart){
            throw new Exception(mysqli_error($conn));
        }

        // Everything successful
        mysqli_commit($conn);

        header("Location: order_success.php");
        exit();

    } catch(Exception $e){

        // Cancel all database changes
        mysqli_rollback($conn);

        die("Order failed: " . $e->getMessage());
    }
}
// Place Order
if(isset($_POST['place_order'])){

    $customer_name = mysqli_real_escape_string($conn,$_POST['customer_name']);
    $phone         = mysqli_real_escape_string($conn,$_POST['phone']);
    $address       = mysqli_real_escape_string($conn,$_POST['address']);
    $city          = mysqli_real_escape_string($conn,$_POST['city']);
    $pincode       = mysqli_real_escape_string($conn,$_POST['pincode']);
    $payment       = mysqli_real_escape_string($conn,$_POST['payment_method']);

    mysqli_query($conn,"
    INSERT INTO orders
    (
    user_id,
    total,
    payment_method,
    status,
    customer_name,
    phone,
    address,
    city,
    pincode
    )
    VALUES
    (
    '$user_id',
    '$total',
    '$payment',
    'Pending',
    '$customer_name',
    '$phone',
    '$address',
    '$city',
    '$pincode'
    )
    ");

    $order_id = mysqli_insert_id($conn);

    // Save Order Items
    $cart = mysqli_query($conn,"
    SELECT cart.*, products.name, products.price
    FROM cart
    JOIN products
    ON cart.product_id = products.id
    WHERE cart.user_id='$user_id'
    ");

    while($item = mysqli_fetch_assoc($cart)){

        mysqli_query($conn,"
        INSERT INTO order_items
        (
        order_id,
        product_id,
        product_name,
        quantity,
        price
        )
        VALUES
        (
        '$order_id',
        '".$item['product_id']."',
        '".$item['name']."',
        '".$item['quantity']."',
        '".$item['price']."'
        )
        ");
    }

    // Clear Cart
    mysqli_query($conn,"
    DELETE FROM cart
    WHERE user_id='$user_id'
    ");

    header("Location: order_success.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Checkout</title>
</head>
<body>

<h2>Checkout</h2>

<p><strong>Total Amount:</strong> ₹<?php echo $total; ?></p>

<form method="POST">

<h3>Shipping Address</h3>

<input type="text" name="customer_name" placeholder="Full Name" required>

<br><br>

<input type="text" name="phone" placeholder="Phone Number" required>

<br><br>

<textarea name="address" placeholder="Full Address" required></textarea>

<br><br>

<input type="text" name="city" placeholder="City" required>

<br><br>

<input type="text" name="pincode" placeholder="Pincode" required>

<br><br>

<h3>Select Payment Method</h3>

<label>
<input type="radio" name="payment_method"
value="Cash on Delivery" checked>
Cash on Delivery
</label>

<br><br>

<label>
<input type="radio" name="payment_method"
value="Online Payment">
Online Payment
</label>

<br><br>

<input type="submit"
name="place_order"
value="Place Order">

</form>

</body>
</html>