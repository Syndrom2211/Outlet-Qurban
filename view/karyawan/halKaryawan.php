<?php
session_start();
error_reporting(0);
include "../../class/pengelolaan_petugas/Karyawan.php";

$karyawan = new Karyawan();

if(isset($_GET["logout"])){
  echo $karyawan->logout();
  header("Location: halLogin.php");
}

// SESSION
$nama     = $_SESSION["username"];
?>

<!DOCTYPE html>
<html>
  <head>
    <?php include "pages/header.php"; ?>
  </head>
  <body>
    <?php
    include "pages/nav.php";
    //Ubah
    if(isset($_POST["ubah"])){
      // init image
      $target_dir   = "img/";
      $foto         = $target_dir . basename($_FILES["fileToUpload"]["name"]);
      $error        = $_FILES["fileToUpload"]["error"];
      $cek_extensi  = pathinfo($foto,PATHINFO_EXTENSION);
      $pindahgambar = $_FILES["fileToUpload"]["tmp_name"];

      // post data
      $id_karyawan   = $_POST["id_karyawan"];
      $foto_lama     = $_POST["foto_lama"];
      $nama_lengkap  = $_POST["nama_lengkap"];
      $usia          = $_POST["usia"];
      $jk_lama       = $_POST["jk_lama"];
      $jk_baru       = $_POST["jk_baru"];
      $alamat        = $_POST["alamat"];
      $no_telp       = $_POST["no_telp"];
      $jabatan       = $_POST["jabatan"];
      $jabatan_lama  = $_POST["jabatan_lama"];
      $username      = $_POST["username"];
      $password      = $_POST["password"];
      $password_lama = $_POST["password_lama"];
      $email         = $_POST["email"];
      $cek           = $karyawan->edit_karyawan($error, $id_karyawan, $foto_lama, $foto, $nama_lengkap, $usia, $jk_lama, $jk_baru, $alamat, $no_telp, $jabatan, $jabatan_lama, $username, $password, $password_lama, $email);

      if($cek) {
        move_uploaded_file($pindahgambar, $foto);
        echo '<script>alert("data berhasil diubah");</script>';
        echo '<meta http-equiv="refresh" content="0; url=halKaryawan.php?kelola=karyawan"';
      }else{
        echo '<script>alert("data gagal diubah");</script>';
      }
    }

    //Tambah
    if(isset($_POST["simpan"])){
      // init image
      $target_dir   = "img/";
      $foto         = $target_dir . basename($_FILES["fileToUpload"]["name"]);
      $pindahgambar = $_FILES["fileToUpload"]["tmp_name"];

      // post data
      $nama_lengkap = $_POST["nama_lengkap"];
      $usia         = $_POST["usia"];
      $jk           = $_POST["jk"];
      $alamat       = $_POST["alamat"];
      $no_telp      = $_POST["no_telp"];
      $jabatan      = $_POST["jabatan"];
      $username     = $_POST["username"];
      $password     = $_POST["password"];
      $email        = $_POST["email"];

      if(empty($nama_lengkap) || empty($usia) || empty($alamat) || empty($no_telp) || empty($username) || empty($password) || empty($email)) {
        header("Location: halKaryawan.php?kelola=karyawan");
      }else{
        $cek          = $karyawan->tambah_karyawan($foto, $nama_lengkap, $usia, $jk, $alamat, $no_telp, $jabatan, $username, $password, $email);
        if($cek){
          move_uploaded_file($pindahgambar, $foto);
          echo '<script>alert("data berhasil ditambahkan");</script>';
          echo '<meta http-equiv="refresh" content="0; url=halKaryawan.php?kelola=karyawan"';
        }else{
          echo '<script>alert("data gagal ditambahkan");</script>';
        }
      }
    }

    //Hapus
    if(isset($_GET["hapus_karyawan"])){
      $id_karyawan = $_GET["hapus_karyawan"];
      $cek         = $karyawan->hapus_karyawan($id_karyawan);

      if($cek){
        echo '<script>alert("data berhasil dihapus");</script>';
        echo '<meta http-equiv="refresh" content="0; url=halKaryawan.php?kelola=karyawan"';
      }else{
        echo '<script>alert("data gagal dihapus");</script>';
      }
    }
    ?>
    <div class="container-fluid">
      <?php
      if(isset($_GET["kelola"])){
        if($_GET["kelola"] == "karyawan"){ ?>
          <a href="halKaryawan.php?kelola=tambah_karyawan"><button class="btn btn-info" name="">Tambah</button></a>
          <br>
          <br>
          <form name="" action="halKaryawan.php" method="get">
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
          <table class="table table-bordered table2 table-responsive" name="formKaryawan">
            <thead>
              <tr class="tr1">
                <th>No</th>
                <th>Foto</th>
                <th>Nama Lengkap</th>
                <th>Usia</th>
                <th>JK</th>
                <th>Alamat</th>
                <th>No Tlp</th>
                <th>Jabatan</th>
                <th>Username</th>
                <th>Email</th>
                <th>Aksi</th>
              </tr>
            </thead>
            <tbody>
              <?php
              $no = 1;
              foreach($karyawan->tampil_karyawan() as $data){
              ?>
              <tr>
                <td><?php echo $no; ?></td>
                <td><img src='<?php echo $data["foto"]; ?>' width="100px" /></td>
                <td><?php echo $data["nama_lengkap"]; ?></td>
                <td><?php echo $data["usia"]; ?></td>
                <td><?php echo $data["jk"]; ?></td>
                <td><?php echo $data["alamat"]; ?></td>
                <td><?php echo $data["no_telp"]; ?></td>
                <td><?php echo $data["jabatan"]; ?></td>
                <td><?php echo $data["username"]; ?></td>
                <td><?php echo $data["email"]; ?></td>
                <td>
                    <a href="halKaryawan.php?kelola=edit_karyawan&id_karyawan=<?php echo $data["id_karyawan"]; ?>"><button class="btn-sm btn-danger" name="">Edit</button></a>
                    <a onclick="return konfirmasi()" href="halKaryawan.php?hapus_karyawan=<?php echo $data["id_karyawan"]; ?>"><button class="btn-sm btn-warning" name="">Hapus</button></a>
                </td>
              </tr>
              <?php
              $no++;
              }
              ?>
            </tbody>
          </table>
        <?php
        }if($_GET["kelola"] == "tambah_karyawan"){ ?>
          <form class="table3" action="halKaryawan.php" method="POST" name="formTambahKaryawan" enctype="multipart/form-data">
          <table class="table label1" align="center">
            <tr>
              <td>Foto</label></td>
              <td>:</td>
              <td><input class="btn btn-default" type="file" name="fileToUpload" id="fileToUpload"></td>
            </tr>
            <tr>
              <td>Nama Lengkap</td>
              <td>:</td>
              <td ><input type="text" class="form-control input1" name="nama_lengkap" /></td>
            </tr>
            <tr>
              <td>Usia</td>
              <td>:</td>
              <td><input type="text" class="form-control  input1" name="usia" /></td>
            </tr>
            <tr>
              <td>Jenis Kelamin</td>
              <td>:</td>
              <td>
              	<select class="form-control" name="jk">
                  	<option value="L">Laki - Laki</option>
                  	<option value="P">Perempuan</option>
                	</select>
              </td>
            </tr>
            <tr>
              <td>Alamat</td>
              <td>:</td>
              <td><input type="text" class="form-control input1" name="alamat" /></td>
            </tr>
            <tr>
              <td>No Telepon</td>
              <td>:</td>
              <td><input type="text" class="form-control  input1" name="no_telp" /></td>
            </tr>
            <tr>
              <td>Jabatan</td>
              <td>:</td>
              <td>
              	<select class="form-control" name="jabatan">
                  	<option value="Admin">Admin</option>
                  	<option value="PKasir">Petugas Kasir</option>
                  	<option value="PHewan">Petugas Hewan</option>
                </select>
              </td>
            </tr>
            <tr>
              <td>Username</td>
              <td>:</td>
              <td><input type="text" class="form-control input1" name="username" /></td>
            </tr>
            <tr>
              <td>Password</td>
              <td>:</td>
              <td><input type="password" class="form-control input1" name="password" /></td>
            </tr>
            <tr>
              <td>Email</td>
              <td>:</td>
              <td><input type="text" class="form-control col-sm input1" name="email" /></td>
            </tr>
            <tr>
              <td></td>
              <td></td>
              <div class="form-group" align="center">
              <div class="col-sm-offset-2 col-sm-4">
              <td>
                <input type="submit" class="btn btn-success" name="simpan" value="Simpan" align="center" />
                <input type="reset" class="btn btn-default" name="reset" value="Reset" align="center" />
              </td>
              </div>
              </div>
            </tr>
          </table>
          </form>
         <?php
        }if($_GET["kelola"] == "edit_karyawan"){
          $id_karyawan = $_GET["id_karyawan"];
          foreach($karyawan->tampil_karyawan_byid($id_karyawan) as $data){
        ?>
        <div class="row">
          <div class="col-md-5">
        <form action="halKaryawan.php" method="POST" name="formEditKaryawan" enctype="multipart/form-data">
          <table class="table label1">
            <input type="hidden" name="id_karyawan" value="<?php echo $id_karyawan; ?>" />
            <tr>
              <td>Foto</td>
              <td>:</td>
              <td>
                <img src='<?php echo $data["foto"]; ?>' width='100px' />
                <input type="hidden" name="foto_lama" value="<?php echo $data['foto']; ?>" />
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
              <td>Nama Lengkap</td>
              <td>:</td>
              <td><input class="form-control input1" type="text" name="nama_lengkap" value="<?php echo $data["nama_lengkap"]; ?>"/></td>
            </tr>
            <tr>
              <td>Usia</td>
              <td>:</td>
              <td><input class="form-control input1" type="text" name="usia" value="<?php echo $data["usia"]; ?>"/></td>
            </tr>
            <tr>
              <td>Jenis Kelamin</td>
              <td>:</td>
              <td><input class="form-control input1" type="text" name="jk_lama" style="width:50px" value="<?php echo $data["jk"]; ?>" readonly /></td>
            </tr>
            <tr>
              <td>Ganti Jenis Kelamin<br/>
                  <i>(Diganti jika ada kesalahan input)</i>
              </td>
              <td>:</td>
              <td>
                <select class="form-control" name="jk_baru">
                  <option value="">Pilih</option>
                  <option value="L">Laki - Laki</option>
                  <option value="P">Perempuan</option>
                </select>
              </td>
            </tr>
            <tr>
              <td>Alamat</td>
              <td>:</td>
              <td><input class="form-control input1" type="text" name="alamat" value="<?php echo $data["alamat"]; ?>"/></td>
            </tr>
            <tr>
              <td>No Telepon</td>
              <td>:</td>
              <td><input class="form-control input1" type="text" name="no_telp" value="<?php echo $data["no_telp"]; ?>"/></td>
            </tr>
            <tr>
              <td>Jabatan</td>
              <td>:</td>
              <td>
                <select class="form-control" name="jabatan">
                  <option value="">Pilih</option>
                  <option value="Admin">Admin</option>
                  <option value="PKasir">Petugas Kasir</option>
                  <option value="PHewan">Petugas Hewan</option>
                </select>
                <input type="hidden" name="jabatan_lama" value="<?php echo $data["jabatan"]; ?>"/></td>
              </td>
            </tr>
            <tr>
              <td>Username</td>
              <td>:</td>
              <td><input class="form-control input1" type="text" name="username" value="<?php echo $data["username"]; ?>"/></td>
            </tr>
            <tr>
              <td>
                Password<br/>
                <i>(Di isi jika ingin diganti password)</i>
              </td>
              <td>:</td>
              <td>
                <input class="form-control input1" type="password" name="password" value="" />
                <input type="hidden" name="password_lama" value="<?php echo $data["password"]; ?>" />
              </td>
            </tr>
            <tr>
              <td>Email</td>
              <td>:</td>
              <td><input class="form-control input1" type="email" name="email" value="<?php echo $data["email"]; ?>"/></td>
            </tr>
            <tr>
              <td></td>
              <td></td>
              <td>
                <input class="btn btn-success" type="submit" name="ubah" value="Simpan" />
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
      }if(!isset($_GET['kelola']) && (!isset($_GET['kata_kunci']))){
        ?>
          Hi, <?php echo $karyawan->tampil($nama); ?>
        <?php
      }

      if(isset($_GET["kata_kunci"])){ ?>
        <a href="halKaryawan.php?kelola=tambah_karyawan"><button class="btn btn-info" name="">Tambah</button></a>
        <br>
        <br>
        <form name="" action="halKaryawan.php" method="get">
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
        <table class="table table-bordered table2 table-responsive" name="formKaryawan">
          <thead>
            <tr class="tr1">
              <th>No</th>
              <th>Foto</th>
              <th>Nama Lengkap</th>
              <th>Usia</th>
              <th>JK</th>
              <th>Alamat</th>
              <th>No Tlp</th>
              <th>Jabatan</th>
              <th>Username</th>
              <th>Email</th>
              <th>Aksi</th>
            </tr>
          </thead>
          <tbody>
          <?php
          $no = 1;
          $kata_kunci = $_GET['kata_kunci'];
          foreach($karyawan->cari_karyawan($kata_kunci) as $data){
            ?>
            <tr>
              <td><?php echo $no; ?></td>
              <td><img src='<?php echo $data["foto"]; ?>' width="100px" /></td>
              <td><?php echo $data["nama_lengkap"]; ?></td>
              <td><?php echo $data["usia"]; ?></td>
              <td><?php echo $data["jk"]; ?></td>
              <td><?php echo $data["alamat"]; ?></td>
              <td><?php echo $data["no_telp"]; ?></td>
              <td><?php echo $data["jabatan"]; ?></td>
              <td><?php echo $data["username"]; ?></td>
              <td><?php echo $data["email"]; ?></td>
              <td>
                  <a href="halKaryawan.php?kelola=edit_karyawan&id_karyawan=<?php echo $data["id_karyawan"]; ?>"><button class="btn-sm btn-danger" name="">Edit</button></a>
                  <a onclick="return konfirmasi()" href="halKaryawan.php?hapus_karyawan=<?php echo $data["id_karyawan"]; ?>"><button class="btn-sm btn-warning" name="">Hapus</button></a>
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
