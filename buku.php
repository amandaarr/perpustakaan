<?php
include 'koneksi.php';
include 'header.php';

$stmt = $koneksi->prepare("SELECT id_buku, judul, pengarang FROM buku ORDER BY id_buku");
$stmt->execute();
$res = $stmt->get_result();
?>
<div class="d-flex justify-content-between align-items-center mb-3">
  <h2>Data Buku</h2>
  <a href="tambah_buku.php" class="btn btn-success">+ Tambah Buku</a>
</div>

<div class="card p-3">
<table class="table table-striped mb-0">
  <thead><tr><th>ID</th><th>Judul</th><th>Pengarang</th><th>Aksi</th></tr></thead>
  <tbody>
    <?php while($r = $res->fetch_assoc()): ?>
    <tr>
      <td><?= htmlspecialchars($r['id_buku']) ?></td>
      <td><?= htmlspecialchars($r['judul']) ?></td>
      <td><?= htmlspecialchars($r['pengarang']) ?></td>
      <td>
        <a class="btn btn-sm btn-primary" href="edit_buku.php?id=<?= urlencode($r['id_buku']) ?>">Edit</a>
        <a class="btn btn-sm btn-danger" href="hapus_buku.php?id=<?= urlencode($r['id_buku']) ?>" onclick="return confirm('Yakin hapus buku?')">Hapus</a>
      </td>
    </tr>
    <?php endwhile; ?>
  </tbody>
</table>
</div>

<?php include 'footer.php'; ?>
