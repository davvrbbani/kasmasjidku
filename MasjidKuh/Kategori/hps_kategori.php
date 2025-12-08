<?php
require_once "../config.php";

$id = $_GET['id'];
$sql = "DELETE FROM sub_kategori WHERE id='$id'";
$hapus = mysqli_query($konek, $sql);

if($hapus){
    echo "<script>
            alert('Data Berhasil Dihapus!'); 
            window.location='./?p=KT';
          </script>";
} else {
    echo "<script>
            alert('Gagal Hapus! Kemungkinan data ini sedang digunakan di riwayat transaksi.'); 
            window.location='./?p=KT';
          </script>";
}
?>