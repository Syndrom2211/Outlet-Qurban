<?php
session_start();
include "../../class/pengelolaan_hewan/MembeliHewan.php";
include "../../class/pengelolaan_hewan/Transaksi.php";

$transaksi = new Transaksi();
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
		        <h2 class="text-center">Isi Identitas </h2>
        <hr/>
	      </div>
        <?php
        if(isset($_POST['isi_bank'])){
          $id_pelanggan = rand(1, 100);
          $nama     = $_POST['nama_pelanggan'];
          $jk       = $_POST['jk'];
          $alamat   = $_POST['alamat'];
          $no_telp  = $_POST['no_telp'];
          $tgl      = $_POST['tgl'];
          $waktu    = $_POST['waktu'];
          $bayar    = $_POST['bayar'];
          $cek      = $membelihewan->tambah_pelanggan($id_pelanggan, $nama, $jk, $alamat, $no_telp);

          // SESSION
          $_SESSION['id_pelanggan'] = $id_pelanggan;
          $_SESSION['tgl']          = $tgl;
          $_SESSION['waktu']        = $waktu;
          $_SESSION['bayar']        = $bayar;

          foreach ($_SESSION['data'] as $key => $value) {
            $tes = implode(", ", $value);
            $tess = explode(', ',$tes,-1);
            $cek_lagi = $membelihewan->beli_hewan($id_pelanggan, $tess[0], $tgl, $waktu);
          }

          if($cek){
            if($cek_lagi){
              if($bayar == "online"){
                echo '<meta http-equiv="refresh" content="0; url=halBankTransfer.php">';
              }
            }
          }

          if($cek){
            if($cek_lagi){
              if($bayar == "depot"){
                echo '<meta http-equiv="refresh" content="0; url=halInfoIdentitas.php">';
              }
            }
          }
        }

        if(isset($_POST['kembali_bank'])) {
          $cek = $transaksi->hapus_transaksi($_POST['id_pelanggan']);
        }

        if(isset($_POST['isi_identitas']) || isset($_POST['kembali_bank'])){
        ?>
        <form action="halIdentitas.php" method="post" nam="formIdentitas">
          <div class="form-group">
            <label for="exampleInputEmail1">Nama</label>
            <input type="text" name="nama_pelanggan" class="form-control input1" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Masukan nama lengkap">
            <small id="emailHelp" class="form-text text-muted">Dibutuhkan sebagai bukti pembeli.</small>
            <input type="hidden" name="tgl" value="<?php echo $_POST['tgl']; ?>" />
            <input type="hidden" name="waktu" value="<?php echo $_POST['waktu']; ?>" />
            <input type="hidden" name="bayar" value="<?php echo $_POST['bayar']; ?>" />
          </div>
          <fieldset class="form-group">
          <label for="exampleInputEmail1">Jenis Kelamin</label>
            <div class="form-check">
              <label class="form-check-label">
                <input type="radio" class="form-check-input " name="jk" id="optionsRadios1" value="L" checked>
                Laki - Laki
              </label>
            </div>
            <div class="form-check">
            <label class="form-check-label">
                <input type="radio" class="form-check-input" name="jk" id="optionsRadios2" value="P">
                Perempuan
              </label>
            </div>
          </fieldset>
          <div class="form-group">
            <label for="exampleTextarea">Alamat Lengkap</label>
            <textarea class="form-control input1" id="exampleTextarea" rows="3" name="alamat" placeholder="Masukan alamat"></textarea>
          </div>
          <div class="form-group">
            <label for="exampleInputEmail1">No Telepon</label>
            <input type="text" class="form-control input1" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Masukan no telepon" name="no_telp">
            <small id="emailHelp" class="form-text text-muted">Dibutuhkan untuk komunikasi jika ada permasalahan.</small>
          </div>
          <button style="float:right;" type="submit" class="btn btn-pesan" name="isi_bank">Lanjut</button>
          </form>

          <form action="halTotalPemesanan.php" method="post">
            <input type="hidden" value="<?php echo $_POST['tgl']; ?>" name="tgl" />
            <input type="hidden" value="<?php echo $_POST['waktu']; ?>" name="waktu" />
            <button style="float:left;" type="submit" class="btn btn_tidak" name="kembali_identitas">Kembali</button>
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
    </div>
  </body>
</html>
