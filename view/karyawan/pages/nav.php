<nav  class="navbar  navbar-default ">

    <div class="container-fluid">
    <div class="navbar-header">
     <button
      type="button"
      class="navbar-toggle collapsed"
      data-toggle="collapse"
      data-target="#main_navbar"
      aria-expanded="false">
      <span class="icon-bar"></span>
      <span class="icon-bar"></span>
      <span class="icon-bar"></span>
       </button>
    </div>
  <!-- Logo Header -->
  <div class="collapse navbar-collapse">
  <div class="navbar-header">
    <?php
    if($_SESSION["jabatan"] == "Admin"){
      $pesan = "Administrator";
    }if($_SESSION["jabatan"] == "PKasir"){
      $pesan = "Petugas Kasir";
    }if($_SESSION["jabatan"] == "PHewan"){
      $pesan = "Petugas Hewan";
    }
    ?>
    <a href="halKaryawan.php" class="navbar-brand">Halaman <?php echo $pesan; ?></a>
  </div>

  <!-- Isi Header -->
  <div>
    <?php
    if($_SESSION["jabatan"] == "Admin"){ ?>
      <ul class="nav navbar-nav">
        <li><a href="halKaryawan.php">Home</a></li>
        <li><a href="halPemasok.php?kelola=pemasok">Pemasok</a></li>
        <li><a href="halKaryawan.php?kelola=karyawan">Karyawan</a></li>
        <li><a href="halLaporanDataHewan.php?kelola=pelaporan_datahewan">Laporan Data Hewan</a></li>
        <li><a href="halLaporanTransaksi.php?kelola=pelaporan_transaksi">Laporan Transaksi</a></li>
        <li><a href="halKaryawan.php?logout">Logout</a></li>
      </ul>
    <?php
    }if($_SESSION["jabatan"] == "PKasir"){ ?>
      <ul class="nav navbar-nav">
        <li><a href="halKaryawan.php">Home</a></li>
        <li><a href="halTransaksi.php?kelola=transaksi">Data Transaksi</a></li>
        <li><a href="halKaryawan.php?logout">Logout</a></li>
      </ul>
    <?php
    }if($_SESSION["jabatan"] == "PHewan"){ ?>
      <ul class="nav navbar-nav">
        <li><a href="halKaryawan.php">Home</a></li>
        <li><a href="halDataHewan.php?kelola=datahewan">Data Hewan</a></li>
        <li><a href="halKaryawan.php?logout">Logout</a></li>
      </ul>
    <?php
    }
    ?>
  </div>
</nav>
