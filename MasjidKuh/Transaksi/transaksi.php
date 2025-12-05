<?php
// 1. Cek Jenis (Masuk/Keluar) agar judul dinamis
$jenis = $_GET['jenis'] ?? 'masuk'; // Default masuk kalo gak ada url
$judul = ($jenis == 'masuk') ? 'Pemasukan' : 'Pengeluaran';

// 2. Logika Pencarian (SAMA PERSIS GAYA SIAKAD)
$keyword = $_POST['keyword'] ?? '';
$category = $_POST['category'] ?? '';

if (empty($keyword)) {
    // Kalo gak nyari, ambil semua data urut tanggal terbaru
    $data = $konek->query("SELECT * FROM transaksi ORDER BY tanggal DESC");
} else {
    // Kalo nyari
    if ($category == 1) {
        // Cari di Keterangan
        $data = $konek->query("SELECT * FROM transaksi WHERE keterangan LIKE '%$keyword%' ORDER BY tanggal DESC");
    } elseif ($category == 2) {
         // Cari di Tanggal
        $data = $konek->query("SELECT * FROM transaksi WHERE tanggal LIKE '%$keyword%' ORDER BY tanggal DESC");
    } else {
        $data = $konek->query("SELECT * FROM transaksi ORDER BY tanggal DESC");
    }
}
?>

<main class="app-main">
    <div class="app-content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h3 class="mb-0">Dashboard Admin</h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Data <?= $judul ?></li>
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
                            <h3 class="card-title">Data <?= $judul ?></h3>
                            
                            <div class="d-flex justify-content-end mb-3">
                                <a href="./?p=tambah-transaksi&jenis=<?= $jenis ?>" class="btn btn-success">
                                    Tambah Data
                                </a>
                            </div>

                            <div>
                                <form class="d-flex" role="search" method="POST" action="">
                                    <input class="form-control me-2" type="text" placeholder="Search..." aria-label="Search" name="keyword" style="width: 300px; display: inline-block;" value="<?= $keyword ?>">
                                    
                                    <select class="form-select me-2" aria-label="Default select example" name="category" style="width: 200px;">
                                        <option value="">-- Pilih Kategori --</option>
                                        <option value="1" <?php if($category==1) echo "selected";?>> Keterangan</option>
                                        <option value="2" <?php if($category==2) echo "selected";?>> Tanggal</option>
                                    </select>
                                    
                                    <input class="btn btn-secondary btn-sm me-2" type="submit" value="Reset" name="reset" onclick="window.location.href='./?p=transaksi&jenis=<?= $jenis ?>'; return false;">
                                    <input class="btn btn-primary" type="submit" value="Search" name="search">
                                </form>
                            </div>
                        </div>

                        <div class="card-body p-0">
                            <table class="table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Tanggal</th>
                                        <th>Kategori</th>
                                        <th>Keterangan</th>
                                        <th>Jumlah (Rp)</th>
                                        <th>Option</th> </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $n = 0;
                                    foreach ($data as $d) {
                                        // LOGIKA MANUAL (PENGGANTI JOIN)
                                        // Ambil data kategori berdasarkan id yang ada di transaksi
                                        $id_kat = $d['kategori_id'];
                                        $q_kat = $konek->query("SELECT * FROM sub_kategori WHERE id='$id_kat'");
                                        $kat = $q_kat->fetch_assoc();

                                        // Filter: Hanya tampilkan baris yang jenisnya sesuai (masuk/keluar)
                                        if ($kat['jenis'] == $jenis) {
                                            $n++;
                                            // Format Uang dan Tanggal
                                            $tgl_indo = date('d-m-Y', strtotime($d['tanggal']));
                                            $uang_indo = number_format($d['jumlah'], 0, ',', '.');

                                            echo "<tr>
                                                <td>$n</td>
                                                <td>$tgl_indo</td>
                                                <td><b>{$kat['nama_kategori']}</b></td>
                                                <td>{$d['keterangan']}</td>
                                                <td>$uang_indo</td>
                                                <td>
                                                    <a href='./?p=detail-transaksi&id={$d["id"]}' class='btn btn-sm btn-info'>Detail</a>
                                                    <a href='./?p=edit-transaksi&id={$d["id"]}' class='btn btn-sm btn-warning'>Edit</a>
                                                    <a href='./?p=hapus-transaksi&id={$d["id"]}' class='btn btn-sm btn-danger' onclick=\"return confirm('Yakin hapus data ini?')\">Hapus</a>
                                                </td>
                                            </tr>";
                                        }
                                    }
                                    // Pesan jika kosong
                                    if ($n == 0) {
                                        echo "<tr><td colspan='6' class='text-center'>Data tidak ditemukan</td></tr>";
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