DROP TABLE IF EXISTS tbl_admin;

CREATE TABLE `tbl_admin` (
  `id_admin` int(5) NOT NULL AUTO_INCREMENT,
  `username` varchar(30) NOT NULL,
  `password` varchar(40) NOT NULL,
  `nama_admin` varchar(40) DEFAULT NULL,
  `level` varchar(10) NOT NULL,
  PRIMARY KEY (`id_admin`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

INSERT INTO tbl_admin VALUES("4","admin","21232f297a57a5a743894a0e4a801fc3","Ismail M","Operator");
INSERT INTO tbl_admin VALUES("5","josh","21232f297a57a5a743894a0e4a801fc3","Josh","Admin");



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
) ENGINE=MyISAM AUTO_INCREMENT=13 DEFAULT CHARSET=latin1;

INSERT INTO tbl_billing VALUES("12","Voucher","Unlimited","1","1","2014-12-16","2015-01-15","12:24:48","Aktiv","");



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
) ENGINE=MyISAM AUTO_INCREMENT=12 DEFAULT CHARSET=latin1;

INSERT INTO tbl_laporan VALUES("1","demouser","demopaket","100000","2014-11-22","2014-12-22","10:38:58","Hotspot","Ismail M","");
INSERT INTO tbl_laporan VALUES("2","demouser","50Jam","25000","2014-11-22","2014-12-07","10:40:25","Hotspot","Ismail M","");
INSERT INTO tbl_laporan VALUES("3","demouser","50Jam","25000","2014-11-22","2014-12-07","10:41:46","Hotspot","Ismail M","");
INSERT INTO tbl_laporan VALUES("4","demouser","","","2014-12-16","2014-12-16","11:34:25","Voucher","","");
INSERT INTO tbl_laporan VALUES("5","demouser","","","2014-12-16","2014-12-16","11:38:59","Voucher","","");
INSERT INTO tbl_laporan VALUES("6","demouser","","","2014-12-16","2014-12-16","11:40:55","Voucher","","");
INSERT INTO tbl_laporan VALUES("7","demouser","50Jam","25000","2014-12-16","2014-12-31","11:44:04","Hotspot","Ismail M","");
INSERT INTO tbl_laporan VALUES("8","demouser","","","2014-12-16","2014-12-16","11:50:20","Voucher","","");
INSERT INTO tbl_laporan VALUES("9","demouser","","","2014-12-16","2014-12-16","12:06:53","Voucher","","");
INSERT INTO tbl_laporan VALUES("10","demouser","demopaket","100000","2014-12-16","2015-01-15","12:10:31","Voucher","","");
INSERT INTO tbl_laporan VALUES("11","demouser","demopaket","100000","2014-12-16","2015-01-15","12:24:48","Voucher","","E1CBD981ADE0");



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
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

INSERT INTO tbl_paket VALUES("1","Unlimited","demopaket","100000","512k/512k","30","Unlimited");
INSERT INTO tbl_paket VALUES("2","TimeBase","50Jam","25000","384k/384k","15","50");



DROP TABLE IF EXISTS tbl_pm;

CREATE TABLE `tbl_pm` (
  `id_pm` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `subj` varchar(255) NOT NULL,
  `text` text NOT NULL,
  `from_user` varchar(40) NOT NULL,
  `date` date NOT NULL,
  `time` time NOT NULL,
  `pm_read` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id_pm`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;




DROP TABLE IF EXISTS tbl_user;

CREATE TABLE `tbl_user` (
  `id_user` int(5) NOT NULL AUTO_INCREMENT,
  `nama_user` varchar(30) NOT NULL,
  `username` varchar(30) NOT NULL,
  `password` varchar(40) NOT NULL,
  `telp` varchar(15) NOT NULL,
  PRIMARY KEY (`id_user`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

INSERT INTO tbl_user VALUES("1","admin","demouser","123","081322225141");



DROP TABLE IF EXISTS tbl_voucher;

CREATE TABLE `tbl_voucher` (
  `id_voucher` int(7) NOT NULL AUTO_INCREMENT,
  `id_paket` int(7) NOT NULL,
  `kode_voucher` varchar(20) NOT NULL,
  `id_user` int(7) DEFAULT NULL,
  `status` varchar(10) NOT NULL DEFAULT 'true',
  PRIMARY KEY (`id_voucher`),
  KEY `id_paket` (`id_paket`),
  KEY `id_user` (`id_user`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

INSERT INTO tbl_voucher VALUES("2","1","7EF5B665DBA7","1","NonAktiv");
INSERT INTO tbl_voucher VALUES("3","2","93595B4B2B01","1","NonAktiv");
INSERT INTO tbl_voucher VALUES("4","2","34F43D278826","1","NonAktiv");
INSERT INTO tbl_voucher VALUES("5","1","E1CBD981ADE0","1","NonAktiv");
INSERT INTO tbl_voucher VALUES("6","1","B9F9500F1535","","Aktiv");



