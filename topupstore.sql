-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 09, 2025 at 04:44 AM
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
-- Table structure for table `akun`
--

CREATE TABLE `akun` (
  `NAMA_AKUN` varchar(50) NOT NULL,
  `EMAIL` varchar(100) NOT NULL,
  `PASSWORD` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `akun`
--

INSERT INTO `akun` (`NAMA_AKUN`, `EMAIL`, `PASSWORD`) VALUES
('sherine', 'sherine24ti@mahasiswa.pcr.ac.id', 'sherine'),
('user', 'user22@gmail.com', 'hallo111');

-- --------------------------------------------------------

--
-- Table structure for table `pembeli`
--

CREATE TABLE `pembeli` (
  `ID_PEMBELI` varchar(30) NOT NULL,
  `USERNAME` varchar(50) NOT NULL,
  `AKUN_WEBSITE` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pembeli`
--

INSERT INTO `pembeli` (`ID_PEMBELI`, `USERNAME`, `AKUN_WEBSITE`) VALUES
('076295031', 'Bennett_Pro', 'user'),
('343143143', 'iqdb132e34', 'sherine'),
('809989427', 'Sherine', 'sherine'),
('851899868', 'Sien', 'sherine');

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
('100991GI', 'Genshin Impact', 'Primogem', 40000.00),
('199233FF', 'Free Fire', 'Diamond Free Fire', 15000.00),
('298003V', 'Valorant', 'Valorant Point', 25000.00),
('889183HOK', 'Honor of Kings', 'Token', 30000.00);

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
(1, '100991GI', '851899868', 'Primogem', 40000.00, 'DANA', '2025-07-09', 'Menunggu'),
(2, '889183HOK', '809989427', 'Token', 30000.00, 'QRIS', '2025-07-09', 'Menunggu'),
(3, '199233FF', '076295031', 'Diamond Free Fire', 15000.00, 'DANA', '2025-07-09', 'Menunggu'),
(4, '298003V', '343143143', 'Valorant Point', 25000.00, 'QRIS', '2025-07-09', 'Menunggu');

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
-- Stand-in structure for view `transaksi_user`
-- (See below for the actual view)
--
CREATE TABLE `transaksi_user` (
`UID` varchar(30)
,`USERNAME` varchar(50)
,`AKUN` varchar(50)
,`PEMBELIAN` varchar(50)
,`HARGA` decimal(10,2)
,`METODE_PEMBAYARAN` varchar(40)
,`TANGGAL` date
,`STATUS` varchar(10)
);

-- --------------------------------------------------------

--
-- Structure for view `transaksi_top_up`
--
DROP TABLE IF EXISTS `transaksi_top_up`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `transaksi_top_up`  AS SELECT `transaksi`.`ID_TRANSAKSI` AS `ID_TRANSAKSI`, `transaksi`.`ID_TOKO_TR` AS `ID_TOKO_TR`, `transaksi`.`ID_PEMBELI_TR` AS `ID_PEMBELI_TR`, `transaksi`.`PRODUK_TRANSAKSI` AS `PRODUK_TRANSAKSI`, `transaksi`.`HARGA` AS `HARGA`, `transaksi`.`METODE_PEMBAYARAN` AS `METODE_PEMBAYARAN`, `transaksi`.`WAKTU_TR` AS `WAKTU_TR`, `transaksi`.`STATUS` AS `STATUS` FROM `transaksi` ;

-- --------------------------------------------------------

--
-- Structure for view `transaksi_user`
--
DROP TABLE IF EXISTS `transaksi_user`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `transaksi_user`  AS SELECT `p`.`ID_PEMBELI` AS `UID`, `p`.`USERNAME` AS `USERNAME`, `a`.`NAMA_AKUN` AS `AKUN`, `tr`.`PRODUK_TRANSAKSI` AS `PEMBELIAN`, `tr`.`HARGA` AS `HARGA`, `tr`.`METODE_PEMBAYARAN` AS `METODE_PEMBAYARAN`, `tr`.`WAKTU_TR` AS `TANGGAL`, `tr`.`STATUS` AS `STATUS` FROM ((`transaksi` `tr` join `pembeli` `p` on(`tr`.`ID_PEMBELI_TR` = `p`.`ID_PEMBELI`)) join `akun` `a` on(`p`.`AKUN_WEBSITE` = `a`.`NAMA_AKUN`)) ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `akun`
--
ALTER TABLE `akun`
  ADD PRIMARY KEY (`NAMA_AKUN`);

--
-- Indexes for table `pembeli`
--
ALTER TABLE `pembeli`
  ADD PRIMARY KEY (`ID_PEMBELI`),
  ADD KEY `AKUN` (`AKUN_WEBSITE`);

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
  MODIFY `ID_TRANSAKSI` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `pembeli`
--
ALTER TABLE `pembeli`
  ADD CONSTRAINT `AKUN` FOREIGN KEY (`AKUN_WEBSITE`) REFERENCES `akun` (`NAMA_AKUN`) ON DELETE CASCADE ON UPDATE CASCADE;

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
