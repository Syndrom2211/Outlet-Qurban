<?php
include_once("../../class/Koneksi.php");

class Karyawan extends Koneksi{
  private $id_karyawan;
  private $foto;
  private $nama_lengkap;
  private $usia;
  private $jk;
  private $alamat;
  private $no_telp;
  private $jabatan;
  private $username_karyawan;
  private $password_karyawan;
  private $email;

  public function login($datausername, $datapassword){
    $this->username = $datausername;
    $this->password = $datapassword;

    $sql      = "SELECT * FROM karyawan WHERE username='".$this->username."' AND password = '".md5($this->password)."'";
    $eksekusi = $this->koneksi->query($sql);
    $data     = $eksekusi->fetch_array(MYSQLI_ASSOC);
    $sesi_cek = $eksekusi->num_rows;

    if($sesi_cek == 1){
        if($data["jabatan"] == "Admin"){
          $_SESSION["status"]   = TRUE;
          $_SESSION["id_karyawan"] = $data["id_karyawan"];
          $_SESSION["username"] = $data["username"];
          $_SESSION["jabatan"]  = $data["jabatan"];
          echo '<meta http-equiv="refresh" content="0; url=halKaryawan.php">';
          return TRUE;
        }if($data["jabatan"] == "PKasir"){
          $_SESSION["status"]   = TRUE;
          $_SESSION["id_karyawan"] = $data["id_karyawan"];
          $_SESSION["username"] = $data["username"];
          $_SESSION["jabatan"]  = $data["jabatan"];
          echo '<meta http-equiv="refresh" content="0; url=halTransaksi.php">';
          return TRUE;
        }if($data["jabatan"] == "PHewan"){
          $_SESSION["status"]   = TRUE;
          $_SESSION["id_karyawan"] = $data["id_karyawan"];
          $_SESSION["username"] = $data["username"];
          $_SESSION["jabatan"]  = $data["jabatan"];
          echo '<meta http-equiv="refresh" content="0; url=halDataHewan.php">';
          return TRUE;
        }if($data["jabatan"] == ""){
          $_SESSION["status"]   = FALSE;
          echo '<meta http-equiv="refresh" content="0; url=halLogin.php">';
          return FALSE;
        }
      }
  }

  public function tampil($username){
    $sql      = "SELECT * FROM karyawan WHERE username='".$username."'";
    $eksekusi = $this->koneksi->query($sql);
    $data     = $eksekusi->fetch_array(MYSQLI_ASSOC);
    echo $data["username"];
  }

  public function logout(){
    $_SESSION["status"] = FALSE;
    session_destroy();
  }

  public function tampil_karyawan(){
    $sql       = "SELECT * FROM karyawan";
    $eksekusi  = $this->koneksi->query($sql);

    while($data = $eksekusi->fetch_array(MYSQLI_ASSOC)){
      $hasil[] = $data;
    }

    return $hasil;
  }

  public function ceksesi(){
    return isset($_SESSION["status"]);
  }

  public function tampil_karyawan_byid($id_karyawan){
    $this->id_karyawan = $id_karyawan;

    $sql       = "SELECT * FROM karyawan WHERE id_karyawan = '".$this->id_karyawan."'";
    $eksekusi  = $this->koneksi->query($sql);

    while($data = $eksekusi->fetch_array(MYSQLI_ASSOC)){
      $hasil[] = $data;
    }

    return $hasil;
  }

  public function tampil_karyawan_byjabatan(){
    $sql       = "SELECT * FROM karyawan WHERE jabatan = 'PHewan'";
    $eksekusi  = $this->koneksi->query($sql);

    while($data = $eksekusi->fetch_array(MYSQLI_ASSOC)){
      $hasil[] = $data;
    }

    return $hasil;
  }

  public function hapus_karyawan($id_karyawan){
    $this->id_karyawan = $id_karyawan;

    $sql      = "DELETE FROM karyawan WHERE id_karyawan = '".$this->id_karyawan."'";
    $eksekusi = $this->koneksi->query($sql);

    return TRUE;
  }

