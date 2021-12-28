-- phpMyAdmin SQL Dump
-- version 4.9.7
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Dec 28, 2021 at 01:23 PM
-- Server version: 8.0.22
-- PHP Version: 7.2.34

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `perpus`
--

-- --------------------------------------------------------

--
-- Table structure for table `buku_tamu`
--

CREATE TABLE `buku_tamu` (
  `id_buku_tamu` int NOT NULL,
  `nama` varchar(100) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `alamat` varchar(100) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `pesan` longtext CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `email` varchar(100) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `tanggal` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

--
-- Dumping data for table `buku_tamu`
--

INSERT INTO `buku_tamu` (`id_buku_tamu`, `nama`, `alamat`, `pesan`, `email`, `tanggal`) VALUES
(1, 'andi azwar', 'sudiang', 'hadir', 'andiazawarsaman@gmail.com', '2021-12-23 15:30:58');

-- --------------------------------------------------------

--
-- Table structure for table `ci_sessions`
--

CREATE TABLE `ci_sessions` (
  `id` varchar(40) NOT NULL,
  `ip_address` varchar(45) NOT NULL,
  `timestamp` int UNSIGNED NOT NULL DEFAULT '0',
  `data` blob NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `identitas`
--

CREATE TABLE `identitas` (
  `id_identitas` int NOT NULL,
  `nama_website` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `url` varchar(100) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `facebook` text CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `twitter` varchar(255) NOT NULL,
  `instagram` varchar(255) NOT NULL,
  `youtube` varchar(255) NOT NULL,
  `rekening` varchar(100) NOT NULL,
  `no_telp` varchar(20) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `telp` varchar(50) NOT NULL,
  `alamat` varchar(250) NOT NULL,
  `meta_keyword` varchar(250) NOT NULL,
  `meta_deskripsi` longtext NOT NULL,
  `favicon` varchar(50) NOT NULL,
  `maps` text NOT NULL,
  `waktu` varchar(255) NOT NULL,
  `universitas` varchar(100) NOT NULL,
  `type` varchar(100) NOT NULL,
  `credits` varchar(100) NOT NULL,
  `kabupaten` varchar(100) NOT NULL,
  `propinsi` varchar(100) NOT NULL,
  `profil` longtext NOT NULL,
  `visi` varchar(100) NOT NULL,
  `misi` longtext NOT NULL,
  `str` longtext NOT NULL,
  `kepala_perpus` varchar(100) DEFAULT NULL,
  `nip_kabid` varchar(100) DEFAULT NULL,
  `tahun_awal` int DEFAULT NULL,
  `tahun_akhir` int DEFAULT NULL,
  `denda` int NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `identitas`
--

INSERT INTO `identitas` (`id_identitas`, `nama_website`, `email`, `url`, `facebook`, `twitter`, `instagram`, `youtube`, `rekening`, `no_telp`, `telp`, `alamat`, `meta_keyword`, `meta_deskripsi`, `favicon`, `maps`, `waktu`, `universitas`, `type`, `credits`, `kabupaten`, `propinsi`, `profil`, `visi`, `misi`, `str`, `kepala_perpus`, `nip_kabid`, `tahun_awal`, `tahun_akhir`, `denda`) VALUES
(1, 'Perpustakaan JTIK', 'andiazwarsaman@gmail.com', 'https://pustaka.onhacker.co.id/', '', 'https://twitter.com/KotaPpdb', 'https://www.instagram.com/ppdb_makassar/', 'https://www.youtube.com/channel/UCDIbtyXMczhrTj4pG01kBHQ', 'SULAWESI SELATAN', '(0411) 883187', '(0411) 458233', 'Jl. A. P. Pettarani', 'unm,perpustakaan,universitas negeri makassar,buku,mahasasiwa', 'Pustaka UNM adalaha sarana untuk', 'favicon.png', '', 'Asia/Makassar', 'UNIVERSITAS NEGERI MAKASSAR', 'Dinas', 'Onhacker,https://onhacker.net/', 'Makassar', 'SULAWESI SELATAN', '<p><span style=\"font-weight: 700; color: rgb(62, 77, 92); font-family: \" open=\"\" sans\",=\"\" arial,=\"\" sans-serif;=\"\" font-size:=\"\" 15px;\"=\"\">KEDUDUKAN</span><br style=\"color: rgb(62, 77, 92); font-family: \" open=\"\" sans\",=\"\" arial,=\"\" sans-serif;=\"\" font-size:=\"\" 15px;\"=\"\"></p><ul style=\"margin-bottom: 10px; color: rgb(62, 77, 92); font-family: \" open=\"\" sans\",=\"\" arial,=\"\" sans-serif;=\"\" font-size:=\"\" 15px;\"=\"\"><li>Perpustakaan Nasional merupakan Lembaga Pemerintah Nonkementerian yang berada di bawah dan bertanggung jawab kepada Presiden.</li><li>Perpustakaan Nasional dipimpin oleh seorang Kepala.</li></ul><p><span style=\"font-weight: 700; color: rgb(62, 77, 92); font-family: \" open=\"\" sans\",=\"\" arial,=\"\" sans-serif;=\"\" font-size:=\"\" 15px;\"=\"\">TUGAS DAN FUNGSI</span><br style=\"color: rgb(62, 77, 92); font-family: \" open=\"\" sans\",=\"\" arial,=\"\" sans-serif;=\"\" font-size:=\"\" 15px;\"=\"\"><span style=\"color: rgb(62, 77, 92); font-family: \" open=\"\" sans\",=\"\" arial,=\"\" sans-serif;=\"\" font-size:=\"\" 15px;\"=\"\">Perpustakaan Nasional melaksanakan tugas pemerintahan di bidang perpustakaan sesuai dengan ketentuan peraturan perundang-undangan meliputi:</span></p><ul style=\"margin-bottom: 10px; color: rgb(62, 77, 92); font-family: \" open=\"\" sans\",=\"\" arial,=\"\" sans-serif;=\"\" font-size:=\"\" 15px;\"=\"\"><li>menetapkan kebijakan nasional, kebijakan umum, dan kebijakan teknis pengelolaan perpustakaan;</li><li>melaksanakan pembinaan, pengembangan, evaluasi, dan koordinasi terhadap pengelolaan perpustakaan;</li><li>membina kerja sama dalam pengelolaan berbagai jenis perpustakaan; dan</li><li>mengembangkan standar nasional perpustakaan.</li></ul><p><br style=\"color: rgb(62, 77, 92); font-family: \" open=\"\" sans\",=\"\" arial,=\"\" sans-serif;=\"\" font-size:=\"\" 15px;\"=\"\"><span style=\"color: rgb(62, 77, 92); font-family: \" open=\"\" sans\",=\"\" arial,=\"\" sans-serif;=\"\" font-size:=\"\" 15px;\"=\"\">Dalam melaksanakan tugas sebagaimana dimaksud dalam Pasal 2, Perpustakaan Nasional menyelenggarakan fungsi:</span></p><ul style=\"margin-bottom: 10px; color: rgb(62, 77, 92); font-family: \" open=\"\" sans\",=\"\" arial,=\"\" sans-serif;=\"\" font-size:=\"\" 15px;\"=\"\"><li>pengkajian dan penyusunan kebijakan nasional di bidang perpustakaan;</li><li>pengoordinasian kegiatan fungsional dalam pelaksanaan tugas Perpustakaan Nasional;</li><li>pelaksanaan fasilitasi dan pembinaan terhadap kegiatan instansi pemerintah di bidang perpustakaan; dan</li><li>penyelenggaraan pembinaan dan pelayanan administrasi umum di bidang perencanaan umum, ketatausahaan, organisasi dan tatalaksana, kepegawaian, keuangan, kearsipan, hukum, persandian, perlengkapan, dan rumah tangga.</li></ul><p><br style=\"color: rgb(62, 77, 92); font-family: \" open=\"\" sans\",=\"\" arial,=\"\" sans-serif;=\"\" font-size:=\"\" 15px;\"=\"\"><br style=\"color: rgb(62, 77, 92); font-family: \" open=\"\" sans\",=\"\" arial,=\"\" sans-serif;=\"\" font-size:=\"\" 15px;\"=\"\"><span style=\"font-weight: 700; color: rgb(62, 77, 92); font-family: \" open=\"\" sans\",=\"\" arial,=\"\" sans-serif;=\"\" font-size:=\"\" 15px;\"=\"\">WEWENANG</span><br style=\"color: rgb(62, 77, 92); font-family: \" open=\"\" sans\",=\"\" arial,=\"\" sans-serif;=\"\" font-size:=\"\" 15px;\"=\"\"><br style=\"color: rgb(62, 77, 92); font-family: \" open=\"\" sans\",=\"\" arial,=\"\" sans-serif;=\"\" font-size:=\"\" 15px;\"=\"\"><span style=\"color: rgb(62, 77, 92); font-family: \" open=\"\" sans\",=\"\" arial,=\"\" sans-serif;=\"\" font-size:=\"\" 15px;\"=\"\">Dalam menyelenggarakan fungsi sebagaimana dimaksud dalam Pasal 3, Perpustakaan Nasional mempunyai wewenang:</span><br style=\"color: rgb(62, 77, 92); font-family: \" open=\"\" sans\",=\"\" arial,=\"\" sans-serif;=\"\" font-size:=\"\" 15px;\"=\"\"></p><ul style=\"margin-bottom: 10px; color: rgb(62, 77, 92); font-family: \" open=\"\" sans\",=\"\" arial,=\"\" sans-serif;=\"\" font-size:=\"\" 15px;\"=\"\"><li>penyusunan rencana nasional secara makro di bidang perpustakaan;</li><li>perumusan kebijakan di bidang perpustakaan untuk mendukung pembangunan secara makro;</li><li>penetapan sistem informasi di bidang perpustakaan;</li><li>kewenangan lain yang melekat dan telah dilaksanakan sesuai dengan ketentuan peraturan perundang-undangan meliputi:</li><ol><li>perumusan dan pelaksanaan kebijakan tertentu di bidang perpustakaan; dan</li><li>perumusan dan pelaksanaan kebijakan pelestarian pustaka budaya bangsa dalam mewujudkan koleksi deposit nasional dan pemanfaatannya.</li></ol></ul>', 'Terwujudnya Indonesia Cerdas Melalui Gemar Membaca Dengan Memberdayakan Perpustakaan', '<div style=\"text-align: center; \"><font color=\"#3e4d5c\"><b>MISI</b></font></div><ol style=\"margin-bottom: 10px; color: rgb(62, 77, 92); font-family: \" open=\"\" sans\",=\"\" arial,=\"\" sans-serif;=\"\" font-size:=\"\" 15px;\"=\"\"><li>Terwujudnya layanan prima;</li><li>Terwujudnya perpustakaan sebagai pelestari khazanah budaya bangsa;</li><li>Terwujudnya perpustakaan sesuai standar nasional perpustakaan.</li></ol>', '<div style=\"text-align: center; \"><font color=\"#3e4d5c\"><b>STRUKTIR ORGANISASAI</b></font></div><ol type=\"I\" style=\"margin-bottom: 10px; color: rgb(62, 77, 92); font-family: \" open=\"\" sans\",=\"\" arial,=\"\" sans-serif;=\"\" font-size:=\"\" 15px;\"=\"\"><img src=\"http://localhost/perpus/assets/images/min_note-on-thumb-030ed0c1a8.png\" style=\"width: 100%;\"></ol>', 'Chaerunnisa Ar Lamasitudju, S.Kom., M.Pd.', '196912101991032016', 2019, 2021, 0);

-- --------------------------------------------------------

--
-- Table structure for table `jurnal`
--

CREATE TABLE `jurnal` (
  `id_jurnal` int NOT NULL,
  `judul` varchar(99) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `pengarang` varchar(99) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `tahun` varchar(99) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `file` varchar(255) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `logo`
--

CREATE TABLE `logo` (
  `id_logo` int NOT NULL,
  `gambar` varchar(100) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

--
-- Dumping data for table `logo`
--

INSERT INTO `logo` (`id_logo`, `gambar`) VALUES
(1, 'logo.png');

-- --------------------------------------------------------

--
-- Table structure for table `master_buku`
--

CREATE TABLE `master_buku` (
  `id_buku` int NOT NULL,
  `kode_buku` char(255) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `judul_buku` varchar(99) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `deskripsi` longtext CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `nama_pengarang` varchar(99) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `nama_penerbit` varchar(99) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `tahun_terbit` varchar(99) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `jumlah_unit` int NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

--
-- Dumping data for table `master_buku`
--

INSERT INTO `master_buku` (`id_buku`, `kode_buku`, `judul_buku`, `deskripsi`, `nama_pengarang`, `nama_penerbit`, `tahun_terbit`, `jumlah_unit`) VALUES
(6, '111', 'menara', 'Negeri 5 Menara adalah roman karya Ahmad Fuadi yang diterbitkan oleh Gramedia pada tahun 2009. Novel ini bercerita tentang kehidupan 6 santri dari 6 daerah yang berbeda menuntut ilmu di Pondok Madani (PM) Ponorogo Jawa Timur yang jauh dari rumah dan berhasil mewujudkan mimpi menggapai jendela dunia.', 'aa', 'aa', '2020', 3),
(7, '222', 'buku guru', 'buku guru adalah buku untuk guru', 'an', 'aa', '2019', 3);

-- --------------------------------------------------------

--
-- Table structure for table `master_fakultas`
--

CREATE TABLE `master_fakultas` (
  `id_fakultas` int NOT NULL,
  `nama_fakultas` varchar(100) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

--
-- Dumping data for table `master_fakultas`
--

INSERT INTO `master_fakultas` (`id_fakultas`, `nama_fakultas`) VALUES
(2, 'Teknik');

-- --------------------------------------------------------

--
-- Table structure for table `master_jurusan`
--

CREATE TABLE `master_jurusan` (
  `id_jurusan` int NOT NULL,
  `nama_jurusan` varchar(100) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `id_fakultas` int NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

--
-- Dumping data for table `master_jurusan`
--

INSERT INTO `master_jurusan` (`id_jurusan`, `nama_jurusan`, `id_fakultas`) VALUES
(2, 'Jurusan Teknik Informatika dan Komputer', 2);

-- --------------------------------------------------------

--
-- Table structure for table `master_link_berita`
--

CREATE TABLE `master_link_berita` (
  `id_link_berita` int NOT NULL,
  `nama_berita` varchar(100) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `link` varchar(100) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

--
-- Dumping data for table `master_link_berita`
--

INSERT INTO `master_link_berita` (`id_link_berita`, `nama_berita`, `link`) VALUES
(1, 'LPM Profesi UNM', 'https://profesi-unm.com/'),
(2, 'Kompas Tekno', 'https://tekno.kompas.com/'),
(3, 'Okezone Tekno', 'https://techno.okezone.com/'),
(4, 'Detik', 'https://www.detik.com/tag/pendidikan');

-- --------------------------------------------------------

--
-- Table structure for table `master_link_jurnal`
--

CREATE TABLE `master_link_jurnal` (
  `id_link_jurnal` int NOT NULL,
  `nama_jurnal` varchar(100) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `link` varchar(100) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

--
-- Dumping data for table `master_link_jurnal`
--

INSERT INTO `master_link_jurnal` (`id_link_jurnal`, `nama_jurnal`, `link`) VALUES
(1, 'jurnal', 'https://ejournal.upbatam.ac.id/index.php/jif'),
(2, 'Sciencedirect', 'https://www.sciencedirect.com/'),
(3, 'Academia', 'https://www.academia.edu/'),
(4, 'Freefullpdf', 'https://freefullpdf.com/#gsc.tab=0');

-- --------------------------------------------------------

--
-- Table structure for table `master_prodi`
--

CREATE TABLE `master_prodi` (
  `id_prodi` int NOT NULL,
  `nama_prodi` varchar(100) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `id_jurusan` int NOT NULL,
  `id_fakultas` int NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

--
-- Dumping data for table `master_prodi`
--

INSERT INTO `master_prodi` (`id_prodi`, `nama_prodi`, `id_jurusan`, `id_fakultas`) VALUES
(2, 'Pendidikan Teknik Informatika dan Komputer', 2, 2);

-- --------------------------------------------------------

--
-- Table structure for table `modul`
--

CREATE TABLE `modul` (
  `id_modul` int NOT NULL,
  `nama_modul` varchar(50) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `username` varchar(50) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `link` varchar(100) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `static_content` text CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `gambar` varchar(100) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `publish` enum('Y','N') CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL DEFAULT 'Y',
  `status` enum('user','admin') CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `aktif` enum('Y','N') CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL DEFAULT 'Y',
  `urutan` int NOT NULL,
  `link_seo` varchar(50) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `modul`
--

INSERT INTO `modul` (`id_modul`, `nama_modul`, `username`, `link`, `static_content`, `gambar`, `publish`, `status`, `aktif`, `urutan`, `link_seo`) VALUES
(2, 'Member', 'admin', 'Admin_user', '', '', 'Y', 'admin', 'Y', 0, ''),
(10, 'Jurnal', 'admin', 'admin_file', '', '', 'Y', 'admin', 'Y', 0, ''),
(31, 'Sirkulasi', 'admin', 'Admin_sirkulasi', '', '', 'Y', 'admin', 'Y', 0, ''),
(33, 'Link Jurnal', 'admin', 'Admin_link_jurnal', '', '', 'Y', 'admin', 'Y', 0, ''),
(34, 'Fakultas', 'admin', 'Admin_fakultas', '', '', 'Y', 'admin', 'Y', 0, ''),
(41, 'Link Berita', 'admin', 'Admin_link_berita', '', '', 'Y', 'admin', 'Y', 0, ''),
(46, 'Skripsi', 'admin', 'Admin_skripsi', '', '', 'Y', 'admin', 'Y', 0, ''),
(61, 'Pengaturan System', 'admin', 'Admin_setting_web', '', '', 'Y', 'admin', 'Y', 0, 'identitas'),
(66, 'Logo', 'admin', 'Admin_logo', '', '', 'Y', 'admin', 'Y', 0, 'logo'),
(67, 'Kalender Epidemiologi', 'admin', 'Admin_kalender', '', '', 'Y', 'admin', 'Y', 0, ''),
(69, 'Imunisasi', 'admin', 'Admin_imunisasi', '', '', 'Y', 'user', 'Y', 0, ''),
(70, 'Pesan Masuk', 'admin', 'Admin_pesan', '', '', 'Y', 'admin', 'Y', 0, 'hubungi'),
(72, 'Pengumuman', 'admin', 'Admin_pengumuman', '', '', 'Y', 'admin', 'Y', 0, 'sekilasinfo'),
(73, 'Laporan', 'admin', 'Admin_log', '', '', 'Y', 'admin', 'Y', 0, 'pengurus'),
(76, 'Katalog', 'admin', 'Admin_buku', '', '', 'Y', 'admin', 'Y', 0, 'aktifitas'),
(140, 'Program Studi', 'admin', 'Admin_prodi', '', '', 'Y', 'admin', 'Y', 0, ''),
(146, 'Jurusan', 'admin', 'Admin_jurusan', '', '', 'Y', 'admin', 'Y', 0, '');

-- --------------------------------------------------------

--
-- Table structure for table `sirkulasi`
--

CREATE TABLE `sirkulasi` (
  `id_sirkulasi` int NOT NULL,
  `id_buku` int NOT NULL,
  `kode_buku` char(100) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `judul_buku` varchar(99) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `status` int NOT NULL,
  `nim` char(99) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `nama_mahasiswa` varchar(99) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `email` varchar(99) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `tgl_peminjaman` datetime NOT NULL,
  `tgl_pengembalian` datetime NOT NULL,
  `tgl_dikembalikan` datetime NOT NULL,
  `denda` int NOT NULL,
  `uang` int NOT NULL,
  `lewat` int NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

--
-- Dumping data for table `sirkulasi`
--

INSERT INTO `sirkulasi` (`id_sirkulasi`, `id_buku`, `kode_buku`, `judul_buku`, `status`, `nim`, `nama_mahasiswa`, `email`, `tgl_peminjaman`, `tgl_pengembalian`, `tgl_dikembalikan`, `denda`, `uang`, `lewat`) VALUES
(18, 6, '111', 'menara', 0, '1729042056', 'andi azwar', 'andiazwarsaman@gmai.com', '2021-12-23 17:46:51', '2021-12-30 17:46:51', '2021-12-23 21:41:45', 0, 0, 0),
(19, 7, '222', 'buku guru', 1, '123456789', 'Baso Irwan Sakti', 'basoirwansakti4@gmail.com', '2021-12-23 12:00:00', '2021-12-27 12:00:00', '0000-00-00 00:00:00', 0, 0, 0),
(20, 7, '222', 'buku guru', 0, '1729042056', 'andi azwar', 'andiazwarsaman@gmail.com', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '2021-12-25 17:54:04', 1, 0, 738546),
(21, 6, '111', 'menara', 1, '1729042056', 'andi azwar', 'andiazwarsaman@gmail.com', '2021-12-24 12:00:00', '2021-12-27 12:00:00', '0000-00-00 00:00:00', 0, 0, 0),
(22, 6, '111', 'menara', 1, '1632042011', 'Syehan', 'sean@onhacker.net', '2021-12-25 12:00:00', '2021-12-28 12:00:00', '0000-00-00 00:00:00', 0, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `skripsi`
--

CREATE TABLE `skripsi` (
  `id_skripsi` int NOT NULL,
  `judul` varchar(99) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `pengarang` varchar(99) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `tahun` varchar(99) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `file` varchar(255) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `tgl_diterima` date NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

--
-- Dumping data for table `skripsi`
--

INSERT INTO `skripsi` (`id_skripsi`, `judul`, `pengarang`, `tahun`, `file`, `tgl_diterima`) VALUES
(4, 'sasa', 'aa', '2020', 'Skripsi_23122021180309.pdf', '2021-12-23'),
(5, 'yudi', 'ahmad', '2021', 'Skripsi_23122021181017.pdf', '2021-12-23');

-- --------------------------------------------------------

--
-- Table structure for table `templates`
--

CREATE TABLE `templates` (
  `id_templates` int NOT NULL,
  `judul` varchar(100) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `username` varchar(50) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `pembuat` varchar(50) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `folder` varchar(50) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `aktif` enum('Y','N') CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL DEFAULT 'N'
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

--
-- Dumping data for table `templates`
--

INSERT INTO `templates` (`id_templates`, `judul`, `username`, `pembuat`, `folder`, `aktif`) VALUES
(24, 'Template Onhacker', 'admin', 'Rio', 'perpus', 'Y');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id_user` int NOT NULL,
  `username` varchar(50) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `password` varchar(255) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `nim` char(99) NOT NULL,
  `nama_lengkap` varchar(100) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `email` varchar(100) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `no_telp` varchar(20) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `foto` varchar(100) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `level` varchar(20) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL DEFAULT 'user',
  `blokir` enum('Y','N','P') CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL DEFAULT 'N',
  `id_session` varchar(255) NOT NULL,
  `permission_publish` enum('Y','N') NOT NULL DEFAULT 'N',
  `attack` varchar(255) NOT NULL,
  `tanggal_reg` date NOT NULL,
  `deleted` enum('Y','N') NOT NULL DEFAULT 'N',
  `valid_reset` date NOT NULL,
  `id_reset` varchar(255) NOT NULL,
  `id_prodi` int NOT NULL,
  `alamat` text NOT NULL,
  `id_jurusan` int NOT NULL,
  `id_fakultas` int NOT NULL,
  `angkatan` int NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id_user`, `username`, `password`, `nim`, `nama_lengkap`, `email`, `no_telp`, `foto`, `level`, `blokir`, `id_session`, `permission_publish`, `attack`, `tanggal_reg`, `deleted`, `valid_reset`, `id_reset`, `id_prodi`, `alamat`, `id_jurusan`, `id_fakultas`, `angkatan`) VALUES
(1, 'admin', 'bff0cc42103de1b4721370e84dc24f635a7afeca41198c9b3e03946a1b6b7191d14356408a5e57ce6daf77e6e800c66fac7ab0482d57d48d23e6808e4b562daa', '0', 'Admin Perpus', 'onhacker@gmail.com', '081241158909', 'admin_perpus_78044a1f.jpg', 'admin', 'N', '890060150521', 'Y', '9a9be62d996637089f6b73863dbf2ef2', '2020-04-23', 'N', '2021-12-26', '12eb9f14e7c9fa1ef646491e20c27b92cb586254009f348f2640ec809604b60199d596e14583796c34b79d3a8587b146edcb51a2b45e31a6551d90488b813d06', 0, '', 0, 2147483647, 0),
(9, 'andiazwar', '3c9ae29d4718bff86c2b36042bd390bf8e9ffce92f7c282ded90053bb009332aea90f313d59446288779bf69da408735639121b382c5fb0b9deefcdd5775d223', '1729042056', 'andi azwar', 'andiazwarsaman@gmail.com', '082344602637', '', 'user', 'N', '80704171072', 'N', '7bb84a69559964d696b73b43690fcc71', '2021-12-23', 'N', '2021-12-26', '2137c94d4ac420fc90d09f7a7399a380d2b1e3186eb395aded5ea3f05f519504054eeceb83809c58ece481a87ba733b61e55a2402f191c931a97b8deb1f31733', 2, 'sudiang', 2, 2, 2017),
(10, 'onhacker', '8fcc53c9595555e624cbbd0e7f03feb5fd51652aa382bb7c39291adbc755306ae7de2d81afb08325198e652ebff4778718e294aad9e798c8650014341abe9124', '123456789', 'Baso Irwan Sakti', 'basoirwansakti4@gmail.com', '085203954888', '', 'user', 'N', '88981906976', 'N', '89ff81ffdbc90c697b6921ed4c3039fb', '2021-12-23', 'N', '2021-12-26', '4912f271bb9a51e25d67b64122e4a2bc5fecffdf7ee1f6839d509e3207085713bee3a48cec48bbaaf360cb661819bdc13d3b4eeabee42218f34c3624d26c3a73', 2, 'BTP', 2, 2, 2014),
(11, 'sean123', '85e5ad808ee12a925d2b19fabcadb5575d4434811eeff2506af6df10f84a77d2288e10610a3a5aaa8964743999aace03633e5130969150c59091a76865f201d3', '1632042011', 'Syehan', 'sean@onhacker.net', '082291302063', '', 'user', 'N', '82796534274', 'N', '2f79a6aa5f3da42b7c455fd71d70a4b7', '2021-12-26', 'N', '0000-00-00', 'b1718791ad4be055b6a2e10f3ded2838ecb749fd5a3e2378fea8f10b4eb5a64ce079ff1920848de32c19fac05b787a665f8c450f78dc9c90c9c529df64d2087b', 2, 'Jalan Kedamaian Selatan 8', 2, 2, 2016);

-- --------------------------------------------------------

--
-- Table structure for table `users_modul`
--

CREATE TABLE `users_modul` (
  `id_umod` int NOT NULL,
  `id_session` varchar(255) NOT NULL,
  `id_modul` int NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users_modul`
--

INSERT INTO `users_modul` (`id_umod`, `id_session`, `id_modul`) VALUES
(59, '89365748023', 69),
(58, '89365748023', 73),
(57, '89365748023', 41),
(56, '89365748023', 33),
(60, '83989376951', 33),
(61, '83989376951', 41),
(62, '83989376951', 73),
(63, '83989376951', 69),
(64, '87997559195', 33),
(65, '87997559195', 41),
(66, '87997559195', 73),
(67, '87997559195', 69),
(68, '88895617815', 33),
(69, '88895617815', 41),
(70, '88895617815', 73),
(71, '88895617815', 69),
(72, '88572224294', 33),
(73, '88572224294', 41),
(74, '88572224294', 73),
(75, '88572224294', 69),
(76, '85678951205', 33),
(77, '85678951205', 41),
(78, '85678951205', 73),
(79, '85678951205', 69),
(80, '87014421361', 33),
(81, '87014421361', 41),
(82, '87014421361', 73),
(83, '87014421361', 69),
(84, '87842140724', 33),
(85, '87842140724', 41),
(86, '87842140724', 73),
(87, '87842140724', 69),
(88, '84056473618', 33),
(89, '84056473618', 41),
(90, '84056473618', 73),
(91, '84056473618', 69),
(92, '81016978705', 33),
(93, '81016978705', 41),
(94, '81016978705', 73),
(95, '81016978705', 69),
(96, '82157163998', 33),
(97, '82157163998', 41),
(98, '82157163998', 73),
(99, '82157163998', 69),
(100, '80473525751', 33),
(101, '80473525751', 41),
(102, '80473525751', 73),
(103, '80473525751', 69),
(104, '88791779688', 33),
(105, '88791779688', 41),
(106, '88791779688', 73),
(107, '88791779688', 69),
(108, '83101907245', 33),
(109, '83101907245', 41),
(110, '83101907245', 73),
(111, '83101907245', 69),
(112, '85822889183', 33),
(113, '85822889183', 41),
(114, '85822889183', 73),
(115, '85822889183', 69),
(116, '84744562720', 33),
(117, '84744562720', 41),
(118, '84744562720', 73),
(119, '84744562720', 69),
(120, '82809673208', 33),
(121, '82809673208', 41),
(122, '82809673208', 73),
(123, '82809673208', 69),
(124, '82809673208', 31),
(125, '82809673208', 140),
(126, '84744562720', 31),
(127, '84744562720', 140),
(128, '85822889183', 31),
(129, '85822889183', 140),
(130, '83101907245', 31),
(131, '83101907245', 140),
(132, '80473525751', 140),
(133, '80473525751', 31),
(134, '88791779688', 31),
(135, '88791779688', 140),
(136, '82157163998', 31),
(137, '82157163998', 140),
(138, '81016978705', 140),
(139, '81016978705', 31),
(140, '87842140724', 140),
(141, '87842140724', 31),
(142, '84056473618', 31),
(143, '84056473618', 140),
(144, '87014421361', 140),
(145, '87014421361', 31),
(146, '85678951205', 31),
(147, '85678951205', 140),
(148, '88572224294', 31),
(149, '88572224294', 140),
(150, '88895617815', 31),
(151, '88895617815', 140),
(152, '83989376951', 31),
(153, '83989376951', 140),
(154, '87997559195', 31),
(155, '87997559195', 140),
(156, '89365748023', 31),
(157, '89365748023', 140);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `buku_tamu`
--
ALTER TABLE `buku_tamu`
  ADD PRIMARY KEY (`id_buku_tamu`);

--
-- Indexes for table `ci_sessions`
--
ALTER TABLE `ci_sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ci_sessions_timestamp` (`timestamp`);

--
-- Indexes for table `identitas`
--
ALTER TABLE `identitas`
  ADD PRIMARY KEY (`id_identitas`);

--
-- Indexes for table `jurnal`
--
ALTER TABLE `jurnal`
  ADD PRIMARY KEY (`id_jurnal`);

--
-- Indexes for table `logo`
--
ALTER TABLE `logo`
  ADD PRIMARY KEY (`id_logo`);

--
-- Indexes for table `master_buku`
--
ALTER TABLE `master_buku`
  ADD PRIMARY KEY (`id_buku`);

--
-- Indexes for table `master_fakultas`
--
ALTER TABLE `master_fakultas`
  ADD PRIMARY KEY (`id_fakultas`);

--
-- Indexes for table `master_jurusan`
--
ALTER TABLE `master_jurusan`
  ADD PRIMARY KEY (`id_jurusan`);

--
-- Indexes for table `master_link_berita`
--
ALTER TABLE `master_link_berita`
  ADD PRIMARY KEY (`id_link_berita`);

--
-- Indexes for table `master_link_jurnal`
--
ALTER TABLE `master_link_jurnal`
  ADD PRIMARY KEY (`id_link_jurnal`);

--
-- Indexes for table `master_prodi`
--
ALTER TABLE `master_prodi`
  ADD PRIMARY KEY (`id_prodi`);

--
-- Indexes for table `modul`
--
ALTER TABLE `modul`
  ADD PRIMARY KEY (`id_modul`);

--
-- Indexes for table `sirkulasi`
--
ALTER TABLE `sirkulasi`
  ADD PRIMARY KEY (`id_sirkulasi`);

--
-- Indexes for table `skripsi`
--
ALTER TABLE `skripsi`
  ADD PRIMARY KEY (`id_skripsi`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id_user`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `buku_tamu`
--
ALTER TABLE `buku_tamu`
  MODIFY `id_buku_tamu` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `jurnal`
--
ALTER TABLE `jurnal`
  MODIFY `id_jurnal` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `logo`
--
ALTER TABLE `logo`
  MODIFY `id_logo` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `master_buku`
--
ALTER TABLE `master_buku`
  MODIFY `id_buku` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `master_fakultas`
--
ALTER TABLE `master_fakultas`
  MODIFY `id_fakultas` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `master_jurusan`
--
ALTER TABLE `master_jurusan`
  MODIFY `id_jurusan` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `master_link_berita`
--
ALTER TABLE `master_link_berita`
  MODIFY `id_link_berita` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `master_link_jurnal`
--
ALTER TABLE `master_link_jurnal`
  MODIFY `id_link_jurnal` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `master_prodi`
--
ALTER TABLE `master_prodi`
  MODIFY `id_prodi` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `modul`
--
ALTER TABLE `modul`
  MODIFY `id_modul` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=147;

--
-- AUTO_INCREMENT for table `sirkulasi`
--
ALTER TABLE `sirkulasi`
  MODIFY `id_sirkulasi` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `skripsi`
--
ALTER TABLE `skripsi`
  MODIFY `id_skripsi` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id_user` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
