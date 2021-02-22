-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 22, 2021 at 10:41 PM
-- Server version: 10.4.16-MariaDB
-- PHP Version: 7.4.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `testpg`
--

-- --------------------------------------------------------

--
-- Table structure for table `pelanggan`
--

CREATE TABLE `pelanggan` (
  `id_pelanggan` int(11) UNSIGNED NOT NULL,
  `nomor_pelanggan` char(50) NOT NULL,
  `nama_pelanggan` varchar(50) DEFAULT NULL,
  `tgl_lahir` date DEFAULT NULL,
  `jenis_keanggotaan` enum('Diamond','Silver','Gold') DEFAULT NULL,
  `alamat` text DEFAULT NULL,
  `telp` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `pelanggan`
--

INSERT INTO `pelanggan` (`id_pelanggan`, `nomor_pelanggan`, `nama_pelanggan`, `tgl_lahir`, `jenis_keanggotaan`, `alamat`, `telp`) VALUES
(5, 'VN-X1-0001', 'Lukman', '1998-06-25', 'Diamond', 'Pekanbaru', '0123'),
(6, 'VN-X1-0002', 'Eka', '1998-08-19', 'Gold', 'Jakarta', '1234'),
(7, 'VN-X1-0003', 'Fadli', '1998-04-18', 'Silver', 'Bandung', '3253'),
(12, 'VN-X1-0004', 'Anton', '1998-06-25', 'Diamond', 'Bekasi', '3455'),
(13, 'VN-X1-0005', 'Rangga', '1998-08-19', 'Gold', 'Jakarta', '6789'),
(14, 'VN-X1-0006', 'Putri', '1998-04-18', 'Silver', 'Jakarta', '3456'),
(15, 'VN-X1-0007', 'Gunawan', '1998-06-25', 'Diamond', 'Bekasi', '1232'),
(16, 'VN-X1-0008', 'Ahmad', '1998-08-19', 'Gold', 'Jakarta', '7687'),
(17, 'VN-X1-0009', 'Muhammad', '1998-04-18', 'Silver', 'Jakarta', '5647'),
(18, 'VN-X1-0010', 'Danny', '1998-06-25', 'Diamond', 'Bekasi', '6789'),
(19, 'VN-X1-0011', 'Bunga', '1998-08-19', 'Gold', 'Jakarta', '3425'),
(20, 'VN-X1-0012', 'Putra', '1998-04-18', 'Silver', 'Jakarta', '7589');

-- --------------------------------------------------------

--
-- Table structure for table `transaksi`
--

CREATE TABLE `transaksi` (
  `id_transaksi` int(11) NOT NULL,
  `no_faktur` varchar(20) DEFAULT NULL,
  `tanggal` date DEFAULT NULL,
  `id_pelanggan` varchar(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `transaksi`
--

INSERT INTO `transaksi` (`id_transaksi`, `no_faktur`, `tanggal`, `id_pelanggan`) VALUES
(1, 'FX-112', '2021-02-22', '1'),
(2, 'FX-113', '2021-02-22', '1'),
(3, 'FX-114', '2021-02-20', '2');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `pelanggan`
--
ALTER TABLE `pelanggan`
  ADD PRIMARY KEY (`id_pelanggan`);

--
-- Indexes for table `transaksi`
--
ALTER TABLE `transaksi`
  ADD PRIMARY KEY (`id_transaksi`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `pelanggan`
--
ALTER TABLE `pelanggan`
  MODIFY `id_pelanggan` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `transaksi`
--
ALTER TABLE `transaksi`
  MODIFY `id_transaksi` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
