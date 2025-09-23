<?php
include 'koneksi.php';
$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = trim($_POST['id_buku'] ?? '');
    $judul = trim($_POST['judul'] ?? '');
    $pengarang = trim($_POST['pengarang'] ?? '');
    if ($id==='' || $judul==='') $error="ID dan Judul harus diisi.";
    else {
        $stmt = $koneksi->prepare("INSERT INTO buku (id_buku, judul, pengarang) VALUES (?, ?, ?)");
        $stmt->bind_param("sss",$id,$judul,$pengarang);
        if ($stmt->execute()) header("Location: buku.php"); else $error="Gagal: ".htmlspecialchars($koneksi->error);
    }
}
include 'header.php';
?>
<h2>Tambah Buku</h2>
<?php if ($error): ?><div class="alert alert-danger"><?= $error ?></div><?php endif; ?>
<div class="card p-3">
<form method="post">
  <div class="mb-3"><label class="form-label">ID Buku</label><input class="form-control" name="id_buku" required></div>
  <div class="mb-3"><label class="form-label">Judul</label><input class="form-control" name="judul" required></div>
  <div class="mb-3"><label class="form-label">Pengarang</label><input class="form-control" name="pengarang"></div>
  <button class="btn btn-success">Simpan</button>
  <a href="buku.php" class="btn btn-secondary">Batal</a>
</form>
</div>
<?php include 'footer.php'; ?>
