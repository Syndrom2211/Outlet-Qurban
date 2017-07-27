<?php
session_start();
error_reporting(0);
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
		        <h2 class="text-center">Info Total Pemesanan Hewan </h2>
        <hr/>
	      </div>
        <div class="row li1">
          <div class="col-md-4"><b>Hewan</b></div>
          <div class="col-md-4"><b>:</b></div>
          <div class="col-md-4">
            <?php
            foreach ($_SESSION['data'] as $key => $value) {
              $tes = implode(", ", $value);
              $tess = explode(', ',$tes,-1);
              $i = 0;
              while($i < count($tess)){
                $k = FALSE;
                if(($tess[2] == "domba") || ($tess[2] == "sapi")){
                  $k = TRUE;
                }else if($tess[2] == "domba"){
                  $j = TRUE;
                }else if($tess[2] == "sapi"){
                  $p = TRUE;
                }
              $i++;
              }
            }

            if($k == TRUE){
              echo "Domba dan Sapi";
            }else if($j == TRUE){
              echo "Domba";
            }else if($p == TRUE){
              echo "Sapi";
            }
            ?>
          </div>
        </div>
        <div class="row li1">
          <div class="col-md-4"><b>Jumlah Pesanan</b></div>
          <div class="col-md-4"><b>:</b></div>
          <div class="col-md-4">
            <?php
            foreach ($_SESSION['data'] as $key => $value) {
              $tes = implode(", ", $value);
              $tess = explode(', ',$tes,-1);

              $i = 0;
              while($i < 1){
                if($tess[2] == "domba"){
                  $j[] = count($tess[2]);
                }else if($tess[2] == "sapi"){
                  $p[] = count($tess[2]);
                }
              $i++;
              }
            }

            echo count($j)." Domba dan ".count($p)." Sapi";
            ?>
          </div>
        </div>

        <?php
        if (isset($_POST['checkout']) || isset($_POST['kembali_identitas'])) {
          $tgl   = $_POST['tgl'];
          $waktu = $_POST['waktu'];
        ?>
        <form action="halIdentitas.php" method="post">
          <div class="row li1">
            <div class="col-md-4"><b>Tanggal Pembelian</b></div>
            <div class="col-md-4"><b>:</b></div>
            <div class="col-md-4">
              <?php echo $tgl; ?>
              <input type="hidden" name="tgl" value="<?php echo $_POST['tgl']; ?>" />
            </div>
          </div>
          <div class="row li1">
            <div class="col-md-4"><b>Waktu Pembelian</b></div>
            <div class="col-md-4"><b>:</b></div>
            <div class="col-md-4">
              <?php echo $waktu; ?>
              <input type="hidden" name="waktu" value="<?php echo $_POST['waktu']; ?>" />
            </div>
          </div>
          <div class="row li1">
            <div class="col-md-4"><b>Bayar dimana ?</b></div>
            <div class="col-md-4"><b>:</b></div>
            <div class="col-md-4">
              <input type="radio" name="bayar" value="online" required="" />Online
              <input type="radio" name="bayar" value="depot" required="" />Depot
            </div>
          </div>
          <div class="row">
            <div class="col-md-12">
              <span style="float:right;" >
                  <button type="submit" class="btn btn_tempat" name="isi_identitas">Lanjut</button>
            </div>
          </div>
        </form>
        <?php
        }
        ?><!--
        /*
        foreach ($_SESSION['data'] as $key => $value) {
          $tes = implode(", ", $value);
          $tess = explode(', ',$tes,-1);
          $iya = $tess[0];
          echo $iya;
        }

        echo "<br/>".count($_SESSION['data']);
      }*/ -->
    </div>
  </body>
</html>
