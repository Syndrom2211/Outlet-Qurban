<?php
session_start();
include "../../class/pengelolaan_hewan/Transaksi.php";

$transaksi = new Transaksi();
?>
<!DOCTYPE html>
<html>
  <head>
    <?php include "pages/header.php"; ?>
  </head>
  <body class="bg2">
    <div class="container">
      <?php include "pages/judul.php"; ?>
      <div class="row">
          <h2 class="text-center">Bank Transfer </h2>
      <hr/>
      </div>
      <center>
        <?php
        if (isset($_POST['ok'])) {
          $id_transaksi_random = rand(1, 100);
          $id_transaksi = "#".$id_transaksi_random;
          $id_pelanggan = $_SESSION['id_pelanggan'];
          $_SESSION['id_transaksi'] = $id_transaksi;
          $jml_hewan   = count($_SESSION['data']);
          $_SESSION['bank_next']    = TRUE;
          $id_karyawan = '0';

          foreach ($_SESSION['data'] as $value) {
            $tes = implode(", ", $value);
            $tess = explode(', ',$tes,-1);
            $dump[] = str_replace(".", "", $tess[1]);
          }
          $total_harga = array_sum($dump);

          $metode_bayar = $_SESSION['bayar']."(".$_POST['metode_bayar'].")";
          $status_bayar = "Belum Terverifikasi";

          $cek = $transaksi->tambah_transaksi($id_transaksi, $jml_hewan, $total_harga, $metode_bayar, $status_bayar);
          $cekdua = $transaksi->edit_transaksi_byid($id_transaksi, $id_pelanggan);

          if($cek && $cekdua) {
            echo '<meta http-equiv="refresh" content="0; url=halTotalTransaksi.php">';
          }
        }

        if (isset($_SESSION['bank_next']) == FALSE) {
        ?>
        <form class="" name="formBankTransfer" action="halBankTransfer.php" method="post">
          <fieldset class="form-group">
            <div class="form-check">
              <label class="form-check-label">
                <input type="radio" class="form-check-input" name="metode_bayar" id="optionsRadios1" value="bca:1510591590:Amirul Darmawan" checked>
                <img src="img/bca.png" />
                <br/>
                1510591590
                a/n Amirul Darmawan
              </label>
            </div>
            <br/>
            <div class="form-check">
            <label class="form-check-label">
                <input type="radio" class="form-check-input" name="metode_bayar" id="optionsRadios2" value="bri:576101001579506:Amirul Darmawan">
                <img src="img/bri.png" />
                <br/>
                576101001579506
                a/n Amirul Darmawan
              </label>
            </div>
            <br/>
            <div class="form-check">
            <label class="form-check-label">
                <input type="radio" class="form-check-input" name="metode_bayar" id="optionsRadios2" value="mandiri:1130006261931:Lena Sumarni">
                <img src="img/mandiri.png" />
                <br/>
                1130006261931
                a/n Lena Sumarni
              </label>
            </div>
            <br/>
            <div class="form-check">
            <label class="form-check-label">
                <input type="radio" class="form-check-input" name="metode_bayar" id="optionsRadios2" value="bni:0450672729::Amirul Darmawan">
                <img src="img/bni.png" />
                <br/>
                0450672729
                a/n Amirul Darmawan
              </label>
            </div>
            <br/>
          </fieldset>
          <button style="float:right;" type="submit" class="btn btn-pesan" name="ok">Lanjut</button>
        </form>
        <form action="halIdentitas.php" method="post">
          <input type="hidden" name="id_pelanggan" value="<?php echo $_SESSION['id_pelanggan']; ?>" />
          <input type="hidden" name="tgl" value="<?php echo $_SESSION['tgl']; ?>" />
          <input type="hidden" name="waktu" value="<?php echo $_SESSION['waktu']; ?>" />
          <input type="hidden" name="bayar" value="<?php echo $_SESSION['bayar']; ?>" />
          <button style="float:left;" type="submit" class="btn btn_tidak" name="kembali_bank">Kembali</button>
        </form>
        <?php
        }else{
        ?>
          <div class="row">
  		        <h2 class="text-center"><img src="../../assets/img/loading.gif" width="50px" /></h2>
  	      </div>
        <?php
        }
        ?>
      </center>
    </div>
  </body>
</html>
