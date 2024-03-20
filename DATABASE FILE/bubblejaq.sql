-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 20, 2023 at 11:03 AM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `bubblejaq`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) UNSIGNED NOT NULL,
  `name` varchar(60) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`) VALUES
(3, 'Classic Milkshake'),
(1, 'Fruit Soda'),
(2, 'Fruitea'),
(8, 'Iced Coffee'),
(4, 'Milktea'),
(5, 'Special Milkshake'),
(6, 'Yakult');

-- --------------------------------------------------------

--
-- Table structure for table `item`
--

CREATE TABLE `item` (
  `id` int(11) NOT NULL,
  `common_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `item`
--

INSERT INTO `item` (`id`, `common_id`) VALUES
(1, 1),
(2, 2),
(3, 3),
(4, 4),
(5, 5),
(6, 6),
(7, 7),
(17, 248883);

-- --------------------------------------------------------

--
-- Table structure for table `logs`
--

CREATE TABLE `logs` (
  `id` int(11) NOT NULL,
  `content` text NOT NULL,
  `user` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `logs`
--

INSERT INTO `logs` (`id`, `content`, `user`, `created_at`) VALUES
(1, 'he/she updated the user of Natie Williams', 1, '2023-09-20 12:13:44'),
(2, 'he/she updated the product of Vanilla Shake', 1, '2023-09-21 11:33:04'),
(3, 'he/she updated the product of Yema Milkshake', 1, '2023-09-21 11:33:19'),
(4, 'he/she updated the product of Green  Tea Shake', 1, '2023-09-21 11:33:30'),
(5, 'he/she updated the product of Oreo Milkshake', 1, '2023-09-30 01:01:43'),
(6, 'he/she updated the product of Oreo Milkshake', 1, '2023-09-30 01:01:44'),
(7, 'he/she updated the product of Oreo Milkshake', 1, '2023-09-30 01:02:02');

-- --------------------------------------------------------

--
-- Table structure for table `media`
--

CREATE TABLE `media` (
  `id` int(11) UNSIGNED NOT NULL,
  `file_name` varchar(255) NOT NULL,
  `file_type` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) UNSIGNED NOT NULL,
  `common_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `quantity` varchar(50) DEFAULT NULL,
  `buy_price` decimal(25,2) DEFAULT NULL,
  `sale_price` decimal(25,2) NOT NULL,
  `categorie_id` int(11) UNSIGNED NOT NULL,
  `item_size` varchar(255) DEFAULT NULL,
  `media_id` int(11) DEFAULT 0,
  `picture` varchar(255) NOT NULL,
  `date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `common_id`, `name`, `quantity`, `buy_price`, `sale_price`, `categorie_id`, `item_size`, `media_id`, `picture`, `date`) VALUES
