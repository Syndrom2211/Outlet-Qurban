<?php
session_start();
error_reporting(0);
include "../../class/pengelolaan_hewan/DataHewan.php";

$datahewan = new DataHewan();
?>
<!DOCTYPE html>
<html>
  <head>
    <?php include "pages/header.php"; ?>
    <title>Data Hewan</title>
  </head>
  <body>
    <?php
      include "pages/nav.php";
      //Ubah
      if(isset($_POST["ubah"])){
        // init image
        $target_dir = "img/";
        $foto = $target_dir.basename($_FILES["fileToUpload"]["name"]);
        $error        = $_FILES["fileToUpload"]["error"];
        $cek_extensi = pathinfo($foto,PATHINFO_EXTENSION);
        $pindahgambar = $_FILES["fileToUpload"]["tmp_name"];

        //post Data
        $id_hewan = $_POST["id_hewan"];
        $foto_lama = $_POST["foto_lama"];
        $level_lama = $_POST["level_lama"];
        $kondisi_fisik_lama = $_POST["kondisi_fisik_lama"];
        $jenis = $_POST["jenis"];
        $jenis_lama = $_POST["jenis_lama"];
        $usia = $_POST["usia"];
        $level = $_POST["level"];
        $berat = $_POST["berat"];
        $kondisi_fisik = $_POST["kondisi_fisik"];
        $harga = $_POST["harga"];
        $cek          = $datahewan->edit_hewan($error, $foto, $id_hewan, $foto_lama, $level_lama, $kondisi_fisik_lama, $jenis, $jenis_lama, $usia, $level, $berat, $kondisi_fisik, $harga);

        if($cek) {
          move_uploaded_file($pindahgambar, $foto);
          echo '<script>alert("data berhasil diubah");</script>';
          echo '<meta http-equiv="refresh" content="0; url=halDataHewan.php?kelola=datahewan"';
        }else{
          echo '<script>alert("data gagal diubah");</script>';
        }
      }

      //tambah
      if (isset($_POST["simpan"])) {
        //gambar
        $target_dir = "img/";
        $foto = $target_dir.basename($_FILES["fileToUpload"]["name"]);
        $pindahgambar = $_FILES["fileToUpload"]["tmp_name"];

        //post Data
        $jenis = $_POST["jenis"];
        $usia = $_POST["usia"];
        $level = $_POST["level"];
        $berat = $_POST["berat"];
        $kondisi_fisik = $_POST["kondisi_fisik"];
        $harga = $_POST["harga"];

        if(empty($usia) || empty($berat) || empty($harga)){
          header("Location: halDataHewan.php?kelola=datahewan");
        }else{
          $cek =$datahewan->tambah_hewan($jenis,$foto,$usia,$level,$berat,$kondisi_fisik,$harga);
          if($cek){
            move_uploaded_file($pindahgambar,$foto);
            echo '<script>alert("data berhasil ditambahkan");</script>';
            echo '<meta http-equiv="refresh" content="0; url=halDataHewan.php?kelola=datahewan"';
          }else{
            echo '<script>alert("data gagal ditambahkan");</script>';
          }
        }
      }
      //hapus
      if (isset($_GET["hapus_hewan"])) {
        $id_hewan = $_GET["hapus_hewan"];
        $cek = $datahewan->hapus_hewan($id_hewan);
        if($cek){
          echo '<script>alert("data berhasil dihapus");</script>';
          echo '<meta http-equiv="refresh" content="0; url=halDataHewan.php?kelola=datahewan"';
        }else{
          echo '<script>alert("data gagal dihapus");</script>';
        }
      }
    ?>
    <div class="container-fluid">
      <?php
        if (isset($_GET["kelola"])) {
          if($_GET["kelola"]=="datahewan"){?>
            <a href="halDataHewan.php?kelola=tambah_hewan"><button class="btn btn-info">Tambah</button></a>
            <br><br>
            <form name="" action="halDataHewan.php" method="get">
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
                  <th>Aksi</th>
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
                      <td>
                        <a href="halDataHewan.php?kelola=edit_hewan&id_hewan=<?php echo $data["id_hewan"]; ?>"><button class="btn-sm btn-danger">Edit</button></a>
                        <a onclick="return konfirmasi()" href="halDataHewan.php?hapus_hewan=<?php echo $data["id_hewan"]; ?>"><button class="btn-sm btn-warning">Hapus</button></a>
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

          if ($_GET["kelola"]=="tambah_hewan") { ?>
            <form action="halDataHewan.php" method="post" name="formTambahHewan" enctype="multipart/form-data">
              <table class="table label1" align="center">
                <tr>
                  <td>Foto</td>
                  <td>:</td>
                  <td><input type="file" name="fileToUpload" id="fileToUpload"></td>
                </tr>
                <tr>
                  <td>Jenis</td>
                  <td>:</td>
                  <td>
                    <select name="jenis">
                      <option value="domba">Domba</option>
                      <option value="sapi">Sapi</option>
                    </select>
                  </td>
                </tr>
                <tr>
                  <td>Usia</td>
                  <td>:</td>
                  <td><input type="text" name="usia"></td>
                </tr>
                <tr>
                  <td>Level</td>
                  <td>:</td>
                  <td>
                    <select name="level">
                      <option value="super">Super</option>
                      <option value="medium">Medium</option>
                      <option value="small">Small</option>
                    </select>
                  </td>
                </tr>
                <tr>
                  <td>Berat</td>
                  <td>:</td>
                  <td><input type="text" name="berat">KG</td>
                </tr>
                <tr>
                  <td>Kondisi Fisik</td>
                  <td>:</td>
                  <td>
                    <select name="kondisi_fisik">
                      <option value="sehat">Sehat</option>
                      <option value="sakit">Sakit</option>
                    </select>
                  </td>
                </tr>
                <tr>
                  <td>Harga</td>
                  <td>:</td>
                  <td><input type="text" name="harga"></td>
                </tr>
                <tr>
                  <td></td>
                  <td></td>
                  <td>
                    <input type="submit" class="btn btn-success" name="simpan" value="Simpan">
                    <input type="reset" class="btn btn-default" name="reset" value="Reset">
                  </td>
                </tr>
              </table>
            </form>
            <?php
          }if($_GET["kelola"]=="edit_hewan"){
            $id_hewan = $_GET["id_hewan"];
            foreach ($datahewan->tampil_hewan_byid($id_hewan) as $data) {
              ?>
              <div class="row">
                <div class="col-md-5">
              <form action="halDataHewan.php" method="post" name="formEditHewan" enctype="multipart/form-data">
                <table class="table label1">
                  <input type="hidden" name="id_hewan" value="<?php echo $id_hewan; ?>">
                  <tr>
                    <td>Foto</td>
                    <td>:</td>
                    <td>
                      <img src='<?php echo $data["foto"]; ?>' width="100px">
                      <input type="hidden" name="foto_lama" value="<?php echo $data['foto']; ?>">
                    </td>
                  </tr>
                  <tr>
                    <td>Ganti Foto</td>
                    <td>:</td>
                    <td>
                      <input type="file" name="fileToUpload" id="fileToUpload">
                      <i>(Kosongkan jika tidak diganti)</i>
                    </td>
                  </tr>
                  <tr>
                    <td>Jenis</td>
                    <td>:</td>
                    <td>
                      <input type="hidden" name="jenis_lama" value="<?php echo $data["jenis"]; ?>">
                      <select name="jenis">
                        <option value="">-</option>
                        <option value="domba">Domba</option>
                        <option value="sapi">Sapi</option>
                      </select>
                    </td>
                  </tr>
                  <tr>
                    <td>Usia</td>
                    <td>:</td>
                    <td><input type="text" name="usia" value="<?php echo $data["usia"]; ?>"></td>
                  </tr>
                  <tr>
                    <td>Ganti Level</td>
                    <td>:</td>
                    <td>
                      <input type="hidden" name="level_lama" style="width:100px" value="<?php echo $data["level"] ?>" readonly="" />
                      <select name="level">
                        <option value="">-</option>
                        <option value="super">Super</option>
                        <option value="medium">Medium</option>
                        <option value="small">Small</option>
                      </select>
                    </td>
                  </tr>
                  <tr>
                    <td>Berat</td>
                    <td>:</td>
                    <td><input type="text" name="berat" value="<?php echo $data["berat"] ?>">KG</td>
                  </tr>
                  <tr>
                    <td>Ganti Kondisi Fisik</td>
                    <td>:</td>
                    <td>
                      <input type="text" name="kondisi_fisik_lama" value="<?php echo $data["kondisi_fisik"] ?>" readonly="" />
                      <select name="kondisi_fisik">
                        <option value="">-</option>
                        <option value="sehat">Sehat</option>
                        <option value="sakit">Sakit</option>
                      </select>
                    </td>
                  </tr>
                  <tr>
                    <td>Harga</td>
                    <td>:</td>
                    <td><input type="text" name="harga"  value="<?php echo $data["harga"] ?>" /></td>
                  </tr>
                  <tr>
                    <td></td>
                    <td></td>
                    <td>
                      <input type="submit" class="btn btn-success" name="ubah" value="Simpan">
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

        if(isset($_GET["kata_kunci"])){ ?>
          <a href="halDataHewan.php?kelola=tambah_hewan"><button class="btn btn-info">Tambah</button></a>
          <br><br>
          <form name="" action="halDataHewan.php" method="get">
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
          <table class="table table-bordered table table-bordered table2 table-responsive" name="formDataHewan">
            <thead>
              <tr>
                <th>No</th>
                <th>Foto</th>
                <th>Jenis</th>
                <th>Usia</th>
                <th>Level</th>
                <th>Berat</th>
                <th>Kondisi Fisik</th>
                <th>Harga</th>
                <th>Aksi</th>
              </tr>
            </thead>
            <tbody>
          <?php
          $no=1;
            $kata_kunci = $_GET['kata_kunci'];
            foreach($datahewan->cari_hewan($kata_kunci) as $data){
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
                    <td>
                      <a href="halDataHewan.php?kelola=edit_hewan&id_hewan=<?php echo $data["id_hewan"]; ?>"><button class="btn-sm btn-danger">Edit</button></a>
                      <a onclick="return konfirmasi()" href="halDataHewan.php?hapus_hewan=<?php echo $data["id_hewan"]; ?>"><button class="btn-sm btn-warning">Hapus</button></a>
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
