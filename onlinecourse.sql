-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 20, 2021 at 08:32 AM
-- Server version: 10.4.21-MariaDB
-- PHP Version: 8.0.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `onlinecourse`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id_admin` char(5) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `nama` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id_admin`, `email`, `password`, `nama`) VALUES
('A0001', 'admin@admin.com', 'admin1', 'aku admin 1');

-- --------------------------------------------------------

--
-- Table structure for table `course`
--

CREATE TABLE `course` (
  `id_course` char(5) NOT NULL,
  `judul_course` varchar(100) NOT NULL,
  `deskripsi_course` varchar(300) NOT NULL,
  `harga` float NOT NULL,
  `thumbnail` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `course`
--

INSERT INTO `course` (`id_course`, `judul_course`, `deskripsi_course`, `harga`, `thumbnail`) VALUES
('E0001', 'Flutter & Dart - The Complete Guide [2022 Edition]', 'A Complete Guide to the Flutter SDK & Flutter Framework for building native iOS and Android apps', 50000, 'flutter.jpg'),
('E0002', 'The Complete Go:Golang Bootcamp', 'Learn Golang programing language From Scratch to Expert Level with Hands-On Exercises', 70000, 'golang.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `customer`
--

CREATE TABLE `customer` (
  `id_customer` char(5) NOT NULL,
  `id_course` char(5) DEFAULT NULL,
  `id_portofolio` char(5) DEFAULT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `nama_customer` varchar(100) NOT NULL,
  `alamat` varchar(100) NOT NULL,
  `telepon` varchar(13) NOT NULL,
  `tanggal` date NOT NULL,
  `gender` enum('L','P') NOT NULL,
  `saldo` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `customer`
--

INSERT INTO `customer` (`id_customer`, `id_course`, `id_portofolio`, `email`, `password`, `nama_customer`, `alamat`, `telepon`, `tanggal`, `gender`, `saldo`) VALUES
('C9705', NULL, NULL, 'customer1@gmail.com', 'customer1', 'customer 1', 'Sleman', '08983141211', '2014-02-06', 'L', 5000000);

-- --------------------------------------------------------

--
-- Table structure for table `portofolio`
--

CREATE TABLE `portofolio` (
  `id_portofolio` char(5) NOT NULL,
  `judul_portofolio` varchar(100) NOT NULL,
  `deskripsi` varchar(300) NOT NULL,
  `thumbnail` varchar(255) NOT NULL,
  `lampiran` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `transaksi`
--

CREATE TABLE `transaksi` (
  `id_transaksi` char(5) NOT NULL,
  `id_customer` char(5) NOT NULL,
  `id_course` char(5) NOT NULL,
  `jumlah` int(11) NOT NULL,
  `total` float NOT NULL,
  `tanggal` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `transaksi`
--

INSERT INTO `transaksi` (`id_transaksi`, `id_customer`, `id_course`, `jumlah`, `total`, `tanggal`) VALUES
('T0001', 'C9705', 'E0001', 1, 50000, '2021-12-18'),
('T0002', 'C9705', 'E0002', 1, 70000, '2021-12-03'),
('T0003', 'C9705', 'E0001', 1, 50000, '2020-12-17'),
('T0004', 'C9705', 'E0001', 1, 50000, '2021-12-18'),
('T0005', 'C9705', 'E0002', 1, 70000, '2021-12-18'),
('T0006', 'C9705', 'E0001', 1, 50000, '2021-11-17'),
('T0007', 'C9705', 'E0001', 1, 50000, '2021-11-17'),
('T0008', 'C9705', 'E0001', 1, 50000, '2021-11-18'),
('T0009', 'C9705', 'E0001', 1, 50000, '2021-11-19');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id_admin`);

--
-- Indexes for table `course`
--
ALTER TABLE `course`
  ADD PRIMARY KEY (`id_course`);

--
-- Indexes for table `customer`
--
ALTER TABLE `customer`
  ADD PRIMARY KEY (`id_customer`),
  ADD KEY `id_course` (`id_course`),
  ADD KEY `id_portofolio` (`id_portofolio`);

--
-- Indexes for table `portofolio`
--
ALTER TABLE `portofolio`
  ADD PRIMARY KEY (`id_portofolio`);

--
-- Indexes for table `transaksi`
--
ALTER TABLE `transaksi`
  ADD PRIMARY KEY (`id_transaksi`),
  ADD KEY `id_course` (`id_course`),
  ADD KEY `id_customer` (`id_customer`);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `customer`
--
ALTER TABLE `customer`
  ADD CONSTRAINT `customer_ibfk_1` FOREIGN KEY (`id_course`) REFERENCES `course` (`id_course`),
  ADD CONSTRAINT `customer_ibfk_2` FOREIGN KEY (`id_portofolio`) REFERENCES `portofolio` (`id_portofolio`);

--
-- Constraints for table `transaksi`
--
ALTER TABLE `transaksi`
  ADD CONSTRAINT `transaksi_ibfk_1` FOREIGN KEY (`id_course`) REFERENCES `course` (`id_course`),
  ADD CONSTRAINT `transaksi_ibfk_2` FOREIGN KEY (`id_customer`) REFERENCES `customer` (`id_customer`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
