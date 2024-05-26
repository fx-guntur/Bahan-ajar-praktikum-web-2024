-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               8.0.30 - MySQL Community Server - GPL
-- Server OS:                    Win64
-- HeidiSQL Version:             12.1.0.6537
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Dumping database structure for manajemen_keuangan
CREATE DATABASE IF NOT EXISTS `manajemen_keuangan` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `manajemen_keuangan`;

-- Dumping structure for table manajemen_keuangan.tabel_keuangan
CREATE TABLE IF NOT EXISTS `tabel_keuangan` (
  `id` int(1) unsigned zerofill NOT NULL AUTO_INCREMENT,
  `kategori` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL DEFAULT '',
  `keterangan` varchar(255) NOT NULL DEFAULT '',
  `pemasukan` int NOT NULL DEFAULT '0',
  `pengeluaran` int NOT NULL DEFAULT '0',
  `id_akun` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_tabel_keuangan_user` (`id_akun`),
  CONSTRAINT `FK_tabel_keuangan_user` FOREIGN KEY (`id_akun`) REFERENCES `user` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table manajemen_keuangan.tabel_keuangan: ~2 rows (approximately)
DELETE FROM `tabel_keuangan`;
INSERT INTO `tabel_keuangan` (`id`, `kategori`, `keterangan`, `pemasukan`, `pengeluaran`, `id_akun`) VALUES
	(2, 'Bisnis Kopi', 'penjualan hari pertama', 200000, 150000, 1),
	(3, 'Bisnis Shopee', 'penjualan hari kedua', 50000, 50000, 1);

-- Dumping structure for table manajemen_keuangan.user
CREATE TABLE IF NOT EXISTS `user` (
  `id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `email` varchar(60) NOT NULL,
  `password` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table manajemen_keuangan.user: ~5 rows (approximately)
DELETE FROM `user`;
INSERT INTO `user` (`id`, `username`, `email`, `password`) VALUES
	(1, 'admin', 'admin@gmail.com', 'admin'),
	(2, 'bobi', 'bobi@gmail.com', '$2y$10$Z82pxUs9HpEfkOsl0lbq4e3VeAP591JjLHJ..uI2U6NCU66EmEO7C'),
	(3, 'ahmad', 'ahmad@gmail.com', '$2y$10$UFtwJuieJsBZPGuRBUzpqOs.tBdF7.vut.CoKcGxUECjKHj0TLbBq'),
	(4, 'edi', 'edi@gmail.com', '$2y$10$jE5jHWgbWNEgck5Lv40zT.r8guLKlYVBtJUHs/VNFQ1CffQCawPv.'),
	(5, 'jarjit', 'jarjit@gmail.com', '$2y$10$xns/1HRN8lzvs9Ztq8Zmre5OAGKHmuOPli46rqwjfeCThzLEQKHIG');

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
