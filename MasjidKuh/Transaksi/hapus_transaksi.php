<?php
require_once "../config.php";
$xid = $_GET['id'];
$sql = "DELETE FROM transaksi WHERE id='$xid'";
$a=$konek->query($sql);
if($a){
    echo"<script>alert('Data Berhasil Dihapus!');
    window.location.href = './?p=TS';
    </script>";
}else{
    echo"<script>alert('Data Gagal Dihapus!');
    window.location.href = './?p=TS';
    </script>";
}
?>