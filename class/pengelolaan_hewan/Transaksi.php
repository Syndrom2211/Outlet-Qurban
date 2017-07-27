<?php
include_once("../../class/Koneksi.php");

class Transaksi extends Koneksi{
  private $id_transaksi;
  private $id_karyawan;
  private $jml_hewan;
  private $total_harga;
  private $metode_bayar;
  private $status_bayar;

  public function hapus_transaksi($id_pelanggan){
    $sql     = "DELETE FROM membelihewan WHERE id_pelanggan='".$id_pelanggan."'";
    $sqldua  = "DELETE FROM pelanggan WHERE id_pelanggan = '".$id_pelanggan."'";
    $eksekusi = $this->koneksi->query($sql);
    $eksekusi = $this->koneksi->query($sqldua);

    return TRUE;
  }

  public function tambah_transaksi($id_transaksi, $jml_hewan, $total_harga, $metode_bayar, $status_bayar){
    $this->id_transaksi   = $id_transaksi;
    $this->jml_hewan      = $jml_hewan;
    $this->total_harga    = $total_harga;
    $this->metode_bayar   = $metode_bayar;
    $this->status_bayar   = $status_bayar;

    $sql = "INSERT INTO transaksi VALUES('".$this->id_transaksi."',NULL,'".$this->jml_hewan."','".$this->total_harga."','".$this->metode_bayar."','".$this->status_bayar."')";
    $eksekusi = $this->koneksi->query($sql);

    return TRUE;
  }

  public function edit_transaksi_byid($id_transaksi, $id_pelanggan){
    $this->id_transaksi   = $id_transaksi;
    $sql = "UPDATE membelihewan SET id_transaksi = '".$this->id_transaksi."' WHERE id_pelanggan = '".$id_pelanggan."'";
    $eksekusi = $this->koneksi->query($sql);

    return TRUE;
  }

  public function edit_transaksi($id_transaksi, $id_karyawan, $datastatus_bayar, $status_bayar_lama){
    $this->id_transaksi   = $id_transaksi;
    $this->status_bayar   = $datastatus_bayar;

    if ($this->status_bayar == "Belum Terverifikasi") {
      $sql = "UPDATE transaksi SET id_transaksi = '".$this->id_transaksi."', id_karyawan = '".$id_karyawan."', status_bayar = '".$status_bayar_lama."' WHERE id_transaksi = '".$id_transaksi."'";
      $eksekusi = $this->koneksi->query($sql);
    }else{
      $sql = "UPDATE transaksi SET id_transaksi = '".$this->id_transaksi."', id_karyawan = '".$id_karyawan."', status_bayar = '".$this->status_bayar."' WHERE id_transaksi = '".$id_transaksi."'";
      $eksekusi = $this->koneksi->query($sql);
    }

    return TRUE;
  }

  public function tampil_transaksi_pelanggan($id_pelanggan){
    $sql = "SELECT transaksi.id_transaksi, transaksi.jml_hewan, transaksi.total_harga, transaksi.metode_bayar, transaksi.status_bayar, pelanggan.nama, pelanggan.jk, pelanggan.alamat, pelanggan.no_telp, membelihewan.tgl_beli, membelihewan.waktu_beli FROM transaksi, membelihewan, pelanggan, datahewan WHERE transaksi.id_transaksi = membelihewan.id_transaksi AND datahewan.id_hewan = membelihewan.id_hewan AND membelihewan.id_pelanggan = pelanggan.id_pelanggan AND membelihewan.id_pelanggan = '".$id_pelanggan."' LIMIT 1";
    $eksekusi = $this->koneksi->query($sql);

    while ($data = $eksekusi->fetch_array(MYSQLI_ASSOC)) {
      $hasil[] = $data;
    }
    return $hasil;
  }

  public function tampil_transaksi_byid($id_transaksi){
    $this->id_transaksi = $id_transaksi;
    $sql = "SELECT * FROM transaksi WHERE id_transaksi='".$this->id_transaksi."'";
    $eksekusi = $this->koneksi->query($sql);

    while($data = $eksekusi->fetch_array(MYSQLI_ASSOC)){
      $hasil[] = $data;
    }

    return $hasil;
  }

  public function tampil_transaksi(){
    $sql = "SELECT * FROM transaksi";
    $eksekusi = $this->koneksi->query($sql);

    while ($data = $eksekusi->fetch_array(MYSQLI_ASSOC)) {
      $hasil[] = $data;
    }

    return $hasil;
  }

  public function cari_transaksi($kata_kunci){
    $sql       = "SELECT * FROM transaksi WHERE id_transaksi REGEXP '$kata_kunci.*' OR jml_hewan REGEXP '$kata_kunci.*' OR total_harga REGEXP '$kata_kunci.*' OR metode_bayar REGEXP '$kata_kunci.*' OR status_bayar REGEXP '$kata_kunci.*'";
    $eksekusi  = $this->koneksi->query($sql);

    while($data = $eksekusi->fetch_array(MYSQLI_ASSOC)){
      $hasil[] = $data;
    }

    return $hasil;
  }
}
?>
