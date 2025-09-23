<?php
include 'koneksi.php';
$id = $_GET['id'] ?? '';
if ($id) {
    // cek relasi pada peminjaman
    $stmt = $koneksi->prepare("SELECT COUNT(*) AS cnt FROM peminjaman WHERE id_anggota=?");
    $stmt->bind_param("s",$id); $stmt->execute();
    $cnt = $stmt->get_result()->fetch_assoc()['cnt'] ?? 0;
    if ($cnt > 0) {
        echo "<script>alert('Tidak dapat menghapus: anggota masih memiliki peminjaman.');window.location='anggota.php';</script>";
        exit;
    }
    $stmt2 = $koneksi->prepare("DELETE FROM anggota WHERE id_anggota=?");
    $stmt2->bind_param("s",$id);
    $stmt2->execute();
}
header("Location: anggota.php");
exit;
