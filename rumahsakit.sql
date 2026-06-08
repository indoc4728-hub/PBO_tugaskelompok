-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jun 08, 2026 at 04:56 AM
-- Server version: 8.0.30
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `rumahsakit`
--

-- --------------------------------------------------------

--
-- Table structure for table `pasien`
--

CREATE TABLE `pasien` (
  `id_pasien` varchar(10) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `usia` int NOT NULL,
  `lama_rawat` int NOT NULL,
  `biaya_kamar_per_hari` decimal(12,2) NOT NULL,
  `jenis_pasien` enum('BPJS','Asuransi Swasta','Umum') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `pasien`
--

INSERT INTO `pasien` (`id_pasien`, `nama`, `usia`, `lama_rawat`, `biaya_kamar_per_hari`, `jenis_pasien`) VALUES
('PSN-001', 'Budi Santoso', 45, 5, '300000.00', 'BPJS'),
('PSN-002', 'Siti Aminah', 60, 3, '500000.00', 'BPJS'),
('PSN-003', 'Ahmad Fauzi', 28, 7, '200000.00', 'BPJS'),
('PSN-004', 'Dewi Lestari', 34, 4, '300000.00', 'BPJS'),
('PSN-005', 'Eko Prasetyo', 39, 4, '1000000.00', 'Asuransi Swasta'),
('PSN-006', 'Rina Wijaya', 52, 2, '1200000.00', 'Asuransi Swasta'),
('PSN-007', 'Hendra Wijaya', 41, 6, '800000.00', 'Asuransi Swasta'),
('PSN-008', 'Slamet Riyadi', 65, 3, '400000.00', 'Umum'),
('PSN-009', 'Anisa Putri', 19, 5, '400000.00', 'Umum'),
('PSN-010', 'Bambang Utomo', 55, 2, '600000.00', 'Umum');

-- --------------------------------------------------------

--
-- Table structure for table `pasien_asuransi_swasta`
--

CREATE TABLE `pasien_asuransi_swasta` (
  `id_pasien` varchar(10) NOT NULL,
  `nama_provider` varchar(100) NOT NULL,
  `nomor_polis` varchar(50) NOT NULL,
  `limit_cover` decimal(12,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `pasien_asuransi_swasta`
--

INSERT INTO `pasien_asuransi_swasta` (`id_pasien`, `nama_provider`, `nomor_polis`, `limit_cover`) VALUES
('PSN-005', 'Prudential', 'PRU-99211', '3000000.00'),
('PSN-006', 'Allianz', 'ALZ-55432', '5000000.00'),
('PSN-007', 'Mandiri Inhealth', 'IH-8821', '4000000.00');

-- --------------------------------------------------------

--
-- Table structure for table `pasien_bpjs`
--

CREATE TABLE `pasien_bpjs` (
  `id_pasien` varchar(10) NOT NULL,
  `nomor_pbi` varchar(30) NOT NULL,
  `faskes_asal` varchar(100) NOT NULL,
  `kelas_kamar` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `pasien_bpjs`
--

INSERT INTO `pasien_bpjs` (`id_pasien`, `nomor_pbi`, `faskes_asal`, `kelas_kamar`) VALUES
('PSN-001', '000123456789', 'Puskesmas Cilacap Utara', 'Kelas 2'),
('PSN-002', '000987654321', 'Klinik Sehat PNC', 'Kelas 1'),
('PSN-003', '000456123789', 'Puskesmas Kesugihan', 'Kelas 3'),
('PSN-004', '000789321456', 'Klinik Medika Cilacap', 'Kelas 2');

-- --------------------------------------------------------

--
-- Table structure for table `pasien_umum`
--

CREATE TABLE `pasien_umum` (
  `id_pasien` varchar(10) NOT NULL,
  `nik` varchar(20) NOT NULL,
  `metode_pembayaran` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `pasien_umum`
--

INSERT INTO `pasien_umum` (`id_pasien`, `nik`, `metode_pembayaran`) VALUES
('PSN-008', '3301011212700001', 'Tunai'),
('PSN-009', '3301022405050002', 'Transfer QRIS'),
('PSN-010', '3301031508710003', 'Kartu Kredit');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `pasien`
--
ALTER TABLE `pasien`
  ADD PRIMARY KEY (`id_pasien`);

--
-- Indexes for table `pasien_asuransi_swasta`
--
ALTER TABLE `pasien_asuransi_swasta`
  ADD PRIMARY KEY (`id_pasien`);

--
-- Indexes for table `pasien_bpjs`
--
ALTER TABLE `pasien_bpjs`
  ADD PRIMARY KEY (`id_pasien`);

--
-- Indexes for table `pasien_umum`
--
ALTER TABLE `pasien_umum`
  ADD PRIMARY KEY (`id_pasien`);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `pasien_asuransi_swasta`
--
ALTER TABLE `pasien_asuransi_swasta`
  ADD CONSTRAINT `pasien_asuransi_swasta_ibfk_1` FOREIGN KEY (`id_pasien`) REFERENCES `pasien` (`id_pasien`) ON DELETE CASCADE;

--
-- Constraints for table `pasien_bpjs`
--
ALTER TABLE `pasien_bpjs`
  ADD CONSTRAINT `pasien_bpjs_ibfk_1` FOREIGN KEY (`id_pasien`) REFERENCES `pasien` (`id_pasien`) ON DELETE CASCADE;

--
-- Constraints for table `pasien_umum`
--
ALTER TABLE `pasien_umum`
  ADD CONSTRAINT `pasien_umum_ibfk_1` FOREIGN KEY (`id_pasien`) REFERENCES `pasien` (`id_pasien`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
