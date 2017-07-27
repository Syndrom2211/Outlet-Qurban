<?php
include_once("../../class/Koneksi.php");

class Pemasok extends Koneksi{
  private $id_pemasok;
  private $id_karyawan;
  private $nama_peternakan;
  private $alamat_peternakan;
  private $nama_pemilik;
  private $no_telp_pemilik;
  private $ketersedian_sapi;
  private $ketersedian_domba;


  public function tampil_pemasok(){
    $sql       = "SELECT * FROM pemasok, karyawan WHERE pemasok.id_karyawan = karyawan.id_karyawan";
    $eksekusi  = $this->koneksi->query($sql);

    while($data = $eksekusi->fetch_array(MYSQLI_ASSOC)){
      $hasil[] = $data;
    }

    return $hasil;
  }

  public function tampil_pemasok_byid($id_pemasok){
    $this->id_pemasok = $id_pemasok;

    $sql       = "SELECT * FROM pemasok WHERE id_pemasok = '".$this->id_pemasok."'";
    $eksekusi  = $this->koneksi->query($sql);

    while($data = $eksekusi->fetch_array(MYSQLI_ASSOC)){
      $hasil[] = $data;
    }

    return $hasil;
  }

  public function hapus_pemasok($id_pemasok){
    $this->id_pemasok = $id_pemasok;

    $sql      = "DELETE FROM pemasok WHERE id_pemasok = '".$this->id_pemasok."'";
    $eksekusi = $this->koneksi->query($sql);

    return TRUE;
  }

  public function tambah_pemasok($dataidkaryawan, $datanama_peternakan, $dataalamat_peternakan, $datanama_pemilik, $datano_telp_pemilik, $dataketersediaan_sapi, $dataketersediaan_domba){
    $this->nama_peternakan    = $datanama_peternakan;
    $this->alamat_peternakan    = $dataalamat_peternakan;
    $this->nama_pemilik         = $datanama_pemilik;
    $this->no_telp_pemilik      = $datano_telp_pemilik;
    $this->ketersedian_sapi     = $dataketersediaan_sapi;
    $this->ketersedian_domba    = $dataketersediaan_domba;

    //id_karyawan masih null
    $sql = "INSERT INTO pemasok VALUES(NULL,'".$dataidkaryawan."','".$this->nama_peternakan."','".$this->alamat_peternakan."','".$this->nama_pemilik."','".$this->no_telp_pemilik."','".$this->ketersedian_sapi."','".$this->ketersedian_domba."')";
    $eksekusi = $this->koneksi->query($sql);

    return TRUE;
  }

  public function edit_pemasok($id_karyawan_lama, $dataid_karyawan, $dataid_pemasok, $datanama_peternakan, $datalamat_peternakan, $datanama_pemilik, $datano_telp_pemilik, $dataketersediaan_sapi, $dataketersediaan_domba){
    $this->id_karyawan        = $dataid_karyawan;
    $this->id_pemasok         = $dataid_pemasok;
    $this->nama_peternakan    = $datanama_peternakan;
    $this->alamat_peternakan  = $datalamat_peternakan;
    $this->nama_pemilik       = $datanama_pemilik;
    $this->no_telp_pemilik    = $datano_telp_pemilik;
    $this->ketersediaan_sapi  = $dataketersediaan_sapi;
    $this->ketersediaan_domba = $dataketersediaan_domba;

    // Kondisi Update
    if(!empty($this->id_karyawan)){
      $sql = "UPDATE pemasok SET id_karyawan = '".$this->id_karyawan."', nama_peternakan = '".$this->nama_peternakan."', alamat_peternakan = '".$this->alamat_peternakan."', nama_pemilik = '".$this->nama_pemilik."', no_telp_pemilik = '".$this->no_telp_pemilik."', ketersediaan_sapi = '".$this->ketersediaan_sapi."', ketersediaan_domba = '".$this->ketersediaan_domba."' WHERE id_pemasok = '".$this->id_pemasok."'";
      $eksekusi = $this->koneksi->query($sql);
    }else if(empty($this->id_karyawan)){
      $sql = "UPDATE pemasok SET id_karyawan = '".$id_karyawan_lama."', nama_peternakan = '".$this->nama_peternakan."', alamat_peternakan = '".$this->alamat_peternakan."', nama_pemilik = '".$this->nama_pemilik."', no_telp_pemilik = '".$this->no_telp_pemilik."', ketersediaan_sapi = '".$this->ketersediaan_sapi."', ketersediaan_domba = '".$this->ketersediaan_domba."' WHERE id_pemasok = '".$this->id_pemasok."'";
      $eksekusi = $this->koneksi->query($sql);
    }

    return TRUE;
  }

  public function cari_pemasok($kata_kunci){
    $sql       = "SELECT * FROM pemasok WHERE nama_peternakan REGEXP '$kata_kunci.*' OR alamat_peternakan REGEXP '$kata_kunci.*' OR nama_pemilik REGEXP '$kata_kunci.*' OR no_telp_pemilik REGEXP '$kata_kunci.*' OR ketersediaan_sapi REGEXP '$kata_kunci.*' OR ketersediaan_domba REGEXP '$kata_kunci.*'";
    $eksekusi  = $this->koneksi->query($sql);

    while($data = $eksekusi->fetch_array(MYSQLI_ASSOC)){
      $hasil[] = $data;
    }

    return $hasil;
  }
}
?>
