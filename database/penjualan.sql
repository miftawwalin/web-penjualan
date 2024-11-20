-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 13, 2024 at 01:31 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `penjualan`
--

-- --------------------------------------------------------

--
-- Table structure for table `barang`
--

CREATE TABLE `barang` (
  `id_barang` int(11) NOT NULL,
  `nama_produk` varchar(100) NOT NULL,
  `harga_satuan` decimal(10,2) NOT NULL,
  `stok` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `barang`
--

INSERT INTO `barang` (`id_barang`, `nama_produk`, `harga_satuan`, `stok`) VALUES
(52, 'Indomie Goreng', 3000.00, 100),
(53, 'Bimoli Minyak Goreng 1L', 15000.00, 50),
(54, 'Aqua Botol 600ml', 3500.00, 120),
(55, 'Pepsodent Pasta Gigi', 12000.00, 60),
(56, 'Rinso Deterjen 800g', 14000.00, 40),
(57, 'Kopi Kapal Api Sachet', 2000.00, 150),
(58, 'Sari Roti Tawar', 12000.00, 35),
(59, 'SilverQueen Cokelat 65g', 12000.00, 25),
(60, 'Ultra Milk Cokelat 250ml', 5000.00, 80),
(61, 'Le Minerale Botol 600ml', 3000.00, 110),
(62, 'Lifebuoy Sabun Cair 450ml', 20000.00, 40),
(63, 'Nu Green Tea 500ml', 6000.00, 70),
(64, 'Teh Kotak 200ml', 4000.00, 95),
(65, 'Good Day Cappuccino 250ml', 5000.00, 65),
(66, 'Richeese Nabati 145g', 7000.00, 60),
(67, 'Roma Kelapa 300g', 10000.00, 50),
(68, 'Oreo Cokelat 137g', 8000.00, 55),
(69, 'Mie Sedaap Goreng', 2500.00, 110),
(70, 'Pocari Sweat 500ml', 7000.00, 90),
(71, 'ABC Kopi Susu Sachet', 2000.00, 120),
(72, 'Clear Shampoo 170ml', 18000.00, 40),
(73, 'Buavita Orange 250ml', 8000.00, 75),
(74, 'Tango Wafer Coklat 145g', 7000.00, 65),
(75, 'Nestle Milo Kotak 200ml', 5000.00, 70),
(76, 'Coca-Cola Kaleng 330ml', 6000.00, 80),
(77, 'Teh Pucuk Harum 350ml', 5000.00, 90),
(78, 'Fanta Botol 1L', 12000.00, 40),
(79, 'Sunlight Jeruk Nipis 755ml', 16000.00, 50),
(80, 'Dettol Antiseptik 250ml', 20000.00, 45),
(81, 'Gulaku Gula Pasir 1kg', 12000.00, 55),
(82, 'Tissue Paseo 250 Lembar', 15000.00, 30),
(83, 'Frisian Flag Susu Kental Manis', 8000.00, 60),
(84, 'Nutrisari Jeruk Sachet', 1500.00, 150),
(85, 'Indofood Kecap Manis 550ml', 10000.00, 40),
(86, 'Sedaap Saus Sambal 135ml', 5000.00, 80),
(87, 'So Klin Pewangi 800ml', 12000.00, 35),
(88, 'Mama Lemon 800ml', 15000.00, 30),
(89, 'Energen Cokelat Sachet', 2000.00, 100),
(90, 'Listerine Cool Mint 250ml', 25000.00, 20),
(91, 'Kratingdaeng 150ml', 7000.00, 85),
(92, 'Gatsby Pomade 75g', 25000.00, 15),
(93, 'Sedaap Mie Kari Ayam', 2500.00, 110),
(94, 'Nescafe Classic 100g', 25000.00, 25),
(95, 'Susu Bendera Coklat 200ml', 5000.00, 95),
(96, 'ABC Sambal Terasi Sachet', 1500.00, 130),
(97, 'Chocolatos Stick Wafer 20g', 2000.00, 110),
(98, 'Kopiko Candy Bag 150g', 8000.00, 40),
(99, 'Sakatonik ABC Anak 150ml', 15000.00, 20),
(100, 'Indofood Bumbu Racik Ayam', 2500.00, 100),
(101, 'Hansaplast Plester 1 box', 12000.00, 50);

-- --------------------------------------------------------

--
-- Table structure for table `detail_transaksi`
--

CREATE TABLE `detail_transaksi` (
  `id_detail` int(11) NOT NULL,
  `id_transaksi` varchar(15) NOT NULL,
  `nama_produk` varchar(100) NOT NULL,
  `jumlah` int(11) NOT NULL,
  `harga_satuan` decimal(10,2) NOT NULL,
  `total_harga` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `detail_transaksi`
--

INSERT INTO `detail_transaksi` (`id_detail`, `id_transaksi`, `nama_produk`, `jumlah`, `harga_satuan`, `total_harga`) VALUES
(19, '20241111100951', 'Indomie Goreng', 6, 3000.00, 18000.00),
(20, '20241111100951', 'Sari Roti Tawar', 4, 12000.00, 48000.00),
(21, '20241111101254', 'Rinso Deterjen 800g', 5, 14000.00, 70000.00),
(22, '20241111101254', 'Pepsodent Pasta Gigi', 2, 12000.00, 24000.00),
(23, '20241111101747', 'Bimoli Minyak Goreng 1L', 4, 15000.00, 60000.00),
(24, '20241111102606', 'Bimoli Minyak Goreng 1L', 4, 15000.00, 60000.00),
(25, '2024-11-11 10:2', 'Sari Roti Tawar', 12, 12000.00, 144000.00),
(26, '20241111102836', 'Sari Roti Tawar', 12, 12000.00, 144000.00),
(27, '20241111103001', 'Bimoli Minyak Goreng 1L', 2, 15000.00, 30000.00),
(28, '20241111103354', 'Aqua Botol 600ml', 2, 3500.00, 7000.00),
(29, '20241111163503', 'Indomie Goreng', 4, 3000.00, 12000.00),
(30, '20241111163646', 'Bimoli Minyak Goreng 1L', 2, 15000.00, 30000.00),
(31, '20241111164517', 'Bimoli Minyak Goreng 1L', 5, 15000.00, 75000.00),
(32, '20241111164517', 'Sari Roti Tawar', 4, 12000.00, 48000.00),
(33, '20241111165330', 'Indomie Goreng', 3, 3000.00, 9000.00),
(34, '20241112194610', 'Indomie Goreng', 4, 3000.00, 12000.00),
(35, '20241112194610', 'Kopi Kapal Api Sachet', 5, 2000.00, 10000.00);

-- --------------------------------------------------------

--
-- Stand-in structure for view `history`
-- (See below for the actual view)
--
CREATE TABLE `history` (
`id_transaksi` varchar(15)
,`nama_produk` varchar(100)
,`jumlah` int(11)
,`harga_satuan` decimal(10,2)
,`total_harga` decimal(10,2)
);

-- --------------------------------------------------------

--
-- Table structure for table `transaksi`
--

CREATE TABLE `transaksi` (
  `id_transaksi` varchar(15) NOT NULL,
  `id_user` int(11) NOT NULL,
  `tanggal_transaksi` datetime NOT NULL,
  `total` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `transaksi`
--

INSERT INTO `transaksi` (`id_transaksi`, `id_user`, `tanggal_transaksi`, `total`) VALUES
('2024-11-11 10:2', 1, '0000-00-00 00:00:00', 144000.00),
('20241111100951', 1, '0000-00-00 00:00:00', 0.00),
('20241111101254', 1, '0000-00-00 00:00:00', 0.00),
('20241111101747', 1, '0000-00-00 00:00:00', 0.00),
('20241111102606', 1, '0000-00-00 00:00:00', 60000.00),
('20241111102836', 1, '0000-00-00 00:00:00', 144000.00),
('20241111103001', 1, '2024-11-11 00:00:00', 30000.00),
('20241111103354', 1, '2024-11-11 10:33:54', 7000.00),
('20241111163503', 1, '2024-11-11 10:35:03', 12000.00),
('20241111163646', 1, '2024-11-11 16:36:46', 30000.00),
('20241111164517', 1, '2024-11-11 16:45:17', 123000.00),
('20241111165330', 1, '2024-11-11 16:53:30', 9000.00),
('20241112194610', 1, '2024-11-12 19:46:10', 22000.00);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id_user` int(5) NOT NULL,
  `nama_user` varchar(50) NOT NULL,
  `username` varchar(8) NOT NULL,
  `password` varchar(8) NOT NULL,
  `akses` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id_user`, `nama_user`, `username`, `password`, `akses`) VALUES
(1, 'Wendi Nugraha Nurrahmansyah', 'wendi21', 'Wendi@21', 1);

-- --------------------------------------------------------

--
-- Structure for view `history`
--
DROP TABLE IF EXISTS `history`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `history`  AS SELECT `transaksi`.`id_transaksi` AS `id_transaksi`, `detail_transaksi`.`nama_produk` AS `nama_produk`, `detail_transaksi`.`jumlah` AS `jumlah`, `detail_transaksi`.`harga_satuan` AS `harga_satuan`, `detail_transaksi`.`total_harga` AS `total_harga` FROM (`transaksi` join `detail_transaksi` on(`transaksi`.`id_transaksi` = `detail_transaksi`.`id_transaksi`)) ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `barang`
--
ALTER TABLE `barang`
  ADD PRIMARY KEY (`id_barang`);

--
-- Indexes for table `detail_transaksi`
--
ALTER TABLE `detail_transaksi`
  ADD PRIMARY KEY (`id_detail`);

--
-- Indexes for table `transaksi`
--
ALTER TABLE `transaksi`
  ADD PRIMARY KEY (`id_transaksi`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id_user`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `barang`
--
ALTER TABLE `barang`
  MODIFY `id_barang` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=102;

--
-- AUTO_INCREMENT for table `detail_transaksi`
--
ALTER TABLE `detail_transaksi`
  MODIFY `id_detail` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
