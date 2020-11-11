-- phpMyAdmin SQL Dump
-- version 4.6.6deb5
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jun 21, 2019 at 06:42 AM
-- Server version: 5.7.26-0ubuntu0.18.04.1
-- PHP Version: 7.2.19-0ubuntu0.18.04.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ksp_xyz`
--

-- --------------------------------------------------------

--
-- Table structure for table `anggota`
--

CREATE TABLE `anggota` (
  `id` int(11) NOT NULL,
  `ktp` text NOT NULL,
  `nik` varchar(25) NOT NULL,
  `nama` varchar(25) NOT NULL,
  `alamat` text NOT NULL,
  `telepon` varchar(15) NOT NULL,
  `jk` varchar(10) NOT NULL,
  `username` varchar(25) NOT NULL,
  `password` text NOT NULL,
  `status` int(11) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `anggota`
--

INSERT INTO `anggota` (`id`, `ktp`, `nik`, `nama`, `alamat`, `telepon`, `jk`, `username`, `password`, `status`) VALUES
(1, 'Screenshot from 2018-08-21 13-53-30.png', '123456789', 'Ismail', 'Bojonegoro', '085600000000', 'Pria', 'ismail', 'e10adc3949ba59abbe56e057f20f883e', 1),
(5, 'Screenshot from 2018-09-12 07-49-21.png', '987654321', 'Hasan', 'Surabaya', '085600000001', 'Pria', 'hasan', 'e10adc3949ba59abbe56e057f20f883e', 1);

-- --------------------------------------------------------

--
-- Table structure for table `bunga`
--

CREATE TABLE `bunga` (
  `id` int(11) NOT NULL,
  `simpanan_id` int(11) NOT NULL,
  `bulan` int(11) NOT NULL,
  `tahun` int(11) NOT NULL,
  `jumlah` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `bunga`
--

INSERT INTO `bunga` (`id`, `simpanan_id`, `bulan`, `tahun`, `jumlah`) VALUES
(15, 3, 4, 2019, 20000),
(16, 3, 5, 2019, 20000),
(17, 3, 6, 2019, 20000),
(18, 3, 7, 2019, 20000),
(19, 3, 8, 2019, 20000),
(20, 3, 9, 2019, 20000),
(21, 3, 10, 2019, 20000),
(22, 3, 11, 2019, 20000),
(23, 3, 12, 2019, 20000),
(24, 3, 1, 2020, 20000),
(25, 3, 2, 2020, 20000),
(26, 3, 3, 2020, 20000),
(27, 3, 4, 2020, 20000),
(28, 3, 5, 2020, 20000);

-- --------------------------------------------------------

--
-- Table structure for table `pembayaran_pinjaman`
--

CREATE TABLE `pembayaran_pinjaman` (
  `id` int(11) NOT NULL,
  `pinjaman_id` int(11) NOT NULL,
  `jatuh_tempo` date NOT NULL,
  `angsuran_ke` int(11) NOT NULL,
  `jumlah` int(11) NOT NULL,
  `denda` int(11) NOT NULL DEFAULT '0',
  `status` int(11) NOT NULL DEFAULT '0' COMMENT '0: Belum Lunas, 1: Sudah Lunas'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `periode`
--

CREATE TABLE `periode` (
  `id` int(11) NOT NULL,
  `nama` varchar(25) NOT NULL,
  `awal` date NOT NULL,
  `akhir` date NOT NULL,
  `aktif` int(11) NOT NULL,
  `status` int(11) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `periode`
--

INSERT INTO `periode` (`id`, `nama`, `awal`, `akhir`, `aktif`, `status`) VALUES
(1, '2019/2020', '2019-05-03', '2020-05-03', 1, 1),
(2, '2020/2021', '2020-05-03', '2020-05-03', 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `pinjaman`
--

CREATE TABLE `pinjaman` (
  `id` int(11) NOT NULL,
  `anggota_id` int(11) NOT NULL,
  `jumlah_pinjaman` int(11) NOT NULL,
  `lama_pinjaman` int(11) NOT NULL,
  `bunga_pinjaman` double NOT NULL,
  `total_pinjaman` int(11) NOT NULL,
  `cicilan_per_bulan` int(11) NOT NULL,
  `uang_yang_diterima` int(11) NOT NULL,
  `status` enum('pengajuan','diterima','selesai','ditolak') NOT NULL,
  `tgl_acc` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `pinjaman`
--

INSERT INTO `pinjaman` (`id`, `anggota_id`, `jumlah_pinjaman`, `lama_pinjaman`, `bunga_pinjaman`, `total_pinjaman`, `cicilan_per_bulan`, `uang_yang_diterima`, `status`, `tgl_acc`) VALUES
(1, 1, 1000000, 12, 0.5, 1005000, 83750, 900000, 'pengajuan', NULL),
(2, 2, 1500000, 24, 10, 1650000, 68750, 1300000, 'pengajuan', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `simpanan`
--

CREATE TABLE `simpanan` (
  `id` int(11) NOT NULL,
  `periode_id` int(11) NOT NULL,
  `anggota_id` int(11) NOT NULL,
  `tanggal_debet` date NOT NULL,
  `debet` int(11) NOT NULL,
  `tanggal_kredit` date DEFAULT NULL,
  `kredit` int(11) DEFAULT '0',
  `keterangan` text
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `simpanan`
--

INSERT INTO `simpanan` (`id`, `periode_id`, `anggota_id`, `tanggal_debet`, `debet`, `tanggal_kredit`, `kredit`, `keterangan`) VALUES
(1, 1, 1, '2019-04-03', 100000, NULL, 0, 'Saham Awal'),
(3, 1, 1, '2019-04-21', 200000, NULL, 0, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `nama` varchar(50) NOT NULL,
  `username` varchar(25) NOT NULL,
  `password` text NOT NULL,
  `akses` varchar(10) NOT NULL,
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `nama`, `username`, `password`, `akses`, `status`) VALUES
(1, 'Admin', 'admin', '21232f297a57a5a743894a0e4a801fc3', 'Admin', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `anggota`
--
ALTER TABLE `anggota`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nik` (`nik`);

--
-- Indexes for table `bunga`
--
ALTER TABLE `bunga`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pembayaran_pinjaman`
--
ALTER TABLE `pembayaran_pinjaman`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `periode`
--
ALTER TABLE `periode`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pinjaman`
--
ALTER TABLE `pinjaman`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `simpanan`
--
ALTER TABLE `simpanan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `anggota`
--
ALTER TABLE `anggota`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `bunga`
--
ALTER TABLE `bunga`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;
--
-- AUTO_INCREMENT for table `pembayaran_pinjaman`
--
ALTER TABLE `pembayaran_pinjaman`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `periode`
--
ALTER TABLE `periode`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `pinjaman`
--
ALTER TABLE `pinjaman`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `simpanan`
--
ALTER TABLE `simpanan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
