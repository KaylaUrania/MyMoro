-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 14 Okt 2025 pada 05.24
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
-- Database: `db_mymoro`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_barang`
--

CREATE TABLE `tbl_barang` (
  `id_barang` varchar(100) NOT NULL,
  `barcode` varchar(20) NOT NULL,
  `nama_barang` varchar(100) NOT NULL,
  `harga_beli` int(11) NOT NULL,
  `harga_jual` int(11) NOT NULL,
  `satuan` varchar(20) NOT NULL,
  `stock_minimal` int(11) NOT NULL,
  `gambar` varchar(100) NOT NULL,
  `stock` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data untuk tabel `tbl_barang`
--

INSERT INTO `tbl_barang` (`id_barang`, `barcode`, `nama_barang`, `harga_beli`, `harga_jual`, `satuan`, `stock_minimal`, `gambar`, `stock`) VALUES
('BRG-003', '8991976136393', 'Saos Nasional (Percobaan)', 500, 1500, 'pack', 10, 'BRG-003.jpeg', 14),
('BRG-004', '9786233286473', 'Buku IPAS', 90000, 150000, 'piece', 5, 'BRG-004.jpg', 13);

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_beli_detail`
--

CREATE TABLE `tbl_beli_detail` (
  `id` int(11) NOT NULL,
  `no_beli` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `tgl_beli` date NOT NULL,
  `kode_brg` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `nama_brg` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `qty` int(11) NOT NULL,
  `harga_beli` int(11) NOT NULL,
  `jml_harga` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data untuk tabel `tbl_beli_detail`
--

INSERT INTO `tbl_beli_detail` (`id`, `no_beli`, `tgl_beli`, `kode_brg`, `nama_brg`, `qty`, `harga_beli`, `jml_harga`) VALUES
(28, 'PB0001', '2025-09-11', 'BRG-001', 'Botol Susu Philips ', 15, 30000, 450000),
(29, 'PB0001', '2025-09-11', 'BRG-002', 'Baju Bayi', 15, 80000, 1200000),
(30, 'PB0002', '2025-09-11', 'BRG-003', 'Saos Nasional (Percobaan)', 15, 500, 7500),
(31, 'PB0003', '2025-09-12', 'BRG-004', 'Buku IPAS', 10, 90000, 900000),
(32, 'PB0004', '2025-09-24', 'BRG-004', 'Buku IPAS', 2, 90000, 180000),
(34, 'PB0005', '2025-09-29', 'BRG-003', 'Saos Nasional (Percobaan)', 10, 500, 5000),
(35, 'PB0006', '2025-09-30', 'BRG-003', 'Saos Nasional (Percobaan)', 1, 500, 500),
(36, 'PB0007', '2025-09-30', 'BRG-003', 'Saos Nasional (Percobaan)', 1, 500, 500),
(37, 'PB0008', '2025-09-30', 'BRG-003', 'Saos Nasional (Percobaan)', 5, 500, 2500),
(38, 'PB0009', '2025-09-30', 'BRG-004', 'Buku IPAS', 10, 90000, 900000);

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_beli_head`
--

CREATE TABLE `tbl_beli_head` (
  `no_beli` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `tgl_beli` date NOT NULL,
  `supplier` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `total` int(11) NOT NULL,
  `keterangan` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data untuk tabel `tbl_beli_head`
--

INSERT INTO `tbl_beli_head` (`no_beli`, `tgl_beli`, `supplier`, `total`, `keterangan`) VALUES
('PB0001', '2025-09-11', 'PT Mensa', 1650000, ''),
('PB0002', '2025-09-11', 'PT Nunul Sejaterah', 7500, ''),
('PB0003', '2025-09-12', 'PT Nunul Sejaterah', 900000, ''),
('PB0004', '2025-09-24', 'PT Nunul Sejaterah', 180000, ''),
('PB0005', '2025-09-29', 'PT Nunul Sejaterah', 5000, ''),
('PB0006', '2025-09-30', 'PT Nunul Sejaterah', 500, ''),
('PB0007', '2025-09-30', '', 500, ''),
('PB0008', '2025-09-30', 'kayla', 2500, ''),
('PB0009', '2025-09-30', 'PT Mensa', 900000, '');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_customer`
--

CREATE TABLE `tbl_customer` (
  `id_customer` int(11) NOT NULL,
  `nama` varchar(256) NOT NULL,
  `telpon` varchar(25) NOT NULL,
  `deskripsi` varchar(256) NOT NULL,
  `alamat` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data untuk tabel `tbl_customer`
--

INSERT INTO `tbl_customer` (`id_customer`, `nama`, `telpon`, `deskripsi`, `alamat`) VALUES
(2, 'General', '00000', 'Pengunjung', '--'),
(5, 'Other Customer', '000000', 'Lain lain', '--'),
(8, 'Pak Yusuf', '098721241241542', 'Pengunjung Tetap', 'mauk');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_jual_detail`
--

CREATE TABLE `tbl_jual_detail` (
  `id` int(11) NOT NULL,
  `no_jual` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `tgl_jual` date NOT NULL,
  `barcode` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `nama_brg` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `qty` int(11) NOT NULL,
  `harga_jual` int(11) NOT NULL,
  `jml_harga` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data untuk tabel `tbl_jual_detail`
--

INSERT INTO `tbl_jual_detail` (`id`, `no_jual`, `tgl_jual`, `barcode`, `nama_brg`, `qty`, `harga_jual`, `jml_harga`) VALUES
(27, 'PJ0001', '2025-09-12', '9786233286473', 'Buku IPAS', 1, 150000, 150000),
(28, 'PJ0002', '2025-09-22', '9786233286473', 'Buku IPAS', 1, 150000, 150000),
(29, 'PJ0003', '2025-09-22', '8991976136393', 'Saos Nasional (Percobaan)', 3, 1500, 4500),
(30, 'PJ0004', '2025-09-24', '8991976136393', 'Saos Nasional (Percobaan)', 5, 1500, 7500),
(31, 'PJ0005', '2025-09-29', '9786233286473', 'Buku IPAS', 2, 150000, 300000),
(32, 'PJ0005', '2025-09-29', '8991976136393', 'Saos Nasional (Percobaan)', 3, 1500, 4500),
(33, 'PJ0006', '2025-09-30', '8991976136393', 'Saos Nasional (Percobaan)', 2, 1500, 3000),
(34, 'PJ0007', '2025-09-30', '9786233286473', 'Buku IPAS', 5, 150000, 750000);

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_jual_head`
--

CREATE TABLE `tbl_jual_head` (
  `no_jual` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `tgl_jual` date NOT NULL,
  `customer` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `total` int(11) NOT NULL,
  `keterangan` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `jml_bayar` int(11) NOT NULL,
  `kembalian` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data untuk tabel `tbl_jual_head`
--

INSERT INTO `tbl_jual_head` (`no_jual`, `tgl_jual`, `customer`, `total`, `keterangan`, `jml_bayar`, `kembalian`) VALUES
('PJ0001', '2025-09-12', 'Umum', 150000, '', 150000, 0),
('PJ0002', '2025-09-22', 'Umum', 150000, '', 150000, 0),
('PJ0003', '2025-09-22', 'Umum', 4500, '', 5000, 500),
('PJ0004', '2025-09-24', 'Umum', 7500, '', 8000, 500),
('PJ0005', '2025-09-29', 'General', 304500, '', 305000, 500),
('PJ0006', '2025-09-30', 'Pak Yusuf', 3000, '', 5000, 2000),
('PJ0007', '2025-09-30', 'General', 750000, '', 800000, 50000);

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_supplier`
--

CREATE TABLE `tbl_supplier` (
  `id_supplier` int(11) NOT NULL,
  `nama` varchar(256) NOT NULL,
  `telpon` varchar(25) NOT NULL,
  `deskripsi` varchar(256) NOT NULL,
  `alamat` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data untuk tabel `tbl_supplier`
--

INSERT INTO `tbl_supplier` (`id_supplier`, `nama`, `telpon`, `deskripsi`, `alamat`) VALUES
(1, 'PT Mensa', '02722333', 'Distributor Barang', 'Jl. Raya Mauk Barat'),
(14, 'PT Nunul Sejaterah', '0210000', 'Distributor Kosmetik', 'Jl. Raya Karawaci');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_user`
--

CREATE TABLE `tbl_user` (
  `userid` int(11) NOT NULL,
  `username` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `fullname` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `password` varchar(256) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `address` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `level` int(1) NOT NULL COMMENT '1-administrator \r\n2-operator',
  `foto` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data untuk tabel `tbl_user`
--

INSERT INTO `tbl_user` (`userid`, `username`, `fullname`, `password`, `address`, `level`, `foto`) VALUES
(7, 'kayla', 'Kayla Urania', '$2y$10$x938AkIJgKj11.r1EGAGwu3BWbyAzPxJrN1eQtWz9AuDHBfaG5STu', 'Jl . Rajeg Mulya', 1, '968-yaa.png'),
(11, 'kaylala', 'kayla suci', '$2y$10$Hj8Wk6FLBOXLjqiEgZnMBOK4avyrKHK5SX2zUC7UeQ0X8mJB/94jC', 'Jl. Ps Kemis', 2, 'pp.jpg'),
(13, 'pak hari', 'Hari Mulia', '$2y$10$V1mci.RvB6buOcXMsU7rROGUtBmRWJU6sVvivgiTTFy2R8vJP47iy', 'Mauk', 2, '485-jeruk.jpeg');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `tbl_barang`
--
ALTER TABLE `tbl_barang`
  ADD PRIMARY KEY (`id_barang`);

--
-- Indeks untuk tabel `tbl_beli_detail`
--
ALTER TABLE `tbl_beli_detail`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `tbl_beli_head`
--
ALTER TABLE `tbl_beli_head`
  ADD PRIMARY KEY (`no_beli`);

--
-- Indeks untuk tabel `tbl_customer`
--
ALTER TABLE `tbl_customer`
  ADD PRIMARY KEY (`id_customer`);

--
-- Indeks untuk tabel `tbl_jual_detail`
--
ALTER TABLE `tbl_jual_detail`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `tbl_jual_head`
--
ALTER TABLE `tbl_jual_head`
  ADD PRIMARY KEY (`no_jual`);

--
-- Indeks untuk tabel `tbl_supplier`
--
ALTER TABLE `tbl_supplier`
  ADD PRIMARY KEY (`id_supplier`);

--
-- Indeks untuk tabel `tbl_user`
--
ALTER TABLE `tbl_user`
  ADD PRIMARY KEY (`userid`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `tbl_beli_detail`
--
ALTER TABLE `tbl_beli_detail`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT untuk tabel `tbl_customer`
--
ALTER TABLE `tbl_customer`
  MODIFY `id_customer` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT untuk tabel `tbl_jual_detail`
--
ALTER TABLE `tbl_jual_detail`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT untuk tabel `tbl_supplier`
--
ALTER TABLE `tbl_supplier`
  MODIFY `id_supplier` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT untuk tabel `tbl_user`
--
ALTER TABLE `tbl_user`
  MODIFY `userid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
