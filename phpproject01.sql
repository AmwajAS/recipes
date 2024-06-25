-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: db
-- Generation Time: Jul 17, 2022 at 08:37 PM
-- Server version: 8.0.29
-- PHP Version: 8.0.21

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `phpproject01`
--

-- --------------------------------------------------------

--
-- Table structure for table `recipes`
--

CREATE TABLE `recipes` (
  `id` int NOT NULL,
  `user_id` int NOT NULL,
  `name` varchar(128) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `image` varchar(255) NOT NULL,
  `ingredients` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `method` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `published_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `recipes`
--

INSERT INTO `recipes` (`id`, `user_id`, `name`, `description`, `image`, `ingredients`, `method`, `published_at`) VALUES
(1, 4, 'Pan-seared lamb\r\n', ' \"Think of this as a fresh take on a roast\r\n        dinner for 2– it’ll give you the same  comforting\r\n        feelings but is much simpler and faster to knock\r\n        up. You can have this beauty on the table in under 30\r\n        minutes. \"', 'https://images.eatthismuch.com/img/33601_tabitharwheeler_20fbb5bf-8aad-4441-b93e-479a68ce5344.jpg', '* 400g baby new potatoes\r\n* 200 g frozen peas\r\n* 200 g piece of lamb rump\r\n* 4 sprigs of fresh basil\r\n* 1 heaped tablespoon yellow pepper', 'Halve any larger potatoes, then cook in a pan of boiling salted water for 15 minutes, or until tender,\r\nadding the peas to the party for the last 3 minutes.\r\nMeanwhile, rub the lamb all over with 1 teaspoon of olive oil, and a pinch of sea salt and black pepper.\r\nStarting fat side down, sear the lamb in a non-stick frying pan on a medium-high heat for 10 minutes,\r\nturning regularly until gnarly all over but blushing in the middle, or use your instincts to cook to your liking.\r\nRemove to a plate to rest, then, with the frying pan on a low heat, make a liquor by stirring in a splash of\r\nwater and a little red wine vinegar to pick up all those nice sticky bits, leaving it to tick away slowly until needed.\r\nDrain the potatoes and peas, tip into the liquor pan, pick over most of the basil, add the pesto and toss it\r\nall well.\r\nServe with the lamb, sliced thinly, then pour over the resting juices. Pick over the remaining basil leaves,\r\nand tuck in.', '2022-07-11 00:03:04'),
(2, 3, 'Pizza', 'TO DO', 'https://pizza-elias.de/wp-content/uploads/2020/12/pizzeria_14.png', 'Tomato\r\nolives\r\n\r\n', 'Put Tomato', '2022-07-12 19:13:13'),
(3, 4, '1', '1', 'https://pizza-elias.de/wp-content/uploads/2020/12/pizzeria_14.png', '1', '1', '2022-07-17 19:29:18'),
(4, 3, '2', '1', 'https://pizza-elias.de/wp-content/uploads/2020/12/pizzeria_14.png', '1', '1', '2022-07-17 19:38:04');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int NOT NULL,
  `email` varchar(128) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `name` varchar(128) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `password` varchar(128) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `vkey` varchar(45) NOT NULL,
  `verified` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `email`, `name`, `password`, `vkey`, `verified`, `created_at`) VALUES
(1, 'test@test.com', 'test', '$2y$10$.twJbJii46ZpxtNSehcJsONUCWwAL4mz64jDMfbkV5v22ExRkQmxq', 'd497e35cd65a451f763d5f613dd6b368', 0, '2022-07-10 12:10:29'),
(2, 'amwaj.a.s@gmail.com', 'test22', '$2y$10$hCpRFyNaQTh20JCoVKBXM.Xp159a8x9Q7tU7P5m2KHezqEV498vMO', '5de6672f75c50b07a3396323c58f9caa', 0, '2022-07-10 12:14:10'),
(3, 'amwaj@test.com', 'amwaj', '$2y$10$1wC/vmFsyFcm2ymmXbxUF.QUHnI0w1okb2uBRGvEsLQgYPe1oCmnG', 'db0ec4d11573cd4be74f12bee567f45e', 0, '2022-07-10 21:28:12'),
(4, 'nermin@test.com', 'nerminJurban', '$2y$10$p4fc4hp6DfgNATYM6YnEU.X4smVZ.HHgv6dSEZo0xTXWglVD78hi6', '85b7eb15a7d58611419646a0b1b09ff2', 1, '2022-07-10 23:58:54');

-- --------------------------------------------------------

--
-- Table structure for table `users_recipes`
--

CREATE TABLE `users_recipes` (
  `id` int NOT NULL,
  `owner_id` int NOT NULL,
  `user_id` int NOT NULL,
  `recipe_id` int NOT NULL,
  `status` varchar(32) NOT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `users_recipes`
--

INSERT INTO `users_recipes` (`id`, `owner_id`, `user_id`, `recipe_id`, `status`, `created_at`) VALUES
(21, 4, 3, 1, 'accepted', '2022-07-16 22:07:54'),
(36, 3, 4, 4, 'pending', '2022-07-17 19:38:23'),
(38, 4, 1, 1, 'rejected', '2022-07-17 19:38:23');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `recipes`
--
ALTER TABLE `recipes`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`,`user_id`),
  ADD KEY `fk_users_id` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users_recipes`
--
ALTER TABLE `users_recipes`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `owner_id` (`owner_id`,`user_id`,`recipe_id`),
  ADD KEY `fk_user_id` (`user_id`),
  ADD KEY `fk_recipe_id` (`recipe_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `recipes`
--
ALTER TABLE `recipes`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `users_recipes`
--
ALTER TABLE `users_recipes`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `recipes`
--
ALTER TABLE `recipes`
  ADD CONSTRAINT `fk_users_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Constraints for table `users_recipes`
--
ALTER TABLE `users_recipes`
  ADD CONSTRAINT `fk_owner_id` FOREIGN KEY (`owner_id`) REFERENCES `users` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `fk_recipe_id` FOREIGN KEY (`recipe_id`) REFERENCES `recipes` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `fk_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
