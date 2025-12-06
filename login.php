<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>KasMasjidKu | Masjid Al-Ikhlas</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="assets/css/all.min.css">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="assets/css/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="assets/css/adminlte.min.css?v=3.2.0">

<body class="hold-transition login-page bg-success">
<div class="login-box">
  <!-- /.login-logo -->
  <div class="card card-outline card-primary">
    <div class="card-header text-center">
      <a href="#" class="h1"><b>KasMasjidKu   Masjid Al-Ikhlas</b></a>
    </div>
    <div class="card-body">
    <?php
    if (isset($_POST['btnlogin'])){
        require_once "config.php";
        $user= str_replace("'","'",$_POST['user']);
        $pass= str_replace("'","'",$_POST['pass']);

        $sql="SELECT * FROM users WHERE username='$user' AND password=md5('$pass')";
        $hasil=$konek->query($sql);
        $ada=$hasil->num_rows;
        if ($ada > 0) {
        $data=$hasil->fetch_array();
        $_SESSION['user']=$user;
        $_SESSION['level']=$data['level'];
        if ($_SESSION['level']=='admin'){
            header ("Location: MasjidKuh/index.php");
        }
        echo "VALID!";
    }
        else echo "GAGAL!";
    }
    ?>
      <p class="login-box-msg">Sign in to start your session</p>

      <form action="#" method="post">
        <div class="input-group mb-3">
          <input type="username" class="form-control" name="user" placeholder="Username or email address" required>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="bi bi-person-fill"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="password" class="form-control" name="pass" placeholder="Password" required>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-8">
            <div class="icheck-primary">
              <input type="checkbox" id="remember">
              <label for="remember">
                Remember Me
              </label>
            </div>
          </div>
          <!-- /.col -->
          <div class="col-4">
            <button type="submit" class="btn btn-primary" value="Sign In" name="btnlogin">Sign In</button>
          </div>
          <!-- /.col -->
        </div>
      </form>
<!-- /.login-box -->
<!-- jQuery -->
<script src="../../plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="assets/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="assets/js/adminlte.min.js?v=3.2.0"></script>
<script defer src="https://static.cloudflareinsights.com/beacon.min.js/vcd15cbe7772f49c399c6a5babf22c1241717689176015" integrity="sha512-ZpsOmlRQV6y907TI0dKBHq9Md29nnaEIPlkf84rnaERnq6zvWvPUqr2ft8M1aS28oN72PdrCzSjY4U6VaAw1EQ==" data-cf-beacon='{"version":"2024.11.0","token":"2437d112162f4ec4b63c3ca0eb38fb20","server_timing":{"name":{"cfCacheStatus":true,"cfEdge":true,"cfExtPri":true,"cfL4":true,"cfOrigin":true,"cfSpeedBrain":true},"location_startswith":null}}' crossorigin="anonymous"></script>
</body>
</html>