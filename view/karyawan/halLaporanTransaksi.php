<?php
session_start();
error_reporting(0);
include "../../class/pengelolaan_hewan/Transaksi.php";
include "../../class/pelaporan_data/pelaporanTransaksi.php";

$datatransaksi = new Transaksi();
$pelaporan_data = new PelaporanTransaksi();
?>
<!DOCTYPE html>
<html>
  <head>
    <?php include "pages/header.php"; ?>
    <title>Laporan Data Transaksi</title>
  </head>
  <body>
    <?php
    include "pages/nav.php";
    ?>
    <div class="container-fluid">
      <?php
        if (isset($_GET["kelola"])) {
          if($_GET["kelola"]=="pelaporan_transaksi"){?>
            <a href="halLaporanTransaksi.php?kelola=print"><button class="btn btn-info">Print</button></a>
            <br>
            <h4><font color="red">*Harap dilakukan terlebih dahulu sebelum melakukan print : </font></h4>
            <h4>- Untuk pengguna browser mozilla : <a target="_blank" href="https://support.mozilla.org/en-US/kb/pop-blocker-settings-exceptions-troubleshooting"><font color="lime">Matikan Pop-Up Blocker</font></a>
            <h4>- Untuk pengguna browser google chrome : <a target="_blank" href="https://support.google.com/chrome/answer/95472?co=GENIE.Platform%3DDesktop&hl=en"><font color="lime">Matikan Pop-Up Blocker</font></a>
            <br><br>
            <table class="table table-bordered table table-bordered table2 table-responsive" name="formDataHewan">
              <thead>
                <tr class="tr1">
                  <th>No</th>
                  <th>ID Transaksi</th>
                  <th>Jumlah Hewan</th>
                  <th>Total Harga</th>
                  <th>Metode Bayar</th>
                  <th>Status Bayar</th>
                </tr>
              </thead>
              <tbody>
                <?php
                  $no=1;
                  foreach($datatransaksi->tampil_transaksi() as $data){
                    ?>
                    <tr>
                      <td><?php echo $no; ?></td>
                      <td><?php echo $data["id_transaksi"]; ?></td>
                      <td><?php echo $data["jml_hewan"]; ?></td>
                      <td>
                        <?php
                        echo "Rp".number_format($data['total_harga'],0,",",".");
                        ?>
                      </td>
                      <td><?php echo $data["metode_bayar"]; ?></td>
                      <td>
                        <?php
                        if ($data["status_bayar"] == "Belum Terverifikasi") {
                          echo "<font color='red'>Belum Terverifikasi</font>";
                        }else if($data["status_bayar"] == "Sudah Terverifikasi"){
                          echo "<font color='lime'>Sudah Terverifikasi</font>";
                        }
                        ?>
                      </td>
                    </tr>
                    <?php
                    $no++;
                  }
                ?>
              </tbody>
            </table>
          <?php
          }if($_GET["kelola"]=="print"){
            $waktu = date('h:i:s');
            $tgl   = date('Y-m-d');

            foreach($datatransaksi->tampil_transaksi() as $data){
              $hasil[] = $data['id_transaksi'];
            }

            $tes = implode(", ", $hasil);
            $tess = explode(', ',$tes);

            $prefix = '#ARSIP_LDT_';
            $key1   = rand(1, 1000);
            $randomkeys = $prefix.$key1;

            if(empty($tess[0])) {
              header("Location: halLaporanTransaksi.php?kelola=pelaporan_transaksi");
            }else{
              $cek = $pelaporan_data->cetak_laporan($randomkeys, $_SESSION['id_karyawan'], $tess, $waktu, $tgl);
              $remove = ltrim($randomkeys, '#');
              echo '<script>window.open("../../assets/laporan_transaksi/%23'.$remove.'_'.$tgl.'/");</script>';
              echo '<script>alert("Silahkan download laporan transaksi nya :)");</script>';
              echo '<meta http-equiv="refresh" content="0; url=halLaporanTransaksi.php?kelola=pelaporan_transaksi">';
            }
          }
        }
      ?>
  </body>
</html>
