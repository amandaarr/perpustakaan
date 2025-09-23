<?php
include 'koneksi.php';
$id = $_GET['id'] ?? '';
if ($id) {
    // cek relasi peminjaman
    $stmt = $koneksi->prepare("SELECT COUNT(*) AS cnt FROM peminjaman WHERE id_buku=?");
    $stmt->bind_param("s",$id); $stmt->execute();
    $cnt = $stmt->get_result()->fetch_assoc()['cnt'] ?? 0;
    if ($cnt > 0) {
        echo "<script>alert('Tidak bisa hapus: buku masih dipinjam.');window.location='buku.php';</script>";
        exit;
    }
    $stmt2 = $koneksi->prepare("DELETE FROM buku WHERE id_buku=?");
    $stmt2->bind_param("s",$id); $stmt2->execute();
}
header("Location: buku.php"); exit;
