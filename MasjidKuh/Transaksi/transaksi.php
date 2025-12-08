<?php
include "../config.php";


$keyword = $_POST['keyword'] ?? '';
if(!empty($keyword)){

    $query_str = "SELECT * FROM transaksi WHERE keterangan LIKE '%$keyword%' ORDER BY tanggal DESC";
} else {

    $query_str = "SELECT * FROM transaksi ORDER BY tanggal DESC";
}

$data = mysqli_query($konek, $query_str);
?>

<main class="app-main">
  <div class="app-content-header">
    <div class="container-fluid">
      <div class="row">
        <div class="col-sm-6"><h3 class="mb-0">Transaksi Kas Masjid</h3></div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-end">
            <li class="breadcrumb-item"><a href="index.php">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Data Transaksi</li>
          </ol>
        </div>
      </div>
    </div>
  </div>

  <div class="app-content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-header">
              <h3 class="card-title" style="font-weight: bold;">Data Pemasukan & Pengeluaran</h3>
              
              <table class="table table-borderless mb-0 mt-3">
                <tr>
              <div class="d-flex justify-content-end align-items-right mt-2">
                  <a href="./?p=add_tr" class="btn btn-success">
                      <i class="bi bi-plus-circle"></i> Tambah Transaksi
                  </a>

                  <form class="d-flex" method="POST" action="#">
                    <input style="width: 250px" class="form-control me-2" type="text" name="keyword" placeholder="Cari keterangan..." value="<?= $keyword ?>">
                    <button class="btn btn-primary" type="submit">Cari</button>
                    <a href="transaksi.php" class="btn btn-secondary ms-1">Reset</a>
                  </form>
              </div>
                </tr>
              </table>
            </div>

            <div class="card-body">
              <table class="table table-bordered table-hover table-striped">
                <thead>
                  <tr style="text-align: center;">
                    <th width="5%">No</th>
                    <th>Tanggal</th>
                    <th>Kategori</th>
                    <th>Jenis</th>
                    <th>Keterangan</th>
                    <th>Jumlah (Rp)</th>
                    <th width="15%">Aksi</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  $no = 1;
                  while($d = mysqli_fetch_array($data)){

                      $id_kat = $d['sub_kategori_id'];
                      
                      $q_kat = mysqli_query($konek, "SELECT * FROM sub_kategori WHERE id='$id_kat'");
                      $d_kat = mysqli_fetch_array($q_kat);


                      $nama_kategori = $d_kat['nama_sub_kategori']; 
                      $jenis = $d_kat['jenis']; 
                      

                      if($jenis == 'masuk'){
                          $badge = "<span class='badge bg-success'>Pemasukan</span>";
                      } else {
                          $badge = "<span class='badge bg-danger'>Pengeluaran</span>";
                      }
                  ?>
                  <tr style="text-align: center;">
                    <td><?= $no++; ?></td>
                    <td><?= date('d-m-Y', strtotime($d['tanggal'])); ?></td>
                    <td><?= $nama_kategori; ?></td>
                    <td><?= $badge; ?></td>
                    <td><?= $d['keterangan']; ?></td>
                    <td>Rp. <?= number_format($d['jumlah'], 0, ',', '.'); ?></td>
                    <td>
                      <a href="transaksi_edit.php?id=<?= $d['id']; ?>" class="btn btn-sm btn-warning">Edit</a>
                      <a href="transaksi_hapus.php?id=<?= $d['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Hapus data ini?')">Hapus</a>
                    </td>
                  </tr>
                  <?php } ?>
                  
                  <?php if(mysqli_num_rows($data) == 0): ?>
                      <tr><td colspan="7" class="text-center">Belum ada data transaksi.</td></tr>
                  <?php endif; ?>
                </tbody>
              </table>
            </div>
            </div>
          </div>
      </div>
    </div>
  </div>
</main> 