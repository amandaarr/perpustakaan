<?php
include 'koneksi.php';
$error = '';

$anggotaRes = $koneksi->query("SELECT id_anggota, nama_anggota FROM anggota ORDER BY id_anggota");
$bukuRes = $koneksi->query("SELECT id_buku, judul FROM buku ORDER BY id_buku");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = trim($_POST['id_peminjaman'] ?? '');
    $id_anggota = $_POST['id_anggota'] ?? '';
    $id_buku = $_POST['id_buku'] ?? '';
    $tgl_pinjam = $_POST['tgl_pinjam'] ?? null;
    $tgl_kembali = $_POST['tgl_kembali'] ?? null;

    if ($id==='' || $id_anggota==='' || $id_buku==='') $error="ID / Anggota / Buku wajib diisi.";
    else {
        // convert empty to null
        $tp = $tgl_pinjam==='' ? null : str_replace('T',' ',$tgl_pinjam).':00';
        $tk = $tgl_kembali==='' ? null : str_replace('T',' ',$tgl_kembali).':00';
        $stmt = $koneksi->prepare("INSERT INTO peminjaman (id_peminjaman, id_anggota, id_buku, tgl_pinjam, tgl_kembali) VALUES (?,?,?,?,?)");
        $stmt->bind_param("sssss", $id, $id_anggota, $id_buku, $tp, $tk);
        if ($stmt->execute()) header("Location: peminjaman.php"); else $error="Gagal: ".htmlspecialchars($koneksi->error);
    }
}

include 'header.php';
?>
<h2>Tambah Peminjaman</h2>
<?php if ($error): ?><div class="alert alert-danger"><?= $error ?></div><?php endif; ?>
<div class="card p-3">
<form method="post">
  <div class="mb-3"><label class="form-label">ID Peminjaman</label><input class="form-control" name="id_peminjaman" required></div>

  <div class="mb-3"><label class="form-label">Anggota</label>
    <select class="form-select" name="id_anggota" required>
      <option value="">-- Pilih Anggota --</option>
      <?php foreach($anggotaRes as $a): ?>
        <option value="<?=htmlspecialchars($a['id_anggota'])?>"><?=htmlspecialchars($a['id_anggota'].' - '.$a['nama_anggota'])?></option>
      <?php endforeach; ?>
    </select>
  </div>

  <div class="mb-3"><label class="form-label">Buku</label>
    <select class="form-select" name="id_buku" required>
      <option value="">-- Pilih Buku --</option>
      <?php foreach($bukuRes as $b): ?>
        <option value="<?=htmlspecialchars($b['id_buku'])?>"><?=htmlspecialchars($b['id_buku'].' - '.$b['judul'])?></option>
      <?php endforeach; ?>
    </select>
  </div>

  <div class="mb-3"><label class="form-label">Tgl Pinjam</label><input class="form-control" type="datetime-local" name="tgl_pinjam"></div>
  <div class="mb-3"><label class="form-label">Tgl Kembali</label><input class="form-control" type="datetime-local" name="tgl_kembali"></div>

  <button class="btn btn-success">Simpan</button>
  <a href="peminjaman.php" class="btn btn-secondary">Batal</a>
</form>
</div>
<?php include 'footer.php'; ?>
