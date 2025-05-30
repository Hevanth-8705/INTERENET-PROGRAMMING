<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<title>Online E-Commerce Business</title>
<link rel="stylesheet" href="css/style.css" />
</head>
<body>
<header>
  <div class="container">
    <h1><a href="menu.php">E-Shop</a></h1>
    <nav>
      <ul>
        <li><a href="menu.php">Menu</a></li>
        <li><a href="cart.php">Cart (<?php echo isset($_SESSION['cart']) ? count($_SESSION['cart']) : 0; ?>)</a></li>
        <li><a href="track_order.php">Track Order</a></li>
        <?php if (isset($_SESSION['user'])): ?>
          <li><a href="logout.php">Logout</a></li>
        <?php else: ?>
          <li><a href="login.php">Login</a></li>
          <li><a href="register.php">Register</a></li>
        <?php endif; ?>
      </ul>
    </nav>
  </div>
</header>
<main class="container">
