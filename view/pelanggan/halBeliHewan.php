<?php
session_start();
error_reporting(0);
include "../../class/pengelolaan_hewan/MembeliHewan.php";
include "../../class/pengelolaan_hewan/DataHewan.php";

$membelihewan = new MembeliHewan();
$datahewan    = new DataHewan();
?>
<!DOCTYPE html>
<html>
  <head>
    <?php
    include "pages/header.php";
    ?>
  </head>
  <body>
    <div class="container">
        <?php include "pages/judul.php"; ?>
        <div class="row">
		        <h2 class="text-center">Daftar Hewan </h2>
            <?php $jum = count($_SESSION['data']); ?>
            <h4 class="text-center">Jumlah Pesanan : <?php echo $jum; ?></h4>
            <?php
            if($jum == TRUE){
            echo "<script>
                 $(window).load(function(){
                     $('#myModal').modal('show');
                 });
            </script>";
            }

            // Bagian POST DATA
            if(isset($_POST['pesan_hewan'])){
              $id_hewan         = $_POST['id_hewan'];
              $harga            = $_POST['harga'];
              $jenis_hewan      = $_POST['jenis_hewan'];
              $usia             = $_POST['usia'];
              $level            = $_POST['level'];
              $berat            = $_POST['berat'];
              $kondisi_fisik    = $_POST['kondisi_fisik'];
              $cek              = $membelihewan->pesan_hewan($id_hewan, $harga, $jenis_hewan, $usia, $level, $berat, $kondisi_fisik);
              $data             = array($cek);
              $_SESSION['data'][] = $data;

              if($cek){
                echo '<meta http-equiv="refresh" content="0; url=halBeliHewan.php">';
              }
            }
            ?>

            <form name="" action="halBeliHewan.php" method="get">
              <div class="row">
                <div class="col-lg-12">
                  <div class="input-group">
                    <input name="kata_kunci" type="text" class="form-control input_cari" placeholder="Masukan kata kunci...">
                    <span class="input-group-btn">
                      <button class="btn btn-success" type="button">Cari</button>
                    </span>
                  </div>
                </div>
              </div>
            </form>
        <hr/>
	      </div>
        <div class="row">
          <!-- BAGIAN MODAL -->
          <form name="formBeliHewan" action="halTotalPemesanan.php" method="post">
          <div id="myModal" class="modal fade in">
              <div class="modal-dialog">
                  <div class="modal-content">

                      <div class="modal-header">
                          <a class="btn btn_tidak" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span></a>
                          <br>
                          <h4 class="modal-title">Konfirmasi Pesanan</h4>
                      </div>
                      <div class="modal-body">
                          <h4>Ingin pesan lagi ?</h4>
                          <p>*Catatan : <br/>
                              Klik <i><b><font color=" #009933">iya</font></b></i> kembali memilih hewan<br/>
                              Klik <i><b><font color="#ff3333">tidak</font></b></i> lanjut ke info total pemesanan hewan<br/>
                          </p>
                          <?php
                          date_default_timezone_set('Asia/Jakarta');
                          $waktu = date('h:i:s');
                          $tgl   = date('Y-m-d');
                          ?>
                          <input type="hidden" name="tgl" value="<?php echo $tgl; ?>"/>
                          <input type="hidden" name="waktu" value="<?php echo $waktu; ?>"/>
                      </div>
                      <div class="modal-footer">
                          <div class="btn-group">
                              <button class="btn btn-pesan" data-dismiss="modal"><span class="glyphicon glyphicon-check"></span> Ya</button>
                              <button type="submit" name="checkout" class="btn btn_tidak"><span class="glyphicon glyphicon-remove"></span> Tidak</button>
                          </div>
                      </div>

                  </div><!-- /.modal-content -->
              </div><!-- /.modal-dalog -->
          </div><!-- /.modal -->
          </form>

          <?php
          if(isset($_GET['kata_kunci'])){
            $kata_kunci = $_GET['kata_kunci'];
            foreach($membelihewan->cari_hewan($kata_kunci) as $data){
          ?>
          <form action="halBeliHewan.php" method="POST" name="">
            <div class="col-sm-6 col-md-4">
                <div class="thumbnail">
                    <h4>
                        <span class="label label-default info">
                            <span data-toggle="tooltip">Harga : Rp<input name="harga" style="background:transparent;border:0px solid transparent;width:100px;" type="text" value="<?php echo number_format($data['harga'],0,",","."); ?>" /></span>
                        </span>
                    </h4>
                      <img style="width:500px;height:200px;" src="../karyawan/<?php echo $data['foto']; ?>" />
                      <ul class="list-group li1">
                        <li class="list-group-item justify-content-between">
                          Jenis Hewan
                          <?php
                          if($data['jenis'] == "sapi"){
                          ?>
                          <span class="badge badge-default badge-pill"><input style="background:transparent;border:0px solid transparent;width:40px;" type="text" name="jenis_hewan" value="<?php echo $data['jenis']; ?>" readonly /></span>
                          <?php
                          }else if($data['jenis'] == "domba"){
                          ?>
                          <span class="badge badge-default badge-pill"><input style="background:transparent;border:0px solid transparent;width:40px;" type="text" name="jenis_hewan" value="<?php echo $data['jenis']; ?>" readonly /></span>
                          <?php
                          }
                          ?>
                        </li>
                        <li class="list-group-item justify-content-between">
                          Usia
                          <span class="badge badge-default badge-pill"><input type="hidden" name="id_hewan" value="<?php echo $data['id_hewan']; ?>" /><input style="background:transparent;border:0px solid transparent;width:20px;" type="text" name="usia" value="<?php echo $data['usia']; ?>" readonly /> Bulan</span>
                        </li>
                        <li class="list-group-item justify-content-between">
                          Level
                          <span class="badge badge-default badge-pill"><input style="background:transparent;border:0px solid transparent;width:50px;" type="text" name="level" value="<?php echo $data['level']; ?>" readonly /></span>
                        </li>
                        <li class="list-group-item justify-content-between">
                          Berat
                          <span class="badge badge-default badge-pill"><input style="background:transparent;border:0px solid transparent;width:25px;" type="text" name="berat" value="<?php echo $data['berat']; ?>" readonly /> KG</span>
                        </li>
                        <li class="list-group-item justify-content-between">
                          Kondisi Fisik
                          <span class="badge badge-default badge-pill"><input style="background:transparent;border:0px solid transparent;width:38px;" type="text" name="kondisi_fisik" value="<?php echo $data['kondisi_fisik']; ?>" readonly /></span>
                        </li>
                      </ul>
                    <!--<a data-toggle="modal" href="#myModal"--><button type="submit" class="btn btn-pesan col-xs-12" role="button" name="pesan_hewan">Pesan</button><!--</a>-->
                    <div class="clearfix"></div>
                </div>
            </div>
          </form>
            <?php
              }
            }else{
              foreach($datahewan->tampil_hewan() as $data){
              ?>
              <form action="halBeliHewan.php" method="POST" name="formBeliHewan">
                <div class="col-sm-6 col-md-4">
                    <div class="thumbnail">
                        <h4>
                            <span class="label label-default info">
                                <span data-toggle="tooltip">Harga : Rp<input name="harga" style="background:transparent;border:0px solid transparent;width:100px;" type="text" value="<?php echo number_format($data['harga'],0,",","."); ?>" /></span>
                            </span>
                        </h4>
                          <img style="width:500px;height:200px;" src="../karyawan/<?php echo $data['foto']; ?>" />
                          <ul class="list-group li1">
                            <li class="list-group-item justify-content-between">
                              Jenis Hewan
                              <?php
                              if($data['jenis'] == "sapi"){
                              ?>
                              <span class="badge badge-default badge-pill"><input style="background:transparent;border:0px solid transparent;width:40px;" type="text" name="jenis_hewan" value="<?php echo $data['jenis']; ?>" readonly /></span>
                              <?php
                              }else if($data['jenis'] == "domba"){
                              ?>
                              <span class="badge badge-default badge-pill"><input style="background:transparent;border:0px solid transparent;width:40px;" type="text" name="jenis_hewan" value="<?php echo $data['jenis']; ?>" readonly /></span>
                              <?php
                              }
                              ?>
                            </li>
                            <li class="list-group-item justify-content-between">
                              Usia
                              <span class="badge badge-default badge-pill"><input type="hidden" name="id_hewan" value="<?php echo $data['id_hewan']; ?>" /><input style="background:transparent;border:0px solid transparent;width:20px;" type="text" name="usia" value="<?php echo $data['usia']; ?>" readonly /> Bulan</span>
                            </li>
                            <li class="list-group-item justify-content-between">
                              Level
                              <span class="badge badge-default badge-pill"><input style="background:transparent;border:0px solid transparent;width:50px;" type="text" name="level" value="<?php echo $data['level']; ?>" readonly /></span>
                            </li>
                            <li class="list-group-item justify-content-between">
                              Berat
                              <span class="badge badge-default badge-pill"><input style="background:transparent;border:0px solid transparent;width:25px;" type="text" name="berat" value="<?php echo $data['berat']; ?>" readonly /> KG</span>
                            </li>
                            <li class="list-group-item justify-content-between">
                              Kondisi Fisik
                              <span class="badge badge-default badge-pill"><input style="background:transparent;border:0px solid transparent;width:38px;" type="text" name="kondisi_fisik" value="<?php echo $data['kondisi_fisik']; ?>" readonly /></span>
                            </li>
                          </ul>
                        <!--<a data-toggle="modal" href="#myModal"--><button type="submit" class="btn btn-pesan col-xs-12" role="button" name="pesan_hewan">Pesan</button><!--</a>-->
                        <div class="clearfix"></div>
                    </div>
                </div>
              </form>
              <?php
              }
              ?>
          </div>
          <?php
          }
          ?>
      </div>

    <!-- Footer -->
    <script type="text/javascript">
    $(document).ready( function() {
        $('[data-toggle="tooltip"]').tooltip();
    });
    </script>
  </body>
</html>
