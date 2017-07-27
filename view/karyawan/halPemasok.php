<?php
session_start();
error_reporting(0);
include "../../class/pengelolaan_hewan/Pemasok.php";
include "../../class/pengelolaan_petugas/Karyawan.php";

$karyawan = new Karyawan();
$pemasok = new Pemasok();

if(isset($_GET["logout"])){
  echo $karyawan->logout();
  header("Location: halLogin.php");
}
?>

<!DOCTYPE html>
<html>
  <head>
    <?php include "pages/header.php"; ?>
  </head>
  <body>
    <?php
    include "pages/nav.php";
    //Pemasok
    //Tambah
    if(isset($_POST["simpan1"])){
      // post data
      $nama_peternakan    = $_POST["nama_peternakan"];
      $alamat_peternakan  = $_POST["alamat_peternakan"];
      $nama_pemilik       = $_POST["nama_pemilik"];
      $no_telp_pemilik    = $_POST["no_telp_pemilik"];
      $ketersediaan_sapi  = $_POST["ketersediaan_sapi"];
      $ketersediaan_domba = $_POST["ketersediaan_domba"];
      $id_karyawan        = $_POST['id_karyawan'];


      if(empty($nama_peternakan) || empty($alamat_peternakan) || empty($nama_pemilik) || empty($no_telp_pemilik) || empty($ketersediaan_sapi) || empty($ketersediaan_domba)){
        header("Location: halPemasok.php?kelola=pemasok");
      }else{
        $cek = $pemasok->tambah_pemasok($id_karyawan, $nama_peternakan, $alamat_peternakan, $nama_pemilik, $no_telp_pemilik, $ketersediaan_sapi, $ketersediaan_domba);
        if($cek){
            echo '<script>alert("data berhasil ditambahkan");</script>';
            echo '<meta http-equiv="refresh" content="0; url=halPemasok.php?kelola=pemasok"';
          }else{
            echo '<script>alert("data gagal ditambahkan");</script>';
          }
      }
    }

    //Hapus
    if(isset($_GET["hapus_pemasok"])){
      $id_pemasok  = $_GET["hapus_pemasok"];
      $cek         = $pemasok->hapus_pemasok($id_pemasok);

      if($cek){
        echo '<script>alert("data berhasil dihapus");</script>';
        echo '<meta http-equiv="refresh" content="0; url=halPemasok.php?kelola=pemasok"';
      }else{
        echo '<script>alert("data gagal dihapus");</script>';
      }
    }

    //Ubah
    if(isset($_POST["ubah_pasok"])){
      // post data
      $id_pemasok         = $_POST["id_pemasok"];
      $nama_peternakan    = $_POST["nama_peternakan"];
      $alamat_peternakan  = $_POST["alamat_peternakan"];
      $nama_pemilik       = $_POST["nama_pemilik"];
      $no_telp_pemilik    = $_POST["no_telp_pemilik"];
      $ketersediaan_sapi  = $_POST["ketersediaan_sapi"];
      $ketersediaan_domba = $_POST["ketersediaan_domba"];
      $id_karyawan_lama   = $_POST["id_karyawan_lama"];
      $id_karyawan        = $_POST["id_karyawan"];
      $cek                = $pemasok->edit_pemasok($id_karyawan_lama, $id_karyawan, $id_pemasok, $nama_peternakan, $alamat_peternakan, $nama_pemilik, $no_telp_pemilik, $ketersediaan_sapi, $ketersediaan_domba);

      if($cek) {
        echo '<script>alert("data berhasil diubah");</script>';
        echo '<meta http-equiv="refresh" content="0; url=halPemasok.php?kelola=pemasok"';
      }else{
        echo '<script>alert("data gagal diubah");</script>';
      }
    }
  ?>
    <div class="container-fluid">
      <?php
      if(isset($_GET["kelola"])){
        if($_GET["kelola"] == "pemasok"){ ?>
          <a href="halPemasok.php?kelola=tambah_pemasok"><button class="btn btn-info" name="">Tambah</button></a>
          <br><br>
          <form name="" action="halPemasok.php" method="get">
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
          </form><br>
          <table class="table table-bordered table2 table-responsive" name="formPemasok">
            <thead>
              <tr class="tr1">
                <th>No</th>
                <th>Nama Peternakan</th>
                <th>Alamat Peternakan</th>
                <th>Nama Pemilik</th>
                <th>No Telp Pemilik</th>
                <th>Ketersediaan Sapi</th>
                <th>Ketersediaan Domba</th>
                <th>Petugas Hewan</th>
                <th>Aksi</th>
            </thead>
            <tbody>
              <?php
              $no = 1;
              foreach($pemasok->tampil_pemasok() as $data){
              ?>
              <tr>
                <td><?php echo $no; ?></td>
                <td><?php echo $data["nama_peternakan"]; ?></td>
                <td><?php echo $data["alamat_peternakan"]; ?></td>
                <td><?php echo $data["nama_pemilik"]; ?></td>
                <td><?php echo $data["no_telp_pemilik"]; ?></td>
                <td><?php echo $data["ketersediaan_sapi"]; ?></td>
                <td><?php echo $data["ketersediaan_domba"]; ?></td>
                <td><?php echo $data["nama_lengkap"]; ?></td>
                <td>
                    <a href="halPemasok.php?kelola=edit_pemasok&id_pemasok=<?php echo $data["id_pemasok"]; ?>"><button  class="btn-sm btn-danger" name="">Edit</button></a>
                    <a onclick="return konfirmasi()" href="halPemasok.php?hapus_pemasok=<?php echo $data["id_pemasok"]; ?>"><button  class="btn-sm btn-warning" name="">Hapus</button></a>
                </td>
              </tr>
              <?php
              $no++;
              }
      }
      if($_GET["kelola"] =="tambah_pemasok"){ ?>
        <form action="halPemasok.php" method="POST" name="formTambahPemasok" enctype="multipart/form-data">
        <table class="table">
          <tr>
            <td>Nama Peternakan</td>
            <td>:</td>
            <td><input type="text" name="nama_peternakan" /></td>
          </tr>
          <tr>
            <td>Alamat Peternakan</td>
            <td>:</td>
            <td><input type="text" name="alamat_peternakan" /></td>
          </tr>
          <tr>
            <td>Nama Pemilik</td>
            <td>:</td>
            <td><input type="text" name="nama_pemilik" /></td>
          </tr>
          <tr>
            <td>No Telp Pemilik</td>
            <td>:</td>
            <td><input type="text" name="no_telp_pemilik" /></td>
          </tr>
          <tr>
            <td>Ketersediaan Sapi</td>
            <td>:</td>
            <td><input type="text" name="ketersediaan_sapi" /></td>
          </tr>
          <tr>
            <td>Ketersediaan Domba</td>
            <td>:</td>
            <td><input type="text" name="ketersediaan_domba" /></td>
          </tr>
          <tr>
            <td>Petugas Hewan<br/><i>(Yang menangani pasokan hewan)</i></td>
            <td>:</td>
            <td>
              <select name="id_karyawan">
                <?php
                $no=1;
                foreach($karyawan->tampil_karyawan_byjabatan() as $data){
                ?>
                  <option value="<?php echo $data['id_karyawan']; ?>"><?php echo $data['nama_lengkap']; ?></<option>
                <?php
                }
                ?>
              </select>
            </td>
          </tr>
          <tr>
            <td></td>
            <td></td>
            <td>
              <input type="submit" class="btn btn-success" name="simpan1" value="Simpan" />
              <input type="reset" class="btn btn-default" name="reset" value="Reset" />
            </td>
          </tr>
        </table>
        </form>
      <?php
      }if($_GET["kelola"] == "edit_pemasok"){
        $id_pemasok = $_GET["id_pemasok"];
        foreach($pemasok->tampil_pemasok_byid($id_pemasok) as $data){
      ?>
        <form action="halPemasok.php" method="POST" name="formEditPemasok" enctype="multipart/form-data">
        <table class="table">
          <input type="hidden" name="id_pemasok" value="<?php echo $id_pemasok; ?>" />
          <tr>
            <td>Nama Peternakan</td>
            <td>:</td>
            <td><input type="text" name="nama_peternakan" value="<?php echo $data["nama_peternakan"]; ?>"/></td>
          </tr>
          <tr>
            <td>Alamat Peternakan</td>
            <td>:</td>
            <td><input type="text" name="alamat_peternakan" value="<?php echo $data["alamat_peternakan"]; ?>"/></td>
          </tr>
          <tr>
            <td>Nama Pemilik</td>
            <td>:</td>
            <td><input type="text" name="nama_pemilik" value="<?php echo $data["nama_pemilik"]; ?>"/></td>
          </tr>
          <tr>
            <td>No Telepon Pemilik</td>
            <td>:</td>
            <td><input type="text" name="no_telp_pemilik" value="<?php echo $data["no_telp_pemilik"]; ?>"/></td>
          </tr>
          <tr>
            <td>Ketersediaan Sapi</td>
            <td>:</td>
            <td><input type="text" name="ketersediaan_sapi" value="<?php echo $data["ketersediaan_sapi"]; ?>"/></td>
          </tr>
          <tr>
            <td>Ketersediaan Domba</td>
            <td>:</td>
            <td>
              <input type="text" name="ketersediaan_domba" value="<?php echo $data["ketersediaan_domba"]; ?>"/></td>
            </td>
          </tr>
          <tr>
            <td>Ganti Petugas Hewan</td>
            <td>:</td>
            <td>
              <input type="hidden" name="id_karyawan_lama" value="<?php echo $data["id_karyawan"]; ?>"/>
              <select name="id_karyawan">
                  <option value="">-</option>
                <?php
                $no=1;
                foreach($karyawan->tampil_karyawan_byjabatan() as $datas){
                ?>
                  <option value="<?php echo $datas['id_karyawan']; ?>"><?php echo $datas['nama_lengkap']; ?></<option>
                <?php
                }
                ?>
              </select>
            </td>
          </tr>
          <tr>
            <td></td>
            <td></td>
            <td>
              <input type="submit" class="btn btn-success" name="ubah_pasok" value="Simpan" />
              <!-- <input type="reset" name="reset" value="Reset" />
              lihat bagian ini di class diagram
              -->
            </td>
          </tr>
        </table>
        </form>
      <?php
        }
      }
    }
    ?>

    <?php
    if(isset($_GET["kata_kunci"])){
    ?>
    <a href="halPemasok.php?kelola=tambah_pemasok"><button class="btn btn-info" name="">Tambah</button></a>
    <br><br>
    <form name="" action="halPemasok.php" method="get">
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
    </form><br>
    <table class="table table-bordered table2 table-responsive" name="formPemasok">
      <thead>
        <tr class="tr1">
          <th>No</th>
          <th>Nama Peternakan</th>
          <th>Alamat Peternakan</th>
          <th>Nama Pemilik</th>
          <th>No Telp Pemilik</th>
          <th>Ketersediaan Sapi</th>
          <th>Ketersediaan Domba</th>
          <th>Aksi</th>
      </thead>
      <tbody>
    <?php
        $no = 1;
        $kata_kunci = $_GET['kata_kunci'];
        foreach($pemasok->cari_pemasok($kata_kunci) as $data){
          ?>
          <tr>
            <td><?php echo $no; ?></td>
            <td><?php echo $data["nama_peternakan"]; ?></td>
            <td><?php echo $data["alamat_peternakan"]; ?></td>
            <td><?php echo $data["nama_pemilik"]; ?></td>
            <td><?php echo $data["no_telp_pemilik"]; ?></td>
            <td><?php echo $data["ketersediaan_sapi"]; ?></td>
            <td><?php echo $data["ketersediaan_domba"]; ?></td>
            <td>
                <a href="halPemasok.php?kelola=edit_pemasok&id_pemasok=<?php echo $data["id_pemasok"]; ?>"><button  class="btn-sm btn-danger" name="">Edit</button></a>
                <a onclick="return konfirmasi()" href="halPemasok.php?hapus_pemasok=<?php echo $data["id_pemasok"]; ?>"><button  class="btn-sm btn-warning" name="">Hapus</button></a>
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
    </div>
  </body>
</html>
