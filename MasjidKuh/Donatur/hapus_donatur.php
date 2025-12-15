<?php
require_once "../config.php";
$xid = $_GET['id'];
$sql = "DELETE FROM donatur WHERE id='$xid'";
$a=$konek->query($sql);
if($a){
    echo"<script>alert('Data Berhasil Dihapus!');
    window.location.href = './?p=DN';
    </script>";
}else{
    echo"<script>alert('Data Gagal Dihapus!');
    window.location.href = './?p=DN';
    </script>";
}
?>