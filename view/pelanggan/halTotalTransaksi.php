<?php
session_start();
include "../../class/pengelolaan_hewan/Transaksi.php";
include "../../class/pengelolaan_hewan/MembeliHewan.php";

$transaksi    = new Transaksi();
$membelihewan = new MembeliHewan();
?>
<!DOCTYPE html>
<html>
  <head>
    <?php include "pages/header.php"; ?>
    <script language="javascript" type="text/javascript">
    <!--
    function bukti_tf(url) {
    	newwindow = window.open(url,'name','height=200,width=150');
    	if (window.focus) {newwindow.focus()}
    	return false;
    }
    // -->
    </script>
  </head>
  <body>
    <div class="container">
        <?php include "pages/judul.php"; ?>
        <div class="row">
		        <h2 class="text-center">Info Total Transaksi </h2>
        <hr/>
	      </div>
        <?php
        if (isset($_POST['download'])) {
          $cek = $membelihewan->cetak_buktitransaksi_pembelian($_SESSION['id_transaksi'],$_SESSION['id_pelanggan']);
          $remove = ltrim($_SESSION['id_transaksi'], '#');
          echo '<script>window.open("../../assets/file_bukti_tf/%23'.$remove.'_'.$_SESSION['id_pelanggan'].'/");</script>';
          echo '<script>alert("Selamat! Pemesanan Hewan telah Berhasil, silahkan download bukti transaksinya :)");</script>';
          session_destroy();
          echo '<meta http-equiv="refresh" content="0; url=halBeliHewan.php">';
        }
        ?>
        <form action="halTotalTransaksi.php" method="post">
        <?php
        foreach ($transaksi->tampil_transaksi_pelanggan($_SESSION['id_pelanggan']) as $value) {
        ?>
        <div class="row bg1">
          <div class="col-md-4"><b>ID Transaksi</b></div>
          <div class="col-md-4"><b>:</b></div>
          <div class="col-md-4"><b><?php echo $value['id_transaksi'];?></b></div>
        </div>
        <div class="row bg1">
          <div class="col-md-4"><b>Jumlah Hewan</b></div>
          <div class="col-md-4"><b>:</b></div>
          <div class="col-md-4"><?php echo $value['jml_hewan'];?></div>
        </div>
        <div class="row bg1">
          <div class="col-md-4"><b>Total Harga</b></div>
          <div class="col-md-4"><b>:</b></div>
          <div class="col-md-4">Rp<?php echo number_format($value['total_harga'],0,",",".");?></div>
        </div>
        <div class="row bg1">
          <div class="col-md-4"><b>Nama Pelanggan</b></div>
          <div class="col-md-4"><b>:</b></div>
          <div class="col-md-4"><?php echo $value['nama'];?></div>
        </div>
        <div class="row bg1">
          <div class="col-md-4"><b>Tanggal Beli</b></div>
          <div class="col-md-4"><b>:</b></div>
          <div class="col-md-4"><?php echo $value['tgl_beli'];?></div>
        </div>
        <div class="row bg1">
          <div class="col-md-4"><b>Waktu Beli</b></div>
          <div class="col-md-4"><b>:</b></div>
          <div class="col-md-4"><?php echo $value['waktu_beli'];?></div>
        </div>
        <div class="row bg1">
          <div class="col-md-4"><b>Transfer-ke</b></div>
          <div class="col-md-4"><b>:</b></div>
          <div class="col-md-4"><?php echo $value['metode_bayar'];?></div>
        </div>
        <div class="row bg1">
          <div class="col-md-4"><b>Status</b></div>
          <div class="col-md-4"><b>:</b></div>
          <div class="col-md-4"><font color=" #ff3333"><?php echo $value['status_bayar'];?></font><br/><i>(Harap datang ke depot untuk verifikasi)</i></div>
        </div>
        <br>
        <br>
        <br>
        <div class="row">
          <div class="col-md-12">
            <span>
              <center><button type="submit" class="btn btn-success" name="download">DOWNLOAD BUKTI TRANSAKSI</button></center>
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
