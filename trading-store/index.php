<?php
session_start();
include 'db.php';

if (isset($_POST['login'])) {
  $email = $_POST['email'];
  $pass = $_POST['password'];

  $query = $conn->query("SELECT * FROM users WHERE email='$email' AND password='$pass'");
  if ($query->num_rows > 0) {
    $user = $query->fetch_assoc();
    $_SESSION['user'] = $user;
    header("Location: dashboard.php");
  } else {
    $error = "Email atau password salah!";
  }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Login | Trading Store</title>
<script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-900 text-white flex justify-center items-center h-screen">
<div class="bg-gray-800 p-8 rounded-2xl shadow-xl w-96">
  <h2 class="text-2xl font-bold mb-4 text-center">Login Akun</h2>
  <?php if(isset($error)) echo "<p class='text-red-500 mb-3'>$error</p>"; ?>
  <form method="post">
    <input type="email" name="email" placeholder="Email" required class="w-full mb-3 p-2 rounded bg-gray-700">
    <input type="password" name="password" placeholder="Password" required class="w-full mb-3 p-2 rounded bg-gray-700">
    <button name="login" class="bg-blue-600 hover:bg-blue-700 w-full p-2 rounded">Login</button>
  </form>
  <p class="mt-3 text-sm text-center">Belum punya akun? <a href="register.php" class="text-blue-400">Daftar</a></p>
</div>
</body>
</html>
