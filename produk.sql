-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 06, 2025 at 04:25 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `produk`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(9) NOT NULL,
  `name_admin` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `name_admin`, `email`, `password`) VALUES
(1, 'Admin Maulana', 'admin-maulana@gmail.com', 'admin-maulana');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(9) NOT NULL,
  `user_id` int(9) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `quantity` int(4) DEFAULT NULL,
  `order_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` enum('sudah','belum') NOT NULL DEFAULT 'belum',
  `payment_status` varchar(20) DEFAULT 'pending',
  `midtrans_order_id` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `product_id`, `quantity`, `order_date`, `status`, `payment_status`, `midtrans_order_id`) VALUES
(1, 3, 131313, 2, '2024-07-05 18:42:27', 'belum', 'success', NULL),
(2, 3, 271172398, 4, '2024-07-05 18:42:27', 'belum', 'pending', NULL),
(3, 3, 271172398, 4, '2024-07-05 18:42:41', 'belum', 'pending', NULL),
(4, 3, 12213, 2, '2024-07-05 18:47:38', 'belum', 'pending', NULL),
(5, 3, 102990, 4, '2024-07-05 18:47:38', 'belum', 'pending', NULL),
(6, 3, 12213, 2, '2024-07-05 18:47:47', 'belum', 'pending', NULL),
(7, 3, 3, 2, '2024-07-05 18:48:32', 'belum', 'pending', NULL),
(8, 3, 212, 2, '2024-07-05 18:48:32', 'belum', 'pending', NULL),
(9, 3, 212, 2, '2024-07-05 18:48:41', 'belum', 'pending', NULL),
(10, 3, 1212, 3, '2024-07-05 18:50:31', 'belum', 'pending', NULL),
(11, 3, 12213, 3, '2024-07-05 18:50:31', 'belum', 'pending', NULL),
(12, 3, 12213, 3, '2024-07-05 18:50:38', 'belum', 'pending', NULL),
(13, 3, 212, 3, '2024-07-05 18:57:44', 'belum', 'pending', NULL),
(14, 3, 102990, 2, '2024-07-05 18:57:44', 'belum', 'pending', NULL),
(15, 3, 212, 3, '2024-07-05 18:57:49', 'belum', 'pending', NULL),
(16, 3, 131313, 2, '2024-07-05 18:58:46', 'belum', 'pending', NULL),
(17, 3, 271172398, 3, '2024-07-05 18:58:46', 'belum', 'pending', NULL),
(18, 3, 131313, 2, '2024-07-05 18:58:59', 'belum', 'pending', NULL),
(19, 3, 131313, 2, '2024-07-05 18:59:14', 'belum', 'pending', NULL),
(20, 3, 271172398, 1, '2024-07-05 18:59:14', 'belum', 'pending', NULL),
(21, 3, 271172398, 1, '2024-07-05 18:59:19', 'belum', 'pending', NULL),
(22, 3, 102990, 4, '2024-07-05 18:59:46', 'belum', 'pending', NULL),
(23, 3, 131313, 4, '2024-07-05 18:59:46', 'belum', 'pending', NULL),
(24, 3, 102990, 4, '2024-07-05 18:59:53', 'belum', 'pending', NULL),
(25, 3, 102990, 1, '2024-07-05 19:00:53', 'belum', 'pending', NULL),
(26, 3, 1212, 2, '2024-07-05 19:01:24', 'belum', 'pending', NULL),
(27, 3, 102990, 5, '2024-07-05 19:01:24', 'belum', 'pending', NULL),
(28, 1, 1, 3, '2024-07-05 19:03:34', 'belum', 'pending', NULL),
(29, 1, 2, 3, '2024-07-05 19:03:34', 'belum', 'pending', NULL),
(30, 3, 1212, 2, '2024-07-05 19:06:05', 'belum', 'pending', NULL),
(31, 3, 12213, 2, '2024-07-05 19:06:05', 'belum', 'pending', NULL),
(32, 3, 12213, 2, '2024-07-05 19:06:09', 'belum', 'pending', NULL),
(33, 3, 1, 1, '2024-07-05 19:07:08', 'belum', 'pending', NULL),
(34, 3, 2, 1, '2024-07-05 19:07:08', 'belum', 'pending', NULL),
(35, 3, 131313, 1, '2024-07-05 19:09:07', 'belum', 'pending', NULL),
(36, 3, 1212, 2, '2024-07-05 20:11:32', 'belum', 'pending', NULL),
(37, 3, 12213, 2, '2024-07-05 20:11:32', 'belum', 'pending', NULL),
(38, 3, 3, 1, '2024-07-05 20:12:04', 'belum', 'pending', NULL),
(39, 3, 212, 1, '2024-07-05 20:12:04', 'belum', 'pending', NULL),
(40, 3, 1, 1, '2024-07-07 09:45:01', 'belum', 'pending', NULL),
(41, 1, 1212, 1, '2024-07-07 11:29:02', 'belum', 'pending', NULL),
(42, 1, 1290921, 1, '2024-07-07 11:36:22', 'belum', 'pending', NULL),
(43, 1, 1, 2, '2024-07-07 14:10:43', 'sudah', 'pending', NULL),
(44, 1, 2, 1, '2024-07-07 14:10:43', 'belum', 'pending', NULL),
(45, 3, 1, 2, '2024-07-10 02:02:09', 'belum', 'pending', NULL),
(46, 3, 2, 2, '2024-07-10 02:02:09', 'belum', 'pending', NULL),
(47, 3, 3, 2, '2024-07-10 02:02:09', 'belum', 'pending', NULL),
(48, 3, 1, 2, '2024-07-10 02:04:35', 'belum', 'pending', NULL),
(49, 3, 2, 2, '2024-07-10 02:04:35', 'belum', 'pending', NULL),
(50, 3, 3, 2, '2024-07-10 02:04:35', 'belum', 'pending', NULL),
(51, 1, 1, 3, '2024-07-16 13:22:10', 'belum', 'pending', NULL),
(52, 1, 2, 2, '2024-07-16 13:22:10', 'belum', 'pending', NULL),
(53, 1, 3, 2, '2024-07-16 13:22:10', 'belum', 'pending', NULL),
(54, 3, 1, 2, '2024-08-13 17:49:42', 'belum', 'pending', NULL),
(55, 3, 2, 2, '2024-08-13 17:49:42', 'belum', 'pending', NULL),
(56, 3, NULL, NULL, '2024-08-13 13:11:52', 'belum', 'pending', NULL),
(57, 3, NULL, NULL, '2024-08-13 13:11:54', 'belum', 'pending', NULL),
(58, 3, NULL, NULL, '2024-08-13 13:12:04', 'belum', 'pending', NULL),
(59, 3, NULL, NULL, '2024-08-13 13:12:04', 'belum', 'pending', NULL),
(60, 3, 2, 1, '2024-08-13 18:13:21', 'belum', 'pending', NULL),
(61, 3, 3, 1, '2024-08-13 18:13:21', 'belum', 'pending', NULL),
(62, 3, NULL, NULL, '2024-08-13 13:16:11', 'belum', 'pending', NULL),
(63, 3, NULL, NULL, '2024-08-13 13:16:11', 'belum', 'pending', NULL),
(64, 3, 3, 2, '2024-08-13 18:22:12', 'belum', 'pending', NULL),
(65, 3, 271172398, 3, '2024-08-13 18:24:36', 'belum', 'pending', NULL),
(66, 3, 131313, 1, '2024-08-13 18:28:03', 'belum', 'pending', NULL),
(67, 3, 271172398, 2, '2024-08-13 18:28:21', 'belum', 'pending', NULL),
(68, 3, 271172398, 1, '2024-08-13 18:30:53', 'belum', 'pending', NULL),
(69, 3, 131313, 2, '2024-08-13 19:15:00', 'belum', 'pending', NULL),
(70, 3, 271172398, 2, '2024-08-13 19:15:00', 'belum', 'pending', NULL),
(71, 3, 2, 1, '2024-08-13 19:19:23', 'belum', 'pending', NULL),
(72, 3, 1, 1, '2024-08-13 19:29:44', 'belum', 'pending', NULL),
(73, 3, 2, 1, '2024-08-13 19:29:44', 'belum', 'pending', NULL),
(74, 3, 222, 3, '2024-08-13 19:33:30', 'belum', 'pending', NULL),
(75, 3, 131313, 1, '2024-08-13 19:39:50', 'belum', 'pending', NULL),
(76, 3, 271172398, 1, '2024-08-13 19:39:50', 'belum', 'pending', NULL),
(77, 3, 1212, 1, '2024-08-13 19:46:05', 'belum', 'pending', NULL),
(78, 3, 3, 1, '2024-08-13 20:01:45', 'belum', 'pending', '1518792931'),
(79, 3, 2, 1, '2024-08-13 20:07:16', 'belum', 'pending', '87212381'),
(80, 3, 212, 1, '2024-08-13 20:07:16', 'belum', 'pending', '87212381'),
(81, 3, 212, 1, '2024-08-13 20:16:19', 'belum', 'pending', '260040549'),
(82, 3, 3, 1, '2024-08-13 20:17:22', 'belum', 'pending', '1100596480'),
(83, 3, 212, 1, '2024-08-13 20:47:33', 'belum', 'pending', '687316354'),
(84, 3, 212, 2, '2024-08-13 21:09:55', 'belum', 'failure', '66bbcba349df2'),
(85, 3, 212, 1, '2024-08-13 21:10:19', 'belum', 'failure', '66bbcbbbba5b1'),
(86, 3, 212, 2, '2024-08-13 21:10:51', 'belum', 'failure', '66bbcbdb5ed34'),
(87, 3, 1, 1, '2024-08-13 21:47:32', 'belum', 'pending', '0d3146c7-2a67-4351-9'),
(88, 3, 1212, 1, '2024-08-13 21:47:32', 'belum', 'pending', '0d3146c7-2a67-4351-9'),
(89, 3, 1212, 1, '2024-08-13 21:52:05', 'belum', 'failure', '66bbd58522c56'),
(90, 3, 3, 2, '2024-08-13 21:54:29', 'belum', 'failure', '66bbd61512009'),
(91, 3, 212, 2, '2024-08-13 21:54:29', 'belum', 'failure', '66bbd61512009'),
(92, 3, 1, 1, '2024-08-13 22:00:29', 'belum', 'failure', '66bbd77d66b59'),
(93, 3, 131313, 1, '2024-08-13 22:05:45', 'belum', 'failure', '66bbd8b964e35'),
(94, 3, 1212, 1, '2024-08-13 22:10:12', 'belum', 'failure', '66bbd9c471295'),
(95, 1, 1, 2, '2024-08-13 22:14:25', 'belum', 'failure', '66bbdac1065dd'),
(96, 1, 2, 2, '2024-08-13 22:14:25', 'belum', 'failure', '66bbdac1065dd'),
(97, 1, 1, 3, '2024-08-13 22:16:10', 'belum', 'failure', '66bbdb2af2d67'),
(98, 1, 12213, 1, '2024-08-13 22:22:23', 'belum', 'success', '66bbdc9fc4284'),
(99, 1, 1, 2, '2024-08-13 22:24:19', 'belum', 'failure', '66bbdd13eab19'),
(100, 1, 212, 2, '2024-08-13 22:24:19', 'belum', 'failure', '66bbdd13eab19'),
(101, 3, 212, 2, '2024-08-15 17:41:07', 'belum', 'pending', '66be3db3ac61e'),
(102, 3, 102990, 1, '2024-08-15 17:41:07', 'belum', 'pending', '66be3db3ac61e'),
(103, 1, 1, 1, '2024-08-15 18:04:40', 'belum', 'success', '66be4338375fd'),
(104, 1, 2, 1, '2024-08-15 18:04:40', 'belum', 'success', '66be4338375fd'),
(105, 3, 12213, 1, '2024-08-15 18:05:21', 'belum', 'success', '66be43619ec01'),
(106, 3, 102990, 2, '2024-08-15 18:05:21', 'belum', 'success', '66be43619ec01'),
(107, 1, 131313, 1, '2024-08-15 18:06:51', 'belum', 'success', '66be43bb8fc33'),
(108, 1, 271172398, 1, '2024-08-15 18:06:51', 'belum', 'success', '66be43bb8fc33'),
(109, 3, 1, 1, '2024-08-15 18:08:35', 'belum', 'success', '66be4423535f7'),
(110, 1, 131313, 1, '2024-08-15 18:10:03', 'belum', 'pending', '66be447b00c12'),
(111, 1, 222, 1, '2024-08-15 18:24:07', 'belum', 'success', '66be47c7313b5'),
(112, 1, 1, 2, '2024-09-11 15:27:27', 'belum', 'pending', '66e1b6df3b22a'),
(113, 1, 2, 2, '2024-09-11 15:27:27', 'belum', 'pending', '66e1b6df3b22a'),
(114, 1, 3, 2, '2024-09-11 15:27:27', 'belum', 'pending', '66e1b6df3b22a');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `stock` int(4) NOT NULL,
  `price` int(7) NOT NULL,
  `purchase_price` int(7) NOT NULL,
  `image` varchar(50) NOT NULL,
  `special` tinyint(1) NOT NULL,
  `nodiscount` int(7) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `stock`, `price`, `purchase_price`, `image`, `special`, `nodiscount`) VALUES
