<?php
include_once("../../class/Koneksi.php");

class DataHewan extends Koneksi{
  private $id_hewan;
  private $jenis;
  private $foto;
  private $usia;
  private $level;
  private $berat;
  private $kondisi_fisik;
  private $harga;

  public function tampil_hewan(){
    $hasil = NULL;
    $sql       = "SELECT * FROM datahewan";
    $eksekusi  = $this->koneksi->query($sql);

    while($data = $eksekusi->fetch_array(MYSQLI_ASSOC)){
      $hasil[] = $data;
    }

    return $hasil;
  }

  public function tampil_hewan_byid($id_hewan){
    $this->id_hewan = $id_hewan;
    $sql = "SELECT * FROM datahewan WHERE id_hewan='".$this->id_hewan."'";
    $eksekusi = $this->koneksi->query($sql);

    while($data = $eksekusi->fetch_array(MYSQLI_ASSOC)){
      $hasil[] = $data;
    }
    return $hasil;
  }

  public function tambah_hewan($jenis,$foto,$usia,$level,$berat,$kondisi_fisik,$harga){
    $this->jenis = $jenis;
    $this->foto = $foto;
    $this->usia = $usia;
    $this->level = $level;
    $this->berat = $berat;
    $this->kondisi_fisik = $kondisi_fisik;
    $this->harga = $harga;

    $sql ="INSERT INTO datahewan VALUES(NULL,'".$this->jenis."','".$this->foto."','".$this->usia."','".$this->level."','".$this->berat."','".$this->kondisi_fisik."','".$this->harga."')";
    $eksekusi = $this->koneksi->query($sql);
    return TRUE;
  }

  public function hapus_hewan($id_hewan){
    $this->id_hewan = $id_hewan;

    $sql = "DELETE from datahewan WHERE id_hewan='".$this->id_hewan."'";

    $eksekusi = $this->koneksi->query($sql);
    return TRUE;
  }

