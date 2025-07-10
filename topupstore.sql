-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 10, 2025 at 04:12 AM
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

DELIMITER $$
--
-- Procedures
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `INSERT_DATA` (IN `p_ID_PEMBELI` VARCHAR(20), IN `p_USERNAME` VARCHAR(100), IN `p_AKUN_WEBSITE` VARCHAR(100), IN `p_ID_TOKO` VARCHAR(20), IN `p_NAMA_GAME` VARCHAR(100), IN `p_PRODUK` VARCHAR(100), IN `p_HARGA` INT, IN `p_METODE_PEMBAYARAN` VARCHAR(50), IN `p_TANGGAL` DATE, IN `p_STATUS` VARCHAR(20))   BEGIN
    INSERT IGNORE INTO PEMBELI (ID_PEMBELI, USERNAME, AKUN_WEBSITE)
    VALUES (p_ID_PEMBELI, p_USERNAME, p_AKUN_WEBSITE);

    INSERT IGNORE INTO TOKO (ID_TOKO, NAMA_GAME, PRODUK, HARGA)
    VALUES (p_ID_TOKO, p_NAMA_GAME, p_PRODUK, p_HARGA);

    INSERT INTO TRANSAKSI (
        ID_TOKO_TR, ID_PEMBELI_TR, PRODUK_TRANSAKSI, HARGA,
        METODE_PEMBAYARAN, WAKTU_TR, STATUS
    )
    VALUES (
        p_ID_TOKO, p_ID_PEMBELI, p_PRODUK, p_HARGA,
        p_METODE_PEMBAYARAN, p_TANGGAL, p_STATUS
    );
END$$

DELIMITER ;

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
('mikel', 'mikel@yahoo.com', 'mikel'),
('sherine', 'sherine24ti@mahasiswa.pcr.ac.id', 'sherine'),
('sherine24', 'sherine@gmail.com', 'sherine24'),
('sherine241', 'gemcom177@gmail.com', 'as12'),
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
('0000000zero', 'zero', 'sherine24'),
('00918344', 'Heelllo', 'sherine24'),
('00918344435453', 'Glowstick', 'sherine24'),
('076295031', 'Bennett_Pro', 'user'),
('100123', 'jaxkip', 'mikel'),
('11111111', 'mikhail', 'sherine24'),
('113345565', 'ABCabjad', 'sherine24'),
('333641113', '111Hei111', 'sherine24'),
('343143143', 'iqdb132e34', 'sherine'),
('44345112', 'Eni', 'sherine'),
('55451234', 'Main123Main', 'sherine24'),
('6614177623', 'WAaW1', 'sherine'),
('76768423', 'EEEE123', 'sherine24'),
('809989427', 'Sherine', 'sherine'),
('851899868', 'Sien', 'sherine'),
('91919182', 'Bennnnet', 'sherine24');

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
('009231PM', 'PUBG Mobile', 'UC', 20000.00),
('100991GI', 'Genshin Impact', 'Primogem', 40000.00),
('112256ZZZ', 'Zenless Zone Zero', 'Monochrome', 30000.00),
('199233FF', 'Free Fire', 'Diamond Free Fire', 15000.00),
('200192WW', 'Wuthering Waves', 'Lunites', 30000.00),
('229811ML', 'Mobile Legends', 'Diamond Mobile Legends', 10000.00),
('298003V', 'Valorant', 'Valorant Point', 25000.00),
('889183HOK', 'Honor of Kings', 'Token', 30000.00),
('8901922R', 'Roblox', 'Robux', 30000.00);

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
(1, '100991GI', '851899868', 'Primogem', 40000.00, 'DANA', '2025-07-09', 'Selesai'),
(2, '889183HOK', '809989427', 'Token', 30000.00, 'QRIS', '2025-07-09', 'Selesai'),
(3, '199233FF', '076295031', 'Diamond Free Fire', 15000.00, 'DANA', '2025-07-09', 'Menunggu'),
(4, '298003V', '343143143', 'Valorant Point', 25000.00, 'QRIS', '2025-07-09', 'Menunggu'),
(5, '200192WW', '44345112', 'Lunites', 30000.00, 'OVO', '2025-07-09', 'Menunggu'),
(6, '889183HOK', '6614177623', 'Token', 30000.00, 'GoPay', '2025-07-09', 'Menunggu'),
(7, '199233FF', '00918344', 'Diamond Free Fire', 15000.00, 'OVO', '2025-07-10', 'Selesai'),
(8, '229811ML', '113345565', 'Diamond Mobile Legends', 10000.00, 'Bank Transfer', '2025-07-10', 'Menunggu'),
(9, '889183HOK', '76768423', 'Token', 30000.00, 'OVO', '2025-07-10', 'Menunggu'),
(10, '8901922R', '55451234', 'Robux', 30000.00, 'QRIS', '2025-07-10', 'Menunggu'),
(11, '112256ZZZ', '333641113', 'Monochrome', 30000.00, 'GoPay', '2025-07-10', 'Menunggu'),
(12, '009231PM', '91919182', 'UC', 20000.00, 'DANA', '2025-07-10', 'Menunggu'),
(13, '009231PM', '00918344435453', 'UC', 20000.00, 'GoPay', '2025-07-10', 'Menunggu'),
(14, '229811ML', '100123', 'Diamond Mobile Legends', 10000.00, 'DANA', '2025-07-10', 'Menunggu'),
(15, '100991GI', '100123', 'Primogem', 40000.00, 'DANA', '2025-07-10', 'Menunggu'),
(16, '229811ML', '0000000zero', 'Diamond Mobile Legends', 10000.00, 'Bank Transfer', '2025-07-10', 'Menunggu'),
(17, '8901922R', '11111111', 'Robux', 30000.00, 'QRIS', '2025-07-10', 'Menunggu');

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
  MODIFY `ID_TRANSAKSI` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

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
