<?php
$konek = new mysqli("localhost", "root", "", "db_kas_masjid");

if ($konek) {
    //echo "Koneksi nyambung";
} else {
    echo "Koneksi gak nyambung";
}
?>
