<?php
session_start();
include "../../class/pengelolaan_hewan/MembeliHewan.php";

$membelihewan = new MembeliHewan();
?>
<!DOCTYPE html>
<html>
  <head>
    <?php include "pages/header.php"; ?>
  </head>
  <body>
    <div class="container">
        <?php include "pages/judul.php"; ?>
        <div class="row">
		        <h2 class="text-center">Info Identitas </h2>
        <hr/>
	      </div>
        <?php
        if (isset($_POST['download'])) {
          $randomkey = rand(1, 1000);
          $jml_hewan = count($_SESSION['data']);
          $cek = $membelihewan->cetak_buktitransaksi_identitas($randomkey, $jml_hewan, $_SESSION['id_pelanggan']);
          echo '<script>window.open("../../assets/file_bukti_id/%23bukti'.$randomkey.'_'.$_SESSION['id_pelanggan'].'/");</script>';
          echo '<script>alert("Selamat! Pemesanan Hewan telah Berhasil, silahkan download bukti identitasnya :)");</script>';
          session_destroy();
          echo '<meta http-equiv="refresh" content="0; url=halBeliHewan.php">';
        }
        ?>
        <form action="halInfoIdentitas.php" method="post">
        <?php
        foreach ($membelihewan->tampil_info_identitas($_SESSION['id_pelanggan']) as $value) {
        ?>
        <div class="row">
          <div class="col-md-4"><b>ID Pelanggan</b></div>
          <div class="col-md-4"><b>:</b></div>
          <div class="col-md-4"><b><?php echo $_SESSION['id_pelanggan'];?></b></div>
        </div>
        <div class="row">
          <div class="col-md-4"><b>Nama Pelanggan</b></div>
          <div class="col-md-4"><b>:</b></div>
          <div class="col-md-4"><?php echo $value['nama'];?></div>
        </div>
        <div class="row">
          <div class="col-md-4"><b>Jenis Kelamin</b></div>
          <div class="col-md-4"><b>:</b></div>
          <div class="col-md-4"><?php echo $value['jk'];?></div>
        </div>
        <div class="row">
          <div class="col-md-4"><b>Alamat</b></div>
          <div class="col-md-4"><b>:</b></div>
          <div class="col-md-4"><?php echo $value['alamat'];?></div>
        </div>
        <div class="row">
          <div class="col-md-4"><b>No telepon</b></div>
          <div class="col-md-4"><b>:</b></div>
          <div class="col-md-4"><?php echo $value['no_telp'];?></div>
        </div>
        <div class="row">
          <div class="col-md-4"><b>Jumlah Hewan</b></div>
          <div class="col-md-4"><b>:</b></div>
          <div class="col-md-4"><?php echo count($_SESSION['data']); ?></div>
        </div>
        <div class="row">
          <div class="col-md-12">
            <span>
              <center><button type="submit" class="btn btn-success" name="download">DOWNLOAD BUKTI IDENTITAS</button></center>
            </span>
          </div>
        </div>
      <?php
      }
      ?>
      </form>
    </div>
  </body>
</html>
