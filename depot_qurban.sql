-- phpMyAdmin SQL Dump
-- version 4.6.5.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jul 27, 2017 at 07:47 PM
-- Server version: 10.1.21-MariaDB
-- PHP Version: 7.1.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `hadipot`
--

-- --------------------------------------------------------

--
-- Table structure for table `datahewan`
--

CREATE TABLE `datahewan` (
  `id_hewan` int(5) NOT NULL,
  `jenis` varchar(30) DEFAULT NULL,
  `foto` varchar(100) DEFAULT NULL,
  `usia` int(3) DEFAULT NULL,
  `level` varchar(20) DEFAULT NULL,
  `berat` float DEFAULT NULL,
  `kondisi_fisik` varchar(20) DEFAULT NULL,
  `harga` int(5) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `datahewan`
--

INSERT INTO `datahewan` (`id_hewan`, `jenis`, `foto`, `usia`, `level`, `berat`, `kondisi_fisik`, `harga`) VALUES
(19, 'sapi', 'img/sapi1.jpg', 12, 'super', 215, 'sehat', 13500000),
(20, 'sapi', 'img/sapi2.JPG', 10, 'medium', 225, 'sehat', 14000000),
(21, 'domba', 'img/domba1.jpg', 7, 'super', 14, 'sehat', 1650000),
(22, 'domba', 'img/domba2.JPG', 12, 'small', 21, 'sehat', 2300000),
(23, 'domba', 'img/domba4.JPG', 13, 'super', 27, 'sehat', 2800000),
(24, 'sapi', 'img/sapisapi.jpg', 18, 'super', 400, 'sehat', 25000000);

-- --------------------------------------------------------

--
-- Table structure for table `karyawan`
--

CREATE TABLE `karyawan` (
  `id_karyawan` int(5) NOT NULL,
  `foto` varchar(100) DEFAULT NULL,
  `nama_lengkap` varchar(50) DEFAULT NULL,
  `usia` int(3) DEFAULT NULL,
  `jk` char(1) DEFAULT NULL,
  `alamat` text,
  `no_telp` varchar(15) DEFAULT NULL,
  `jabatan` varchar(20) DEFAULT NULL,
  `username` varchar(50) DEFAULT NULL,
  `password` varchar(32) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `karyawan`
--

INSERT INTO `karyawan` (`id_karyawan`, `foto`, `nama_lengkap`, `usia`, `jk`, `alamat`, `no_telp`, `jabatan`, `username`, `password`, `email`) VALUES
(7, 'img/PSD Firdam.jpg', 'Firdamdam Sasmita', 21, 'L', 'Kp.Ciherang Banjaran Bandung', '085798160154', 'Admin', 'firdam', 'c88de6328cf89727e6ad3d7f48591f35', 'siapakita2211@gmail.com'),
(8, 'img/hadi.png', 'Hadi Permana', 21, 'L', 'Jl. Karapitan', '085778112786', 'PHewan', 'hadi', '76671d4b83f6e6f953ea2dfb75ded921', 'hadiperm@gmail.com'),
(9, 'img/fudjie.jpg', 'Fudjie Pangestu Tandjung', 21, 'L', 'Sabang', '086776534212', 'PHewan', 'fuji', '3a1b5b974a2401efad9932ccc9af2671', 'fudjie.pangestu@gmail.com'),
(11, 'img/1501143566555.jpg', 'Refah Istifahani Handoko', 21, 'P', 'Indramayu', '087665342512', 'PKasir', 'refah', 'db29db126a9bbb9e74dd632cf66219b3', 'refah.ih@gmail.com');

-- --------------------------------------------------------

--
-- Table structure for table `membelihewan`
--

CREATE TABLE `membelihewan` (
  `id_beli` int(5) NOT NULL,
  `id_transaksi` varchar(6) DEFAULT NULL,
  `id_pelanggan` int(5) DEFAULT NULL,
  `id_hewan` int(5) DEFAULT NULL,
  `tgl_beli` date DEFAULT NULL,
  `waktu_beli` varchar(8) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `membelihewan`
--

INSERT INTO `membelihewan` (`id_beli`, `id_transaksi`, `id_pelanggan`, `id_hewan`, `tgl_beli`, `waktu_beli`) VALUES
(1, '#35', 14, 19, '2017-07-27', '11:48:58'),
(2, '#35', 14, 21, '2017-07-27', '11:48:58');

-- --------------------------------------------------------

--
-- Table structure for table `pelanggan`
--

CREATE TABLE `pelanggan` (
  `id_pelanggan` int(5) NOT NULL,
  `nama` varchar(50) DEFAULT NULL,
  `jk` char(1) DEFAULT NULL,
  `alamat` text,
  `no_telp` varchar(15) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `pelanggan`
--

INSERT INTO `pelanggan` (`id_pelanggan`, `nama`, `jk`, `alamat`, `no_telp`) VALUES
(14, 'Firdamdam Sasmita', 'L', 'Kp.Ciherang Banjaran Bandung', '085798160154');

-- --------------------------------------------------------

--
-- Table structure for table `pelaporandatahewan`
--

CREATE TABLE `pelaporandatahewan` (
  `id_pelaporan` varchar(30) NOT NULL,
  `id_karyawan` int(5) DEFAULT NULL,
  `id_hewan` int(5) DEFAULT NULL,
  `tgl_pelaporan` date DEFAULT NULL,
  `waktu_pelaporan` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `pelaporandatahewan`
--

INSERT INTO `pelaporandatahewan` (`id_pelaporan`, `id_karyawan`, `id_hewan`, `tgl_pelaporan`, `waktu_pelaporan`) VALUES
('#LDH_12647', 7, 22, '2017-07-27', '05:18:29'),
('#LDH_31820', 7, 19, '2017-07-27', '05:18:29'),
('#LDH_37780', 7, 20, '2017-07-27', '05:18:29'),
('#LDH_47039', 7, 23, '2017-07-27', '05:18:29'),
('#LDH_83216', 7, 21, '2017-07-27', '05:18:29'),
('#LDH_91445', 7, 24, '2017-07-27', '05:18:29');

-- --------------------------------------------------------

--
-- Table structure for table `pelaporantransaksi`
--

CREATE TABLE `pelaporantransaksi` (
  `id_pelaporan` varchar(30) NOT NULL,
  `id_transaksi` varchar(30) DEFAULT NULL,
  `id_karyawan` int(5) DEFAULT NULL,
  `tgl_pelaporan` date DEFAULT NULL,
  `waktu_pelaporan` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `pelaporantransaksi`
--

INSERT INTO `pelaporantransaksi` (`id_pelaporan`, `id_transaksi`, `id_karyawan`, `tgl_pelaporan`, `waktu_pelaporan`) VALUES
('#LDT_62740', '#35', 7, '2017-07-27', '11:51:12');

-- --------------------------------------------------------

--
-- Table structure for table `pemasok`
--

CREATE TABLE `pemasok` (
  `id_pemasok` int(5) NOT NULL,
  `id_karyawan` int(5) DEFAULT NULL,
  `nama_peternakan` varchar(100) DEFAULT NULL,
  `alamat_peternakan` text,
  `nama_pemilik` varchar(50) DEFAULT NULL,
  `no_telp_pemilik` varchar(15) DEFAULT NULL,
  `ketersediaan_sapi` int(7) DEFAULT NULL,
  `ketersediaan_domba` int(7) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `pemasok`
--

INSERT INTO `pemasok` (`id_pemasok`, `id_karyawan`, `nama_peternakan`, `alamat_peternakan`, `nama_pemilik`, `no_telp_pemilik`, `ketersediaan_sapi`, `ketersediaan_domba`) VALUES
(1, 8, 'Ternak Barokah Mandiri', 'Jl. DR. Setia Budi No. 5 RT 07/01 Gandasuli, Brebes - Jawa Tengah.', 'Ridwan Maulana', '081286929090', 15, 50),
(2, 9, 'Pulang Kandang', 'Bandung, TKI 1 Blok O no 164', 'Asep Rohmat', '082117083680', 20, 10);

-- --------------------------------------------------------

--
-- Table structure for table `transaksi`
--

CREATE TABLE `transaksi` (
  `id_transaksi` varchar(30) NOT NULL,
  `id_karyawan` int(5) DEFAULT NULL,
  `jml_hewan` int(5) DEFAULT NULL,
  `total_harga` varchar(30) DEFAULT NULL,
  `metode_bayar` varchar(50) DEFAULT NULL,
  `status_bayar` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `transaksi`
--

INSERT INTO `transaksi` (`id_transaksi`, `id_karyawan`, `jml_hewan`, `total_harga`, `metode_bayar`, `status_bayar`) VALUES
('#35', 11, 2, '15150000', 'online(bni:0450672729::Amirul Darmawan)', 'Sudah Terverifikasi');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `datahewan`
--
ALTER TABLE `datahewan`
  ADD PRIMARY KEY (`id_hewan`);

--
-- Indexes for table `karyawan`
--
ALTER TABLE `karyawan`
  ADD PRIMARY KEY (`id_karyawan`);

--
-- Indexes for table `membelihewan`
--
ALTER TABLE `membelihewan`
  ADD PRIMARY KEY (`id_beli`),
  ADD KEY `FK_MembeliHewanPelanggan` (`id_pelanggan`),
  ADD KEY `FK_MembeliHewanHewan` (`id_hewan`),
  ADD KEY `FK_MembeliHewanTransaksi` (`id_transaksi`);

--
-- Indexes for table `pelanggan`
--
ALTER TABLE `pelanggan`
  ADD PRIMARY KEY (`id_pelanggan`);

--
-- Indexes for table `pelaporandatahewan`
--
ALTER TABLE `pelaporandatahewan`
  ADD PRIMARY KEY (`id_pelaporan`),
  ADD UNIQUE KEY `id_hewan` (`id_hewan`),
  ADD KEY `FK_PeldawanHewan` (`id_hewan`),
  ADD KEY `FK_PeldawanTransaksi` (`id_karyawan`);

--
-- Indexes for table `pelaporantransaksi`
--
ALTER TABLE `pelaporantransaksi`
  ADD PRIMARY KEY (`id_pelaporan`),
  ADD UNIQUE KEY `id_transaksi` (`id_transaksi`),
  ADD KEY `FK_PeltraTransaksi` (`id_transaksi`),
  ADD KEY `FK_PeltraKaryawan` (`id_karyawan`);

--
-- Indexes for table `pemasok`
--
ALTER TABLE `pemasok`
  ADD PRIMARY KEY (`id_pemasok`),
  ADD KEY `FK_PemasokKaryawan` (`id_karyawan`);

--
-- Indexes for table `transaksi`
--
ALTER TABLE `transaksi`
  ADD PRIMARY KEY (`id_transaksi`),
  ADD KEY `FK_TransaksiKaryawan` (`id_karyawan`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `datahewan`
--
ALTER TABLE `datahewan`
  MODIFY `id_hewan` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;
--
-- AUTO_INCREMENT for table `karyawan`
--
ALTER TABLE `karyawan`
  MODIFY `id_karyawan` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
--
-- AUTO_INCREMENT for table `membelihewan`
--
ALTER TABLE `membelihewan`
  MODIFY `id_beli` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `pemasok`
--
ALTER TABLE `pemasok`
  MODIFY `id_pemasok` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `membelihewan`
--
ALTER TABLE `membelihewan`
  ADD CONSTRAINT `FK_MembeliHewanHewan` FOREIGN KEY (`id_hewan`) REFERENCES `datahewan` (`id_hewan`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_MembeliHewanPelanggan` FOREIGN KEY (`id_pelanggan`) REFERENCES `pelanggan` (`id_pelanggan`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_MembeliHewanTransaksi` FOREIGN KEY (`id_transaksi`) REFERENCES `transaksi` (`id_transaksi`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `pelaporandatahewan`
--
ALTER TABLE `pelaporandatahewan`
  ADD CONSTRAINT `FK_PeldawanHewan` FOREIGN KEY (`id_hewan`) REFERENCES `datahewan` (`id_hewan`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_PeldawanTransaksi` FOREIGN KEY (`id_karyawan`) REFERENCES `karyawan` (`id_karyawan`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `pelaporantransaksi`
--
ALTER TABLE `pelaporantransaksi`
  ADD CONSTRAINT `FK_PeltraKaryawan` FOREIGN KEY (`id_karyawan`) REFERENCES `karyawan` (`id_karyawan`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_PeltraTransaksi` FOREIGN KEY (`id_transaksi`) REFERENCES `transaksi` (`id_transaksi`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `pemasok`
--
ALTER TABLE `pemasok`
  ADD CONSTRAINT `FK_PemasokKaryawan` FOREIGN KEY (`id_karyawan`) REFERENCES `karyawan` (`id_karyawan`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `transaksi`
--
ALTER TABLE `transaksi`
  ADD CONSTRAINT `FK_TransaksiKaryawan` FOREIGN KEY (`id_karyawan`) REFERENCES `karyawan` (`id_karyawan`) ON DELETE SET NULL ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
