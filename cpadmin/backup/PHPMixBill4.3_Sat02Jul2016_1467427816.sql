DROP TABLE IF EXISTS tbl_admin;

CREATE TABLE `tbl_admin` (
  `id_admin` int(5) NOT NULL AUTO_INCREMENT,
  `username` varchar(30) NOT NULL,
  `password` varchar(40) NOT NULL,
  `nama_admin` varchar(40) NOT NULL,
  `level` varchar(10) NOT NULL,
  PRIMARY KEY (`id_admin`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

INSERT INTO tbl_admin VALUES("1","admin","21232f297a57a5a743894a0e4a801fc3","Willian Hoyos","Admin");



DROP TABLE IF EXISTS tbl_billing;

CREATE TABLE `tbl_billing` (
  `id_billing` int(5) NOT NULL AUTO_INCREMENT,
  `jenis` varchar(10) NOT NULL,
  `jenispaket` varchar(10) NOT NULL,
  `id_user` int(5) NOT NULL,
  `id_paket` int(5) NOT NULL,
  `daftar` date NOT NULL,
  `expire` date NOT NULL,
  `jam` time NOT NULL,
  `status` varchar(10) NOT NULL,
  `id_admin` int(5) DEFAULT NULL,
  PRIMARY KEY (`id_billing`),
  KEY `id_user` (`id_user`),
  KEY `id_paket` (`id_paket`),
  KEY `id_admin` (`id_admin`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

INSERT INTO tbl_billing VALUES("1","Hotspot","Unlimited","1","1","2016-07-02","2016-07-17","09:33:34","on","4");



DROP TABLE IF EXISTS tbl_laporan;

CREATE TABLE `tbl_laporan` (
  `id_laporan` int(7) NOT NULL AUTO_INCREMENT,
  `username` varchar(30) NOT NULL,
  `paket` varchar(30) NOT NULL,
  `harga` varchar(12) NOT NULL,
  `daftar` date NOT NULL,
  `expire` date NOT NULL,
  `jam` time NOT NULL,
  `jenis` varchar(10) NOT NULL,
  `kasir` varchar(30) DEFAULT NULL,
  `code` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id_laporan`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

INSERT INTO tbl_laporan VALUES("1","whoar","prueba1m","1500","2016-07-02","2016-07-17","09:33:34","Hotspot","Willian Hoyos","");



DROP TABLE IF EXISTS tbl_modul;

CREATE TABLE `tbl_modul` (
  `id_modul` int(5) NOT NULL AUTO_INCREMENT,
  `nama_modul` varchar(50) COLLATE latin1_general_ci NOT NULL,
  `filename` varchar(100) COLLATE latin1_general_ci NOT NULL,
  `status` enum('user','admin') COLLATE latin1_general_ci NOT NULL,
  `aktif` enum('Y','N') COLLATE latin1_general_ci NOT NULL DEFAULT 'Y',
  `urutan` int(5) NOT NULL,
  PRIMARY KEY (`id_modul`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

INSERT INTO tbl_modul VALUES("1","Database","database","admin","Y","1");



DROP TABLE IF EXISTS tbl_paket;

CREATE TABLE `tbl_paket` (
  `id_paket` int(5) NOT NULL AUTO_INCREMENT,
  `jenis` varchar(15) NOT NULL,
  `nama_paket` varchar(40) NOT NULL,
  `harga` varchar(10) NOT NULL,
  `rate` varchar(10) NOT NULL,
  `masa_aktiv` varchar(5) NOT NULL,
  `limit` varchar(15) NOT NULL,
  PRIMARY KEY (`id_paket`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

INSERT INTO tbl_paket VALUES("1","Unlimited","prueba1m","1500","384k/384k","15","3");



DROP TABLE IF EXISTS tbl_user;

CREATE TABLE `tbl_user` (
  `id_user` int(5) NOT NULL AUTO_INCREMENT,
  `nama_user` varchar(30) NOT NULL,
  `username` varchar(30) NOT NULL,
  `password` varchar(40) NOT NULL,
  `telp` varchar(15) NOT NULL,
  PRIMARY KEY (`id_user`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

INSERT INTO tbl_user VALUES("1","Willian Hoyos Argote","whoar","whoar","3103933042");



