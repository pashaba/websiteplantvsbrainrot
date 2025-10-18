<?php
session_start();
include 'db.php';
if (!isset($_SESSION['user'])) header("Location: index.php");
$user = $_SESSION['user'];

// Ambil produk user
$produk = $conn->query("SELECT * FROM products WHERE user_id='{$user['id']}' ORDER BY id DESC");
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Dashboard | Trading Store</title>
<script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-900 text-white">
<div class="p-6">
  <div class="flex justify-between items-center mb-5">
    <h1 class="text-3xl font-bold">Selamat Datang, <?= $user['nama'] ?></h1>
    <a href="logout.php" class="bg-red-600 px-4 py-2 rounded">Logout</a>
  </div>

  <form action="add_product.php" method="POST" enctype="multipart/form-data" class="bg-gray-800 p-5 rounded mb-5">
    <h2 class="text-xl font-semibold mb-3">Tambah Produk</h2>
    <input type="text" name="judul" placeholder="Judul Produk" required class="w-full mb-2 p-2 rounded bg-gray-700">
    <input type="number" name="harga" placeholder="Harga (Rp)" required class="w-full mb-2 p-2 rounded bg-gray-700">
    <input type="text" name="kontak" placeholder="Nomor WhatsApp" required class="w-full mb-2 p-2 rounded bg-gray-700">
    <input type="number" name="stok" placeholder="Stok" required class="w-full mb-2 p-2 rounded bg-gray-700">
    <input type="file" name="gambar" accept="image/*" required class="w-full mb-2">
    <button name="upload" class="bg-blue-600 hover:bg-blue-700 p-2 rounded w-full">Upload Produk</button>
  </form>

  <h2 class="text-xl font-semibold mb-3">Produk Saya</h2>
  <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
    <?php while($row = $produk->fetch_assoc()): ?>
      <div class="bg-gray-800 p-4 rounded">
        <img src="uploads/<?= $row['gambar'] ?>" class="w-full h-40 object-cover rounded mb-3">
        <h3 class="font-bold"><?= $row['judul'] ?></h3>
        <p>Harga: Rp<?= number_format($row['harga'],0,',','.') ?></p>
        <p>Stok: <?= $row['stok'] ?></p>
        <p>Kontak: <?= $row['kontak'] ?></p>
      </div>
    <?php endwhile; ?>
  </div>
</div>
</body>
</html>
