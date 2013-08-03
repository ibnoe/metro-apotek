-- phpMyAdmin SQL Dump
-- version 3.5.2.2
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Aug 03, 2013 at 05:52 AM
-- Server version: 5.5.27
-- PHP Version: 5.4.7

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Database: `apotek_integrated`
--

-- --------------------------------------------------------

--
-- Table structure for table `akun`
--

CREATE TABLE IF NOT EXISTS `akun` (
  `kode` varchar(5) NOT NULL,
  `keterangan` varchar(100) NOT NULL,
  `kelompok` enum('CC','HPP','Kas/Bank','Kewajiban','Modal','Pendapatan Lain-lain','Pendapatan Penjualan','Prive') NOT NULL,
  PRIMARY KEY (`kode`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `akun`
--

INSERT INTO `akun` (`kode`, `keterangan`, `kelompok`) VALUES
('1.1', '-', 'Pendapatan Penjualan');

-- --------------------------------------------------------

--
-- Table structure for table `asuransi`
--

CREATE TABLE IF NOT EXISTS `asuransi` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nama` varchar(30) NOT NULL,
  `diskon` double NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `asuransi`
--

INSERT INTO `asuransi` (`id`, `nama`, `diskon`) VALUES
(1, 'ASKES GOLD', 100),
(2, 'JAMKESMAS', 50),
(3, 'AXA PRUDENT', 50),
(4, 'PRU-LIFE', 50);

-- --------------------------------------------------------

--
-- Table structure for table `bank`
--

CREATE TABLE IF NOT EXISTS `bank` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nama` varchar(50) NOT NULL,
  `charge` double NOT NULL,
  `kode_akun` varchar(5) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id_akun` (`kode_akun`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `barang`
--

CREATE TABLE IF NOT EXISTS `barang` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nama` varchar(100) NOT NULL,
  `id_pabrik` int(11) DEFAULT NULL,
  `rak` varchar(30) NOT NULL,
  `kekuatan` double NOT NULL,
  `id_golongan` int(11) DEFAULT NULL,
  `satuan_kekuatan` int(3) DEFAULT NULL,
  `id_sediaan` int(11) DEFAULT NULL,
  `adm_r` enum('Oral','Rektal','Infus','Topikal','Sublingual','Transdermal','Intrakutan','Subkutan','Intravena','Intramuskuler','Vagina','Injeksi','Intranasal','Intraokuler','Intraaurikuler','Intrapulmonal','Implantasi','Subkutan','Intralumbal','Intrarteri') NOT NULL,
  `generik` tinyint(1) NOT NULL,
  `indikasi` text NOT NULL,
  `dosis` text NOT NULL,
  `kandungan` text NOT NULL,
  `perhatian` text NOT NULL,
  `kontra_indikasi` text NOT NULL,
  `efek_samping` text NOT NULL,
  `formularium` enum('Ya','Tidak') NOT NULL,
  `perundangan` enum('Bebas','Bebas Terbatas','OWA','Keras','Psikotropika','Narkotika') NOT NULL,
  `stok_minimal` double NOT NULL,
  `margin_non_resep` double NOT NULL,
  `margin_resep` double NOT NULL,
  `plus_ppn` double NOT NULL,
  `hna` double NOT NULL,
  `aktif` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id_pabrik` (`id_pabrik`),
  KEY `satuan_kekuatan` (`satuan_kekuatan`),
  KEY `id_golongan` (`id_golongan`),
  KEY `id_sediaan` (`id_sediaan`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=21 ;

--
-- Dumping data for table `barang`
--

INSERT INTO `barang` (`id`, `nama`, `id_pabrik`, `rak`, `kekuatan`, `id_golongan`, `satuan_kekuatan`, `id_sediaan`, `adm_r`, `generik`, `indikasi`, `dosis`, `kandungan`, `perhatian`, `kontra_indikasi`, `efek_samping`, `formularium`, `perundangan`, `stok_minimal`, `margin_non_resep`, `margin_resep`, `plus_ppn`, `hna`, `aktif`) VALUES
(1, 'Amoxicilin', NULL, 'B.12', 500, 1, 3, 7, 'Oral', 1, '', '', '', '', '', '', 'Ya', 'Bebas', 0, 0, 0, 0, 1250, 0),
(2, 'Paracetamol', 2, 'B.12', 500, 1, 3, 7, 'Oral', 1, '', '', '', '', '', '', 'Ya', 'Bebas', 0, 0, 0, 0, 0, 0),
(3, 'Panadol Extra', NULL, 'B.12', 500, 1, 3, 7, 'Oral', 1, '', '', '', '', '', '', 'Ya', 'Bebas', 0, 0, 0, 0, 0, 0),
(4, 'Sanmol Tablet', 2, 'B.12', 500, 1, 3, 7, 'Oral', 1, '', '', '', '', '', '', 'Ya', 'Bebas', 0, 0, 0, 0, 0, 0),
(5, 'Konidin', NULL, 'B.12', 500, 1, 3, 7, 'Oral', 1, '', '', '', '', '', '', 'Ya', 'Bebas', 0, 0, 0, 0, 0, 0),
(6, 'Konimak', 2, 'B.12', 500, 1, 3, 7, 'Oral', 1, '', '', '', '', '', '', 'Ya', 'Bebas', 0, 0, 0, 0, 0, 0),
(7, 'Insana', NULL, 'B.12', 500, 1, 3, 7, 'Oral', 1, '', '', '', '', '', '', 'Ya', 'Bebas', 0, 0, 0, 0, 0, 0),
(8, 'Oskadon', 2, 'B.12', 500, 1, 3, 7, 'Oral', 1, '', '', '', '', '', '', 'Ya', 'Bebas', 0, 0, 0, 0, 0, 0),
(9, 'Hufagrip', NULL, 'B.12', 500, 1, 3, 7, 'Oral', 1, '', '', '', '', '', '', 'Ya', 'Bebas', 0, 0, 0, 0, 0, 0),
(10, 'Siladek MX', 2, 'B.12', 500, 1, 3, 7, 'Oral', 1, '', '', '', '', '', '', 'Ya', 'Bebas', 0, 0, 0, 0, 0, 0),
(14, 'ASKES GOLD', NULL, '', 500, 1, 3, 2, 'Oral', 1, '', '', '', '', '', '', 'Ya', 'Bebas', 0, 0, 0, 0, 0, 0),
(15, 'ASKES GOLD', NULL, '', 500, 1, 3, 2, 'Oral', 1, '', '', '', '', '', '', 'Ya', 'Bebas', 0, 0, 0, 0, 0, 0),
(16, 'METALLICA', NULL, '', 500, 1, 41, 2, 'Oral', 1, '', '', '', '', '', '', 'Ya', 'Bebas', 0, 0, 0, 0, 0, 0),
(17, 'MAGASIDA', 5, 'R.10', 500, 1, 3, 2, 'Oral', 1, 'Indikasi', '-', '-', '--', '-', '-', 'Ya', 'Bebas', 0, 0, 0, 0, 2500, 10),
(18, 'HUFAGRIP MERAH', NULL, '', 100, 1, 3, 7, 'Oral', 1, '', '', '', '', '', '', 'Ya', 'Bebas', 0, 0, 0, 0, 0, 0),
(19, 'AMOXICILIN', NULL, 'B.12', 100, 1, 3, 7, 'Oral', 1, '', '', '', '', '', '', 'Ya', 'Bebas', 0, 0, 0, 0, 0, 0),
(20, 'HEMAVITON JRENG', NULL, '', 100, 1, 41, 22, '', 0, '', '', '', '', '', '', 'Tidak', 'Bebas', 0, 0, 0, 0, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `config_autonumber`
--

CREATE TABLE IF NOT EXISTS `config_autonumber` (
  `pemesanan` varchar(10) NOT NULL,
  `penerimaan` varchar(10) NOT NULL,
  `penjualan` varchar(10) NOT NULL,
  `retur_penerimaan` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `detail_pemesanan`
--

CREATE TABLE IF NOT EXISTS `detail_pemesanan` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_pemesanan` int(6) unsigned zerofill NOT NULL,
  `id_kemasan` int(11) NOT NULL,
  `jumlah` double NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id_pemesanan` (`id_pemesanan`),
  KEY `id_barang` (`id_kemasan`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `detail_penerimaan`
--

CREATE TABLE IF NOT EXISTS `detail_penerimaan` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_penerimaan` int(11) NOT NULL,
  `id_kemasan` int(11) NOT NULL,
  `nobatch` varchar(15) NOT NULL,
  `expired` date NOT NULL,
  `harga` double NOT NULL,
  `jumlah` double NOT NULL,
  `is_bonus` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id_pembelian` (`id_penerimaan`),
  KEY `id_barang` (`id_kemasan`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `detail_penjualan`
--

CREATE TABLE IF NOT EXISTS `detail_penjualan` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_penjualan` int(11) NOT NULL,
  `id_kemasan` int(11) NOT NULL,
  `expired` date NOT NULL,
  `qty` double NOT NULL,
  `harga_jual` double NOT NULL,
  `is_bonus` tinyint(1) NOT NULL COMMENT '0 = bukan barang bonus, 1 = barang bonus',
  PRIMARY KEY (`id`),
  KEY `id_penjualan` (`id_penjualan`),
  KEY `id_barang` (`id_kemasan`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `detail_retur_penerimaan`
--

CREATE TABLE IF NOT EXISTS `detail_retur_penerimaan` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_retur_penerimaan` int(11) NOT NULL,
  `id_penerimaan` int(11) NOT NULL,
  `id_kemasan` int(11) NOT NULL,
  `expired` date NOT NULL,
  `jumlah` double NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id_retur_penerimaan` (`id_retur_penerimaan`),
  KEY `id_penerimaan` (`id_penerimaan`),
  KEY `id_barang` (`id_kemasan`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `detail_retur_penjualan`
--

CREATE TABLE IF NOT EXISTS `detail_retur_penjualan` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_penjualan` int(11) NOT NULL,
  `id_kemasan` int(11) NOT NULL,
  `expired` date NOT NULL,
  `qty` double NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id_penjualan` (`id_penjualan`),
  KEY `id_barang` (`id_kemasan`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `dinamic_harga_jual`
--

CREATE TABLE IF NOT EXISTS `dinamic_harga_jual` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_kemasan` int(11) NOT NULL,
  `jual_min` double NOT NULL,
  `jual_max` double NOT NULL,
  `margin_non_resep` double NOT NULL,
  `margin_resep` double NOT NULL,
  `diskon_persen` double NOT NULL,
  `hj_non_resep` double NOT NULL,
  `hj_resep` double NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id_barang` (`id_kemasan`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `dokter`
--

CREATE TABLE IF NOT EXISTS `dokter` (
  `id` int(6) unsigned zerofill NOT NULL AUTO_INCREMENT,
  `nama` varchar(50) NOT NULL,
  `kelamin` enum('L','P') NOT NULL,
  `alamat` text NOT NULL,
  `telp` varchar(15) NOT NULL,
  `email` varchar(50) NOT NULL,
  `no_str` varchar(30) NOT NULL,
  `spesialis` varchar(50) NOT NULL,
  `tgl_mulai_praktek` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `dokter`
--

INSERT INTO `dokter` (`id`, `nama`, `kelamin`, `alamat`, `telp`, `email`, `no_str`, `spesialis`, `tgl_mulai_praktek`) VALUES
(000001, 'DR. ACHIRUDIN TIMORA', 'P', 'JL. MAGELANG KM 2', '-', '-', '01991001000', 'UMUM', '2013-07-27'),
(000002, 'DR. BAMBANG GENTHOLET', 'L', 'JL. BRIGJEN KATAMSO', '0286-29188980', '-', '-', 'ANAK', '2011-07-01'),
(000003, 'DR. MARIA FAHDA', 'P', 'JL. S. PARMAN', '0286-5900190', '-', 'NO.12134', 'UMUM', '2013-07-27');

-- --------------------------------------------------------

--
-- Table structure for table `farmako_terapi`
--

CREATE TABLE IF NOT EXISTS `farmako_terapi` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nama` varchar(30) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `farmako_terapi`
--

INSERT INTO `farmako_terapi` (`id`, `nama`) VALUES
(1, 'Alergi & Sistem Imun'),
(2, 'Antiinfeksi (Sistemik)'),
(3, 'Produk ASKES'),
(4, 'Sistem Kardiovaskular & Hemato');

-- --------------------------------------------------------

--
-- Table structure for table `free_on_sale`
--

CREATE TABLE IF NOT EXISTS `free_on_sale` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `id_barang` int(11) NOT NULL,
  `id_barang_gratis` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id_barang` (`id_barang`),
  KEY `id_barang_gratis` (`id_barang_gratis`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `golongan`
--

CREATE TABLE IF NOT EXISTS `golongan` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nama` varchar(30) NOT NULL,
  `margin_non_resep` double NOT NULL,
  `margin_resep` double NOT NULL,
  `diskon` double NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `golongan`
--

INSERT INTO `golongan` (`id`, `nama`, `margin_non_resep`, `margin_resep`, `diskon`) VALUES
(1, 'HV', 20, 25, 0),
(2, 'Obat Resep', 20, 25, 0);

-- --------------------------------------------------------

--
-- Table structure for table `grant_privileges`
--

CREATE TABLE IF NOT EXISTS `grant_privileges` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `privileges_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `penduduk_id` (`user_id`,`privileges_id`),
  KEY `privileges_id` (`privileges_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=12 ;

--
-- Dumping data for table `grant_privileges`
--

INSERT INTO `grant_privileges` (`id`, `user_id`, `privileges_id`) VALUES
(1, 1, 1),
(2, 1, 2),
(3, 1, 3),
(4, 1, 4),
(5, 1, 5),
(6, 1, 6),
(7, 1, 7),
(8, 1, 8),
(9, 1, 9),
(10, 1, 10),
(11, 1, 11);

-- --------------------------------------------------------

--
-- Table structure for table `inkaso`
--

CREATE TABLE IF NOT EXISTS `inkaso` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `no_ref` varchar(15) NOT NULL,
  `tanggal` date NOT NULL,
  `id_supplier` int(11) NOT NULL,
  `no_kuitansi` varchar(30) NOT NULL,
  `cara_bayar` enum('Uang','Cek','Giro','Transfer') NOT NULL,
  `id_bank` int(11) DEFAULT NULL,
  `no_transaksi` varchar(30) NOT NULL,
  `keterangan` text NOT NULL,
  `tgl_cair` date DEFAULT NULL COMMENT 'Jika pembayaran menggunakan giro',
  `is_lunas` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id_supplier` (`id_supplier`),
  KEY `id_bank` (`id_bank`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `inkaso_detail`
--

CREATE TABLE IF NOT EXISTS `inkaso_detail` (
  `id_inkaso` int(11) NOT NULL,
  `id_penerimaan` int(11) NOT NULL,
  `pembayaran` double NOT NULL,
  `potongan` double NOT NULL,
  KEY `id_inkaso` (`id_inkaso`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `instansi`
--

CREATE TABLE IF NOT EXISTS `instansi` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nama` varchar(100) NOT NULL,
  `alamat` text NOT NULL,
  `email` varchar(30) NOT NULL,
  `telp` varchar(15) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `instansi`
--

INSERT INTO `instansi` (`id`, `nama`, `alamat`, `email`, `telp`) VALUES
(1, 'Badan pemeriksaan obat dan makanan', 'JL.Tompeyan (Pingit). Tegalrejo, Yogyakarta', '-', '0274-5512345');

-- --------------------------------------------------------

--
-- Table structure for table `jadwal_dokter`
--

CREATE TABLE IF NOT EXISTS `jadwal_dokter` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_dokter` int(6) unsigned zerofill NOT NULL,
  `hari` enum('Senin','Selasa','Rabu','Kamis','Jumat','Sabtu','Minggu') NOT NULL,
  `jam` varchar(10) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id_dokter` (`id_dokter`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `karyawan`
--

CREATE TABLE IF NOT EXISTS `karyawan` (
  `id` int(6) unsigned zerofill NOT NULL AUTO_INCREMENT,
  `nama` varchar(50) NOT NULL,
  `kelamin` enum('L','P') NOT NULL,
  `tempat_lahir` varchar(50) NOT NULL,
  `tanggal_lahir` date NOT NULL,
  `alamat` text NOT NULL,
  `kabupaten` varchar(30) NOT NULL,
  `propinsi` varchar(30) NOT NULL,
  `telp` varchar(15) NOT NULL,
  `email` varchar(50) NOT NULL,
  `jabatan` enum('APA','Kasir','Staff') NOT NULL,
  `no_sipa` varchar(30) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `karyawan`
--

INSERT INTO `karyawan` (`id`, `nama`, `kelamin`, `tempat_lahir`, `tanggal_lahir`, `alamat`, `kabupaten`, `propinsi`, `telp`, `email`, `jabatan`, `no_sipa`) VALUES
(000001, 'WULAN SUCI', 'P', 'SLEMAN', '1991-04-20', 'JL. DR WAHDIN', 'SLEMAN', 'YOGYAKARTA', '-', '-', 'APA', 'NNO.1023919910'),
(000002, 'ELNA LIANITAS', 'P', 'PALEMBANG', '1988-06-16', 'JL. SURONATAN NO.22', 'YOGYAKARTA', 'YOGYAKARTA', '085228024202', 'ELNALIANITA@YAHOO.COM', 'Staff', '-');

-- --------------------------------------------------------

--
-- Table structure for table `kelas_terapi`
--

CREATE TABLE IF NOT EXISTS `kelas_terapi` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_farmako_terapi` int(11) NOT NULL,
  `nama` varchar(30) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id_farmako_terapi` (`id_farmako_terapi`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `kelas_terapi`
--

INSERT INTO `kelas_terapi` (`id`, `id_farmako_terapi`, `nama`) VALUES
(1, 1, 'Antihistamin & Antialergi'),
(2, 1, 'Imunosupresan'),
(3, 1, 'Vaksin, Antiserum & Imunologik'),
(4, 2, 'Anestesi Lokal & Umum');

-- --------------------------------------------------------

--
-- Table structure for table `kemasan`
--

CREATE TABLE IF NOT EXISTS `kemasan` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_barang` int(11) NOT NULL,
  `barcode` varchar(30) NOT NULL,
  `id_kemasan` int(11) NOT NULL,
  `isi` double NOT NULL,
  `id_satuan` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `id_barang` (`id_barang`),
  KEY `id_kemasan` (`id_kemasan`),
  KEY `id_satuan` (`id_satuan`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=17 ;

--
-- Dumping data for table `kemasan`
--

INSERT INTO `kemasan` (`id`, `id_barang`, `barcode`, `id_kemasan`, `isi`, `id_satuan`) VALUES
(11, 17, '012930', 29, 1, NULL),
(12, 17, '012309', 1, 10, NULL),
(13, 17, '192398', 2, 4, NULL),
(14, 18, '99001293010109', 29, 10, 1),
(15, 18, '01293012390192', 1, 4, 2),
(16, 18, '-', 2, 1, 2);

-- --------------------------------------------------------

--
-- Table structure for table `module`
--

CREATE TABLE IF NOT EXISTS `module` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nama` varchar(255) NOT NULL,
  `icons` varchar(255) NOT NULL,
  `show_desktop` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `module`
--

INSERT INTO `module` (`id`, `nama`, `icons`, `show_desktop`) VALUES
(1, 'Pelayanan', '', 1),
(2, 'Inventory', '', 1),
(3, 'Referensi Data', '', 1),
(4, 'Laporan', '', 1),
(5, 'Setting', '', 1);

-- --------------------------------------------------------

--
-- Table structure for table `pabrik`
--

CREATE TABLE IF NOT EXISTS `pabrik` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nama` varchar(100) NOT NULL,
  `alamat` text NOT NULL,
  `email` varchar(30) NOT NULL,
  `telp` varchar(15) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

--
-- Dumping data for table `pabrik`
--

INSERT INTO `pabrik` (`id`, `nama`, `alamat`, `email`, `telp`) VALUES
(2, 'Trackindo PT', 'Jl. Kusuma Negara Jakarta Pusat', 'trackindofarma@yahoo.com', '021-555060'),
(5, 'Kimia Farma, PT', 'Jl. Kebayoran Lama No.3', 'kimiafarma@yahoo.com', '-'),
(7, 'Djarum PT', 'Jl. Kudus - Semarang Km. 4', '-', '-'),
(8, 'Metallica', 'Jl. Kaliurang km 3', 'arvin_nizar@yahoo.co.id', '-');

-- --------------------------------------------------------

--
-- Table structure for table `pelanggan`
--

CREATE TABLE IF NOT EXISTS `pelanggan` (
  `id` int(6) unsigned zerofill NOT NULL AUTO_INCREMENT,
  `nama` varchar(50) NOT NULL,
  `jenis` enum('Personal','Perusahaan') NOT NULL,
  `kelamin` enum('L','P') NOT NULL,
  `tempat_lahir` varchar(50) NOT NULL,
  `tanggal_lahir` date NOT NULL,
  `alamat` text NOT NULL,
  `kabupaten` varchar(30) NOT NULL,
  `provinsi` varchar(30) NOT NULL,
  `telp` varchar(15) NOT NULL,
  `email` varchar(50) NOT NULL,
  `diskon` double NOT NULL,
  `catatan` text NOT NULL,
  `id_asuransi` int(11) DEFAULT NULL,
  `nopolish` varchar(20) NOT NULL,
  `foto` text NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id_asuransi` (`id_asuransi`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `pelanggan`
--

INSERT INTO `pelanggan` (`id`, `nama`, `jenis`, `kelamin`, `tempat_lahir`, `tanggal_lahir`, `alamat`, `kabupaten`, `provinsi`, `telp`, `email`, `diskon`, `catatan`, `id_asuransi`, `nopolish`, `foto`) VALUES
(000001, 'FERLI APRIANINGRUM', 'Personal', 'P', 'BANJARNEGARA', '0000-00-00', 'JL. PURWANEGARA', '', '', '-', '-', 0, '-', 1, '01920391000199100', ''),
(000002, 'ARVIN NIZAR', 'Personal', 'L', 'BANJARNEGARA', '1987-04-20', 'JL. MAGELANG', '', '', '085236688999', '-', 0, '-', 2, '01023901910290', ''),
(000003, 'APOTEK SARIDEWI', 'Perusahaan', 'P', 'BANJARNEGARA', '0000-00-00', 'JL. KIJAGAPATI NO.15', '', '', '-', 'FAHDA_VEGASHA@YAHOO.CO.ID', 0, '-', NULL, '', ''),
(000005, 'SHAFIRA WILDA PUSPARANI', 'Personal', 'P', 'BANJARNEGARA', '1999-04-15', 'JL. KIJAGAPATI NO 15', '', '', '085236688123', '-', 5, 'PELANGGAN TETAP', NULL, '', '');

-- --------------------------------------------------------

--
-- Table structure for table `pemesanan`
--

CREATE TABLE IF NOT EXISTS `pemesanan` (
  `id` int(6) unsigned zerofill NOT NULL AUTO_INCREMENT,
  `tanggal` date NOT NULL,
  `id_supplier` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `supplier` (`id_supplier`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `pemesanan`
--

INSERT INTO `pemesanan` (`id`, `tanggal`, `id_supplier`) VALUES
(000004, '2013-07-12', 1),
(000006, '2013-07-12', 2);

-- --------------------------------------------------------

--
-- Table structure for table `penerimaan`
--

CREATE TABLE IF NOT EXISTS `penerimaan` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `faktur` varchar(20) NOT NULL,
  `tanggal` date NOT NULL,
  `id_pemesanan` int(6) unsigned zerofill NOT NULL,
  `ppn` double NOT NULL,
  `materai` double NOT NULL,
  `jatuh_tempo` date DEFAULT NULL,
  `id_users` int(11) DEFAULT NULL,
  `diskon_persen` double NOT NULL,
  `diskon_rupiah` double NOT NULL,
  `total` double NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `faktur` (`faktur`),
  KEY `id_pemesanan` (`id_pemesanan`),
  KEY `id_users` (`id_users`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `penjualan`
--

CREATE TABLE IF NOT EXISTS `penjualan` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `waktu` datetime NOT NULL,
  `id_pelanggan` int(11) DEFAULT NULL,
  `diskon_persen` double NOT NULL,
  `diskon_rupiah` double NOT NULL,
  `ppn` double NOT NULL,
  `total` double NOT NULL,
  `tuslah` double NOT NULL,
  `embalage` double NOT NULL,
  `id_asuransi` int(11) NOT NULL,
  `reimburse` double NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id_customer` (`id_pelanggan`),
  KEY `id_asuransi` (`id_asuransi`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `privileges`
--

CREATE TABLE IF NOT EXISTS `privileges` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `module_id` int(11) DEFAULT NULL,
  `form_nama` varchar(255) NOT NULL,
  `url` varchar(255) NOT NULL,
  `icon` varchar(100) NOT NULL,
  `show_desktop` int(1) NOT NULL,
  `sort` int(2) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `modul_id` (`module_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=12 ;

--
-- Dumping data for table `privileges`
--

INSERT INTO `privileges` (`id`, `module_id`, `form_nama`, `url`, `icon`, `show_desktop`, `sort`) VALUES
(1, 1, 'Penjualan', 'penjualan/', 'cart.png', 1, 1),
(2, 2, 'Pemesanan', 'inventory/pemesanan', 'order.png', 1, 1),
(3, 2, 'Penerimaan', 'inventory/penerimaan', 'buy.png', 1, 2),
(4, 3, 'Barang', 'inventory/barang', 'barang.png', 1, 1),
(5, 3, 'Customer', 'masterdata/customer', 'anggota.png', 1, 4),
(6, 3, 'Supplier', 'masterdata/supplier', '', 1, 2),
(7, 2, 'Retur Penerimaan', 'inventory/retur_penerimaan', '', 1, 2),
(8, 2, 'Stok Opname', 'inventory/stok_opname', '', 1, 4),
(9, 4, 'Stok', 'laporan/stok', '', 1, 1),
(10, 3, 'Pabrik', 'masterdata/pabrik', '', 1, 3),
(11, 5, 'Set Harga', 'setting/harga', '', 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `retur_penerimaan`
--

CREATE TABLE IF NOT EXISTS `retur_penerimaan` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tanggal` date NOT NULL,
  `id_supplier` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id_supplier` (`id_supplier`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `retur_penjualan`
--

CREATE TABLE IF NOT EXISTS `retur_penjualan` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `no_ref` varchar(15) NOT NULL,
  `waktu` date NOT NULL,
  `id_penjualan` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `no_ref` (`no_ref`),
  KEY `id_penjualan` (`id_penjualan`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `satuan`
--

CREATE TABLE IF NOT EXISTS `satuan` (
  `id` int(3) NOT NULL AUTO_INCREMENT,
  `nama` varchar(100) NOT NULL,
  `is_satuan_kemasan` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT AUTO_INCREMENT=42 ;

--
-- Dumping data for table `satuan`
--

INSERT INTO `satuan` (`id`, `nama`, `is_satuan_kemasan`) VALUES
(1, 'Strip', 0),
(2, 'Butir', 0),
(3, 'Mg', 1),
(4, 'Ml', 0),
(5, 'Pcs', 0),
(6, 'Kg', 0),
(7, 'Cm', 0),
(8, 'M', 0),
(9, 'L', 0),
(10, 'Gallon', 0),
(11, 'Lb', 0),
(12, 'Pound', 0),
(13, 'Buah', 0),
(14, 'Lembar', 0),
(15, 'Ikat', 0),
(16, 'Dosin', 0),
(17, 'Botol', 0),
(18, 'Ampul', 0),
(19, 'Tube', 0),
(20, 'Flakon', 0),
(21, 'Plabot', 0),
(22, 'Pot', 0),
(23, 'Biji', 0),
(24, 'Bungkus', 0),
(25, 'Batang', 0),
(26, 'Iris', 0),
(27, 'Kotak', 0),
(28, 'Karton', 0),
(29, 'Box', 0),
(30, 'mcg', 0),
(31, 'Satuan', 0),
(32, 'Mdi', 0),
(33, 'Supp', 0),
(35, 'Fls', 0),
(36, 'Kaleng', 0),
(37, 'Unit', 0),
(38, 'Karung', 0),
(39, 'Sachet', 0),
(40, 'Tablet', 0),
(41, 'mg/5ml', 1);

-- --------------------------------------------------------

--
-- Table structure for table `sediaan`
--

CREATE TABLE IF NOT EXISTS `sediaan` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nama` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=28 ;

--
-- Dumping data for table `sediaan`
--

INSERT INTO `sediaan` (`id`, `nama`) VALUES
(1, 'Drop'),
(2, 'dragee'),
(3, 'Enteric coated tablet'),
(4, 'Film coated caplet'),
(5, 'Film coated tablet'),
(6, 'Film coated talet'),
(7, 'Kaplet'),
(8, 'Kaplet coated'),
(9, 'Kaplet salut selaput'),
(10, 'Kapsul'),
(11, 'Kapsul lunak'),
(12, 'Tablet'),
(13, 'Tablet salut gula'),
(14, 'Tablet salut selaput'),
(15, 'Kapsul'),
(16, 'Suppositoria'),
(17, 'Injeksi'),
(18, 'Tetes mata'),
(19, 'Tetes telinga'),
(20, 'Tetes hidung'),
(21, 'Tetes untuk diminum'),
(22, 'Sirup'),
(23, 'Solutio'),
(24, 'Mixtur'),
(25, 'Puyer tidak terbagi'),
(26, 'Infus'),
(27, 'Emulsi');

-- --------------------------------------------------------

--
-- Table structure for table `stok`
--

CREATE TABLE IF NOT EXISTS `stok` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `waktu` datetime NOT NULL,
  `nobatch` varchar(15) NOT NULL,
  `id_barang` int(11) NOT NULL,
  `ed` date NOT NULL,
  `masuk` double NOT NULL,
  `keluar` double NOT NULL,
  `Keterangan` text NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id_barang` (`id_barang`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `supplier`
--

CREATE TABLE IF NOT EXISTS `supplier` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nama` varchar(100) NOT NULL,
  `alamat` text NOT NULL,
  `email` varchar(50) NOT NULL,
  `telp` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `supplier`
--

INSERT INTO `supplier` (`id`, `nama`, `alamat`, `email`, `telp`) VALUES
(1, 'PT. Naufalindo Jaya', 'Jl. Affandi Gg. Surya No. 3B Yogyakarta 54595', '', '0274-5556660'),
(2, 'PT. Argon Anugrah Medika', 'Jl. Yogyakarta - Solo Km 3', '', '085236688999'),
(3, 'Sedico pharma ceutical', 'Jl. Magelang Km 9', '', '0274-5555677'),
(4, 'Anugrah Argon Medika, PT', 'Jl. Magelang Km 23 A', 'aam_dist@yahoo.com', '0274-5656556');

-- --------------------------------------------------------

--
-- Table structure for table `tarif`
--

CREATE TABLE IF NOT EXISTS `tarif` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nama` varchar(254) NOT NULL,
  `nominal` bigint(12) NOT NULL,
  `kode_akun` varchar(5) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `layanan_id` (`nama`),
  KEY `kode_akun` (`kode_akun`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

--
-- Dumping data for table `tarif`
--

INSERT INTO `tarif` (`id`, `nama`, `nominal`, `kode_akun`) VALUES
(5, 'ASKES TUSLAH DAN EMBALAGE', 800, '1.1'),
(6, 'Jasa Apoteker', 3500, '1.1'),
(7, 'TUSLAH DAN EMBALAGE', 1500, '1.1');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(20) NOT NULL,
  `password` varchar(50) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `telp` varchar(15) NOT NULL,
  `level` enum('Staff','Admin') NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `nama`, `telp`, `level`) VALUES
(1, 'admin', '81dc9bdb52d04dc20036dbd8313ed055', 'Arvin Nizar', '085236688999', 'Admin');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `bank`
--
ALTER TABLE `bank`
  ADD CONSTRAINT `bank_ibfk_1` FOREIGN KEY (`kode_akun`) REFERENCES `akun` (`kode`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `barang`
--
ALTER TABLE `barang`
  ADD CONSTRAINT `barang_ibfk_1` FOREIGN KEY (`id_pabrik`) REFERENCES `pabrik` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `barang_ibfk_3` FOREIGN KEY (`id_golongan`) REFERENCES `golongan` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `barang_ibfk_4` FOREIGN KEY (`id_sediaan`) REFERENCES `sediaan` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `barang_ibfk_5` FOREIGN KEY (`satuan_kekuatan`) REFERENCES `satuan` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `detail_pemesanan`
--
ALTER TABLE `detail_pemesanan`
  ADD CONSTRAINT `detail_pemesanan_ibfk_1` FOREIGN KEY (`id_pemesanan`) REFERENCES `pemesanan` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `detail_pemesanan_ibfk_2` FOREIGN KEY (`id_kemasan`) REFERENCES `kemasan` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `detail_penerimaan`
--
ALTER TABLE `detail_penerimaan`
  ADD CONSTRAINT `detail_penerimaan_ibfk_1` FOREIGN KEY (`id_penerimaan`) REFERENCES `penerimaan` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `detail_penerimaan_ibfk_2` FOREIGN KEY (`id_kemasan`) REFERENCES `kemasan` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `detail_penjualan`
--
ALTER TABLE `detail_penjualan`
  ADD CONSTRAINT `detail_penjualan_ibfk_1` FOREIGN KEY (`id_penjualan`) REFERENCES `penjualan` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `detail_penjualan_ibfk_2` FOREIGN KEY (`id_kemasan`) REFERENCES `kemasan` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `inkaso`
--
ALTER TABLE `inkaso`
  ADD CONSTRAINT `inkaso_ibfk_1` FOREIGN KEY (`id_supplier`) REFERENCES `supplier` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `inkaso_ibfk_2` FOREIGN KEY (`id_bank`) REFERENCES `bank` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `jadwal_dokter`
--
ALTER TABLE `jadwal_dokter`
  ADD CONSTRAINT `jadwal_dokter_ibfk_1` FOREIGN KEY (`id_dokter`) REFERENCES `dokter` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `kelas_terapi`
--
ALTER TABLE `kelas_terapi`
  ADD CONSTRAINT `kelas_terapi_ibfk_1` FOREIGN KEY (`id_farmako_terapi`) REFERENCES `farmako_terapi` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `kemasan`
--
ALTER TABLE `kemasan`
  ADD CONSTRAINT `kemasan_ibfk_1` FOREIGN KEY (`id_barang`) REFERENCES `barang` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `kemasan_ibfk_3` FOREIGN KEY (`id_kemasan`) REFERENCES `satuan` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `kemasan_ibfk_4` FOREIGN KEY (`id_satuan`) REFERENCES `satuan` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `pelanggan`
--
ALTER TABLE `pelanggan`
  ADD CONSTRAINT `pelanggan_ibfk_1` FOREIGN KEY (`id_asuransi`) REFERENCES `asuransi` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `tarif`
--
ALTER TABLE `tarif`
  ADD CONSTRAINT `tarif_ibfk_1` FOREIGN KEY (`kode_akun`) REFERENCES `akun` (`kode`) ON DELETE CASCADE ON UPDATE CASCADE;
