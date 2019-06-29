-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Jan 13, 2017 at 09:15 PM
-- Server version: 10.1.16-MariaDB
-- PHP Version: 7.0.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `grosir`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id_admin` int(11) NOT NULL,
  `id_karyawan` int(11) NOT NULL,
  `uname` varchar(30) NOT NULL,
  `pass` varchar(70) NOT NULL,
  `level` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id_admin`, `id_karyawan`, `uname`, `pass`, `level`) VALUES
(10, 6, 'ucok', '827ccb0eea8a706c4c34a16891f84e7b', 'Stok Admin'),
(16, 8, 'Dandi', '827ccb0eea8a706c4c34a16891f84e7b', 'Admin'),
(17, 11, 'tuan', '827ccb0eea8a706c4c34a16891f84e7b', 'Super Super Admin'),
(18, 5, 'oke', '827ccb0eea8a706c4c34a16891f84e7b', 'Super Admin');

-- --------------------------------------------------------

--
-- Table structure for table `barang`
--

CREATE TABLE `barang` (
  `id_gudang` int(11) NOT NULL,
  `nama` text NOT NULL,
  `jenis` text NOT NULL,
  `suplier` text NOT NULL,
  `modal` int(11) NOT NULL,
  `harga_atas` int(11) NOT NULL,
  `harga_bawah` int(11) NOT NULL,
  `jumlah` int(11) NOT NULL,
  `sisa` int(11) NOT NULL,
  `tangal_masuk` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `barang`
--

INSERT INTO `barang` (`id_gudang`, `nama`, `jenis`, `suplier`, `modal`, `harga_atas`, `harga_bawah`, `jumlah`, `sisa`, `tangal_masuk`) VALUES
(81, 'Aqua', 'Minuman', 'Aqua', 2300, 10000, 7000, 100, 300, '0000-00-00'),
(83, 'Mentos', 'permen', 'mint', 10000, 15000, 11000, 200, 300, '0000-00-00'),
(84, 'test', 'test', 'test', 10000, 15000, 11000, 100, 100, '0000-00-00'),
(95, 'acer v5 471', 'laptop', 'acer', 7000000, 8000000, 7500000, 9, 12, '2017-01-06'),
(96, 'Battle star', 'MOD', 'Battle  star', 500000, 600000, 550000, 50, 5, '0000-00-00');

-- --------------------------------------------------------

--
-- Table structure for table `barang_terjual`
--

CREATE TABLE `barang_terjual` (
  `id_terjual` int(11) NOT NULL,
  `id_barangtoko` int(11) NOT NULL,
  `jual_idpelanggan` int(11) NOT NULL,
  `jual_hargaakhir` int(11) NOT NULL,
  `jual_jumlah` int(11) NOT NULL,
  `tanggal` datetime NOT NULL,
  `id_transaksi` int(12) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `barang_terjual`
--

INSERT INTO `barang_terjual` (`id_terjual`, `id_barangtoko`, `jual_idpelanggan`, `jual_hargaakhir`, `jual_jumlah`, `tanggal`, `id_transaksi`) VALUES
(54, 46, 71, 10000, 2, '2017-01-06 20:46:37', 45),
(55, 49, 71, 8000000, 1, '2017-01-06 20:46:37', 45),
(56, 46, 71, 10000, 1, '2017-01-06 20:56:58', 46),
(57, 46, 71, 10000, 1, '2017-01-06 21:00:25', 47),
(58, 46, 71, 10000, 2, '2017-01-06 21:03:04', 48),
(59, 46, 72, 10000, 1, '2017-01-06 21:09:36', 49),
(60, 49, 72, 8000000, 1, '2017-01-06 21:09:36', 49),
(61, 46, 72, 0, 0, '2017-01-06 21:18:50', 49),
(62, 49, 72, 0, 0, '2017-01-06 21:18:50', 49),
(63, 46, 74, 10000, 3, '2017-01-07 13:00:38', 50),
(64, 46, 74, 10000, 3, '2017-01-07 13:01:50', 51),
(65, 46, 0, 10000, 3, '2017-01-07 13:04:40', 51),
(66, 46, 0, 10000, 3, '2017-01-07 13:05:00', 51),
(67, 46, 0, 10000, 3, '2017-01-07 13:05:18', 51),
(68, 46, 0, 10000, 3, '2017-01-07 13:13:03', 51),
(69, 46, 0, 10000, 3, '2017-01-07 13:13:11', 51),
(70, 46, 0, 10000, 3, '2017-01-07 13:13:40', 51),
(71, 46, 0, 10000, 3, '2017-01-07 13:14:16', 51),
(72, 46, 0, 10000, 3, '2017-01-07 13:14:41', 51),
(73, 46, 0, 10000, 3, '2017-01-07 13:14:56', 51),
(74, 46, 0, 10000, 3, '2017-01-07 13:15:51', 51),
(75, 46, 0, 10000, 3, '2017-01-07 13:16:12', 51),
(76, 46, 0, 10000, 3, '2017-01-07 13:16:27', 51);

-- --------------------------------------------------------

--
-- Table structure for table `his_login`
--

CREATE TABLE `his_login` (
  `id_login` int(11) NOT NULL,
  `id_karyawan` int(11) NOT NULL,
  `uname` varchar(25) NOT NULL,
  `level` varchar(25) NOT NULL,
  `tanggal` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `his_login`
--

INSERT INTO `his_login` (`id_login`, `id_karyawan`, `uname`, `level`, `tanggal`) VALUES
(11, 5, 'oke', 'Super Admin', '2017-01-14 00:07:09'),
(12, 8, 'Dandi', 'Admin', '2017-01-14 00:12:47'),
(13, 11, 'tuan', 'Super Super Admin', '2017-01-14 00:12:56');

-- --------------------------------------------------------

--
-- Table structure for table `karyawan`
--

CREATE TABLE `karyawan` (
  `id` int(11) NOT NULL,
  `nama` text NOT NULL,
  `jekel` text NOT NULL,
  `jabatan` text NOT NULL,
  `alamat` text NOT NULL,
  `foto` text NOT NULL,
  `ktp` varchar(12) NOT NULL,
  `nohp` varchar(20) NOT NULL,
  `hutang` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `karyawan`
--

INSERT INTO `karyawan` (`id`, `nama`, `jekel`, `jabatan`, `alamat`, `foto`, `ktp`, `nohp`, `hutang`) VALUES
(5, 'Yogi Grosir', 'Laki-laki', 'Super Admin', 'Kerinci Jambi', 'oke.jpg', '', '', 0),
(6, 'Ucok Sumbara', 'Laki-laki', 'Karyawan', 'Padang Sumatera Barat', 'ucok.jpg\r\n', '', '', 0),
(8, 'Dandi', 'Laki-laki', 'Karyawan', 'Jambi', '8.jpg', '', '081219344136', 0),
(11, 'Boy', 'Laki-laki', 'Manager', 'Jakarta', 'arduino.jpg', 'dht11.jpg', '08212333', 12222);

-- --------------------------------------------------------

--
-- Table structure for table `keranjang`
--

CREATE TABLE `keranjang` (
  `id_keranjang` int(11) NOT NULL,
  `id_barangtoko` int(11) NOT NULL,
  `id_pelanggan` int(11) NOT NULL,
  `jumlah_keranjang` int(11) NOT NULL,
  `harga_akhir` int(11) NOT NULL,
  `sub_total` varchar(100) NOT NULL,
  `sub_totaldiskon` varchar(100) NOT NULL,
  `total_harga` varchar(100) NOT NULL,
  `total_hargadiskon` varchar(100) NOT NULL,
  `id_sesion` varchar(200) NOT NULL,
  `tanggal` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `notif`
--

CREATE TABLE `notif` (
  `id` int(11) NOT NULL,
  `jum_minimal` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `notif`
--

INSERT INTO `notif` (`id`, `jum_minimal`) VALUES
(1, 10),
(2, 20);

-- --------------------------------------------------------

--
-- Table structure for table `pelanggan`
--

CREATE TABLE `pelanggan` (
  `id_pelanggan` int(12) NOT NULL,
  `nama_pelanggan` varchar(100) NOT NULL,
  `hutang` int(11) NOT NULL,
  `alamat` varchar(100) NOT NULL,
  `nohp` varchar(20) NOT NULL,
  `tanggal` date NOT NULL,
  `saldo` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `pelanggan`
--

INSERT INTO `pelanggan` (`id_pelanggan`, `nama_pelanggan`, `hutang`, `alamat`, `nohp`, `tanggal`, `saldo`) VALUES
(69, 'aab', 0, 'fsdfa', '332532422', '0000-00-00', 0),
(71, 'Jokowi', 20900, 'Jakarta', '0821744675', '2016-12-20', 0),
(73, 'ani', 0, 'jakarta', '081270517467', '2017-01-06', 1000),
(74, 'anu', 10000, 'jakarta', '081270517467', '2017-01-06', 0),
(75, 'taik', 0, 'taik', '081270517467', '2017-01-06', 0),
(76, 'tetek', 0, 'dssfsd', 'sfsdf', '2017-01-06', 0);

-- --------------------------------------------------------

--
-- Table structure for table `return_barang`
--

CREATE TABLE `return_barang` (
  `id_return` int(11) NOT NULL,
  `id_pelanggan` int(11) NOT NULL,
  `id_barangtoko` int(11) NOT NULL,
  `jumlah_barang` int(11) NOT NULL,
  `harga` int(11) NOT NULL,
  `tanggal` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `id_sesion` varchar(200) NOT NULL,
  `harga_return` int(12) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `return_barang`
--

INSERT INTO `return_barang` (`id_return`, `id_pelanggan`, `id_barangtoko`, `jumlah_barang`, `harga`, `tanggal`, `id_sesion`, `harga_return`) VALUES
(15, 0, 46, 1, 10000, '2017-01-07 07:15:06', '044ppfsi4k9abp7p0fqfsbqcv1', 1000);

-- --------------------------------------------------------

--
-- Table structure for table `stok_toko`
--

CREATE TABLE `stok_toko` (
  `id_toko` int(11) NOT NULL,
  `id_gudang` int(11) NOT NULL,
  `nama_toko` varchar(200) NOT NULL,
  `jenis_toko` text NOT NULL,
  `suplier_toko` text NOT NULL,
  `modal_toko` int(11) NOT NULL,
  `harga_atas_toko` int(11) NOT NULL,
  `harga_bawah_toko` int(11) NOT NULL,
  `jumlah_toko` int(11) NOT NULL,
  `sisa_toko` int(11) NOT NULL,
  `tanggal_masuktoko` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `stok_toko`
--

INSERT INTO `stok_toko` (`id_toko`, `id_gudang`, `nama_toko`, `jenis_toko`, `suplier_toko`, `modal_toko`, `harga_atas_toko`, `harga_bawah_toko`, `jumlah_toko`, `sisa_toko`, `tanggal_masuktoko`) VALUES
(46, 81, 'Aqua', 'Minuman', 'Aqua', 2300, 10000, 7000, 151, 13, '2016-12-26'),
(48, 83, 'Mentos', 'permen', 'mint', 10000, 15000, 11000, 72, 100, '2017-01-02'),
(49, 95, 'acer v5 471', 'laptop', 'acer', 7000000, 8000000, 7500000, 45, 3, '2017-01-06');

-- --------------------------------------------------------

--
-- Table structure for table `suplier`
--

CREATE TABLE `suplier` (
  `id_suplier` int(11) NOT NULL,
  `nama_suplier` varchar(60) NOT NULL,
  `bank` varchar(50) NOT NULL,
  `no_rekening` int(20) NOT NULL,
  `hutang` int(20) NOT NULL,
  `tempo` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `suplier`
--

INSERT INTO `suplier` (`id_suplier`, `nama_suplier`, `bank`, `no_rekening`, `hutang`, `tempo`) VALUES
(9, 'Yogi Broto', 'PANIN', 211000111, 20000, '2017-01-20'),
(10, 'Bokir', 'BRI', 123456, 6000, '2017-01-19');

-- --------------------------------------------------------

--
-- Table structure for table `transaksi`
--

CREATE TABLE `transaksi` (
  `id_transaksi` int(12) NOT NULL,
  `id_pelanggan` int(12) NOT NULL,
  `tot_belanja` int(11) NOT NULL,
  `jumlah_bayar` int(11) NOT NULL,
  `kembalian` int(11) NOT NULL,
  `tgl_transaksi` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `faktur` char(10) NOT NULL,
  `hutang_pertgl` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `transaksi`
--

INSERT INTO `transaksi` (`id_transaksi`, `id_pelanggan`, `tot_belanja`, `jumlah_bayar`, `kembalian`, `tgl_transaksi`, `faktur`, `hutang_pertgl`) VALUES
(38, 71, 84000, 65000, -19000, '2017-01-06 12:49:13', 'TJ0001', 0),
(39, 71, 8093000, 8000000, -93000, '2017-01-06 12:57:31', 'TJ0002', 0),
(40, 71, 8167000, 8000000, -167000, '2017-01-06 12:59:42', 'TJ0003', 0),
(41, 71, 8177000, 100000, -8077000, '2017-01-06 13:20:17', 'TJ0004', 0),
(42, 71, 16087000, 10000000, -6087000, '2017-01-06 13:21:15', 'TJ0005', 0),
(43, 69, 20000, 21500000, 21480000, '2017-01-06 13:34:56', 'TJ0006', 0),
(44, 71, 22097000, 21000000, -1097000, '2017-01-06 13:43:19', 'TJ0007', 0),
(45, 71, 9117000, 10000000, 883000, '2017-01-06 13:46:37', 'TJ0008', 0),
(46, 71, 10000, 100, -9900, '2017-01-06 13:56:58', 'TJ0009', 0),
(47, 71, 19900, 9000, -10900, '2017-01-06 14:00:25', 'TJ0010', 10900),
(48, 71, 30900, 10000, -20900, '2017-01-06 14:03:04', 'TJ0011', 20900),
(49, 72, 8010000, 7000000, -1010000, '2017-01-06 14:09:36', 'TJ0012', 1010000),
(50, 74, 30000, 20000, -10000, '2017-01-07 06:00:38', 'TJ0013', 10000),
(51, 74, 30000, 20000, -10000, '2017-01-07 06:01:50', 'TJ0014', 10000);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id_admin`);

--
-- Indexes for table `barang`
--
ALTER TABLE `barang`
  ADD PRIMARY KEY (`id_gudang`);

--
-- Indexes for table `barang_terjual`
--
ALTER TABLE `barang_terjual`
  ADD PRIMARY KEY (`id_terjual`);

--
-- Indexes for table `his_login`
--
ALTER TABLE `his_login`
  ADD PRIMARY KEY (`id_login`);

--
-- Indexes for table `karyawan`
--
ALTER TABLE `karyawan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `keranjang`
--
ALTER TABLE `keranjang`
  ADD PRIMARY KEY (`id_keranjang`);

--
-- Indexes for table `notif`
--
ALTER TABLE `notif`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pelanggan`
--
ALTER TABLE `pelanggan`
  ADD PRIMARY KEY (`id_pelanggan`),
  ADD UNIQUE KEY `id_transaksi` (`nama_pelanggan`);

--
-- Indexes for table `return_barang`
--
ALTER TABLE `return_barang`
  ADD PRIMARY KEY (`id_return`);

--
-- Indexes for table `stok_toko`
--
ALTER TABLE `stok_toko`
  ADD PRIMARY KEY (`id_toko`);

--
-- Indexes for table `suplier`
--
ALTER TABLE `suplier`
  ADD PRIMARY KEY (`id_suplier`);

--
-- Indexes for table `transaksi`
--
ALTER TABLE `transaksi`
  ADD PRIMARY KEY (`id_transaksi`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id_admin` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;
--
-- AUTO_INCREMENT for table `barang`
--
ALTER TABLE `barang`
  MODIFY `id_gudang` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=97;
--
-- AUTO_INCREMENT for table `barang_terjual`
--
ALTER TABLE `barang_terjual`
  MODIFY `id_terjual` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=77;
--
-- AUTO_INCREMENT for table `his_login`
--
ALTER TABLE `his_login`
  MODIFY `id_login` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
--
-- AUTO_INCREMENT for table `karyawan`
--
ALTER TABLE `karyawan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
--
-- AUTO_INCREMENT for table `keranjang`
--
ALTER TABLE `keranjang`
  MODIFY `id_keranjang` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `notif`
--
ALTER TABLE `notif`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `pelanggan`
--
ALTER TABLE `pelanggan`
  MODIFY `id_pelanggan` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=77;
--
-- AUTO_INCREMENT for table `return_barang`
--
ALTER TABLE `return_barang`
  MODIFY `id_return` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;
--
-- AUTO_INCREMENT for table `stok_toko`
--
ALTER TABLE `stok_toko`
  MODIFY `id_toko` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;
--
-- AUTO_INCREMENT for table `suplier`
--
ALTER TABLE `suplier`
  MODIFY `id_suplier` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT for table `transaksi`
--
ALTER TABLE `transaksi`
  MODIFY `id_transaksi` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
