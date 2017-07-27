<?php
session_start();
include "../../class/pengelolaan_petugas/Karyawan.php";
$karyawan = new Karyawan();

if(isset($_POST["login"])){
  $username = $_POST["username"];
  $password = $_POST["password"];
  $cek      = $karyawan->login($username, $password);

  if($cek){
    echo '<script>alert("login berhasil");</script>';
  }else{
    echo '<script>alert("login gagal");</script>';
  }
}

$ceksesi = $karyawan->ceksesi();
if($ceksesi){
  echo '<meta http-equiv="refresh" content="0; url=halKaryawan.php"';
}
?>

<!DOCTYPE html>
<html>
  <head>
    <?php include "pages/header.php"; ?>
  </head>
  <body class="bg1" align="center" >
    <div class="container">
        <br>
        <br>
        <br>
        <br>
        <h1 class="h1">Halaman Karyawan</h1>
        <p class="p1">Halaman login khusus <mark class="mark1">karyawan depot</mark></p>
        <div class="row">
        <div class="col-md-2">
        <form class="form col-md-4 center-block table1" align="center" action="halLogin.php" method="POST" name="formLogin">
        <table class="table table-responsive">
          <tr>
          <div class="form-group">
            <td><label class="col-sm-2 control-label">Username</label></td>
            <td></td>
            <div class="col-sm-2">
            <td><input type="text" class="form-control col-sm-5" placeholder="Username" name="username" /></td>
          </div>
          </tr>
          <tr>
          <div class="form-group" >
            <td><label class="col-sm-2 control-label">Password</label></td>
            <td></td>
            <td><input type="password" class="form-control col-sm-2" placeholder="Password" name="password" /></td>
          </tr>
          <tr>

            <td></td>
            <td></td>
            <div class="form-group" align="center">
            <div class="col-sm-offset-2 col-sm-4">
            <td><button type="submit" class="btn btn-success" name="login" value="Login" align="center"/>Login</button></td>
            </div>
          </div>
          </tr>
        </table>
        </form>
    </div>
  </body>
</html>
