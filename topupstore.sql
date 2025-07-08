-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 08, 2025 at 09:34 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `topupstore`
--

-- --------------------------------------------------------

--
-- Table structure for table `pembeli`
--

CREATE TABLE `pembeli` (
  `ID_PEMBELI` varchar(30) NOT NULL,
  `USERNAME` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pembeli`
--

INSERT INTO `pembeli` (`ID_PEMBELI`, `USERNAME`) VALUES
('851899868', 'Sien');

-- --------------------------------------------------------

--
-- Table structure for table `toko`
--

CREATE TABLE `toko` (
  `ID_TOKO` varchar(20) NOT NULL,
  `NAMA_GAME` varchar(100) NOT NULL,
  `PRODUK` varchar(50) NOT NULL,
  `HARGA` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `toko`
--

INSERT INTO `toko` (`ID_TOKO`, `NAMA_GAME`, `PRODUK`, `HARGA`) VALUES
('100991GI', 'Genshin Impact', 'Primogem', 40000.00);

-- --------------------------------------------------------

--
-- Table structure for table `transaksi`
--

CREATE TABLE `transaksi` (
  `ID_TRANSAKSI` int(4) NOT NULL,
  `ID_TOKO_TR` varchar(20) NOT NULL,
  `ID_PEMBELI_TR` varchar(30) NOT NULL,
  `PRODUK_TRANSAKSI` varchar(50) NOT NULL,
  `HARGA` decimal(10,2) NOT NULL,
  `METODE_PEMBAYARAN` varchar(40) NOT NULL,
  `WAKTU_TR` date NOT NULL,
  `STATUS` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `transaksi`
--

INSERT INTO `transaksi` (`ID_TRANSAKSI`, `ID_TOKO_TR`, `ID_PEMBELI_TR`, `PRODUK_TRANSAKSI`, `HARGA`, `METODE_PEMBAYARAN`, `WAKTU_TR`, `STATUS`) VALUES
(1, '100991GI', '851899868', 'Primogem', 40000.00, 'GoPay', '2025-07-08', 'Menunggu');

-- --------------------------------------------------------

--
-- Stand-in structure for view `transaksi_top_up`
-- (See below for the actual view)
--
CREATE TABLE `transaksi_top_up` (
`ID_TRANSAKSI` int(4)
,`ID_TOKO_TR` varchar(20)
,`ID_PEMBELI_TR` varchar(30)
,`PRODUK_TRANSAKSI` varchar(50)
,`HARGA` decimal(10,2)
,`METODE_PEMBAYARAN` varchar(40)
,`WAKTU_TR` date
,`STATUS` varchar(10)
);

-- --------------------------------------------------------

--
-- Structure for view `transaksi_top_up`
--
DROP TABLE IF EXISTS `transaksi_top_up`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `transaksi_top_up`  AS SELECT `transaksi`.`ID_TRANSAKSI` AS `ID_TRANSAKSI`, `transaksi`.`ID_TOKO_TR` AS `ID_TOKO_TR`, `transaksi`.`ID_PEMBELI_TR` AS `ID_PEMBELI_TR`, `transaksi`.`PRODUK_TRANSAKSI` AS `PRODUK_TRANSAKSI`, `transaksi`.`HARGA` AS `HARGA`, `transaksi`.`METODE_PEMBAYARAN` AS `METODE_PEMBAYARAN`, `transaksi`.`WAKTU_TR` AS `WAKTU_TR`, `transaksi`.`STATUS` AS `STATUS` FROM `transaksi` ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `pembeli`
--
ALTER TABLE `pembeli`
  ADD PRIMARY KEY (`ID_PEMBELI`);

--
-- Indexes for table `toko`
--
ALTER TABLE `toko`
  ADD PRIMARY KEY (`ID_TOKO`);

--
-- Indexes for table `transaksi`
--
ALTER TABLE `transaksi`
  ADD PRIMARY KEY (`ID_TRANSAKSI`),
  ADD KEY `ID_TOKO_TR` (`ID_TOKO_TR`),
  ADD KEY `ID_PLAYER_TR` (`ID_PEMBELI_TR`),
  ADD KEY `CARI_STATUS` (`STATUS`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `transaksi`
--
ALTER TABLE `transaksi`
  MODIFY `ID_TRANSAKSI` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `transaksi`
--
ALTER TABLE `transaksi`
  ADD CONSTRAINT `transaksi_ibfk_1` FOREIGN KEY (`ID_TOKO_TR`) REFERENCES `toko` (`ID_TOKO`),
  ADD CONSTRAINT `transaksi_ibfk_2` FOREIGN KEY (`ID_PEMBELI_TR`) REFERENCES `pembeli` (`ID_PEMBELI`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
