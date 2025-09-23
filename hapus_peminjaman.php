<?php
include 'koneksi.php';
$id = $_GET['id'] ?? '';
if ($id) {
    $stmt = $koneksi->prepare("DELETE FROM peminjaman WHERE id_peminjaman=?");
    $stmt->bind_param("s",$id);
    $stmt->execute();
}
header("Location: peminjaman.php");
exit;
