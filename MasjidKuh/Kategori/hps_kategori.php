<?php
require_once "../config.php";

$xid = $_GET['id'];

$cek_parent = $konek->query("SELECT kategori_id FROM sub_kategori WHERE id='$xid'");
$data_parent = mysqli_fetch_assoc($cek_parent);
$id_kategori_utama = $data_parent['kategori_id'];

$hapus_transaksi = "DELETE FROM transaksi WHERE sub_kategori_id='$xid'";
$konek->query($hapus_transaksi);

$sql = "DELETE FROM sub_kategori WHERE id='$xid'";
$hapus = $konek->query($sql);

if($hapus){
    $cek_sisa = $konek->query("SELECT * FROM sub_kategori WHERE kategori_id='$id_kategori_utama'");
    $jumlah_sisa = mysqli_num_rows($cek_sisa);

    if($jumlah_sisa == 0){
        $konek->query("DELETE FROM kategori WHERE id='$id_kategori_utama'");
    }

    echo "<script>
            alert('Data Berhasil Dihapus! (Kategori Utama kosong juga ikut dihapus)');
            window.location.href = './?p=KT';
          </script>";
} else {
    echo "<script>
            alert('Data Gagal Dihapus!');
            window.location.href = './?p=KT';
          </script>";
}
?>