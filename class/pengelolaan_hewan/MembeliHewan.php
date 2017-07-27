<?php
include_once("../../class/Koneksi.php");
include_once("../../assets/lib/PHPExcel.php");
date_default_timezone_set("Asia/Jakarta");

class MembeliHewan extends Koneksi{
  private $id_beli;
  private $id_pelanggan;
  private $id_hewan;
  private $tgl_beli;
  private $waktu_beli;

  public function cari_hewan($kata_kunci){
    $sql       = "SELECT * FROM datahewan WHERE jenis REGEXP '$kata_kunci.*' OR usia REGEXP '$kata_kunci.*' OR level REGEXP '$kata_kunci.*' OR berat REGEXP '$kata_kunci.*' OR kondisi_fisik REGEXP '$kata_kunci.*' OR harga REGEXP '$kata_kunci.*'";
    $eksekusi  = $this->koneksi->query($sql);

    while($data = $eksekusi->fetch_array(MYSQLI_ASSOC)){
      $hasil[] = $data;
    }

    return $hasil;
  }

  public function pesan_hewan($id_hewan, $harga, $jenis_hewan, $usia, $level, $berat, $kondisi_fisik){
    $this->id_hewan = $id_hewan;

    $tampungs = $this->id_hewan.", ".$harga.", ".$jenis_hewan.", ".$usia.", ".$level.", ".$berat.", ".$kondisi_fisik;
    return $tampungs;
  }

  public function tambah_pelanggan($id_pelanggan, $nama, $jk, $alamat, $no_telp){
    $this->id_pelanggan = $id_pelanggan;

    $sql = "INSERT INTO pelanggan VALUES('".$this->id_pelanggan."','".$nama."','".$jk."','".$alamat."','".$no_telp."')";
    $eksekusi = $this->koneksi->query($sql);

    return TRUE;
  }

  public function tampil_info_identitas($id_pelanggan){
    $sql = "SELECT * FROM pelanggan WHERE id_pelanggan = '".$id_pelanggan."' LIMIT 1";
    $eksekusi = $this->koneksi->query($sql);

    while ($data = $eksekusi->fetch_array(MYSQLI_ASSOC)) {
      $hasil[] = $data;
    }
    return $hasil;
  }

  public function beli_hewan($id_pelanggan, $id_hewan, $tgl, $waktu){
    $this->id_pelanggan = $id_pelanggan;
    $this->id_hewan     = $id_hewan;
    $this->tgl_beli     = $tgl;
    $this->waktu_beli   = $waktu;

    $sql = "INSERT INTO membelihewan VALUES(NULL,NULL,'".$this->id_pelanggan."','".$this->id_hewan."','".$this->tgl_beli."','".$this->waktu_beli."')";
    $eksekusi = $this->koneksi->query($sql);

    return TRUE;
  }

  public function tampil_belibyip($id_pelanggan){
    $sql = "SELECT * FROM membelihewan, datahewan, pelanggan WHERE membelihewan.id_hewan = datahewan.id_hewan AND membelihewan.id_pelanggan = pelanggan.id_pelanggan AND membelihewan.id_pelanggan = '".$id_pelanggan."'";
    $eksekusi = $this->koneksi->query($sql);

    while ($data = $eksekusi->fetch_array(MYSQLI_ASSOC)) {
      $hasil[] = $data;
    }

    return $hasil;
  }

