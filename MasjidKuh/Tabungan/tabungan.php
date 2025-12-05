<?php
require_once "../config.php";
$keyword = $_POST['keyword'] ?? '';
$category = $_POST['category'] ?? '';
if (empty($keyword)) {
  $n=0;
  $data=$konek->query("SELECT * FROM siakad order by nim limit 10");
} else{
  $n=0;
  if($category==1){
    $data=$konek->query("SELECT * FROM siakad where nim like '%$keyword%'");
}elseif($category==2){
    $data=$konek->query("SELECT * FROM siakad where nama like '%$keyword%'");
}elseif($category==3){
    $data=$konek->query("SELECT * FROM siakad where gender like '%$keyword%'");
}elseif($category==4){
  if($keyword=="INF"){
  $keyword2="1";
}elseif($keyword=="ARS"){
  $keyword2="2";
}
  $data=$konek->query("SELECT * FROM siakad where prodi like '%$keyword2%'");
}
}
?>
<!--begin::App Main-->
      <main class="app-main">
        <!--begin::App Content Header-->
        <div class="app-content-header">
          <!--begin::Container-->
          <div class="container-fluid">
            <!--begin::Row-->
            <div class="row">
              <!--begin::Col-->
              <div class="col-sm-6"><h3 class="mb-0">Dashboard Admin</h3></div>
              <!--end::Col-->
              <!--begin::Col-->
              <div class="col-sm-6">
                <ol class="breadcrumb float-sm-end">
                  <li class="breadcrumb-item"><a href="#">Home</a></li>
                  <li class="breadcrumb-item active" aria-current="page">Data Mahasiswa</li>
                </ol>
              </div>
              <!--end::Col-->
            </div>
            <!--end::Row-->
          </div>
          <!--end::Container-->
        </div>
        <!--end::App Content Header-->
        <!--begin::App Content-->
        <div class="app-content">
          <!--begin::Container-->
          <div class="container-fluid">
            <!--begin::Row-->
            <div class="row">
              <!--begin::Col-->
              <div class="col-12">
                <!--begin::Card-->
                <div class="card">
                  <!--begin::Card Header-->
                  <div class="card-header">
                    <!--begin::Card Title-->
                    <h3 class="card-title">Data Mahasiswa</h3>
                    <!--end::Card Title-->
                    <div class="d-flex justify-content-end mb-3">
                    <a href="./?p=add-mahasiswa" button type="button" class="btn btn-success">Tambah Data</button></a>
                    </div>
                    <div>
                    <form class="d-flex" role="search" method="POST" action="#">
                    <input class="form-control me-2" type="text" placeholder="Search" aria-label="Search" name="keyword" style="width: 300px; display: inline-block;" value="<?=$keyword?>">
                    <select class="category" aria-label="Default select example" name="category">
                      <option value="#">-- Pilih Kategori --</option>
                      <option value="1"<?php if($category==1) echo "selected";?>> NIM</option>
                      <option value="2"<?php if($category==2) echo "selected";?>> Nama</option>
                      <option value="3"<?php if($category==3) echo "selected";?>> Gender</option>
                      <option value="4"<?php if($category==4) echo "selected";?>> Prodi</option>
                    </select>
                    <input class="btn btn-secondary btn-sm" type="reset" value="Reset" name="reset">
                    <input class="btn btn-primary" type="submit" value="Search" name="search">
                  </form>
                    <!--begin::Card Toolbar-->
                    <div class="card-tools">
                    <table class="table table-stripped table-hover">
                    <tr><th>No</th><th>NIM</th><th>Nama</th><th>Gender</th><th>Prodi</th><th>Tanggal</th><th>Option</th></tr>
                    <?php
                    $n = 0;
                    foreach ($data as $d) {
                      $n++;
                      if($d['prodi']==1){
                        $prodi="INF";
                      }elseif($d['prodi']==2){
                        $prodi="ARS";
                      }
                      else{
                        $prodi="Tidak Di Ketahui";
                      }
                      echo "<tr><td>$n</td><td>$d[nim]</td><td>$d[nama]</td><td>$d[gender]</td><td>$prodi</td><td>$d[W]</td>
                      <td>
                      <a href='./?p=detail-mahasiswa&id={$d["id"]}' class='btn btn-sm btn-info'>Detail</a>
                      <a href='./?p=edit-mahasiswa&id={$d["id"]}' class='btn btn-sm btn-warning'>Edit</a>
                      <a href='./?p=hapus-mahasiswa&id={$d["id"]}' class='btn btn-sm btn-danger'>Hapus</a>
                      </td></tr>";
                    }
                    ?>
                  </table>
                    <!--begin::Card Toolbar-->
                    <div class="card-tools">
                  <!--end::Card Footer-->
           <!--end::Card Footer-->
                </div>
                <!--end::Card-->
              </div>
              <!--end::Col-->
            </div>
            <!--end::Row-->
          </div>
          <!--end::Container-->
        </div>
        <!--end::App Content-->
      </main>
      <!--end::App Main-->