-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 02, 2025 at 08:41 PM
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
-- Database: `ahj_ende_pinedah`
--

-- --------------------------------------------------------

--
-- Table structure for table `cita`
--

CREATE TABLE `cita` (
  `id_cit` int(11) NOT NULL,
  `nom_cit` varchar(100) NOT NULL,
  `id_eje2` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cita`
--

INSERT INTO `cita` (`id_cit`, `nom_cit`, `id_eje2`) VALUES
(1, 'Ana García Silva', 1),
(2, 'Carlos Rodríguez', 2),
(3, 'Laura Martínez', 1),
(4, 'Pedro Sánchez', 3);

-- --------------------------------------------------------

--
-- Table structure for table `ejecutivo`
--

CREATE TABLE `ejecutivo` (
  `id_eje` int(10) UNSIGNED NOT NULL,
  `nom_eje` varchar(100) NOT NULL,
  `tel_eje` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `ejecutivo`
--

INSERT INTO `ejecutivo` (`id_eje`, `nom_eje`, `tel_eje`) VALUES
(1, 'Juan Carlos Pérez', '555-0123'),
(2, 'María Fernanda López', '555-0456'),
(3, 'Roberto González', '555-0789'),
(4, 'Francisco Pineda', '555-0789');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cita`
--
ALTER TABLE `cita`
  ADD PRIMARY KEY (`id_cit`),
  ADD KEY `id_eje2` (`id_eje2`);

--
-- Indexes for table `ejecutivo`
--
ALTER TABLE `ejecutivo`
  ADD PRIMARY KEY (`id_eje`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cita`
--
ALTER TABLE `cita`
  MODIFY `id_cit` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `ejecutivo`
--
ALTER TABLE `ejecutivo`
  MODIFY `id_eje` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `cita`
--
ALTER TABLE `cita`
  ADD CONSTRAINT `cita_ibfk_1` FOREIGN KEY (`id_eje2`) REFERENCES `ejecutivo` (`id_eje`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
