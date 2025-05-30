<?php
include 'includes/db.php';
include 'includes/header.php';

$sql = "SELECT * FROM products";
$result = $conn->query($sql);

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['product_id'])) {
    $product_id = intval($_POST['product_id']);
    $qty = intval($_POST['quantity']);
    if ($qty < 1) $qty = 1;
    if (isset($_SESSION['cart'][$product_id])) {
        $_SESSION['cart'][$product_id] += $qty;
    } else {
        $_SESSION['cart'][$product_id] = $qty;
    }
    echo "<script>alert('Product added to cart!');</script>";
}
?>

<h2>Products</h2>
<div class="products">
    <?php while($row = $result->fetch_assoc()): ?>
    <div class="product-card">
        <img src="images/<?php echo htmlspecialchars($row['image']); ?>" alt="<?php echo htmlspecialchars($row['name']); ?>" />
        <h3><?php echo htmlspecialchars($row['name']); ?></h3>
        <p><?php echo htmlspecialchars($row['description']); ?></p>
        <p><strong>₹<?php echo number_format($row['price'], 2); ?></strong></p>
        <form method="post" action="menu.php">
            <input type="hidden" name="product_id" value="<?php echo $row['id']; ?>" />
            <input type="number" name="quantity" value="1" min="1" />
            <button type="submit">Add to Cart</button>
        </form>
    </div>
    <?php endwhile; ?>
</div>

<?php include 'includes/footer.php'; ?>
