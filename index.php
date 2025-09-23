<?php include "header.php"; ?>
<div class="text-center">
  <h1 class="mb-4">Selamat Datang di Sistem Perpustakaan 📚</h1>
  <div class="row">
    <div class="col-md-4">
      <div class="card p-4 bg-primary text-white">
        <h3>Data Anggota</h3>
        <a href="anggota.php" class="btn btn-light mt-2">Lihat</a>
      </div>
    </div>
    <div class="col-md-4">
      <div class="card p-4 bg-info text-white">
        <h3>Data Buku</h3>
        <a href="buku.php" class="btn btn-light mt-2">Lihat</a>
      </div>
    </div>
    <div class="col-md-4">
      <div class="card p-4 bg-success text-white">
        <h3>Peminjaman</h3>
        <a href="peminjaman.php" class="btn btn-light mt-2">Lihat</a>
      </div>
    </div>
  </div>
</div>
<?php include "footer.php"; ?>
