<?php
include 'koneksi.php';

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = trim($_POST['id_anggota'] ?? '');
    $nama = trim($_POST['nama_anggota'] ?? '');
    $no_hp = trim($_POST['no_hp'] ?? '');
    $alamat = trim($_POST['alamat'] ?? '');

    if ($id === '' || $nama === '') $error = "ID dan Nama harus diisi.";
    else {
        $stmt = $koneksi->prepare("INSERT INTO anggota (id_anggota, nama_anggota, no_hp, alamat) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $id, $nama, $no_hp, $alamat);
        if ($stmt->execute()) header("Location: anggota.php");
        else $error = "Gagal menyimpan: " . htmlspecialchars($koneksi->error);
    }
}

include 'header.php';
?>
<h2>Tambah Anggota</h2>
<?php if ($error): ?><div class="alert alert-danger"><?= $error ?></div><?php endif; ?>
<div class="card p-3">
<form method="post">
  <div class="mb-3"><label class="form-label">ID Anggota</label><input class="form-control" name="id_anggota" required></div>
  <div class="mb-3"><label class="form-label">Nama</label><input class="form-control" name="nama_anggota" required></div>
  <div class="mb-3"><label class="form-label">No HP</label><input class="form-control" name="no_hp"></div>
  <div class="mb-3"><label class="form-label">Alamat</label><input class="form-control" name="alamat"></div>
  <button class="btn btn-success">Simpan</button>
  <a href="anggota.php" class="btn btn-secondary">Batal</a>
</form>
</div>
<?php include 'footer.php'; ?>
