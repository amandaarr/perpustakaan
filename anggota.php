<?php
include 'koneksi.php';
include 'header.php';

$stmt = $koneksi->prepare("SELECT id_anggota, nama_anggota, no_hp, alamat FROM anggota ORDER BY id_anggota");
$stmt->execute();
$res = $stmt->get_result();
?>
<div class="d-flex justify-content-between align-items-center mb-3">
  <h2>Data Anggota</h2>
  <a href="tambah_anggota.php" class="btn btn-success">+ Tambah Anggota</a>
</div>

<div class="card p-3">
  <table class="table table-striped mb-0">
    <thead><tr><th>ID</th><th>Nama</th><th>No HP</th><th>Alamat</th><th>Aksi</th></tr></thead>
    <tbody>
      <?php while($row = $res->fetch_assoc()): ?>
      <tr>
        <td><?= htmlspecialchars($row['id_anggota']) ?></td>
        <td><?= htmlspecialchars($row['nama_anggota']) ?></td>
        <td><?= htmlspecialchars($row['no_hp']) ?></td>
        <td><?= htmlspecialchars($row['alamat']) ?></td>
        <td>
          <a class="btn btn-sm btn-primary" href="edit_anggota.php?id=<?= urlencode($row['id_anggota']) ?>">Edit</a>
          <a class="btn btn-sm btn-danger" href="hapus_anggota.php?id=<?= urlencode($row['id_anggota']) ?>" onclick="return confirm('Yakin hapus anggota?')">Hapus</a>
        </td>
      </tr>
      <?php endwhile; ?>
    </tbody>
  </table>
</div>

<?php include 'footer.php'; ?>
