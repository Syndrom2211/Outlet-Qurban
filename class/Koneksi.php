<?php
class Koneksi{
  // Koneksi
  var $server   = "localhost";
  var $username = "root";
  var $password = "";
  var $database = "hadipot";
  var $koneksi;

  public function __construct(){
    $this->koneksi = new mysqli($this->server, $this->username, $this->password, $this->database);

    if(mysqli_connect_errno()){
      echo "Koneksi Gagal";
    }
  }
}