  public function tambah_karyawan($datafoto, $datanama_lengkap, $datausia, $datajk, $dataalamat, $datano_telp, $datajabatan, $datausername, $datapassword, $dataemail){
    $this->foto         = $datafoto;
    $this->nama_lengkap = $datanama_lengkap;
    $this->usia         = $datausia;
    $this->jk           = $datajk;
    $this->alamat       = $dataalamat;
    $this->no_telp      = $datano_telp;
    $this->jabatan      = $datajabatan;
    $this->username     = $datausername;
    $this->password     = $datapassword;
    $this->email        = $dataemail;

    $sql = "INSERT INTO karyawan VALUES(NULL,'".$this->foto."','".$this->nama_lengkap."','".$this->usia."','".$this->jk."','".$this->alamat."','".$this->no_telp."','".$this->jabatan."','".$this->username."','".md5($this->password)."','".$this->email."')";
    $eksekusi = $this->koneksi->query($sql);

    return TRUE;
  }

  public function edit_karyawan($dataerror, $dataid, $datafotolama, $datafoto, $datanama_lengkap, $datausia, $datajklama, $datajkbaru, $dataalamat, $datano_telp, $datajabatan, $datajabatanlama, $datausername, $datapassword, $datapasswordlama, $dataemail){
    $this->id_karyawan  = $dataid;
    $this->foto         = $datafoto;
    $this->nama_lengkap = $datanama_lengkap;
    $this->usia         = $datausia;
    $this->jk           = $datajkbaru;
    $this->alamat       = $dataalamat;
    $this->no_telp      = $datano_telp;
    $this->jabatan      = $datajabatan;
    $this->username     = $datausername;
    $this->password     = $datapassword;
    $this->email        = $dataemail;

    // Kondisi Update
    if(($dataerror == 0) && !empty($this->jk) && !empty($this->jabatan) && !empty($this->password)){
      $sql = "UPDATE karyawan SET foto = '".$this->foto."', nama_lengkap = '".$this->nama_lengkap."', usia = '".$this->usia."', jk = '".$this->jk."', alamat = '".$this->alamat."', no_telp = '".$this->no_telp."', jabatan = '".$this->jabatan."', username = '".$this->username."', password = '".md5($this->password)."', email = '".$this->email."' WHERE id_karyawan = '".$this->id_karyawan."'";
      $eksekusi = $this->koneksi->query($sql);
    }else if(($dataerror == 0) && !empty($this->jk) && !empty($this->jabatan) && empty($this->password)){
      $sql = "UPDATE karyawan SET foto = '".$this->foto."', nama_lengkap = '".$this->nama_lengkap."', usia = '".$this->usia."', jk = '".$this->jk."', alamat = '".$this->alamat."', no_telp = '".$this->no_telp."', jabatan = '".$this->jabatan."', username = '".$this->username."', password = '".$datapasswordlama."', email = '".$this->email."' WHERE id_karyawan = '".$this->id_karyawan."'";
      $eksekusi = $this->koneksi->query($sql);
    }else if(($dataerror == 0) && !empty($this->jk) && empty($this->jabatan) && empty($this->password)){
      $sql = "UPDATE karyawan SET foto = '".$this->foto."', nama_lengkap = '".$this->nama_lengkap."', usia = '".$this->usia."', jk = '".$this->jk."', alamat = '".$this->alamat."', no_telp = '".$this->no_telp."', jabatan = '".$datajabatanlama."', username = '".$this->username."', password = '".$datapasswordlama."', email = '".$this->email."' WHERE id_karyawan = '".$this->id_karyawan."'";
      $eksekusi = $this->koneksi->query($sql);
    }else if(($dataerror == 0) && empty($this->jk) && empty($this->jabatan) && empty($this->password)){
      $sql = "UPDATE karyawan SET foto = '".$this->foto."', nama_lengkap = '".$this->nama_lengkap."', usia = '".$this->usia."', jk = '".$datajklama."', alamat = '".$this->alamat."', no_telp = '".$this->no_telp."', jabatan = '".$datajabatanlama."', username = '".$this->username."', password = '".$datapasswordlama."', email = '".$this->email."' WHERE id_karyawan = '".$this->id_karyawan."'";
      $eksekusi = $this->koneksi->query($sql);
    }else if(($dataerror == 4) && empty($this->jk) && empty($this->jabatan) && empty($this->password)){
      $sql = "UPDATE karyawan SET foto = '".$datafotolama."', nama_lengkap = '".$this->nama_lengkap."', usia = '".$this->usia."', jk = '".$datajklama."', alamat = '".$this->alamat."', no_telp = '".$this->no_telp."', jabatan = '".$datajabatanlama."', username = '".$this->username."', password = '".$datapasswordlama."', email = '".$this->email."' WHERE id_karyawan = '".$this->id_karyawan."'";
      $eksekusi = $this->koneksi->query($sql);
    }else if(($dataerror == 4) && !empty($this->jk) && !empty($this->jabatan) && !empty($this->password)){
      $sql = "UPDATE karyawan SET foto = '".$datafotolama."', nama_lengkap = '".$this->nama_lengkap."', usia = '".$this->usia."', jk = '".$this->jk."', alamat = '".$this->alamat."', no_telp = '".$this->no_telp."', jabatan = '".$this->jabatan."', username = '".$this->username."', password = '".md5($this->password)."', email = '".$this->email."' WHERE id_karyawan = '".$this->id_karyawan."'";
      $eksekusi = $this->koneksi->query($sql);
    }else if(($dataerror == 4) && !empty($this->jk) && empty($this->jabatan) && !empty($this->password)){
      $sql = "UPDATE karyawan SET foto = '".$datafotolama."', nama_lengkap = '".$this->nama_lengkap."', usia = '".$this->usia."', jk = '".$this->jk."', alamat = '".$this->alamat."', no_telp = '".$this->no_telp."', jabatan = '".$datajabatanlama."', username = '".$this->username."', password = '".md5($this->password)."', email = '".$this->email."' WHERE id_karyawan = '".$this->id_karyawan."'";
      $eksekusi = $this->koneksi->query($sql);
    }else if(($dataerror == 4) && !empty($this->jk) && empty($this->jabatan) && empty($this->password)){
      $sql = "UPDATE karyawan SET foto = '".$datafotolama."', nama_lengkap = '".$this->nama_lengkap."', usia = '".$this->usia."', jk = '".$this->jk."', alamat = '".$this->alamat."', no_telp = '".$this->no_telp."', jabatan = '".$datajabatanlama."', username = '".$this->username."', password = '".$datapasswordlama."', email = '".$this->email."' WHERE id_karyawan = '".$this->id_karyawan."'";
      $eksekusi = $this->koneksi->query($sql);
    }else if(($dataerror == 4) && empty($this->jk) && !empty($this->jabatan) && !empty($this->password)){
      $sql = "UPDATE karyawan SET foto = '".$datafotolama."', nama_lengkap = '".$this->nama_lengkap."', usia = '".$this->usia."', jk = '".$datajklama."', alamat = '".$this->alamat."', no_telp = '".$this->no_telp."', jabatan = '".$this->jabatan."', username = '".$this->username."', password = '".md5($this->password)."', email = '".$this->email."' WHERE id_karyawan = '".$this->id_karyawan."'";
      $eksekusi = $this->koneksi->query($sql);
    }else if(($dataerror == 4) && empty($this->jk) && !empty($this->jabatan) && empty($this->password)){
      $sql = "UPDATE karyawan SET foto = '".$datafotolama."', nama_lengkap = '".$this->nama_lengkap."', usia = '".$this->usia."', jk = '".$datajklama."', alamat = '".$this->alamat."', no_telp = '".$this->no_telp."', jabatan = '".$this->jabatan."', username = '".$this->username."', password = '".$datapasswordlama."', email = '".$this->email."' WHERE id_karyawan = '".$this->id_karyawan."'";
      $eksekusi = $this->koneksi->query($sql);
    }else if(($dataerror == 4) && empty($this->jk) && empty($this->jabatan) && !empty($this->password)){
      $sql = "UPDATE karyawan SET foto = '".$datafotolama."', nama_lengkap = '".$this->nama_lengkap."', usia = '".$this->usia."', jk = '".$datajklama."', alamat = '".$this->alamat."', no_telp = '".$this->no_telp."', jabatan = '".$datajabatanlama."', username = '".$this->username."', password = '".md5($this->password)."', email = '".$this->email."' WHERE id_karyawan = '".$this->id_karyawan."'";
      $eksekusi = $this->koneksi->query($sql);
    }

    return TRUE;
  }

  public function cari_karyawan($kata_kunci){
    $sql       = "SELECT * FROM karyawan WHERE nama_lengkap REGEXP '$kata_kunci.*' OR usia REGEXP '$kata_kunci.*' OR jk REGEXP '$kata_kunci.*' OR alamat REGEXP '$kata_kunci.*' OR no_telp REGEXP '$kata_kunci.*' OR jabatan REGEXP '$kata_kunci.*' OR username REGEXP '$kata_kunci.*' OR password REGEXP '$kata_kunci.*' OR email REGEXP '$kata_kunci.*'";
    $eksekusi  = $this->koneksi->query($sql);

    while($data = $eksekusi->fetch_array(MYSQLI_ASSOC)){
      $hasil[] = $data;
    }

    return $hasil;
  }
}

?>