(122, 1, 'Oreo Milkshake', '100', '30.00', '50.00', 3, 'S', 0, '353167364_233797219439753_55700718211874755_n.jpg', '2023-07-21 10:02:32'),
(123, 1, 'Oreo Milkshake', '100', '50.00', '70.00', 3, 'M', 0, '353167364_233797219439753_55700718211874755_n.jpg', '2023-07-21 10:02:32'),
(124, 1, 'Oreo Milkshake', '100', '70.00', '100.00', 3, 'L', 0, '353167364_233797219439753_55700718211874755_n.jpg', '2023-07-21 10:02:32'),
(125, 1, 'Oreo Milkshake', '100', '100.00', '150.00', 3, 'XL', 0, '353167364_233797219439753_55700718211874755_n.jpg', '2023-07-21 10:02:32'),
(126, 2, 'Chocolate Shake', '100', '30.00', '50.00', 1, 'S', 0, '353692139_9953624454655162_3758447135817497623_n.jpg', '2023-07-21 10:02:57'),
(127, 2, 'Chocolate Shake', '100', '50.00', '70.00', 1, 'M', 0, '353692139_9953624454655162_3758447135817497623_n.jpg', '2023-07-21 10:02:57'),
(128, 2, 'Chocolate Shake', '100', '70.00', '100.00', 1, 'L', 0, '353692139_9953624454655162_3758447135817497623_n.jpg', '2023-07-21 10:02:57'),
(129, 2, 'Chocolate Shake', '100', '100.00', '150.00', 1, 'XL', 0, '353692139_9953624454655162_3758447135817497623_n.jpg', '2023-07-21 10:02:57'),
(130, 3, 'Coke Float Shake', '100', '30.00', '50.00', 2, 'S', 0, '353817895_2003660639988225_8413491927260960039_n.jpg', '2023-07-21 10:03:21'),
(131, 3, 'Coke Float Shake', '100', '50.00', '70.00', 2, 'M', 0, '353817895_2003660639988225_8413491927260960039_n.jpg', '2023-07-21 10:03:21'),
(132, 3, 'Coke Float Shake', '100', '70.00', '100.00', 2, 'L', 0, '353817895_2003660639988225_8413491927260960039_n.jpg', '2023-07-21 10:03:21'),
(133, 3, 'Coke Float Shake', '100', '100.00', '150.00', 2, 'XL', 0, '353817895_2003660639988225_8413491927260960039_n.jpg', '2023-07-21 10:03:21'),
(134, 4, 'Vanilla Shake', '100', '30.00', '50.00', 8, 'S', 0, '650c29f047e4e_4.jpg', '2023-07-21 10:03:47'),
(135, 4, 'Vanilla Shake', '100', '50.00', '70.00', 8, 'M', 0, '650c29f047e4e_4.jpg', '2023-07-21 10:03:47'),
(136, 4, 'Vanilla Shake', '100', '70.00', '100.00', 8, 'L', 0, '650c29f047e4e_4.jpg', '2023-07-21 10:03:47'),
(137, 4, 'Vanilla Shake', '100', '100.00', '150.00', 8, 'XL', 0, '650c29f047e4e_4.jpg', '2023-07-21 10:03:47'),
(138, 5, 'Yema Milkshake', '100', '30.00', '50.00', 4, 'S', 0, '650c29ffe189b_5.jpg', '2023-07-21 10:04:17'),
(139, 5, 'Yema Milkshake', '100', '50.00', '70.00', 4, 'M', 0, '650c29ffe189b_5.jpg', '2023-07-21 10:04:17'),
(140, 5, 'Yema Milkshake', '100', '70.00', '100.00', 4, 'L', 0, '650c29ffe189b_5.jpg', '2023-07-21 10:04:17'),
(141, 5, 'Yema Milkshake', '100', '100.00', '150.00', 4, 'XL', 0, '650c29ffe189b_5.jpg', '2023-07-21 10:04:17'),
(142, 6, 'Green  Tea Shake', '100', '30.00', '50.00', 5, 'S', 0, '650c2a0b04d1c_6.jpg', '2023-07-21 10:04:41'),
(143, 6, 'Green  Tea Shake', '100', '50.00', '70.00', 5, 'M', 0, '650c2a0b04d1c_6.jpg', '2023-07-21 10:04:41'),
(144, 6, 'Green  Tea Shake', '100', '70.00', '100.00', 5, 'L', 0, '650c2a0b04d1c_6.jpg', '2023-07-21 10:04:41'),
(145, 6, 'Green  Tea Shake', '100', '100.00', '150.00', 5, 'XL', 0, '650c2a0b04d1c_6.jpg', '2023-07-21 10:04:41'),
(146, 7, 'Cookies & Cream Shake', '100', '30.00', '50.00', 6, 'S', 0, '353167364_233797219439753_55700718211874755_n.jpg', '2023-07-21 10:05:06'),
(147, 7, 'Cookies & Cream Shake', '100', '50.00', '70.00', 6, 'M', 0, '353167364_233797219439753_55700718211874755_n.jpg', '2023-07-21 10:05:06'),
(148, 7, 'Cookies & Cream Shake', '100', '70.00', '100.00', 6, 'L', 0, '353167364_233797219439753_55700718211874755_n.jpg', '2023-07-21 10:05:06'),
(149, 7, 'Cookies & Cream Shake', '100', '100.00', '150.00', 6, 'XL', 0, '353167364_233797219439753_55700718211874755_n.jpg', '2023-07-21 10:05:06');

-- --------------------------------------------------------

--
-- Table structure for table `sales`
--

