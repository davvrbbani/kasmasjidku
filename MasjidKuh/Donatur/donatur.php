<?php
include "../config.php";

$keyword = $_POST['keyword'] ?? '';
if(empty($keyword)){
    $data = $konek->query("SELECT * FROM donatur ORDER BY nama_donatur ASC");
} else {
    $data = $konek->query("SELECT * FROM donatur 
                           WHERE nama_donatur LIKE '%$keyword%' 
                              OR no_hp LIKE '%$keyword%'
                              OR alamat LIKE '%$keyword%'
                              OR keterangan LIKE '%$keyword%'
                           ORDER BY nama_donatur ASC");
}
?>

<main class="app-main">
  <div class="app-content-header">
    <div class="container-fluid">
      <div class="row">
        <div class="col-sm-6"><h3 class="mb-0">Data Donatur</h3></div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-end">
            <li class="breadcrumb-item"><a href="index.php">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Donatur</li>
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
              <h3 class="card-title" style="font-weight: bold;">Data Donatur Masjid</h3>
              
              <div class="d-flex justify-content-end align-items-center mt-2">
                  <a href="./?p=add_dn" class="btn btn-success me-2">
                      <i class="bi bi-plus-circle"></i> Tambah Donatur
                  </a>

                  <form class="d-flex" method="POST" action="#">
                    <input style="width: 250px" class="form-control me-2" type="text" name="keyword" placeholder="Cari nama, HP, alamat..." value="<?= htmlspecialchars($keyword) ?>">
                    <button class="btn btn-primary" type="submit">Cari</button>
                    <a href="./?p=DN" class="btn btn-secondary ms-1">Reset</a>
                  </form>
              </div>
            </div>

            <div class="card-body">
              <table class="table table-bordered table-hover table-striped">
                <thead class="table-light">
                  <tr class="text-center align-middle">
                    <th style="width: 5%;">No</th>
                    <th>Nama Donatur</th>
                    <th>No. HP</th>
                    <th>Join Date</th>
                    <th>Alamat</th>
                    <th>Keterangan</th>
                    <th style="width: 15%;">Aksi</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  $no = 1;
                  foreach($data as $d){
                  ?>
                  <tr class="align-middle text-center">
                    <td><?= $no++; ?></td>
                    <td class="text-start"><?= $d['nama_donatur'] ?></td>
                    <td><?= $d['no_hp'] ?></td>
                    <td><?= date('d-m-Y', strtotime($d['join_date'])) ?></td>
                    <td class="text-start"><?= $d['alamat'] ?></td>
                    <td class="text-start"><?= $d['keterangan'] ?></td>
                    <td>
                      <a href="./?p=edit_dn&id=<?= $d['id'] ?>" class="btn btn-sm btn-warning">Edit</a>
                      <a href="./?p=hps_dn&id=<?= $d['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Hapus data ini?')">Hapus</a>
                    </td>
                  </tr>
                  <?php } ?>

                  <?php if($data->num_rows == 0): ?>
                    <tr>
                      <td colspan="7" class="text-center text-muted fst-italic py-3">Belum ada data donatur.</td>
                    </tr>
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