  public function edit_hewan($dataerror, $datafoto, $dataid_hewan, $foto_lama, $level_lama, $kondisi_fisik_lama, $datajenis, $jenis_lama, $datausia, $datalevel, $databerat, $datakondisi_fisik, $dataharga){
    $this->id_hewan = $dataid_hewan;
    $this->jenis = $datajenis;
    $this->foto = $datafoto;
    $this->usia  = $datausia;
    $this->level = $datalevel;
    $this->berat = $databerat;
    $this->kondisi_fisik = $datakondisi_fisik;
    $this->harga = $dataharga;

    // Kondisi Update
    if(($dataerror == 0) && !empty($this->jenis) && !empty($this->level) && !empty($this->kondisi_fisik)){
      $sql = "UPDATE datahewan SET jenis = '".$this->jenis."', foto = '".$this->foto."', usia = '".$this->usia."', level = '".$this->level."', berat = '".$this->berat."', kondisi_fisik = '".$this->kondisi_fisik."', harga = '".$this->harga."' WHERE id_hewan = '".$this->id_hewan."'";
      $eksekusi = $this->koneksi->query($sql);
    }else if(($dataerror == 0) && !empty($this->jenis) && !empty($this->level) && empty($this->kondisi_fisik)){
      $sql = "UPDATE datahewan SET jenis = '".$this->jenis."', foto = '".$this->foto."', usia = '".$this->usia."', level = '".$this->level."', berat = '".$this->berat."', kondisi_fisik = '".$kondisi_fisik_lama."', harga = '".$this->harga."' WHERE id_hewan = '".$this->id_hewan."'";
      $eksekusi = $this->koneksi->query($sql);
    }else if(($dataerror == 0) && !empty($this->jenis) && empty($this->level) && empty($this->kondisi_fisik)){
      $sql = "UPDATE datahewan SET jenis = '".$this->jenis."', foto = '".$this->foto."', usia = '".$this->usia."', level = '".$level_lama."', berat = '".$this->berat."', kondisi_fisik = '".$kondisi_fisik_lama."', harga = '".$this->harga."' WHERE id_hewan = '".$this->id_hewan."'";
      $eksekusi = $this->koneksi->query($sql);
    }else if(($dataerror == 0) && empty($this->jenis) && empty($this->level) && empty($this->kondisi_fisik)){
      $sql = "UPDATE datahewan SET jenis = '".$jenis_lama."', foto = '".$this->foto."', usia = '".$this->usia."', level = '".$level_lama."', berat = '".$this->berat."', kondisi_fisik = '".$kondisi_fisik_lama."', harga = '".$this->harga."' WHERE id_hewan = '".$this->id_hewan."'";
      $eksekusi = $this->koneksi->query($sql);
    }else if(($dataerror == 4) && !empty($this->jenis) && !empty($this->level) && !empty($this->kondisi_fisik)){
      $sql = "UPDATE datahewan SET jenis = '".$this->jenis."', foto = '".$foto_lama."', usia = '".$this->usia."', level = '".$this->level."', berat = '".$this->berat."', kondisi_fisik = '".$this->kondisi_fisik."', harga = '".$this->harga."' WHERE id_hewan = '".$this->id_hewan."'";
      $eksekusi = $this->koneksi->query($sql);
    }else if(($dataerror == 4) && empty($this->jenis) && empty($this->level) && !empty($this->kondisi_fisik)){
      $sql = "UPDATE datahewan SET jenis = '".$jenis_lama."', foto = '".$foto_lama."', usia = '".$this->usia."', level = '".$level_lama."', berat = '".$this->berat."', kondisi_fisik = '".$this->kondisi_fisik."', harga = '".$this->harga."' WHERE id_hewan = '".$this->id_hewan."'";
      $eksekusi = $this->koneksi->query($sql);
    }else if(($dataerror == 4) && empty($this->jenis) && !empty($this->level) && !empty($this->kondisi_fisik)){
      $sql = "UPDATE datahewan SET jenis = '".$jenis_lama."', foto = '".$foto_lama."', usia = '".$this->usia."', level = '".$this->level."', berat = '".$this->berat."', kondisi_fisik = '".$this->kondisi_fisik."', harga = '".$this->harga."' WHERE id_hewan = '".$this->id_hewan."'";
      $eksekusi = $this->koneksi->query($sql);
    }else if(($dataerror == 4) && !empty($this->jenis) && empty($this->level) && !empty($this->kondisi_fisik)){
      $sql = "UPDATE datahewan SET jenis = '".$this->jenis."', foto = '".$foto_lama."', usia = '".$this->usia."', level = '".$level_lama."', berat = '".$this->berat."', kondisi_fisik = '".$this->kondisi_fisik."', harga = '".$this->harga."' WHERE id_hewan = '".$this->id_hewan."'";
      $eksekusi = $this->koneksi->query($sql);
    }else if(($dataerror == 4) && empty($this->jenis) && empty($this->level) && empty($this->kondisi_fisik)){
      $sql = "UPDATE datahewan SET jenis = '".$jenis_lama."', foto = '".$foto_lama."', usia = '".$this->usia."', level = '".$level_lama."', berat = '".$this->berat."', kondisi_fisik = '".$kondisi_fisik_lama."', harga = '".$this->harga."' WHERE id_hewan = '".$this->id_hewan."'";
      $eksekusi = $this->koneksi->query($sql);
    }else if(($dataerror == 4) && empty($this->jenis) && !empty($this->level) && empty($this->kondisi_fisik)){
      $sql = "UPDATE datahewan SET jenis = '".$jenis_lama."', foto = '".$foto_lama."', usia = '".$this->usia."', level = '".$this->level."', berat = '".$this->berat."', kondisi_fisik = '".$kondisi_fisik_lama."', harga = '".$this->harga."' WHERE id_hewan = '".$this->id_hewan."'";
      $eksekusi = $this->koneksi->query($sql);
    }else if(($dataerror == 4) && !empty($this->jenis) && empty($this->level) && empty($this->kondisi_fisik)){
      $sql = "UPDATE datahewan SET jenis = '".$this->jenis."', foto = '".$foto_lama."', usia = '".$this->usia."', level = '".$level_lama."', berat = '".$this->berat."', kondisi_fisik = '".$kondisi_fisik_lama."', harga = '".$this->harga."' WHERE id_hewan = '".$this->id_hewan."'";
      $eksekusi = $this->koneksi->query($sql);
    }

    return TRUE;
  }

  public function cari_hewan($kata_kunci){
    $sql       = "SELECT * FROM datahewan WHERE jenis REGEXP '$kata_kunci.*' OR usia REGEXP '$kata_kunci.*' OR level REGEXP '$kata_kunci.*' OR berat REGEXP '$kata_kunci.*' OR kondisi_fisik REGEXP '$kata_kunci.*' OR harga REGEXP '$kata_kunci.*'";
    $eksekusi  = $this->koneksi->query($sql);

    while($data = $eksekusi->fetch_array(MYSQLI_ASSOC)){
      $hasil[] = $data;
    }

    return $hasil;
  }
}
?>
