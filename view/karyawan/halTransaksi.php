<?php
session_start();
error_reporting(0);
include "../../class/pengelolaan_hewan/Transaksi.php";
include "../../class/pengelolaan_hewan/MembeliHewan.php";

$datatransaksi = new Transaksi();
$membelihewan = new MembeliHewan();
?>
<!DOCTYPE html>
<html>
  <head>
    <?php include "pages/header.php"; ?>
    <title>Data Transaksi</title>
  </head>
  <body>
    <?php
      include "pages/nav.php";
      if(isset($_POST["edit_status"])){
        $id_transaksi = $_POST["id_transaksi"];
        $id_karyawan = $_POST["id_karyawan"];
        $status_bayar = $_POST["status_bayar"];
        $status_bayar_lama = $_POST["status_bayar_lama"];
        $cek = $datatransaksi->edit_transaksi($id_transaksi, $id_karyawan, $status_bayar, $status_bayar_lama);

        if($cek) {
          echo '<script>alert("edit transaksi berhasil");</script>';
          echo '<meta http-equiv="refresh" content="0; url=halTransaksi.php?kelola=transaksi"';
        }else{
          echo '<script>alert("edit transaksi gagal");</script>';
        }
      }

      //tambah
      if (isset($_POST["simpan_bayar"])) {
        //post Data
        $id_transaksi = $_POST["id_transaksi"];
        $id_pelanggan = $_POST["id_pelanggan"];
        $jml_hewan    = $_POST["jml_hewan"];
        $total_harga  = $_POST["total_harga"];
        $metode_bayar = $_POST["metode_bayar"];
        $status_bayar = $_POST["status_bayar"];

        $cek = $datatransaksi->tambah_transaksi($id_transaksi, $jml_hewan, $total_harga, $metode_bayar, $status_bayar);
        $cekdua = $datatransaksi->edit_transaksi_byid($id_transaksi, $id_pelanggan);

        if($cek && $cekdua){
          echo '<script>alert("data transaksi berhasil ditambahkan");</script>';
          echo '<script>alert("ID Transaksi : '.$id_transaksi.'");</script>';
          echo '<meta http-equiv="refresh" content="0; url=halTransaksi.php?kelola=transaksi"';
        }else{
          echo '<script>alert("data transaksi gagal ditambahkan");</script>';
        }
      }
    ?>
    <div class="container-fluid">
      <?php
        if (isset($_GET["kelola"])) {
          if($_GET["kelola"]=="transaksi"){?>
            <a href="halTransaksi.php?kelola=bayar_transaksi"><button class="btn btn-info">Bayar</button></a>
            <br><br>
            <form name="" action="halTransaksi.php" method="get">
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
            <br>
            <table class="table table-bordered table table-bordered table2 table-responsive" name="formTransaksi">
              <thead>
                <tr class="tr1">
                  <th>No</th>
                  <th>ID Transaksi</th>
                  <th>Jumlah Hewan</th>
                  <th>Total Harga</th>
                  <th>Metode Bayar</th>
                  <th>Status Bayar</th>
                  <th>Aksi</th>
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
                      <td>
                        <?php
                        if($data["status_bayar"] == "Belum Terverifikasi"){
                          $remove = ltrim($data['id_transaksi'], '#');
                        ?>
                          <a href="halTransaksi.php?kelola=edit_status&id_transaksi=<?php echo "%23".$remove; ?>"><button class="btn-sm btn-danger">Edit</button></a>
                        <?php
                        }else{
                          echo "[Sudah Terverifikasi]";
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
          }
        if ($_GET["kelola"]=="bayar_transaksi") { ?>
          <form action="halTransaksi.php" method="get" name="formBayar" enctype="multipart/form-data">
            <table class="table label1" align="center">
              <tr>
                <td>ID Pelanggan</td>
                <td>:</td>
                <td><input type="text" name="id_pelanggan"></td>
              </tr>
              <tr>
                <td></td>
                <td></td>
                <td>
                  <input type="submit" class="btn btn-success" value="Cek">
                </td>
              </tr>
            </table>
          </form>
          <?php
        }if($_GET["kelola"]=="edit_status"){
          $id_transaksi = $_GET["id_transaksi"];
          foreach ($datatransaksi->tampil_transaksi_byid($id_transaksi) as $data) {
            ?>
            <div class="row">
              <div class="col-md-5">
            <form action="halTransaksi.php" method="post" name="formEditTransaksi" enctype="multipart/form-data">
              <table class="table label1">
                <tr>
                  <td>ID Transaksi</td>
                  <td>:</td>
                  <td>
                    <?php echo $id_transaksi; ?>
                    <input type="hidden" name="id_transaksi" value="<?php echo $id_transaksi; ?>" readonly>
                  </td>
                </tr>
                <tr>
                  <td>ID Karyawan</td>
                  <td>:</td>
                  <td>
                    <?php echo $_SESSION['id_karyawan']; ?>
                    <input type="hidden" name="id_karyawan" value="<?php echo $_SESSION['id_karyawan']; ?>" readonly></td>
                </tr>
                <tr>
                  <td>Jumlah Hewan</td>
                  <td>:</td>
                  <td>
                    <?php echo $data["jml_hewan"]; ?>
                    <input type="hidden" name="jml_hewan" value="<?php echo $data["jml_hewan"]; ?>" readonly>
                  </td>
                </tr>
                <tr>
                  <td>Total Harga</td>
                  <td>:</td>
                  <td>
                    Rp<?php echo $data["total_harga"] ?>
                    <input type="hidden" name="total_harga" value="<?php echo $data["total_harga"] ?>" readonly>
                  </td>
                </tr>
                <tr>
                  <td>Metode Bayar</td>
                  <td>:</td>
                  <td>
                    <?php echo $data["metode_bayar"] ?>
                    <input type="hidden" name="metode_bayar" value="<?php echo $data["metode_bayar"] ?>" readonly>
                  </td>
                </tr>
                <tr>
                  <td>Status Bayar</td>
                  <td>:</td>
                  <td>
                    <input type="hidden" name="status_bayar_lama"  value="<?php echo $data["status_bayar"] ?>" />
                    <select name="status_bayar">
                      <option value="Belum Terverifikasi"><font color="red">Belum Terverifikasi</font></option>
                      <option value="Sudah Terverifikasi"><font color="lime">Sudah Terverifikasi</font></option>
                    </select>
                  </td>
                </tr>
                <tr>
                  <td></td>
                  <td></td>
                  <td>
                    <input type="submit" class="btn btn-success" name="edit_status" value="Simpan">
                  </td>
                </tr>
              </table>
            </form>
          </div>
        </div>
            <?php
          }
        }
      }

          if (isset($_GET['id_pelanggan'])) { ?>
            <form action="halTransaksi.php" method="post" name="formBayar" enctype="multipart/form-data">
              <table class="table label1" align="center">
          <?php
            $id_pelanggan = $_GET["id_pelanggan"];
            if ($id_pelanggan == "") {
              header("Location: halTransaksi.php?kelola=bayar_transaksi");
            }else{
            $id_transaksi_random = rand(1, 100);
            $id_transaksi = "#".$id_transaksi_random;
            $total_harga = 0;
            $jml_hewan = 0;
            $no = 1;

          foreach($membelihewan->tampil_belibyip($id_pelanggan) as $data){
            $jml_hewan    = $no; // Masih belum bisa
            $harga        = number_format($data['harga'],0,",",".");
            $total_harga += $data['harga'];
          ?>
          <tr>
            <td><h3>Data Hewan ke-<?php echo $no; ?></h3></td>
            <td></td>
            <td><img src="<?php echo $data['foto']; ?>" width="100px" /></td>
          </tr>
          <tr>
            <td>Kriteria Hewan</td>
            <td>:</td>
            <td>
                <?php
                echo "ID Hewan : ".$data['id_hewan']."<br/>";
                echo "Jenis : ".$data['jenis']."<br/>";
                echo "Level : ".$data['level']."<br/>";
                echo "Harga : Rp".$harga."<br/><br/>";
                ?>
            </td>
          </tr>
        <?php
        $no++;
        }
        ?>
        <tr>
          <td colspan="3"><hr></td>
        </tr>
          <tr>
            <td>Jumlah Hewan</td>
            <td>:</td>
            <td>
              <?php echo $jml_hewan; ?>
              <input type="hidden" value="<?php echo $jml_hewan; ?>" name="jml_hewan" />
            </td>
          </tr>
          <tr>
            <td>Nama Pelanggan</td>
            <td>:</td>
            <td>
              <?php echo $data['nama']; ?>
              <input type="hidden" value="<?php echo $id_transaksi; ?>" name="id_transaksi" />
              <input type="hidden" value="<?php echo $id_pelanggan; ?>" name="id_pelanggan" />
            </td>
          </tr>
          <tr>
            <td>Tanggal Bei</td>
            <td>:</td>
            <td>
              <?php echo $data['tgl_beli']; ?>
            </td>
          </tr>
          <tr>
            <td>Waktu Bei</td>
            <td>:</td>
            <td>
              <?php echo $data['waktu_beli']; ?>
            </td>
          </tr>
          <tr>
            <td>Total Harga</td>
            <td>:</td>
            <td>
              <?php echo "Rp".number_format($total_harga,0,",","."); ?>
              <input type="hidden" name="total_harga" value="<?php echo $total_harga; ?>" readonly>
            </td>
          </tr>
          <tr>
            <td>Transfer-ke</td>
            <td>:</td>
            <td>
              <select name="metode_bayar">
                <option value="online(bca:1510591590:Amirul Darmawan)">BCA 1510591590 a/n Amirul Darmawan</option>
                <option value="online(bri:576101001579506:Amirul Darmawan)">BRI 576101001579506 a/n Amirul Darmawan</option>
                <option value="online(mandiri:1130006261931:Lena Sumarni)">MANDIRI 1130006261931 a/n Lena Sumarni</option>
                <option value="online(bni:0450672729:Amirul Darmawan)">BNI 0450672729 a/n Amirul Darmawan</option>
              </select>
              <br/>
              <font color="lime">*Pilih Metode Pembayaran nya dengan pasti</font>
            </td>
          </tr>
          <tr>
            <td>Status Pembayaran</td>
            <td>:</td>
            <td>
              <font color="red">Belum Terverifikasi</font>
              <input type="hidden" name="status_bayar" value="Belum Terverifikasi" readonly>
            </td>
          </tr>
          <tr>
            <td></td>
            <td></td>
            <td>
              <input type="submit" name="simpan_bayar" class="btn btn-success" value="Simpan">
            </td>
          </tr>
        </table>
      </form>
      <?php
        }
      }

      if(isset($_GET["kata_kunci"])){ ?>
        <a href="halTransaksi.php?kelola=bayar_transaksi"><button class="btn btn-info">Bayar</button></a>
        <br><br>
        <form name="" action="halTransaksi.php" method="get">
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
        <br>
        <table class="table table-bordered table table-bordered table2 table-responsive" name="formTransaksi">
          <thead>
            <tr class="tr1">
              <th>No</th>
              <th>ID Transaksi</th>
              <th>Jumlah Hewan</th>
              <th>Total Harga</th>
              <th>Metode Bayar</th>
              <th>Status Bayar</th>
              <th>Aksi</th>
            </tr>
          </thead>
          <tbody>
        <?php
        $no=1;
        $kata_kunci = $_GET['kata_kunci'];
          foreach($datatransaksi->cari_transaksi($kata_kunci) as $data){
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
                  <td>
                    <?php
                    if($data["status_bayar"] == "Belum Terverifikasi"){
                      $remove = ltrim($data['id_transaksi'], '#');
                    ?>
                      <a href="halTransaksi.php?kelola=edit_status&id_transaksi=<?php echo "%23".$remove; ?>"><button class="btn-sm btn-danger">Edit</button></a>
                    <?php
                    }else{
                      echo "[Sudah Terverifikasi]";
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
        }
      ?>
  </body>
</html>
