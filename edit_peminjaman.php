<?php
include 'koneksi.php';
$id = $_GET['id'] ?? '';
if (!$id) { header("Location: peminjaman.php"); exit; }

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_anggota = $_POST['id_anggota'] ?? '';
    $id_buku = $_POST['id_buku'] ?? '';
    $tgl_pinjam = $_POST['tgl_pinjam'] ?? null;
    $tgl_kembali = $_POST['tgl_kembali'] ?? null;

    $tp = $tgl_pinjam === '' ? null : str_replace('T',' ',$tgl_pinjam).':00';
    $tk = $tgl_kembali === '' ? null : str_replace('T',' ',$tgl_kembali).':00';

    $stmt = $koneksi->prepare("UPDATE peminjaman SET id_anggota=?, id_buku=?, tgl_pinjam=?, tgl_kembali=? WHERE id_peminjaman=?");
    $stmt->bind_param("sssss", $id_anggota, $id_buku, $tp, $tk, $id);
    if ($stmt->execute()) header("Location: peminjaman.php"); else $error="Gagal update.";
}

$stmt = $koneksi->prepare("SELECT * FROM peminjaman WHERE id_peminjaman=?");
$stmt->bind_param("s",$id); $stmt->execute();
$data = $stmt->get_result()->fetch_assoc();
if (!$data) { header("Location: peminjaman.php"); exit; }

$anggotaRes = $koneksi->query("SELECT id_anggota, nama_anggota FROM anggota ORDER BY id_anggota");
$bukuRes = $koneksi->query("SELECT id_buku, judul FROM buku ORDER BY id_buku");

function dt_to_input($dt) {
    if (!$dt) return '';
    return str_replace(' ', 'T', substr($dt,0,16));
}

include 'header.php';
?>
<h2>Edit Peminjaman</h2>
<?php if ($error): ?><div class="alert alert-danger"><?=$error?></div><?php endif; ?>
<div class="card p-3">
<form method="post">
  <div class="mb-3"><label class="form-label">ID</label><input class="form-control" value="<?=htmlspecialchars($data['id_peminjaman'])?>" disabled></div>

  <div class="mb-3"><label class="form-label">Anggota</label>
    <select class="form-select" name="id_anggota" required>
      <?php while($a = $anggotaRes->fetch_assoc()): $sel = $a['id_anggota']==$data['id_anggota'] ? 'selected' : ''; ?>
        <option <?=$sel?> value="<?=htmlspecialchars($a['id_anggota'])?>"><?=htmlspecialchars($a['id_anggota'].' - '.$a['nama_anggota'])?></option>
      <?php endwhile; ?>
    </select>
  </div>

  <div class="mb-3"><label class="form-label">Buku</label>
    <select class="form-select" name="id_buku" required>
      <?php while($b = $bukuRes->fetch_assoc()): $sel = $b['id_buku']==$data['id_buku'] ? 'selected' : ''; ?>
        <option <?=$sel?> value="<?=htmlspecialchars($b['id_buku'])?>"><?=htmlspecialchars($b['id_buku'].' - '.$b['judul'])?></option>
      <?php endwhile; ?>
    </select>
  </div>

  <div class="mb-3"><label class="form-label">Tgl Pinjam</label><input class="form-control" type="datetime-local" name="tgl_pinjam" value="<?=dt_to_input($data['tgl_pinjam'])?>"></div>
  <div class="mb-3"><label class="form-label">Tgl Kembali</label><input class="form-control" type="datetime-local" name="tgl_kembali" value="<?=dt_to_input($data['tgl_kembali'])?>"></div>

  <button class="btn btn-primary">Update</button>
  <a href="peminjaman.php" class="btn btn-secondary">Batal</a>
</form>
</div>
<?php include 'footer.php'; ?>
