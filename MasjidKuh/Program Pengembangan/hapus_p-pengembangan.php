<?php
require_once '../config.php';
$id=$_GET['id'];
$sql="DELETE FROM pengembangan WHERE id='$id'";
$data=$konek->query($sql);

if($data){
    echo "<script>alert('Data Berhasil Dihapus'); window.location='?p=PG'</script>";
}else{
    echo "<script>alert('Data Gagal Dihapus'); window.location='?p=PG'</script>";
}
