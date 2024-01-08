-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 07 Jan 2024 pada 15.34
-- Versi server: 10.4.28-MariaDB
-- Versi PHP: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `smak_wartabakti`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `auth`
--

CREATE TABLE `auth` (
  `id` int(11) NOT NULL,
  `image` varchar(50) DEFAULT NULL,
  `bg` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `auth`
--

INSERT INTO `auth` (`id`, `image`, `bg`) VALUES
(1, 'auth.jpg', '#4e73de');

-- --------------------------------------------------------

--
-- Struktur dari tabel `berita`
--

CREATE TABLE `berita` (
  `id_berita` int(11) NOT NULL,
  `img_berita` varchar(50) NOT NULL,
  `judul_berita` varchar(255) NOT NULL,
  `isi_berita` text NOT NULL,
  `slug` varchar(100) NOT NULL,
  `tanggal_publikasi` datetime NOT NULL DEFAULT current_timestamp(),
  `id_kategori` int(11) DEFAULT NULL,
  `id_user` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `berita`
--

INSERT INTO `berita` (`id_berita`, `img_berita`, `judul_berita`, `isi_berita`, `slug`, `tanggal_publikasi`, `id_kategori`, `id_user`) VALUES
(5, '4190854117.jpg', 'PENGUMUMAN KELULUSAN 2023', '<p>Untuk melihat hasil kelulusan siswa/ siswi kelas 12 SMAS Katolik Warta Bakti Kefamenanu, Tahun Pelajaran 2022/ 2023, gunakan&nbsp;<strong>NISN</strong>&nbsp;untuk mengecek hasil kelulusan.</p>\r\n', 'pengumuman_kelulusan_2023', '2023-12-19 13:03:37', 8, 1),
(6, '1430215212.jpg', 'Bank NTT Mendukung Kegiatan Class Meeting Smarta', '<p>Bank Pembangunan Daerah Provinsi Nusa Tenggara Timur (PT Bank NTT)&nbsp; Cabang Kota Kefamenanu&nbsp; mendukung penuh&nbsp; kegiatan class meeting Smarta,&nbsp; yakni&nbsp; pertandingan futsal putra-putri dan lomba yel-yel tingkat SMAS Katolik Warta Bakti Kefamenanu.</p>\r\n\r\n<p>&ldquo;Bank NTT selalu siap&nbsp; mendukung semua kegiatan di lingkungan SMAS Katolik Warta Bakti Kefamenanu baik ekstra maupun intra&rdquo;&nbsp; kata wakil kepala bank NTT cabang kota Kefamenanu Yorry R.M Blegur saat memberikan sambutan pembukaan class meeting di lapangan&nbsp; multi fungsi SMAS Katolik Warta Bakti Kefamenanu, Senin sore 20 Juni&nbsp; 2022.</p>\r\n\r\n<p>Ia&nbsp; menyampaikan bahwa event&nbsp; tersebut&nbsp; merupakan&nbsp; suatu momen yang dimana melatih siswa-siswi untuk bisa mengedepankan yang dinamakan dengan sportifitas.</p>\r\n\r\n<p>&ldquo;Kegiatan ekstra ini untuk&nbsp; mempersatukan bukan memecah belakan. dan&nbsp; lewat kesempatan ini,&nbsp; kita semua belajar untuk apa itu yang namanya sportifitas&rdquo; Tambah <strong>Yorry</strong></p>\r\n\r\n<p>Selain itu <strong>Yorry</strong>&nbsp; juga mengajak siswa-siswi Smarta untuk terus mengembangkan bakat dan&nbsp; kreativitas melalui kegiatan ekstra,&nbsp; khususnya dibidang futsal dan yel-yel.</p>\r\n\r\n<p>Berkaitan dengan&nbsp; futsal,&nbsp; Yorry&nbsp; mengatakan bahwa perlombaan ini&nbsp; sedikit senggol-menyenggol,&nbsp; yang dibutuhkan adalah&nbsp; junjung persaudaraan serta dilatih untuk&nbsp; sampai kepada event-event&nbsp; yang lebih besar.</p>\r\n\r\n<p>&ldquo;Selamat bertanding dan selamat bergembira bersama, semua penuh dengan rasa sukacita&rdquo; Tutup <strong>Yorry.</strong></p>\r\n', 'bank_ntt_mendukung_kegiatan_class_meeting_smarta', '2023-12-19 13:16:18', 9, 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `biaya_pembayaran`
--

CREATE TABLE `biaya_pembayaran` (
  `id_biaya` int(11) NOT NULL,
  `nama_biaya` varchar(100) NOT NULL,
  `jumlah_biaya` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `biaya_pembayaran`
--

INSERT INTO `biaya_pembayaran` (`id_biaya`, `nama_biaya`, `jumlah_biaya`) VALUES
(1, 'Biaya Pendaftaran', 300000),
(3, 'Uang Pangkal', 500000),
(4, 'Sumbangan Pembangunan', 100000),
(5, 'Biaya Administrasi', 50000),
(6, 'Biaya Seragam', 100000),
(7, 'Biaya Kegiatan', 50000);

-- --------------------------------------------------------

--
-- Struktur dari tabel `carousel`
--

CREATE TABLE `carousel` (
  `id_carousel` int(11) NOT NULL,
  `nama` varchar(50) NOT NULL,
  `deskripsi` text NOT NULL,
  `icon` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `carousel`
--

INSERT INTO `carousel` (`id_carousel`, `nama`, `deskripsi`, `icon`) VALUES
(1, 'Formulir PPDB', 'Berkas syarat pendaftaran PPDB', 'service-icon-02.png'),
(2, 'Hasil Seleksi', '', 'service-icon-02.png'),
(3, 'Download Formulir', 'Download berkas syarat pendaftaran PPDB', 'service-icon-01.png');

-- --------------------------------------------------------

--
-- Struktur dari tabel `ekstrakulikuler`
--

CREATE TABLE `ekstrakulikuler` (
  `id` int(11) NOT NULL,
  `img` varchar(100) NOT NULL,
  `deskripsi` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `faq`
--

CREATE TABLE `faq` (
  `id_faq` int(11) NOT NULL,
  `pertanyaan` varchar(255) NOT NULL,
  `jawaban` text NOT NULL,
  `tanggal_dibuat` datetime NOT NULL DEFAULT current_timestamp(),
  `terakhir_diperbarui` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `faq`
--

INSERT INTO `faq` (`id_faq`, `pertanyaan`, `jawaban`, `tanggal_dibuat`, `terakhir_diperbarui`) VALUES
(6, 'Apa syarat utama untuk mendaftar di SMA Swasta Katolik Warta Bakti?', 'Calon siswa harus telah menyelesaikan pendidikan SMP atau setara dan memiliki niat serta komitmen untuk mengikuti pendidikan yang berlandaskan ajaran Katolik.', '2023-12-19 13:31:42', NULL),
(7, 'Bagaimana proses pendaftaran di SMA Swasta Katolik Warta Bakti?', 'Proses pendaftaran dilakukan secara online melalui website resmi sekolah atau datang langsung ke sekolah untuk mengambil formulir pendaftaran. Calon siswa kemudian diwajibkan mengikuti serangkaian ujian seleksi.', '2023-12-19 13:33:04', NULL),
(8, 'Apa saja dokumen yang dibutuhkan untuk pendaftaran?', 'Dokumen yang diperlukan biasanya meliputi formulir pendaftaran, fotokopi ijasah terakhir, akta kelahiran, dan pas foto terbaru.', '2023-12-19 13:34:30', NULL),
(9, 'Bagaimana sistem pembayaran di SMA Swasta Katolik Warta Bakti?', 'Informasi mengenai biaya pendidikan dan sistem pembayaran dilakukan secara langsung melalui website resmi ini.', '2023-12-19 13:35:51', NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `formulir`
--

CREATE TABLE `formulir` (
  `id` int(11) NOT NULL,
  `formulir` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `formulir`
--

INSERT INTO `formulir` (`id`, `formulir`) VALUES
(1, 'PPDB_2023_1662161687.pdf');

-- --------------------------------------------------------

--
-- Struktur dari tabel `galeri`
--

CREATE TABLE `galeri` (
  `id_galeri` int(11) NOT NULL,
  `image` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `guru`
--

CREATE TABLE `guru` (
  `id_guru` int(11) NOT NULL,
  `img_guru` varchar(50) NOT NULL DEFAULT 'default.png',
  `nama_lengkap` varchar(100) NOT NULL,
  `nik` varchar(20) NOT NULL,
  `jk` varchar(35) NOT NULL,
  `tempat_lahir` varchar(50) NOT NULL,
  `tgl_lahir` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `guru`
--

INSERT INTO `guru` (`id_guru`, `img_guru`, `nama_lengkap`, `nik`, `jk`, `tempat_lahir`, `tgl_lahir`) VALUES
(1, 'default.png', 'Dominggus Amsikan', '5303060212850001', 'Laki-Laki', 'Neofmuti', '1985-12-02'),
(3, 'default.png', 'Fransiskus Xaverius Sanan', '5303052212860003', 'Laki-Laki', 'Bahakono', '1986-12-22');

-- --------------------------------------------------------

--
-- Struktur dari tabel `hasil_seleksi`
--

CREATE TABLE `hasil_seleksi` (
  `id_hasil_seleksi` int(11) NOT NULL,
  `id_pendaftaran` int(11) DEFAULT NULL,
  `nilai_ujian` int(11) DEFAULT NULL,
  `nilai_rapor` int(11) DEFAULT NULL,
  `nilai_total` int(11) DEFAULT NULL,
  `keterangan` text DEFAULT NULL,
  `tanggal_seleksi` datetime DEFAULT NULL,
  `tanggal_hasil` datetime DEFAULT NULL,
  `status_lulus` varchar(20) DEFAULT 'Belum Dikonfirmasi'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `header`
--

CREATE TABLE `header` (
  `id` int(11) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `deskripsi` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `header`
--

INSERT INTO `header` (`id`, `nama`, `deskripsi`) VALUES
(1, 'Welcome to SMAS K Warta Bakti', 'Yang paling hebat bagi seorang guru adalah mendidik, dan rekreasi yang paling indah adalah mengajar.');

-- --------------------------------------------------------

--
-- Struktur dari tabel `iklan`
--

CREATE TABLE `iklan` (
  `id_iklan` int(11) NOT NULL,
  `judul_iklan` varchar(100) NOT NULL,
  `image` varchar(100) NOT NULL,
  `tanggal_mulai` datetime NOT NULL,
  `tanggal_selesai` datetime NOT NULL,
  `tautan` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `iklan`
--

INSERT INTO `iklan` (`id_iklan`, `judul_iklan`, `image`, `tanggal_mulai`, `tanggal_selesai`, `tautan`) VALUES
(1, 'PENGUMUMAN KELULUSAN 2023', 'smarta.jpg', '2023-12-12 22:24:12', '2023-12-13 22:24:12', 'https://smaskwartabakti.sch.id/read/58/pengumuman-kelulusan-2023');

-- --------------------------------------------------------

--
-- Struktur dari tabel `kategori_berita`
--

CREATE TABLE `kategori_berita` (
  `id_kategori` int(11) NOT NULL,
  `nama_kategori` varchar(255) NOT NULL,
  `slug` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `kategori_berita`
--

INSERT INTO `kategori_berita` (`id_kategori`, `nama_kategori`, `slug`) VALUES
(8, 'Akademis', 'akademis'),
(9, 'Non Akademis', 'non_akademis');

-- --------------------------------------------------------

--
-- Struktur dari tabel `komentar`
--

CREATE TABLE `komentar` (
  `id_komentar` int(11) NOT NULL,
  `nama_komentar` varchar(50) NOT NULL,
  `email_komentar` varchar(50) NOT NULL,
  `isi_komentar` text NOT NULL,
  `tanggal_komentar` datetime NOT NULL DEFAULT current_timestamp(),
  `id_berita` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `kontak`
--

CREATE TABLE `kontak` (
  `id_kontak` int(11) NOT NULL,
  `nama` varchar(50) NOT NULL,
  `email` varchar(75) NOT NULL,
  `subject` varchar(100) DEFAULT NULL,
  `pesan` text NOT NULL,
  `tanggal` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `pembayaran`
--

CREATE TABLE `pembayaran` (
  `id_pembayaran` int(11) NOT NULL,
  `id_hasil_seleksi` int(11) DEFAULT NULL,
  `order_id` varchar(100) NOT NULL,
  `jumlah_pembayaran` int(11) DEFAULT NULL,
  `batas_pembayaran` datetime DEFAULT NULL,
  `tanggal_pembayaran` datetime DEFAULT NULL,
  `status_pembayaran` varchar(20) DEFAULT 'Belum Lunas'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `pendaftaran`
--

CREATE TABLE `pendaftaran` (
  `id_pendaftaran` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `nama_lengkap` varchar(255) NOT NULL,
  `jenis_kelamin` varchar(10) NOT NULL,
  `tanggal_lahir` date NOT NULL,
  `alamat` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `nomor_telepon` varchar(15) NOT NULL,
  `asal_sekolah` varchar(255) DEFAULT NULL,
  `formulir` varchar(50) NOT NULL,
  `tanggal_pendaftaran` datetime NOT NULL DEFAULT current_timestamp(),
  `status_pendaftaran` varchar(20) DEFAULT 'Belum Diverifikasi'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `pengumuman`
--

CREATE TABLE `pengumuman` (
  `id_pengumuman` int(11) NOT NULL,
  `judul` varchar(100) NOT NULL,
  `isi_pengumuman` text NOT NULL,
  `tanggal` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `profil`
--

CREATE TABLE `profil` (
  `id` int(11) NOT NULL,
  `deskripsi` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `profil`
--

INSERT INTO `profil` (`id`, `deskripsi`) VALUES
(1, '<p><strong>Nama Sekolah</strong>&nbsp; &nbsp;: SMA Swasta Katolik Warta Bakti Kefamenanu</p>\r\n\r\n<p><strong>Kepala Sekolah&nbsp;</strong>:&nbsp; Romo Djanuarius W. Mau Kura, Pr</p>\r\n\r\n<p><strong>Tahun Berdiri&nbsp;</strong>&nbsp; &nbsp;: 1995</p>\r\n\r\n<p><strong>Status Sekolah&nbsp;&nbsp;</strong>: Swasta</p>\r\n\r\n<p><strong>NPSN&nbsp; &nbsp; &nbsp;</strong>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; :5301009</p>\r\n\r\n<p><strong>Akreditasi&nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp;</strong>: B</p>\r\n\r\n<p><strong>Bentuk Pendidikan :&nbsp;</strong>SMA</p>\r\n\r\n<p><strong>Status Kepemilikan :&nbsp;</strong>Yayasan</p>\r\n\r\n<p><strong>SK Pendirian Sekolah :&nbsp;</strong>9765/1.21/MN/1995</p>\r\n\r\n<p><strong>Tanggal SK Pendirian :&nbsp;</strong>1995-08-31</p>\r\n\r\n<p><strong>SK Izin Operasional :&nbsp;</strong>9765/I.21.9/MN/1995</p>\r\n\r\n<p><strong>Tanggal SK Izin Operasional :&nbsp;</strong>1995-07-01</p>\r\n\r\n<p><strong>Guru :&nbsp;</strong>22<br />\r\n<strong>Siswa Laki-laki :</strong>&nbsp;166<br />\r\n<strong>Siswa Perempuan :</strong>&nbsp;347<br />\r\n<strong>Rombongan Belajar :&nbsp;</strong>18</p>\r\n\r\n<p><strong>Kurikulum :</strong>&nbsp;SMA 2013 IPS<br />\r\n<strong>Penyelenggaraan : </strong>Pagi/6 hari<br />\r\n<strong>Manajemen Berbasis Sekolah :</strong> Ya<br />\r\n<strong>Semester Data :</strong>&nbsp;2023/2024-1</p>\r\n\r\n<p><strong>Akses Internet : </strong>Tidak Ada<br />\r\n<strong>Sumber Listrik :</strong> PLN<br />\r\n<strong>Daya Listrik :&nbsp;</strong>4,400<br />\r\n<strong>Luas Tanah :&nbsp;</strong>348,100&nbsp;M&sup2;</p>\r\n\r\n<p><strong>Ruang Kelas :</strong>&nbsp;16&nbsp;*<br />\r\n<strong>Laboratorium :</strong>&nbsp;3&nbsp;*<br />\r\n<strong>Perpustakaan :</strong>&nbsp;1&nbsp;*<br />\r\n<strong>Sanitasi Siswa :</strong>&nbsp;2&nbsp;*</p>\r\n');

-- --------------------------------------------------------

--
-- Struktur dari tabel `sejarah`
--

CREATE TABLE `sejarah` (
  `id` int(11) NOT NULL,
  `deskripsi` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `sejarah`
--

INSERT INTO `sejarah` (`id`, `deskripsi`) VALUES
(1, '<p><strong>Lorem ipsum</strong> dolor sit amet consectetur adipisicing elit. Reprehenderit exercitationem praesentium fugit dolorem quam voluptatibus, consequatur facilis, consequuntur minima adipisci, ratione eos harum placeat et natus! Tempore in eius, natus nostrum neque, ducimus, debitis corporis dolorem quidem consequatur laudantium. Harum eum quae deserunt illum repudiandae aspernatur minus, labore doloremque architecto!</p>\r\n');

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id_user` int(11) NOT NULL,
  `id_role` int(11) DEFAULT NULL,
  `id_active` int(11) DEFAULT 2,
  `en_user` varchar(75) DEFAULT NULL,
  `token` char(6) DEFAULT NULL,
  `name` varchar(100) DEFAULT NULL,
  `image` varchar(100) DEFAULT 'default.svg',
  `email` varchar(75) DEFAULT NULL,
  `password` varchar(75) DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id_user`, `id_role`, `id_active`, `en_user`, `token`, `name`, `image`, `email`, `password`, `created_at`, `updated_at`) VALUES
(1, 1, 1, NULL, NULL, 'admin', 'default.svg', 'admin@gmail.com', '$2y$10$KkVESFaW/HVGhwR/YOg52eXDeZ6vpcYRKrl46sO4U6x4YeSF4C0NW', '2023-12-06 01:06:36', '2023-12-06 01:06:36');

--
-- Trigger `users`
--
DELIMITER $$
CREATE TRIGGER `insert_users` BEFORE INSERT ON `users` FOR EACH ROW SET NEW.id_role = (
        SELECT id_role
        FROM `user_role`
        ORDER BY id_role DESC
        LIMIT 1
    )
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Struktur dari tabel `user_access_menu`
--

CREATE TABLE `user_access_menu` (
  `id_access_menu` int(11) NOT NULL,
  `id_role` int(11) DEFAULT NULL,
  `id_menu` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `user_access_menu`
--

INSERT INTO `user_access_menu` (`id_access_menu`, `id_role`, `id_menu`) VALUES
(1, 1, 1),
(2, 1, 2),
(3, 1, 4),
(4, 1, 5),
(5, 1, 6),
(6, 1, 7),
(7, 2, 5),
(8, 3, 5);

-- --------------------------------------------------------

--
-- Struktur dari tabel `user_access_sub_menu`
--

CREATE TABLE `user_access_sub_menu` (
  `id_access_sub_menu` int(11) NOT NULL,
  `id_role` int(11) DEFAULT NULL,
  `id_sub_menu` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `user_access_sub_menu`
--

INSERT INTO `user_access_sub_menu` (`id_access_sub_menu`, `id_role`, `id_sub_menu`) VALUES
(1, 1, 1),
(2, 1, 2),
(3, 1, 3),
(4, 1, 4),
(5, 1, 5),
(6, 1, 6),
(7, 1, 8),
(8, 1, 9),
(9, 1, 10),
(10, 1, 11),
(11, 1, 12),
(12, 1, 13),
(13, 1, 14),
(14, 1, 15),
(15, 1, 16),
(16, 1, 17),
(17, 1, 18),
(18, 2, 14),
(19, 2, 15),
(20, 3, 18),
(21, 3, 15),
(22, 1, 19),
(23, 3, 14),
(24, 3, 13),
(25, 1, 20),
(26, 1, 21),
(27, 1, 22);

-- --------------------------------------------------------

--
-- Struktur dari tabel `user_menu`
--

CREATE TABLE `user_menu` (
  `id_menu` int(11) NOT NULL,
  `menu` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `user_menu`
--

INSERT INTO `user_menu` (`id_menu`, `menu`) VALUES
(1, 'User Management'),
(2, 'Menu Management'),
(4, 'Utilitas'),
(5, 'PPDB'),
(6, 'Berita'),
(7, 'Pengumuman');

-- --------------------------------------------------------

--
-- Struktur dari tabel `user_role`
--

CREATE TABLE `user_role` (
  `id_role` int(11) NOT NULL,
  `role` varchar(35) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `user_role`
--

INSERT INTO `user_role` (`id_role`, `role`) VALUES
(1, 'Administrator'),
(2, 'Kepala Sekolah'),
(3, 'Peserta');

-- --------------------------------------------------------

--
-- Struktur dari tabel `user_status`
--

CREATE TABLE `user_status` (
  `id_status` int(11) NOT NULL,
  `status` varchar(35) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `user_status`
--

INSERT INTO `user_status` (`id_status`, `status`) VALUES
(1, 'Active'),
(2, 'No Active');

-- --------------------------------------------------------

--
-- Struktur dari tabel `user_sub_menu`
--

CREATE TABLE `user_sub_menu` (
  `id_sub_menu` int(11) NOT NULL,
  `id_menu` int(11) DEFAULT NULL,
  `id_active` int(11) DEFAULT 2,
  `title` varchar(50) DEFAULT NULL,
  `url` varchar(50) DEFAULT NULL,
  `icon` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `user_sub_menu`
--

INSERT INTO `user_sub_menu` (`id_sub_menu`, `id_menu`, `id_active`, `title`, `url`, `icon`) VALUES
(1, 1, 1, 'Users', 'users', 'fas fa-users'),
(2, 1, 1, 'Role', 'role', 'fas fa-user-cog'),
(3, 2, 1, 'Menu', 'menu', 'fas fa-fw fa-folder'),
(4, 2, 1, 'Sub Menu', 'sub-menu', 'fas fa-fw fa-folder-open'),
(5, 2, 1, 'Menu Access', 'menu-access', 'fas fa-user-lock'),
(6, 2, 1, 'Sub Menu Access', 'sub-menu-access', 'fas fa-user-lock'),
(8, 4, 1, 'Beranda', 'beranda', 'fa fa-text-width'),
(9, 4, 1, 'Profil', 'profil', 'fa fa-text-width'),
(10, 4, 1, 'Visi Misi', 'visi-misi', 'fa fa-text-width'),
(11, 6, 1, 'Kategori', 'kategori', 'fa fa-list'),
(12, 6, 1, 'List Berita', 'list-berita', 'far fa-newspaper'),
(13, 5, 1, 'Formulir', 'formulir', 'fas fa-file-pdf'),
(14, 5, 1, 'Pendaftaran', 'pendaftaran', 'fa fa-list'),
(15, 5, 1, 'Hasil Seleksi', 'hasil-seleksi', 'fas fa-list'),
(16, 7, 1, 'List Pengumuman', 'list-pengumuman', 'fa fa-bullhorn'),
(17, 4, 1, 'Galeri', 'galeri', 'fas fa-images'),
(18, 5, 1, 'Pembayaran', 'pembayaran', 'fas fa-receipt'),
(19, 5, 1, 'Biaya Pembayaran', 'biaya-pembayaran', 'fas fa-receipt'),
(20, 4, 1, 'Guru', 'guru', 'fa fa-list'),
(21, 4, 1, 'Ekstrakulikuler', 'ekstrakulikuler', 'fa fa-list'),
(22, 4, 1, 'Sejarah', 'sejarah', 'fas fa-history');

-- --------------------------------------------------------

--
-- Struktur dari tabel `visi_misi`
--

CREATE TABLE `visi_misi` (
  `id` int(11) NOT NULL,
  `deskripsi` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `visi_misi`
--

INSERT INTO `visi_misi` (`id`, `deskripsi`) VALUES
(1, '<p>Menjawabi fenomena di atas yang menujukkan karakter pendidikan yang tidak layak dikonsumsi masyarakat karena mencetak generasi muda dari segi jumlah tamatan tanpa memperhatikan kualitas yang mampu bersaing di pasar global, maka sejak tahun 2006 Tim Pengembang Kurikulum SMAK Warta Bakti Kefamenanu menetapkan visi sekolah&nbsp;&nbsp;<em><strong>&ldquo;</strong></em><em>Unggul dalam prestasi, Cerdas&nbsp;&nbsp;berpikir, terampil&nbsp;&nbsp;bekerja, kreatif, inovatif,&nbsp;&nbsp;beriman dan berbudi pekerti luhur&rdquo;.&nbsp;</em>Dengan misi : 1).&nbsp;Mengembangkan iman dan takwa kepada TYME melalui kegiatan keagamaan; 2). Menyelenggarakan kegiatan pembelajaran yang efektif;&nbsp;&nbsp;3). Mengembangkan potensi siswa dalam kegiatan pembelajaran sesuai dengan tuntutan kurikulum; 4). Mengembangkan bakat dan minat siswa melalui kegiatan pengembangan diri. 5).&nbsp;Menciptakan keharmonisan dalam pergaulan, baik di lingkungan sekolah maupun di masyarakat.</p>\r\n\r\n<p>Selain visi dan misi di atas, tujuan sekolah adalah 1). Dihasilkannya lulusan yang berkualitas, dan mampu bersaing minimal di tingkat kabupaten dan mampu melanjutkan ke pendidikan yang lebih tinggi serta menjadi anggota masyarakat yang berkualitas; 2). Terciptanya&nbsp;&nbsp;peserta didik yang memiliki kepribadian&nbsp;&nbsp;terpuji, yang dapat meningkatkan harga diri, keluarga, lembaga, dan masyarakat; 3). Terciptanya peserta didik yang taat menjalankan ibadah sesuai agama dan keyakinannya; 4). Terciptanya suasana yang kondusif di lingkungan keluarga, sekolah, Komite Sekolah, lembaga: masyarakat,&nbsp;&nbsp;Adat,&nbsp;&nbsp;Agama, Pemerintah dan Stakheholder lainnya.&nbsp;</p>\r\n\r\n<p>Untuk mewujudkan visi, misi dan tujuan sekolah di atas, dengan menjaga keseimbangan antara intelency quetion (IQ), emotional quetion (EQ) dan spirituality quetion (SQ) maka&nbsp;&nbsp;sejak semester ganjil tahun ajaran 2011/2012 sampai dengan sekarang ditetapkan program wajib kegiatan ekstra siswa untuk mengembangkan potensi minat dan bakat siswa: 1). Latihan jurnalistik; 2). Latihan penulisan karya ilmiah remaja; 3). Latihan teknik voal dan dirigen; 4). Latihan musik liturgi; 5). Latihan kepemimpinan tingkat dasar dan tingkat lanjut; 6). Lomba drama bahasa Inggris dan drama bahasa Indonesia, lomba debat bahasa Inggris dan drama bahasa Indonesia, lomba lawak, lomba karya tulis ilmiah populer, lomba majalah dinding, lomba pidato, lomba paduan suara; 7). Kegiatan kerohanian; 8). Kegiatan pramuka; 9). Lomba kebersihan; 10). Olah raga prestasi.</p>\r\n');

-- --------------------------------------------------------

--
-- Struktur dari tabel `waktu_pendaftaran`
--

CREATE TABLE `waktu_pendaftaran` (
  `id` int(11) NOT NULL,
  `tgl_buka` datetime NOT NULL,
  `tgl_tutup` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `auth`
--
ALTER TABLE `auth`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `berita`
--
ALTER TABLE `berita`
  ADD PRIMARY KEY (`id_berita`),
  ADD KEY `id_user` (`id_user`),
  ADD KEY `id_kategori` (`id_kategori`);

--
-- Indeks untuk tabel `biaya_pembayaran`
--
ALTER TABLE `biaya_pembayaran`
  ADD PRIMARY KEY (`id_biaya`);

--
-- Indeks untuk tabel `carousel`
--
ALTER TABLE `carousel`
  ADD PRIMARY KEY (`id_carousel`);

--
-- Indeks untuk tabel `ekstrakulikuler`
--
ALTER TABLE `ekstrakulikuler`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `faq`
--
ALTER TABLE `faq`
  ADD PRIMARY KEY (`id_faq`);

--
-- Indeks untuk tabel `formulir`
--
ALTER TABLE `formulir`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `galeri`
--
ALTER TABLE `galeri`
  ADD PRIMARY KEY (`id_galeri`);

--
-- Indeks untuk tabel `guru`
--
ALTER TABLE `guru`
  ADD PRIMARY KEY (`id_guru`);

--
-- Indeks untuk tabel `hasil_seleksi`
--
ALTER TABLE `hasil_seleksi`
  ADD PRIMARY KEY (`id_hasil_seleksi`),
  ADD KEY `hasil_seleksi_ibfk_1` (`id_pendaftaran`);

--
-- Indeks untuk tabel `header`
--
ALTER TABLE `header`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `iklan`
--
ALTER TABLE `iklan`
  ADD PRIMARY KEY (`id_iklan`);

--
-- Indeks untuk tabel `kategori_berita`
--
ALTER TABLE `kategori_berita`
  ADD PRIMARY KEY (`id_kategori`);

--
-- Indeks untuk tabel `komentar`
--
ALTER TABLE `komentar`
  ADD PRIMARY KEY (`id_komentar`),
  ADD KEY `komentar_ibfk_2` (`id_berita`);

--
-- Indeks untuk tabel `kontak`
--
ALTER TABLE `kontak`
  ADD PRIMARY KEY (`id_kontak`);

--
-- Indeks untuk tabel `pembayaran`
--
ALTER TABLE `pembayaran`
  ADD PRIMARY KEY (`id_pembayaran`),
  ADD KEY `pembayaran_ibfk_1` (`id_hasil_seleksi`);

--
-- Indeks untuk tabel `pendaftaran`
--
ALTER TABLE `pendaftaran`
  ADD PRIMARY KEY (`id_pendaftaran`),
  ADD KEY `id_user` (`id_user`);

--
-- Indeks untuk tabel `pengumuman`
--
ALTER TABLE `pengumuman`
  ADD PRIMARY KEY (`id_pengumuman`);

--
-- Indeks untuk tabel `profil`
--
ALTER TABLE `profil`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `sejarah`
--
ALTER TABLE `sejarah`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id_user`),
  ADD KEY `id_role` (`id_role`),
  ADD KEY `id_active` (`id_active`);

--
-- Indeks untuk tabel `user_access_menu`
--
ALTER TABLE `user_access_menu`
  ADD PRIMARY KEY (`id_access_menu`),
  ADD KEY `id_role` (`id_role`),
  ADD KEY `id_menu` (`id_menu`);

--
-- Indeks untuk tabel `user_access_sub_menu`
--
ALTER TABLE `user_access_sub_menu`
  ADD PRIMARY KEY (`id_access_sub_menu`),
  ADD KEY `id_role` (`id_role`),
  ADD KEY `id_sub_menu` (`id_sub_menu`);

--
-- Indeks untuk tabel `user_menu`
--
ALTER TABLE `user_menu`
  ADD PRIMARY KEY (`id_menu`);

--
-- Indeks untuk tabel `user_role`
--
ALTER TABLE `user_role`
  ADD PRIMARY KEY (`id_role`);

--
-- Indeks untuk tabel `user_status`
--
ALTER TABLE `user_status`
  ADD PRIMARY KEY (`id_status`);

--
-- Indeks untuk tabel `user_sub_menu`
--
ALTER TABLE `user_sub_menu`
  ADD PRIMARY KEY (`id_sub_menu`),
  ADD KEY `id_menu` (`id_menu`),
  ADD KEY `id_active` (`id_active`);

--
-- Indeks untuk tabel `visi_misi`
--
ALTER TABLE `visi_misi`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `waktu_pendaftaran`
--
ALTER TABLE `waktu_pendaftaran`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `auth`
--
ALTER TABLE `auth`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `berita`
--
ALTER TABLE `berita`
  MODIFY `id_berita` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT untuk tabel `biaya_pembayaran`
--
ALTER TABLE `biaya_pembayaran`
  MODIFY `id_biaya` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT untuk tabel `carousel`
--
ALTER TABLE `carousel`
  MODIFY `id_carousel` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `ekstrakulikuler`
--
ALTER TABLE `ekstrakulikuler`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `faq`
--
ALTER TABLE `faq`
  MODIFY `id_faq` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT untuk tabel `formulir`
--
ALTER TABLE `formulir`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `galeri`
--
ALTER TABLE `galeri`
  MODIFY `id_galeri` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT untuk tabel `guru`
--
ALTER TABLE `guru`
  MODIFY `id_guru` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `hasil_seleksi`
--
ALTER TABLE `hasil_seleksi`
  MODIFY `id_hasil_seleksi` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT untuk tabel `header`
--
ALTER TABLE `header`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `iklan`
--
ALTER TABLE `iklan`
  MODIFY `id_iklan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `kategori_berita`
--
ALTER TABLE `kategori_berita`
  MODIFY `id_kategori` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT untuk tabel `komentar`
--
ALTER TABLE `komentar`
  MODIFY `id_komentar` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT untuk tabel `kontak`
--
ALTER TABLE `kontak`
  MODIFY `id_kontak` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `pembayaran`
--
ALTER TABLE `pembayaran`
  MODIFY `id_pembayaran` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT untuk tabel `pendaftaran`
--
ALTER TABLE `pendaftaran`
  MODIFY `id_pendaftaran` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT untuk tabel `pengumuman`
--
ALTER TABLE `pengumuman`
  MODIFY `id_pengumuman` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `profil`
--
ALTER TABLE `profil`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `sejarah`
--
ALTER TABLE `sejarah`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `user_access_menu`
--
ALTER TABLE `user_access_menu`
  MODIFY `id_access_menu` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT untuk tabel `user_access_sub_menu`
--
ALTER TABLE `user_access_sub_menu`
  MODIFY `id_access_sub_menu` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT untuk tabel `user_menu`
--
ALTER TABLE `user_menu`
  MODIFY `id_menu` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT untuk tabel `user_role`
--
ALTER TABLE `user_role`
  MODIFY `id_role` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `user_status`
--
ALTER TABLE `user_status`
  MODIFY `id_status` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `user_sub_menu`
--
ALTER TABLE `user_sub_menu`
  MODIFY `id_sub_menu` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT untuk tabel `visi_misi`
--
ALTER TABLE `visi_misi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `waktu_pendaftaran`
--
ALTER TABLE `waktu_pendaftaran`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `berita`
--
ALTER TABLE `berita`
  ADD CONSTRAINT `berita_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `users` (`id_user`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `berita_ibfk_2` FOREIGN KEY (`id_kategori`) REFERENCES `kategori_berita` (`id_kategori`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Ketidakleluasaan untuk tabel `hasil_seleksi`
--
ALTER TABLE `hasil_seleksi`
  ADD CONSTRAINT `hasil_seleksi_ibfk_1` FOREIGN KEY (`id_pendaftaran`) REFERENCES `pendaftaran` (`id_pendaftaran`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `komentar`
--
ALTER TABLE `komentar`
  ADD CONSTRAINT `komentar_ibfk_2` FOREIGN KEY (`id_berita`) REFERENCES `berita` (`id_berita`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `pembayaran`
--
ALTER TABLE `pembayaran`
  ADD CONSTRAINT `pembayaran_ibfk_1` FOREIGN KEY (`id_hasil_seleksi`) REFERENCES `hasil_seleksi` (`id_hasil_seleksi`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `pendaftaran`
--
ALTER TABLE `pendaftaran`
  ADD CONSTRAINT `pendaftaran_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `users` (`id_user`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`id_role`) REFERENCES `user_role` (`id_role`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `users_ibfk_2` FOREIGN KEY (`id_active`) REFERENCES `user_status` (`id_status`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Ketidakleluasaan untuk tabel `user_access_menu`
--
ALTER TABLE `user_access_menu`
  ADD CONSTRAINT `user_access_menu_ibfk_1` FOREIGN KEY (`id_role`) REFERENCES `user_role` (`id_role`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `user_access_menu_ibfk_2` FOREIGN KEY (`id_menu`) REFERENCES `user_menu` (`id_menu`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `user_access_sub_menu`
--
ALTER TABLE `user_access_sub_menu`
  ADD CONSTRAINT `user_access_sub_menu_ibfk_1` FOREIGN KEY (`id_role`) REFERENCES `user_role` (`id_role`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `user_access_sub_menu_ibfk_2` FOREIGN KEY (`id_sub_menu`) REFERENCES `user_sub_menu` (`id_sub_menu`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `user_sub_menu`
--
ALTER TABLE `user_sub_menu`
  ADD CONSTRAINT `user_sub_menu_ibfk_1` FOREIGN KEY (`id_menu`) REFERENCES `user_menu` (`id_menu`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `user_sub_menu_ibfk_2` FOREIGN KEY (`id_active`) REFERENCES `user_status` (`id_status`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
