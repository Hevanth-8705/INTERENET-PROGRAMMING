<?php 
include('../includes/db.php'); 
include('../includes/header.php'); 
session_start();

// Auto admin session for demo
if (!isset($_SESSION['admin_logged_in'])) {
    $_SESSION['admin_logged_in'] = true;
}

// Fetch product count
$productCount = $conn->query("SELECT COUNT(*) as total FROM products")->fetch_assoc()['total'];

// Fetch user count
$userCount = $conn->query("SELECT COUNT(*) as total FROM users")->fetch_assoc()['total'];
?>

<div class="form-container">
    <h2>Admin Dashboard</h2>
    <p><strong>Total Products:</strong> <?php echo $productCount; ?></p>
    <p><strong>Total Users:</strong> <?php echo $userCount; ?></p>
    <a href="add_product.php"><button>Add New Product</button></a>
</div>

<?php include('../includes/footer.php'); ?>