  public function cetak_buktitransaksi_pembelian($id_transaksi, $id_pelanggan){
    $excelku = new PHPExcel();
    $headerStylenya = new PHPExcel_Style();
    $bodyStylenya   = new PHPExcel_Style();

    // Set properties
    $excelku->getProperties()->setCreator("Depot Qurban")
                             ->setLastModifiedBy("Depot Qurban");

    // Set lebar kolom
    $excelku->getActiveSheet()->getColumnDimension('A')->setWidth(30);
    $excelku->getActiveSheet()->getColumnDimension('B')->setWidth(40);

    // Mergecell, menyatukan beberapa kolom
    $excelku->getActiveSheet()->mergeCells('A1:B1');
    $excelku->getActiveSheet()->mergeCells('A2:B2');

    // Buat Kolom judul tabel
    $SI = $excelku->setActiveSheetIndex(0);
    $SI->setCellValue('A1', 'Bukti Transaksi Pembelian Hewan');
    $SI->setCellValue('A2', '(Harap di print bukti transaksi ini dan bawa ke depot)');
    $SI->setCellValue('A4', 'ID Transaksi');
    $SI->setCellValue('A5', 'Jumlah Hewan');
    $SI->setCellValue('A6', 'Total Harga');
    $SI->setCellValue('A7', 'Nama Pelanggan');
    $SI->setCellValue('A8', 'Tanggal Beli');
    $SI->setCellValue('A9', 'Waktu Beli');
    $SI->setCellValue('A10', 'Transfer-ke');
    $SI->setCellValue('A11', 'Status Bayar');

    $headerStylenya->applyFromArray(
      array('fill' 	=> array(
          'type'    => PHPExcel_Style_Fill::FILL_SOLID,
          'color'   => array('argb' => 'FFEEEEEE')),
          'borders' => array('bottom'=> array('style' => PHPExcel_Style_Border::BORDER_THIN),
                'right'		=> array('style' => PHPExcel_Style_Border::BORDER_MEDIUM),
                'left'	    => array('style' => PHPExcel_Style_Border::BORDER_THIN),
                'top'	    => array('style' => PHPExcel_Style_Border::BORDER_THIN)
          )
      ));

    $bodyStylenya->applyFromArray(
      array('fill' 	=> array(
          'type'	=> PHPExcel_Style_Fill::FILL_SOLID,
          'color'	=> array('argb' => 'FFFFFFFF')),
          'borders' => array(
                'bottom'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN),
                'right'		=> array('style' => PHPExcel_Style_Border::BORDER_MEDIUM),
                'left'	    => array('style' => PHPExcel_Style_Border::BORDER_THIN),
                'top'	    => array('style' => PHPExcel_Style_Border::BORDER_THIN)
          ),
          'alignment' => array(
            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
          )
        ));

    //Menggunakan HeaderStylenya
    $excelku->getActiveSheet()->setSharedStyle($headerStylenya, "A4:A11");

    // Mengambil data dari tabel
    $sql	= "SELECT transaksi.id_transaksi, transaksi.jml_hewan, transaksi.total_harga, transaksi.metode_bayar, transaksi.status_bayar, pelanggan.nama, membelihewan.tgl_beli, membelihewan.waktu_beli FROM transaksi, membelihewan, pelanggan, datahewan WHERE transaksi.id_transaksi = membelihewan.id_transaksi AND datahewan.id_hewan = membelihewan.id_hewan AND membelihewan.id_pelanggan = pelanggan.id_pelanggan AND membelihewan.id_pelanggan = '".$id_pelanggan."' LIMIT 1";
    $eksekusi = $this->koneksi->query($sql);
    $k = 4;

