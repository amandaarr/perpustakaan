<?php
include 'koneksi.php';
$id = $_GET['id'] ?? '';
if (!$id) { header("Location: buku.php"); exit; }

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $judul = trim($_POST['judul'] ?? '');
    $pengarang = trim($_POST['pengarang'] ?? '');
    if ($judul==='') $error = "Judul harus diisi.";
    else {
        $stmt = $koneksi->prepare("UPDATE buku SET judul=?, pengarang=? WHERE id_buku=?");
        $stmt->bind_param("sss",$judul,$pengarang,$id);
        if ($stmt->execute()) header("Location: buku.php"); else $error="Gagal update.";
    }
}

$stmt = $koneksi->prepare("SELECT * FROM buku WHERE id_buku=?");
$stmt->bind_param("s",$id);
$stmt->execute();
$data = $stmt->get_result()->fetch_assoc();
if (!$data) { header("Location: buku.php"); exit; }

include 'header.php';
?>
<h2>Edit Buku</h2>
<?php if ($error): ?><div class="alert alert-danger"><?= $error ?></div><?php endif; ?>
<div class="card p-3">
<form method="post">
  <div class="mb-3"><label class="form-label">ID</label><input class="form-control" value="<?=htmlspecialchars($data['id_buku'])?>" disabled></div>
  <div class="mb-3"><label class="form-label">Judul</label><input class="form-control" name="judul" value="<?=htmlspecialchars($data['judul'])?>" required></div>
  <div class="mb-3"><label class="form-label">Pengarang</label><input class="form-control" name="pengarang" value="<?=htmlspecialchars($data['pengarang'])?>"></div>
  <button class="btn btn-primary">Update</button>
  <a href="buku.php" class="btn btn-secondary">Batal</a>
</form>
</div>
<?php include 'footer.php'; ?>
