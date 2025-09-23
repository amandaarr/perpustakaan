<?php
include 'koneksi.php';
$id = $_GET['id'] ?? '';
if (!$id) { header("Location: anggota.php"); exit; }

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama = trim($_POST['nama_anggota'] ?? '');
    $no_hp = trim($_POST['no_hp'] ?? '');
    $alamat = trim($_POST['alamat'] ?? '');
    if ($nama === '') $error = "Nama harus diisi.";
    else {
        $stmt = $koneksi->prepare("UPDATE anggota SET nama_anggota=?, no_hp=?, alamat=? WHERE id_anggota=?");
        $stmt->bind_param("ssss", $nama, $no_hp, $alamat, $id);
        if ($stmt->execute()) header("Location: anggota.php"); else $error = "Gagal update.";
    }
}

$stmt = $koneksi->prepare("SELECT * FROM anggota WHERE id_anggota=?");
$stmt->bind_param("s",$id);
$stmt->execute();
$data = $stmt->get_result()->fetch_assoc();
if (!$data) { header("Location: anggota.php"); exit; }

include 'header.php';
?>
<h2>Edit Anggota</h2>
<?php if ($error): ?><div class="alert alert-danger"><?= $error ?></div><?php endif; ?>
<div class="card p-3">
<form method="post">
  <div class="mb-3"><label class="form-label">ID</label><input class="form-control" value="<?=htmlspecialchars($data['id_anggota'])?>" disabled></div>
  <div class="mb-3"><label class="form-label">Nama</label><input class="form-control" name="nama_anggota" value="<?=htmlspecialchars($data['nama_anggota'])?>" required></div>
  <div class="mb-3"><label class="form-label">No HP</label><input class="form-control" name="no_hp" value="<?=htmlspecialchars($data['no_hp'])?>"></div>
  <div class="mb-3"><label class="form-label">Alamat</label><input class="form-control" name="alamat" value="<?=htmlspecialchars($data['alamat'])?>"></div>
  <button class="btn btn-primary">Update</button>
  <a href="anggota.php" class="btn btn-secondary">Batal</a>
</form>
</div>
<?php include 'footer.php'; ?>
