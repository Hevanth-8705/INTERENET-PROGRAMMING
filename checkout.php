<?php
session_start();
include 'includes/db.php';
include 'includes/header.php';

$cart = isset($_SESSION['cart']) ? $_SESSION['cart'] : [];

if (empty($cart)) {
    echo "<p>Your cart is empty. <a href='menu.php'>Go shopping</a></p>";
    include 'includes/footer.php';
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = trim($_POST['name']);
    $address = trim($_POST['address']);
    $phone = trim($_POST['phone']);

    if (!$name || !$address || !$phone) {
        echo "<p>Please fill all fields.</p>";
    } else {
        // Insert order info
        $stmt = $conn->prepare("INSERT INTO orders (customer_name, address, phone) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $name, $address, $phone);
        $stmt->execute();
        $order_id = $stmt->insert_id;
        $stmt->close();

        // Insert order items
        $stmt2 = $conn->prepare("INSERT INTO order_items (order_id, product_id, quantity, price) VALUES (?, ?, ?, ?)");
        
        foreach ($cart as $pid => $qty) {
            $price_sql = $conn->prepare("SELECT price FROM products WHERE id = ?");
            $price_sql->bind_param("i", $pid);
            $price_sql->execute();
            $price_result = $price_sql->get_result()->fetch_assoc();
            $price_sql->close();
            $price = $price_result['price'];

            $stmt2->bind_param("iiid", $order_id, $pid, $qty, $price);
            $stmt2->execute();
        }
        $stmt2->close();

        // Clear cart
        unset($_SESSION['cart']);

        echo "<p>Order placed successfully! Your Order ID is <strong>$order_id</strong>.</p>";
        echo "<p><a href='menu.php'>Continue Shopping</a></p>";
        include 'includes/footer.php';
        exit();
    }
}
?>

<h2>Checkout</h2>
<form method="post" action="checkout.php">
    <label>Name:</label><br />
    <input type="text" name="name" required /><br />

    <label>Address:</label><br />
    <textarea name="address" required></textarea><br />

    <label>Phone:</label><br />
    <input type="tel" name="phone" required /><br />

    <button type="submit">Place Order</button>
</form>

<?php include 'includes/footer.php'; ?>
