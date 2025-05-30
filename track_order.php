<?php
session_start();
include 'includes/db.php';
include 'includes/header.php';

$order_info = null;
$order_items = [];

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['order_id'])) {
    $order_id = intval($_POST['order_id']);

    $order_sql = $conn->prepare("SELECT * FROM orders WHERE id = ?");
    $order_sql->bind_param("i", $order_id);
    $order_sql->execute();
    $order_result = $order_sql->get_result();
    $order_info = $order_result->fetch_assoc();
    $order_sql->close();

    if ($order_info) {
        $items_sql = $conn->prepare("
            SELECT p.name, oi.quantity, oi.price
            FROM order_items oi
            JOIN products p ON oi.product_id = p.id
            WHERE oi.order_id = ?");
        $items_sql->bind_param("i", $order_id);
        $items_sql->execute();
        $items_result = $items_sql->get_result();

        while ($row = $items_result->fetch_assoc()) {
            $order_items[] = $row;
        }
        $items_sql->close();
    }
}
?>

<h2>Track Your Order</h2>

<form method="post" action="track_order.php">
    <label>Enter Your Order ID:</label><br />
    <input type="number" name="order_id" required />
    <button type="submit">Track</button>
</form>

<?php if ($order_info): ?>
    <h3>Order Details</h3>
    <p><strong>Order ID:</strong> <?php echo $order_info['id']; ?></p>
    <p><strong>Name:</strong> <?php echo htmlspecialchars($order_info['customer_name']); ?></p>
    <p><strong>Address:</strong> <?php echo nl2br(htmlspecialchars($order_info['address'])); ?></p>
    <p><strong>Phone:</strong> <?php echo htmlspecialchars($order_info['phone']); ?></p>
    <p><strong>Order Date:</strong> <?php echo $order_info['order_date']; ?></p>

    <h4>Items</h4>
    <ul>
        <?php foreach ($order_items as $item): ?>
            <li>
                <?php echo htmlspecialchars($item['name']); ?> - Qty: <?php echo $item['quantity']; ?> - Price: ₹<?php echo number_format($item['price'], 2); ?>
            </li>
        <?php endforeach; ?>
    </ul>

<?php elseif ($_SERVER['REQUEST_METHOD'] == 'POST'): ?>
    <p>Order not found. Please check your Order ID.</p>
<?php endif; ?>

<?php include 'includes/footer.php'; ?>