    while ($row = $eksekusi->fetch_array(MYSQLI_ASSOC)) {
        $SI->setCellValue("B".($k+0),$row['id_transaksi']);
        $SI->setCellValue("B".($k+1),$row['jml_hewan']);
        $SI->setCellValue("B".($k+2),"Rp".number_format($row['total_harga']),0,",",".");
        $SI->setCellValue("B".($k+3),$row['nama']);
        $SI->setCellValue("B".($k+4),$row['tgl_beli']);
        $SI->setCellValue("B".($k+5),$row['waktu_beli']);
        $SI->setCellValue("B".($k+6),$row['metode_bayar']);
        $SI->setCellValue("B".($k+7),$row['status_bayar']);

        //Membuat garis di body tabel (isi data)
        $excelku->getActiveSheet()->setSharedStyle($bodyStylenya, "B4:B11");

        //Memberi nama sheet
        $excelku->getActiveSheet()->setTitle('Bukti Transaksi Pembelian Hewan');
        $excelku->setActiveSheetIndex(0);

        $objWriter = PHPExcel_IOFactory::createWriter($excelku, 'Excel2007');
        $mkdir = mkdir("../../assets/file_bukti_tf/".$id_transaksi."_".$id_pelanggan, 0777, true);
        chmod('../../assets/file_bukti_tf/'.$id_transaksi."_".$id_pelanggan, 0777);
        $objWriter->save("../../assets/file_bukti_tf/".$id_transaksi."_".$id_pelanggan."/bukti_tf.xlsx");
        $k++;
    }
  }

  public function cetak_buktitransaksi_identitas($randomkey, $jml_hewan, $id_pelanggan){
    $excelku = new PHPExcel();
    $headerStylenya = new PHPExcel_Style();
    $bodyStylenya   = new PHPExcel_Style();

    // Set properties
    $excelku->getProperties()->setCreator("Depot Qurban")
                             ->setLastModifiedBy("Depot Qurban");

    // Set lebar kolom
    $excelku->getActiveSheet()->getColumnDimension('A')->setWidth(30);
    $excelku->getActiveSheet()->getColumnDimension('B')->setWidth(40);

    // Mergecell, menyatukan beberapa kolom
    $excelku->getActiveSheet()->mergeCells('A1:B1');
    $excelku->getActiveSheet()->mergeCells('A2:B2');

    // Buat Kolom judul tabel
    $SI = $excelku->setActiveSheetIndex(0);
    $SI->setCellValue('A1', 'Bukti Identitas Pembelian Hewan');
    $SI->setCellValue('A2', '(Harap di print bukti identitas ini dan bawa ke depot)');
    $SI->setCellValue('A4', 'ID Pelanggan');
    $SI->setCellValue('A5', 'Nama Pelanggan');
    $SI->setCellValue('A6', 'Jenis Kelamin');
    $SI->setCellValue('A7', 'Alamat');
    $SI->setCellValue('A8', 'No Telepon');
    $SI->setCellValue('A9', 'Jumlah Hewan');

    $headerStylenya->applyFromArray(
      array('fill' 	=> array(
          'type'    => PHPExcel_Style_Fill::FILL_SOLID,
          'color'   => array('argb' => 'FFEEEEEE')),
          'borders' => array('bottom'=> array('style' => PHPExcel_Style_Border::BORDER_THIN),
                'right'		=> array('style' => PHPExcel_Style_Border::BORDER_MEDIUM),
                'left'	    => array('style' => PHPExcel_Style_Border::BORDER_THIN),
                'top'	    => array('style' => PHPExcel_Style_Border::BORDER_THIN)
          )
      ));

    $bodyStylenya->applyFromArray(
      array('fill' 	=> array(
          'type'	=> PHPExcel_Style_Fill::FILL_SOLID,
          'color'	=> array('argb' => 'FFFFFFFF')),
          'borders' => array(
                'bottom'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN),
                'right'		=> array('style' => PHPExcel_Style_Border::BORDER_MEDIUM),
                'left'	    => array('style' => PHPExcel_Style_Border::BORDER_THIN),
                'top'	    => array('style' => PHPExcel_Style_Border::BORDER_THIN)
          ),
          'alignment' => array(
            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
          )
        ));

    //Menggunakan HeaderStylenya
    $excelku->getActiveSheet()->setSharedStyle($headerStylenya, "A4:A9");

    // Mengambil data dari tabel
    $sql	= "SELECT * FROM pelanggan WHERE id_pelanggan = '".$id_pelanggan."' LIMIT 1";
    $eksekusi = $this->koneksi->query($sql);
    $k = 4;

    while ($row = $eksekusi->fetch_array(MYSQLI_ASSOC)) {
        $SI->setCellValue("B".($k+0),$row['id_pelanggan']);
        $SI->setCellValue("B".($k+1),$row['nama']);
        $SI->setCellValue("B".($k+2),$row['jk']);
        $SI->setCellValue("B".($k+3),$row['alamat']);
        $SI->setCellValue("B".($k+4),$row['no_telp']);
        $SI->setCellValue("B".($k+5),$jml_hewan);

        //Membuat garis di body tabel (isi data)
        $excelku->getActiveSheet()->setSharedStyle($bodyStylenya, "B4:B9");

        //Memberi nama sheet
        $excelku->getActiveSheet()->setTitle('Bukti Identitas Pembelian Hewan');
        $excelku->setActiveSheetIndex(0);

        $objWriter = PHPExcel_IOFactory::createWriter($excelku, 'Excel2007');
        $mkdir = mkdir("../../assets/file_bukti_id/#bukti".$randomkey."_".$id_pelanggan, 0777, true);
        chmod('../../assets/file_bukti_id/#bukti'.$randomkey.'_'.$id_pelanggan, 0777);
        $objWriter->save("../../assets/file_bukti_id/#bukti".$randomkey."_".$id_pelanggan."/bukti_id.xlsx");
        $k++;
    }
  }
}
?>