CREATE TABLE `sales` (
  `id` int(11) UNSIGNED NOT NULL,
  `product_id` int(11) UNSIGNED NOT NULL,
  `qty` int(11) NOT NULL,
  `price` decimal(25,2) NOT NULL,
  `employee` int(11) NOT NULL,
  `created_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `sales`
--

INSERT INTO `sales` (`id`, `product_id`, `qty`, `price`, `employee`, `created_date`) VALUES
(104, 148, 3, '100.00', 1, '2023-07-21 10:08:52'),
(105, 127, 1, '70.00', 1, '2023-07-21 10:08:52'),
(106, 149, 1, '150.00', 1, '2023-07-21 10:08:52'),
(107, 147, 2, '70.00', 1, '2023-07-21 10:08:52'),
(108, 146, 1, '50.00', 11, '2023-07-21 10:08:52'),
(109, 142, 1, '50.00', 11, '2023-07-21 10:08:52'),
(110, 145, 1, '150.00', 11, '2023-07-21 10:08:52'),
(111, 144, 1, '100.00', 1, '2023-07-21 10:08:52'),
(112, 143, 1, '70.00', 1, '2023-07-21 10:08:52'),
(113, 139, 1, '70.00', 2, '2023-07-21 10:08:52'),
(114, 140, 1, '100.00', 2, '2023-07-21 10:08:52'),
(115, 141, 1, '150.00', 2, '2023-07-21 10:08:52'),
(116, 138, 1, '50.00', 1, '2023-07-21 10:08:52'),
(117, 134, 1, '50.00', 11, '2023-07-21 10:08:52'),
(118, 137, 1, '150.00', 11, '2023-07-21 10:08:52'),
(119, 136, 1, '100.00', 11, '2023-07-21 10:08:52'),
(120, 135, 3, '70.00', 11, '2023-07-21 10:08:52'),
(121, 131, 1, '70.00', 11, '2023-07-21 10:08:52'),
(122, 132, 4, '100.00', 3, '2023-09-16 04:26:22'),
(123, 145, 1, '150.00', 3, '2023-09-16 04:26:22'),
(124, 133, 1, '150.00', 3, '2023-09-16 04:32:20'),
(131, 132, 1, '100.00', 3, '2023-09-16 04:44:31'),
(132, 124, 1, '100.00', 3, '2023-09-16 04:44:52'),
(133, 132, 1, '100.00', 3, '2023-09-16 04:45:18'),
(134, 132, 2, '100.00', 3, '2023-09-16 04:46:36'),
(135, 132, 15, '100.00', 3, '2023-09-16 04:47:32');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) UNSIGNED NOT NULL,
  `name` varchar(60) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `user_level` int(11) NOT NULL,
  `image` varchar(255) DEFAULT 'no_image.jpg',
  `status` int(1) NOT NULL,
  `last_login` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `username`, `password`, `user_level`, `image`, `status`, `last_login`) VALUES
(1, 'Harry Denn', 'admin', 'd033e22ae348aeb5660fc2140aec35850c4da997', 1, 'no_image.png', 1, '2023-11-20 17:40:35'),
(2, 'John Walker', 'Special', '21bd12dc183f740ee76f27b78eb39c8ad972a757', 2, 'no_image.png', 0, '2023-07-20 09:32:41'),
(3, 'Christopher', 'User', '12dea96fec20593566ab75692c9949596833adc9', 3, 'no_image.png', 1, '2023-11-20 17:59:53'),
(4, 'Natie Williams', 'Natie', 'a94a8fe5ccb19ba61c4c0873d391e987982fbbd3', 3, 'no_image.png', 1, NULL),
(11, 'Jiean Marc Estudillo', 'Jieanmarc22	', '800f5458d52a7c4abb9dc7d4d072752a79923f31', 3, 'no_image.jpg', 1, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `user_groups`
--

CREATE TABLE `user_groups` (
  `id` int(11) NOT NULL,
  `group_name` varchar(150) NOT NULL,
  `group_level` int(11) NOT NULL,
  `group_status` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `user_groups`
--

INSERT INTO `user_groups` (`id`, `group_name`, `group_level`, `group_status`) VALUES
(1, 'Admin', 1, 1),
(2, 'special', 2, 1),
(3, 'User', 3, 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indexes for table `item`
--
ALTER TABLE `item`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `logs`
--
ALTER TABLE `logs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `media`
--
ALTER TABLE `media`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id` (`id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `categorie_id` (`categorie_id`),
  ADD KEY `media_id` (`media_id`);

--
-- Indexes for table `sales`
--
ALTER TABLE `sales`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_level` (`user_level`);

--
-- Indexes for table `user_groups`
--
ALTER TABLE `user_groups`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `group_level` (`group_level`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `item`
--
ALTER TABLE `item`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT for table `logs`
--
ALTER TABLE `logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `media`
--
ALTER TABLE `media`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=273;

--
-- AUTO_INCREMENT for table `sales`
--
ALTER TABLE `sales`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=136;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `user_groups`
--
ALTER TABLE `user_groups`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `FK_products` FOREIGN KEY (`categorie_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `sales`
--
ALTER TABLE `sales`
  ADD CONSTRAINT `SK` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `FK_user` FOREIGN KEY (`user_level`) REFERENCES `user_groups` (`group_level`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
