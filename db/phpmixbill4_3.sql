-- phpMyAdmin SQL Dump
-- version 4.5.4.1
-- http://www.phpmyadmin.net
--
-- Servidor: localhost
-- Tiempo de generación: 05-07-2016 a las 10:49:05
-- Versión del servidor: 5.7.10-log
-- Versión de PHP: 5.6.18

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `phpmixbill4.3`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_admin`
--

CREATE TABLE `tbl_admin` (
  `id_admin` int(5) NOT NULL,
  `username` varchar(30) NOT NULL,
  `password` varchar(40) NOT NULL,
  `nama_admin` varchar(40) NOT NULL,
  `level` varchar(10) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `tbl_admin`
--

INSERT INTO `tbl_admin` (`id_admin`, `username`, `password`, `nama_admin`, `level`) VALUES
(1, 'admin', '21232f297a57a5a743894a0e4a801fc3', 'Database Hoyos', 'Admin');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_billing`
--

CREATE TABLE `tbl_billing` (
  `id_billing` int(5) NOT NULL,
  `jenis` varchar(10) NOT NULL,
  `jenispaket` varchar(10) NOT NULL,
  `id_user` int(5) NOT NULL,
  `id_paket` int(5) NOT NULL,
  `daftar` date NOT NULL,
  `expire` date NOT NULL,
  `jam` time NOT NULL,
  `status` varchar(10) NOT NULL,
  `id_admin` int(5) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `tbl_billing`
--

INSERT INTO `tbl_billing` (`id_billing`, `jenis`, `jenispaket`, `id_user`, `id_paket`, `daftar`, `expire`, `jam`, `status`, `id_admin`) VALUES
(1, 'Hotspot', 'Unlimited', 1, 1, '2016-07-02', '2016-07-17', '09:33:34', 'on', 4);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_laporan`
--

CREATE TABLE `tbl_laporan` (
  `id_laporan` int(7) NOT NULL,
  `username` varchar(30) NOT NULL,
  `paket` varchar(30) NOT NULL,
  `harga` varchar(12) NOT NULL,
  `daftar` date NOT NULL,
  `expire` date NOT NULL,
  `jam` time NOT NULL,
  `jenis` varchar(10) NOT NULL,
  `kasir` varchar(30) DEFAULT NULL,
  `code` varchar(50) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `tbl_laporan`
--

INSERT INTO `tbl_laporan` (`id_laporan`, `username`, `paket`, `harga`, `daftar`, `expire`, `jam`, `jenis`, `kasir`, `code`) VALUES
(1, 'whoar', 'prueba1m', '1500', '2016-07-02', '2016-07-17', '09:33:34', 'Hotspot', 'Database Hoyos', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_modul`
--

CREATE TABLE `tbl_modul` (
  `id_modul` int(5) NOT NULL,
  `nama_modul` varchar(50) COLLATE latin1_general_ci NOT NULL,
  `filename` varchar(100) COLLATE latin1_general_ci NOT NULL,
  `status` enum('user','admin') COLLATE latin1_general_ci NOT NULL,
  `aktif` enum('Y','N') COLLATE latin1_general_ci NOT NULL DEFAULT 'Y',
  `urutan` int(5) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

--
-- Volcado de datos para la tabla `tbl_modul`
--

INSERT INTO `tbl_modul` (`id_modul`, `nama_modul`, `filename`, `status`, `aktif`, `urutan`) VALUES
(1, 'Database', 'Database', 'admin', 'Y', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_paket`
--

CREATE TABLE `tbl_paket` (
  `id_paket` int(5) NOT NULL,
  `jenis` varchar(15) NOT NULL,
  `nama_paket` varchar(40) NOT NULL,
  `harga` varchar(10) NOT NULL,
  `rate` varchar(10) NOT NULL,
  `masa_aktiv` varchar(5) NOT NULL,
  `limit` varchar(15) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `tbl_paket`
--

INSERT INTO `tbl_paket` (`id_paket`, `jenis`, `nama_paket`, `harga`, `rate`, `masa_aktiv`, `limit`) VALUES
(1, 'Unlimited', 'prueba1m', '1500', '384k/384k', '15', '3');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_user`
--

CREATE TABLE `tbl_user` (
  `id_user` int(5) NOT NULL,
  `nama_user` varchar(30) NOT NULL,
  `username` varchar(30) NOT NULL,
  `password` varchar(40) NOT NULL,
  `telp` varchar(15) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `tbl_user`
--

INSERT INTO `tbl_user` (`id_user`, `nama_user`, `username`, `password`, `telp`) VALUES
(1, 'Database Hoyos Argote', 'whoar', 'whoar', '3103933042');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `tbl_admin`
--
ALTER TABLE `tbl_admin`
  ADD PRIMARY KEY (`id_admin`);

--
-- Indices de la tabla `tbl_billing`
--
ALTER TABLE `tbl_billing`
  ADD PRIMARY KEY (`id_billing`),
  ADD KEY `id_user` (`id_user`),
  ADD KEY `id_paket` (`id_paket`),
  ADD KEY `id_admin` (`id_admin`);

--
-- Indices de la tabla `tbl_laporan`
--
ALTER TABLE `tbl_laporan`
  ADD PRIMARY KEY (`id_laporan`);

--
-- Indices de la tabla `tbl_modul`
--
ALTER TABLE `tbl_modul`
  ADD PRIMARY KEY (`id_modul`);

--
-- Indices de la tabla `tbl_paket`
--
ALTER TABLE `tbl_paket`
  ADD PRIMARY KEY (`id_paket`);

--
-- Indices de la tabla `tbl_user`
--
ALTER TABLE `tbl_user`
  ADD PRIMARY KEY (`id_user`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `tbl_admin`
--
ALTER TABLE `tbl_admin`
  MODIFY `id_admin` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT de la tabla `tbl_billing`
--
ALTER TABLE `tbl_billing`
  MODIFY `id_billing` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT de la tabla `tbl_laporan`
--
ALTER TABLE `tbl_laporan`
  MODIFY `id_laporan` int(7) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT de la tabla `tbl_modul`
--
ALTER TABLE `tbl_modul`
  MODIFY `id_modul` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT de la tabla `tbl_paket`
--
ALTER TABLE `tbl_paket`
  MODIFY `id_paket` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT de la tabla `tbl_user`
--
ALTER TABLE `tbl_user`
  MODIFY `id_user` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
