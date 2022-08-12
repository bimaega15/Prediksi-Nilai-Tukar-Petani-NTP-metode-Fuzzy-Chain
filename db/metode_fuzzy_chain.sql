-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 12 Agu 2022 pada 09.54
-- Versi server: 10.4.20-MariaDB
-- Versi PHP: 7.4.22

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `metode_fuzzy_chain`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `data_penerapan`
--

CREATE TABLE `data_penerapan` (
  `id_data_penerapan` int(11) NOT NULL,
  `tanggal` varchar(50) NOT NULL,
  `ntp` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `data_penerapan`
--

INSERT INTO `data_penerapan` (`id_data_penerapan`, `tanggal`, `ntp`) VALUES
(1, '12-2018', 103.26),
(2, '01-2019', 102.67),
(3, '02-2019', 103.3),
(4, '03-2019', 101.79),
(5, '04-2019', 101.58),
(6, '05-2019', 100.99),
(7, '06-2019', 100.52),
(8, '07-2019', 99.69),
(9, '08-2019', 99.7),
(10, '09-2019', 99.51),
(11, '10-2019', 100.68),
(12, '11-2019', 100.48),
(13, '12-2019', 96.13),
(14, '01-2020', 95.16),
(15, '02-2020', 94.81),
(16, '03-2020', 92.34),
(17, '04-2020', 93.47),
(18, '05-2020', 92.84),
(19, '06-2020', 93.05),
(20, '07-2020', 94.13),
(21, '08-2020', 93.61),
(22, '09-2020', 93.68),
(23, '10-2020', 93.64),
(24, '11-2020', 93.15),
(25, '12-2020', 92.94),
(26, '01-2021', 91.89),
(27, '02-2021', 91.43),
(28, '03-2021', 91.13),
(29, '04-2021', 91.95),
(30, '05-2021', 91.79),
(31, '06-2021', 91.18),
(32, '07-2021', 91.13),
(33, '08-2021', 90.5),
(34, '09-2021', 90.74),
(35, '10-2021', 90.32);

-- --------------------------------------------------------

--
-- Struktur dari tabel `konfigurasi`
--

CREATE TABLE `konfigurasi` (
  `id_konfigurasi` int(11) NOT NULL,
  `nama_aplikasi` varchar(300) NOT NULL,
  `keterangan` text NOT NULL,
  `gambar_konfigurasi` varchar(300) NOT NULL,
  `created_by` varchar(300) NOT NULL,
  `facebook` varchar(300) DEFAULT NULL,
  `instagram` varchar(300) DEFAULT NULL,
  `youtube` varchar(300) DEFAULT NULL,
  `email` varchar(150) NOT NULL,
  `alamat` text DEFAULT NULL,
  `no_hp` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `konfigurasi`
--

INSERT INTO `konfigurasi` (`id_konfigurasi`, `nama_aplikasi`, `keterangan`, `gambar_konfigurasi`, `created_by`, `facebook`, `instagram`, `youtube`, `email`, `alamat`, `no_hp`) VALUES
(1, 'Fuzzy Chain', 'Keterangan', '568161642593407logo-hres.png', 'Fullstack Developer', 'bimaegafacebook.com', 'bimaegaig.com', 'bimaega15.com', 'S.Pakar CF@gmail.com', 'S.Pakar CF', '0832983232');

-- --------------------------------------------------------

--
-- Struktur dari tabel `profile`
--

CREATE TABLE `profile` (
  `id_profile` int(11) NOT NULL,
  `nama_profile` varchar(200) NOT NULL,
  `jenis_kelamin` enum('L','P') NOT NULL,
  `no_hp` varchar(50) NOT NULL,
  `alamat` text NOT NULL,
  `gambar_profile` varchar(200) DEFAULT NULL,
  `users_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `profile`
--

INSERT INTO `profile` (`id_profile`, `nama_profile`, `jenis_kelamin`, `no_hp`, `alamat`, `gambar_profile`, `users_id`) VALUES
(1, 'Arnil Admin Master', 'L', '083829323', 'alamat bima', '167291642587346touchIcon.png', 1),
(2, 'Bima Ega', 'L', '092389832798', 'Alamat userbima123', '200351642871465erd-rs1.jpg', 2),
(3, 'userbima124', 'L', '02839828', 'alamat userbima124', '856471642871554erd-rs1.jpg', 3),
(4, 'Super admin', 'L', '08329832923', 'alamat super admin bro', '560861642871560erd-rs1.jpg', 4),
(5, 'Admin Bima', 'L', '08238942832', 'Alamat admin bima', '850731642871662erd-rs1.jpg', 5),
(6, 'Nama admin12345', 'P', '083294728', 'JL. medan', '324721642910751erd-rs1.jpg', 6);

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id_users` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(200) NOT NULL,
  `level` enum('admin','super admin','user') NOT NULL,
  `cookie` varchar(200) NOT NULL,
  `forgot` enum('iya','tidak') NOT NULL DEFAULT 'tidak'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id_users`, `username`, `password`, `level`, `cookie`, `forgot`) VALUES
(1, 'admin123', '0192023a7bbd73250516f069df18b500', 'admin', '240be518fabd2724ddb6f04eeb1da5967448d7e831c08c8fa822809f74c720a9', 'tidak'),
(2, 'userbima123', '0927608b5e2ebb45033f0d3ae0dc7570', 'admin', '24d710c4cb194c7e2c3728d0ca0775b2a5785089c8b80c8ba34fdc931f66f0a6', 'tidak'),
(3, 'userbima124', 'd99a434c4067f237dff29fcda38a3a99', 'admin', '6d6603119fb8b05598a18f2cb28b56761caf5a86c8c9a8d240978ad56201cf0f', 'tidak'),
(4, 'superadmin123', 'ac497cfaba23c4184cb03b97e8c51e0a', 'admin', '', 'tidak'),
(5, 'adminbima', '10288bbb28a71d7c43ebc052b14a5f97', 'admin', '', 'tidak'),
(6, 'admin12345', '7488e331b8b64e5794da3fa4eb10ad5d', 'admin', '', 'tidak');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `data_penerapan`
--
ALTER TABLE `data_penerapan`
  ADD PRIMARY KEY (`id_data_penerapan`);

--
-- Indeks untuk tabel `konfigurasi`
--
ALTER TABLE `konfigurasi`
  ADD PRIMARY KEY (`id_konfigurasi`);

--
-- Indeks untuk tabel `profile`
--
ALTER TABLE `profile`
  ADD PRIMARY KEY (`id_profile`),
  ADD KEY `users_id` (`users_id`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id_users`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `data_penerapan`
--
ALTER TABLE `data_penerapan`
  MODIFY `id_data_penerapan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT untuk tabel `konfigurasi`
--
ALTER TABLE `konfigurasi`
  MODIFY `id_konfigurasi` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `profile`
--
ALTER TABLE `profile`
  MODIFY `id_profile` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id_users` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `profile`
--
ALTER TABLE `profile`
  ADD CONSTRAINT `profile_ibfk_1` FOREIGN KEY (`users_id`) REFERENCES `users` (`id_users`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
