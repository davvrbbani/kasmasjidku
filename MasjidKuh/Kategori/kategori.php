<?php
require_once "../config.php";
$keyword = '';
if (isset($_POST['keyword'])) {
    $keyword = $_POST['keyword'];
}
?>

<main class="app-main">
  <div class="app-content-header">
    <div class="container-fluid">
      <div class="row">
        <div class="col-sm-6"><h3 class="mb-0">Kategori Transaksi Masjid</h3></div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-end">
            <li class="breadcrumb-item"><a href="index.php">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Data Kategori</li>
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
              <h3 class="card-title" style="font-weight: bold;">Katalog Kategori & Sub Kategori</h3>

              <table class="table table-borderless mb-0 mt-3">
                <tr>
                <div class="d-flex justify-content-end align-items-right mt-2">
                    <form class="d-flex" method="POST" action="#">
                    <input style="width: 250px" class="form-control me-2" type="text" name="keyword" placeholder="Cari keterangan..." value="<?= $keyword ?>">
                    <button class="btn btn-primary" type="submit">Cari</button>
                    <a href="./?p=KT" class="btn btn-secondary ms-1">Reset</a>
                    </form>
                </div>
                </tr>
              </table>
            </div>
            <div class="card-body">
              <div class="d-flex justify-content-start align-items-center mb-3">
                    <a href="./?p=add_ktgr" class="btn btn-success space-right me-2">
                        <i class="bi bi-plus-circle"></i> Tambah Kategori
                    </a>
                    <a href="./?p=add_sub" class="btn btn-success">
                        <i class="bi bi-plus-circle"></i> Tambah Sub Kategori
                    </a>
              </div>
                <table class="table table-bordered table-hover table-striped">
                    <thead class="table-light">
                    <tr class="text-center align-middle">
                        <th>No</th>
                        <th>Kategori</th>
                        <th>Sub Kategori</th>
                        <th>Jenis</th>
                        <th>Aksi</th>
                    </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no = 1;
                        
                        $data = $konek->query("SELECT * FROM kategori ORDER BY id ASC");
                        
                        foreach($data as $d){ 
                            
                            $id_kategori   = $d['id'];
                            $nama_kategori = $d['nama_kategori'];

                            $q_sub = $konek->query("SELECT * FROM sub_kategori WHERE kategori_id='$id_kategori'");
                            
                            if ($q_sub->num_rows > 0) {
                                
                                foreach($q_sub as $sub) { 
                        ?>
                                <tr class="align-middle">
                                    <td class="text-center"><?= $no++; ?></td>
                                    <td><?= $nama_kategori; ?></td> 
                                    <td><?= $sub['nama_sub_kategori']; ?></td> 
                                    
                                    <td class="text-center">
                                        <?php if($sub['jenis'] == 'masuk'){ ?>
                                            <span class="badge bg-success">Pemasukan</span>
                                        <?php } else { ?>
                                            <span class="badge bg-danger">Pengeluaran</span>
                                        <?php } ?>
                                    </td>
                                    
                                    <td class="text-center">
                                        <a href="./?p=edit_kat&id=<?= $sub['id']; ?>" class="btn btn-warning btn-sm">Edit</a>
                                        <a href="./?p=hps_kat&id=<?= $sub['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Hapus?')">Hapus</a>
                                    </td>
                                </tr>
                        <?php
                                }

                            } else {
                        ?>
                                <tr class="align-middle">
                                    <td class="text-center"><?= $no++; ?></td>
                                    <td><?= $nama_kategori; ?></td>
                                    <td class="text-danger fst-italic"> - (Kosong) </td> 
                                    <td class="text-center"> - </td>
                                    <td class="text-center"> - </td>
                                </tr>
                        <?php
                            } 
                        } 
                        ?>
                    </tbody>
                </table>
            </div>
            </div>
          </div>
      </div>
    </div>
  </div>
</main>