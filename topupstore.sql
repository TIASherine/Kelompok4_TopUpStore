-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 07, 2025 at 07:11 PM
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
  `ID_PLAYER` varchar(30) NOT NULL,
  `USERNAME` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pembeli`
--

INSERT INTO `pembeli` (`ID_PLAYER`, `USERNAME`) VALUES
('1223667100', 'Heyy1111'),
('1223667188', 'Poll9912'),
('843726195837462', 'MainBesto'),
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
('10099GI', 'Genshin Impact', 'Primogem', 40000.00),
('200192WW', 'Wuthering Waves', 'Lunites', 30000.00),
('89019R', 'Roblox', 'Robux', 30000.00);

-- --------------------------------------------------------

--
-- Table structure for table `transaksi`
--

CREATE TABLE `transaksi` (
  `ID_TRANSAKSI` int(5) NOT NULL,
  `ID_TOKO_TR` varchar(20) NOT NULL,
  `ID_PLAYER_TR` varchar(30) NOT NULL,
  `PRODUK_TRANSAKSI` varchar(50) NOT NULL,
  `HARGA` decimal(10,2) NOT NULL,
  `METODE_PEMBAYARAN` varchar(40) NOT NULL,
  `WAKTU_TR` date NOT NULL,
  `STATUS` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Stand-in structure for view `transaksi_top_up`
-- (See below for the actual view)
--
CREATE TABLE `transaksi_top_up` (
`ID_TRANSAKSI` int(5)
,`ID_TOKO` varchar(20)
,`ID_PLAYER` varchar(30)
,`PRODUK` varchar(50)
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

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `transaksi_top_up`  AS SELECT `t`.`ID_TRANSAKSI` AS `ID_TRANSAKSI`, `k`.`ID_TOKO` AS `ID_TOKO`, `p`.`ID_PLAYER` AS `ID_PLAYER`, `k`.`PRODUK` AS `PRODUK`, `t`.`HARGA` AS `HARGA`, `t`.`METODE_PEMBAYARAN` AS `METODE_PEMBAYARAN`, `t`.`WAKTU_TR` AS `WAKTU_TR`, `t`.`STATUS` AS `STATUS` FROM ((`transaksi` `t` join `pembeli` `p` on(`t`.`ID_PLAYER_TR` = `p`.`ID_PLAYER`)) join `toko` `k` on(`t`.`ID_TOKO_TR` = `k`.`ID_TOKO`)) ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `pembeli`
--
ALTER TABLE `pembeli`
  ADD PRIMARY KEY (`ID_PLAYER`);

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
  ADD KEY `ID_PLAYER_TR` (`ID_PLAYER_TR`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `transaksi`
--
ALTER TABLE `transaksi`
  MODIFY `ID_TRANSAKSI` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `transaksi`
--
ALTER TABLE `transaksi`
  ADD CONSTRAINT `transaksi_ibfk_1` FOREIGN KEY (`ID_TOKO_TR`) REFERENCES `toko` (`ID_TOKO`),
  ADD CONSTRAINT `transaksi_ibfk_2` FOREIGN KEY (`ID_PLAYER_TR`) REFERENCES `pembeli` (`ID_PLAYER`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
