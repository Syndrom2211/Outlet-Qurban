<?php
include_once("../../class/Koneksi.php");
include_once("../../assets/lib/PHPExcel.php");
date_default_timezone_set("Asia/Jakarta");

class PelaporanTransaksi extends Koneksi{
  private $id_pelaporan;
  private $id_transaksi;
  private $id_karyawan;
  private $tgl_pelaporan;
  private $waktu_pelaporan;
  public function cetak_laporan($randomkeys, $id_karyawan, $id_transaksi, $waktu, $tgl){
      $excelku = new PHPExcel();
      $headerStylenya = new PHPExcel_Style();
      $bodyStylenya   = new PHPExcel_Style();

      // Set properties
      $excelku->getProperties()->setCreator("Depot Qurban")
                               ->setLastModifiedBy("Depot Qurban");

      // Set lebar kolom
      $excelku->getActiveSheet()->getColumnDimension('A')->setWidth(20);
      $excelku->getActiveSheet()->getColumnDimension('B')->setWidth(20);
      $excelku->getActiveSheet()->getColumnDimension('C')->setWidth(20);
      $excelku->getActiveSheet()->getColumnDimension('D')->setWidth(15);
      $excelku->getActiveSheet()->getColumnDimension('E')->setWidth(20);

      // Mergecell, menyatukan beberapa kolom
      $excelku->getActiveSheet()->mergeCells('A1:B1');
      $excelku->getActiveSheet()->mergeCells('A2:B2');

      // Buat Kolom judul tabel
      $SI = $excelku->setActiveSheetIndex(0);
      $SI->setCellValue('A1', 'Laporan Transaksi-'.$tgl);
      $SI->setCellValue('A2', '');
      $SI->setCellValue('A4', 'ID Pelaporan');
      $SI->setCellValue('B4', 'ID Transaksi');
      $SI->setCellValue('C4', 'ID Karyawan');
      $SI->setCellValue('D4', 'Tanggal Pelaporan');
      $SI->setCellValue('E4', 'Waktu Pelaporan');

      $headerStylenya->applyFromArray(
        array('fill' 	=> array(
            'type'    => PHPExcel_Style_Fill::FILL_SOLID,
            'color'   => array('argb' => 'FFEEEEEE')),
            'borders' => array('bottom'=> array('style' => PHPExcel_Style_Border::BORDER_THIN),
                  'right'		=> array('style' => PHPExcel_Style_Border::BORDER_MEDIUM),
                  'left'	    => array('style' => PHPExcel_Style_Border::BORDER_THIN),
                  'top'	    => array('style' => PHPExcel_Style_Border::BORDER_THIN)
            ),
            'alignment' => array(
              'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
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
      $excelku->getActiveSheet()->setSharedStyle($headerStylenya, "A4:E4");

      // Tambah ke table
      $x = 0;
      while ($x < count($id_transaksi)) {
        $prefix = '#LDT_';
        $key1   = rand(1, 1000);
        $key2   = rand(1, 100);
        $randomkey = $prefix.$key1.$key2;
        $sqldua = "INSERT INTO pelaporantransaksi VALUES('".$randomkey."', '".$id_transaksi[$x]."', '".$id_karyawan."', '".$tgl."', '".$waktu."')";
        $eksekusidua = $this->koneksi->query($sqldua);
        $x++;
      }

      // Mengambil data dari tabel
      $sql	= "SELECT * FROM pelaporantransaksi, karyawan WHERE pelaporantransaksi.id_karyawan = karyawan.id_karyawan AND pelaporantransaksi.id_karyawan = '".$id_karyawan."'";
      $eksekusi = $this->koneksi->query($sql);
      $k = 5;

      while ($row = $eksekusi->fetch_array(MYSQLI_ASSOC)) {
          $SI->setCellValue("A".$k,$row['id_pelaporan']);
          $SI->setCellValue("B".$k,$row['id_transaksi']);
          $SI->setCellValue("C".$k,$row['id_karyawan']);
          $SI->setCellValue("D".$k,$row['tgl_pelaporan']);
          $SI->setCellValue("E".$k,$row['waktu_pelaporan']);

          //Membuat garis di body tabel (isi data)
          $excelku->getActiveSheet()->setSharedStyle($bodyStylenya, "A4:E4");

          //Memberi nama sheet
          $excelku->getActiveSheet()->setTitle('Laporan Transaksi-'.$row['tgl_pelaporan']);
          $excelku->setActiveSheetIndex(0);

          $objWriter = PHPExcel_IOFactory::createWriter($excelku, 'Excel2007');
          $mkdir = mkdir("../../assets/laporan_transaksi/".$randomkeys."_".$tgl, 0777, true);
          chmod('../../assets/laporan_transaksi/'.$randomkeys.'_'.$tgl, 0777);
          $objWriter->save("../../assets/laporan_transaksi/".$randomkeys."_".$tgl."/laporan.xlsx");
          $k++;
      }
    }
}
?>
