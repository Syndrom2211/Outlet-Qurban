<?php
session_start();
error_reporting(0);
include "../../class/pengelolaan_hewan/DataHewan.php";
include "../../class/pelaporan_data/pelaporanDataHewan.php";

$datahewan = new DataHewan();
$pelaporan_datahewan = new PelaporanDataHewan();
?>
<!DOCTYPE html>
<html>
  <head>
    <?php include "pages/header.php"; ?>
    <title>Laporan Data Hewan</title>
  </head>
  <body>
    <?php
    include "pages/nav.php";
    ?>
    <div class="container-fluid">
      <?php
        if (isset($_GET["kelola"])) {
          if($_GET["kelola"]=="pelaporan_datahewan"){?>
            <a href="halLaporanDataHewan.php?kelola=print"><button class="btn btn-info">Print</button></a>
            <br>
            <h4><font color="red">*Harap dilakukan terlebih dahulu sebelum melakukan print : </font></h4>
            <h4>- Untuk pengguna browser mozilla : <a target="_blank" href="https://support.mozilla.org/en-US/kb/pop-blocker-settings-exceptions-troubleshooting"><font color="lime">Matikan Pop-Up Blocker</font></a>
            <h4>- Untuk pengguna browser google chrome : <a target="_blank" href="https://support.google.com/chrome/answer/95472?co=GENIE.Platform%3DDesktop&hl=en"><font color="lime">Matikan Pop-Up Blocker</font></a>
            <br><br>
            <table class="table table-bordered table table-bordered table2 table-responsive" name="formDataHewan">
              <thead>
                <tr class="tr1">
                  <th>No</th>
                  <th>Foto</th>
                  <th>Jenis</th>
                  <th>Usia</th>
                  <th>Level</th>
                  <th>Berat</th>
                  <th>Kondisi Fisik</th>
                  <th>Harga</th>
                </tr>
              </thead>
              <tbody>
                <?php
                  $no=1;
                  foreach($datahewan->tampil_hewan() as $data){
                    ?>
                    <tr>
                      <td><?php echo $no; ?></td>
                      <td><img src='<?php echo $data["foto"]; ?>' width="100px" /></td>
                      <td><?php echo $data["jenis"]; ?></td>
                      <td><?php echo $data["usia"]; ?></td>
                      <td><?php echo $data["level"]; ?></td>
                      <td><?php echo $data["berat"]; ?></td>
                      <td><?php echo $data["kondisi_fisik"]; ?></td>
                      <td><?php echo $data["harga"]; ?></td>
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

            foreach($datahewan->tampil_hewan() as $data){
              $hasil[] = $data['id_hewan'];
            }

            $tes = implode(", ", $hasil);
            $tess = explode(', ',$tes);

            $prefix = '#ARSIP_LDH_';
            $key1   = rand(1, 1000);
            $randomkeys = $prefix.$key1;

            if(empty($tess[0])) {
              header("Location: halLaporanDataHewan.php?kelola=pelaporan_datahewan");
            }else{
              $cek    = $pelaporan_datahewan->cetak_laporan($randomkeys, $_SESSION['id_karyawan'], $tess, $waktu, $tgl);
              $remove = ltrim($randomkeys, '#');
              echo '<script>window.open("../../assets/laporan_datahewan/%23'.$remove.'_'.$tgl.'/");</script>';
              echo '<script>alert("Silahkan download laporan data hewan nya :)");</script>';
              echo '<meta http-equiv="refresh" content="0; url=halLaporanDataHewan.php?kelola=pelaporan_datahewan">';
            }
          }
        }
      ?>
  </body>
</html>
