<?php
include 'includes/db.php';
include 'includes/header.php';

$cart = isset($_SESSION['cart']) ? $_SESSION['cart'] : [];

if (isset($_POST['remove'])) {
    $remove_id = intval($_POST['remove']);
    if (isset($cart[$remove_id])) {
        unset($cart[$remove_id]);
        $_SESSION['cart'] = $cart;
        echo "<script>alert('Item removed from cart');</script>";
    }
}

if (isset($_POST['update'])) {
    foreach ($_POST['quantities'] as $id => $qty) {
        $qty = intval($qty);
        if ($qty < 1) $qty = 1;
        if (isset($cart[$id])) {
            $cart[$id] = $qty;
        }
    }
    $_SESSION['cart'] = $cart;
    echo "<script>alert('Cart updated');</script>";
}

if (empty($cart)) {
    echo "<p>Your cart is empty.</p>";
    include 'includes/footer.php';
    exit();
}

$ids = implode(',', array_keys($cart));
$sql = "SELECT * FROM products WHERE id IN ($ids)";
$result = $conn->query($sql);
?>

<h2>Your Cart</h2>
<form method="post" action="cart.php">
<table>
    <thead>
        <tr>
            <th>Product</th>
            <th>Price</th>
            <th>Quantity</th>
            <th>Subtotal</th>
            <th>Remove</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $total = 0;
        while($row = $result->fetch_assoc()):
            $pid = $row['id'];
            $qty = $cart[$pid];
            $subtotal = $row['price'] * $qty;
            $total += $subtotal;
        ?>
        <tr>
            <td><?php echo htmlspecialchars($row['name']); ?></td>
            <td>₹<?php echo number_format($row['price'], 2); ?></td>
            <td><input type="number" name="quantities[<?php echo $pid; ?>]" value="<?php echo $qty; ?>" min="1" /></td>
            <td>₹<?php echo number_format($subtotal, 2); ?></td>
            <td>
                <button type="submit" name="remove" value="<?php echo $pid; ?>">Remove</button>
            </td>
        </tr>
        <?php endwhile; ?>
    </tbody>
</table>

<p><strong>Total: ₹<?php echo number_format($total, 2); ?></strong></p>
<button type="submit" name="update">Update Cart</button>
<a href="checkout.php" class="btn-checkout">Proceed to Checkout</a>
</form>

<?php include 'includes/footer.php'; ?>
