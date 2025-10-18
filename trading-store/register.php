<?php
include 'db.php';

if (isset($_POST['register'])) {
  $nama = $_POST['nama'];
  $email = $_POST['email'];
  $pass = $_POST['password'];

  $cek = $conn->query("SELECT * FROM users WHERE email='$email'");
  if ($cek->num_rows > 0) {
    $error = "Email sudah digunakan!";
  } else {
    $conn->query("INSERT INTO users (nama, email, password) VALUES ('$nama', '$email', '$pass')");
    header("Location: index.php");
  }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Register | Trading Store</title>
<script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-900 text-white flex justify-center items-center h-screen">
<div class="bg-gray-800 p-8 rounded-2xl shadow-xl w-96">
  <h2 class="text-2xl font-bold mb-4 text-center">Buat Akun</h2>
  <?php if(isset($error)) echo "<p class='text-red-500 mb-3'>$error</p>"; ?>
  <form method="post">
    <input type="text" name="nama" placeholder="Nama Lengkap" required class="w-full mb-3 p-2 rounded bg-gray-700">
    <input type="email" name="email" placeholder="Email" required class="w-full mb-3 p-2 rounded bg-gray-700">
    <input type="password" name="password" placeholder="Password" required class="w-full mb-3 p-2 rounded bg-gray-700">
    <button name="register" class="bg-green-600 hover:bg-green-700 w-full p-2 rounded">Daftar</button>
  </form>
  <p class="mt-3 text-sm text-center">Sudah punya akun? <a href="index.php" class="text-blue-400">Login</a></p>
</div>
</body>
</html>
