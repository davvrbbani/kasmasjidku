<?php
require_once "../config.php";
$xid = $_GET['id'];
$cek = "DELETE FROM transaksi WHERE sub_kategori_id='$xid'";
$konek ->query($cek);
$sql = "DELETE FROM sub_kategori WHERE id='$xid'";
$hapus=$konek->query($sql);
if($hapus){
    echo"<script>alert('Data Berhasil Dihapus!');
    window.location.href = './?p=KT';
    </script>";
}else{
    echo"<script>alert('Data Gagal Dihapus!');
    window.location.href = './?p=KT';
    </script>";
}
?>