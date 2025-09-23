<?php
include 'koneksi.php';
include 'header.php';

$sql = "SELECT p.id_peminjaman, p.id_anggota, a.nama_anggota, p.id_buku, b.judul, p.tgl_pinjam, p.tgl_kembali
        FROM peminjaman p
        LEFT JOIN anggota a ON p.id_anggota = a.id_anggota
        LEFT JOIN buku b ON p.id_buku = b.id_buku
        ORDER BY p.id_peminjaman";
$res = $koneksi->query($sql);
?>
<div class="d-flex justify-content-between align-items-center mb-3">
  <h2>Data Peminjaman</h2>
  <a href="tambah_peminjaman.php" class="btn btn-success">+ Tambah Peminjaman</a>
</div>

<div class="card p-3">
<table class="table table-striped mb-0">
  <thead><tr><th>ID</th><th>Anggota</th><th>Buku</th><th>Tgl Pinjam</th><th>Tgl Kembali</th><th>Aksi</th></tr></thead>
  <tbody>
    <?php while($r = $res->fetch_assoc()): ?>
    <tr>
      <td><?= htmlspecialchars($r['id_peminjaman']) ?></td>
      <td><?= htmlspecialchars($r['id_anggota'].' - '.$r['nama_anggota']) ?></td>
      <td><?= htmlspecialchars($r['id_buku'].' - '.$r['judul']) ?></td>
      <td><?= htmlspecialchars($r['tgl_pinjam']) ?></td>
      <td><?= htmlspecialchars($r['tgl_kembali']) ?></td>
      <td>
        <a class="btn btn-sm btn-primary" href="edit_peminjaman.php?id=<?= urlencode($r['id_peminjaman']) ?>">Edit</a>
        <a class="btn btn-sm btn-danger" href="hapus_peminjaman.php?id=<?= urlencode($r['id_peminjaman']) ?>" onclick="return confirm('Yakin hapus peminjaman?')">Hapus</a>
      </td>
    </tr>
    <?php endwhile; ?>
  </tbody>
</table>
</div>

<?php include 'footer.php'; ?>
