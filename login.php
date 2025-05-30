<?php
include('includes/db.php');
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT id, password FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows == 1) {
        $stmt->bind_result($user_id, $hashed_pw);
        $stmt->fetch();

        if (password_verify($password, $hashed_pw)) {
            $_SESSION['user_id'] = $user_id;
            header('Location: index.php');
            exit();
        }
    }
    echo "<script>alert('Invalid credentials');</script>";
}
?>

<!DOCTYPE html>
<html>
<head><title>Login</title><link rel="stylesheet" href="css/style.css"></head>
<body>
<div class="form-container">
  <h2>Login</h2>
  <form method="POST">
    <input type="email" name="email" placeholder="Email" required>
    <input type="password" name="password" placeholder="Password" required>
    <button type="submit">Login</button>
    <p>Don't have an account? <a href="register.php">Register</a></p>
  </form>
</div>
</body>
</html>
