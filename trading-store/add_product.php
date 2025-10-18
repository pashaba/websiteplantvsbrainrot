<?php
session_start();
include 'db.php';
if (!isset($_SESSION['user'])) header("Location: index.php");
$user = $_SESSION['user'];

if (isset($_POST['upload'])) {
  $judul = $_POST['judul'];
  $harga = $_POST['harga'];
  $kontak = $_POST['kontak'];
  $stok = $_POST['stok'];
  $img = $_FILES['gambar']['name'];
  $tmp = $_FILES['gambar']['tmp_name'];

  $path = "uploads/" . basename($img);
  move_uploaded_file($tmp, $path);

  $conn->query("INSERT INTO products (user_id, judul, harga, kontak, stok, gambar) VALUES ('{$user['id']}', '$judul', '$harga', '$kontak', '$stok', '$img')");
  header("Location: dashboard.php");
}
?>
