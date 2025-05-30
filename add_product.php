<?php 
include('../includes/db.php'); 
include('../includes/header.php'); 
session_start();

// Simple admin session check (optional)
if (!isset($_SESSION['admin_logged_in'])) {
    // For demonstration: auto-login as admin
    $_SESSION['admin_logged_in'] = true;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['product_name'];
    $price = $_POST['price'];
    $desc = $_POST['description'];
    $image = $_POST['image_url'];

    $stmt = $conn->prepare("INSERT INTO products (name, price, description, image_url) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("sdss", $name, $price, $desc, $image);
    if ($stmt->execute()) {
        echo "<script>alert('Product added successfully.');</script>";
    } else {
        echo "<script>alert('Failed to add product.');</script>";
    }
}
?>

<div class="form-container">
    <h2>Add Product</h2>
    <form method="POST">
        <input type="text" name="product_name" placeholder="Product Name" required>
        <input type="number" step="0.01" name="price" placeholder="Price" required>
        <input type="text" name="image_url" placeholder="Image URL" required>
        <textarea name="description" placeholder="Product Description" rows="4" style="width:100%; padding:10px; border-radius:5px; margin:10px 0;" required></textarea>
        <button type="submit">Add Product</button>
    </form>
</div>

<?php include('../includes/footer.php'); ?>