(1, 'Beras Rojo Lele (1 Liter)', 45, 14000, 13000, 'img/menu/beras.jpg', 0, 0),
(2, 'Minyak Sania (1 Liter)', 40, 17500, 15500, 'img/menu/minyak.jpg', 0, 0),
(3, 'Gula Gulaku (1 Kg)', 50, 18000, 17000, 'img/menu/gula.jpg', 0, 0),
(100, 'Rokok Sampoerna Mild 16', 100, 25000, 22000, 'img/product/mild16.png', 1, 30000),
(212, 'Susu Frisian Flag - Putih (1 renceng)', 200, 9000, 7500, 'img/menu/susu.jpg', 0, 0),
(222, 'Telur (1 Kg)', 50, 29000, 27000, 'img/menu/telur.jpg', 0, 0),
(1212, 'Garam (1 Kg)', 100, 15000, 13300, 'img/menu/garam.jpg', 0, 0),
(12213, 'Gas Elpiji (3 Kg)', 200, 15000, 13000, 'img/menu/gas.jpeg', 0, 0),
(102990, 'Teh Bubuk Sosro', 90, 6000, 4500, 'img/menu/teh.jpg', 0, 0),
(131313, 'Air Mineral Aqua (1 Botol)', 600, 5000, 3500, 'img/menu/aqua.jpg', 0, 0),
(1290921, 'Rokok Gudang Garam Filter', 200, 24500, 20500, 'img/product/gudanggaram.png', 1, 30000),
(7986857, 'Rokok Dji Sam Soe', 300, 20000, 18000, 'img/product/djisamsoe.jpg', 1, 24000),
(72678436, 'Rokok Djarum Super', 200, 24000, 20000, 'img/product/super.jpg', 1, 29000),
(271172398, 'Kopi Kapal Api (1 Renceng)', 170, 18000, 15000, 'img/menu/kopi.png', 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(9) NOT NULL,
  `full_name` varchar(50) NOT NULL,
  `phone_number` varchar(15) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `address` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `full_name`, `phone_number`, `email`, `password`, `address`) VALUES
(1, 'maulana', '087', 'maulana@gmail.com', '$2y$10$YYKrmTvbL5yQaHk41UXvXOdi8zoHe5oSaLZnE/G.VHs', 'jalan semanan raya'),
(3, 'ulyad', '000', 'ulyadbaim@gmail.com', '$2y$10$XvqUVV8zkC/9Gzfejpr05eBbz0vJ5wPGvGmgTMEiITm', 'semanan'),
(4, 'panjul', '000', 'panjul@gmail.com', '$2y$10$mOhJb.rvdjZ0jLSu8gZgn.g3iaL6NNCIk37BZACsiG3', 'dimana saja');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(9) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(9) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=115;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(9) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `orders_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
