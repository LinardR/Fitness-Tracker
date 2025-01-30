-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 30, 2025 at 10:50 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.1.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `fitness_app`
--

-- --------------------------------------------------------

--
-- Table structure for table `contact_requests`
--

CREATE TABLE `contact_requests` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `submitted_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `contact_requests`
--

INSERT INTO `contact_requests` (`id`, `name`, `email`, `message`, `submitted_at`) VALUES
(1, 'test', 'test@gmail.com', 'qweasdzxc', '2025-01-29 23:41:29'),
(2, 'test', 'test@gmail.com', '2', '2025-01-29 23:42:25'),
(3, 'test', 'test@gmail.com', '2', '2025-01-29 23:42:55'),
(4, 'test', 'test@gmail.com', '2', '2025-01-29 23:43:25'),
(5, 'Visar Xhini', 'test@gmail.com', '321', '2025-01-30 00:55:50');

-- --------------------------------------------------------

--
-- Table structure for table `reviews`
--

CREATE TABLE `reviews` (
  `id` int(11) NOT NULL,
  `rating` int(11) NOT NULL CHECK (`rating` between 1 and 5),
  `name` varchar(255) NOT NULL,
  `review` text NOT NULL,
  `status` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `reviews`
--

INSERT INTO `reviews` (`id`, `rating`, `name`, `review`, `status`, `created_at`) VALUES
(1, 5, 'Shend', 'Nice app!', 'approved', '2025-01-28 23:54:08'),
(2, 4, 'Shend', 'Nice app!', 'approved', '2025-01-28 23:55:53'),
(5, 4, '4', '4', 'not-approved', '2025-01-29 00:41:46'),
(6, 5, 'test', '1', '', '2025-01-29 00:43:29'),
(7, 3, 'test', '2', 'approved', '2025-01-30 00:55:20');

-- --------------------------------------------------------

--
-- Table structure for table `site_settings`
--

CREATE TABLE `site_settings` (
  `id` int(11) NOT NULL,
  `site_name` varchar(255) NOT NULL,
  `footer_text` varchar(255) NOT NULL,
  `about_text` text NOT NULL,
  `site_logo` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `site_settings`
--

INSERT INTO `site_settings` (`id`, `site_name`, `footer_text`, `about_text`, `site_logo`) VALUES
(1, 'Fitness Tracker', '© 2025 Fitness Tracker. All rights reserved.', 'Welcome to Fitness Tracker – your ultimate companion in achieving a healthier and more active lifestyle! At Fitness Tracker, we believe that fitness is not just a goal; it’s a journey, and we’re here to make that journey enjoyable, rewarding, and effective.\r\n\r\nOur platform empowers you to:\r\n\r\nTrack Your Progress: Monitor your steps, calories burned, and workout sessions effortlessly. Our easy-to-use dashboard gives you a clear view of your achievements and keeps you motivated to push further.\r\nSet Fitness Goals: Whether you’re aiming to lose weight, build strength, or maintain a healthy lifestyle, our tools are designed to help you set and achieve your personalized fitness goals.\r\nCelebrate Your Achievements: Every milestone matters. From completing a challenging workout to reaching your weekly step count, we ensure your hard work is recognized and celebrated.\r\nOur Mission\r\nOur mission is to inspire and support individuals in leading healthier lives. We are passionate about providing cutting-edge tools and insights that make fitness tracking simple, accurate, and fun.\r\n\r\nWhy Choose Us?\r\n\r\nUser-Friendly Design: Fitness Tracker is designed with simplicity and functionality in mind, making it accessible for users of all fitness levels.\r\nComprehensive Tracking: Keep tabs on every aspect of your fitness journey, including workouts, steps, and calories.\r\nCommunity Support: Join a like-minded community where you can share your progress, exchange tips, and find motivation.\r\nStart Your Journey Today\r\nWhether you\'re just starting out or you\'re a seasoned fitness enthusiast, Fitness Tracker is here to support you every step of the way. Together, let’s turn your fitness dreams into reality.', 'uploads/logo.png');

-- --------------------------------------------------------

--
-- Table structure for table `steps_tracker`
--

CREATE TABLE `steps_tracker` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `date` date NOT NULL,
  `steps` int(11) NOT NULL,
  `calories_burned` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `steps_tracker`
--

INSERT INTO `steps_tracker` (`id`, `user_id`, `date`, `steps`, `calories_burned`, `created_at`) VALUES
(1, 1, '2025-01-23', 5000, 250, '2025-01-29 22:47:15'),
(2, 1, '2025-01-24', 7000, 350, '2025-01-29 22:47:15'),
(3, 1, '2025-01-25', 6500, 300, '2025-01-29 22:47:15'),
(4, 1, '2025-01-26', 8000, 400, '2025-01-29 22:47:15'),
(5, 1, '2025-01-27', 9000, 450, '2025-01-29 22:47:15'),
(6, 1, '2025-01-28', 10000, 500, '2025-01-29 22:47:15'),
(7, 4, '2025-01-29', 12000, 600, '2025-01-29 22:47:15'),
(8, 4, '2025-01-30', 2500, 150, '2025-01-29 23:04:15'),
(9, 1, '2025-01-30', 2500, 150, '2025-01-29 23:04:29'),
(10, 3, '2025-01-29', 2000, 150, '2025-01-30 00:54:49'),
(11, 3, '2025-01-29', 2000, 150, '2025-01-30 00:54:52'),
(12, 3, '2025-01-30', 2500, 160, '2025-01-30 00:55:02');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `age` int(11) NOT NULL,
  `weight` decimal(5,2) NOT NULL,
  `height` decimal(5,2) NOT NULL,
  `fitness_goals` text NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `date_registration` timestamp NOT NULL DEFAULT current_timestamp(),
  `role` enum('admin','user') DEFAULT 'user'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `age`, `weight`, `height`, `fitness_goals`, `email`, `password`, `date_registration`, `role`) VALUES
(1, 'Admin', 22, 12.00, 128.00, 'f', 'admin@admin.com', '$2y$10$/kLY.FkNDSnh.XMOOxh/XOG70rqBguPVdKIUFn73B.zvJQEaGgeIW', '2025-01-27 22:22:01', 'admin'),
(3, 'Shend', 22, 22.00, 22.00, '1', 'shend.xhini@gmail.com', '$2y$10$h4DqFn3RzLT5JLn4pd3ZauuulW7mt5cYRDoQ26wU116wGnwvfSUau', '2025-01-27 23:34:02', 'user'),
(4, 'Shend2', 21, 25.00, 111.00, 'sdasda47ud3fd', 'shendxhini@gmail.com', '$2y$10$/kLY.FkNDSnh.XMOOxh/XOG70rqBguPVdKIUFn73B.zvJQEaGgeIW', '2025-01-29 00:48:18', 'user');

-- --------------------------------------------------------

--
-- Table structure for table `workouts`
--

CREATE TABLE `workouts` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `date` date NOT NULL,
  `exercise` varchar(255) NOT NULL,
  `reps` int(11) NOT NULL,
  `sets` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `workouts`
--

INSERT INTO `workouts` (`id`, `user_id`, `date`, `exercise`, `reps`, `sets`, `created_at`) VALUES
(1, 4, '2025-01-29', 'Push-Ups', 20, 3, '2025-01-29 22:33:43'),
(2, 4, '2025-01-29', 'Push-Ups', 20, 3, '2025-01-29 22:33:53'),
(3, 1, '2025-01-28', 'Push-Ups', 10, 4, '2025-01-29 22:35:11'),
(4, 1, '2025-01-28', 'Push-Ups', 10, 4, '2025-01-29 22:35:16'),
(5, 1, '2025-01-23', 'Push-ups', 20, 3, '2025-01-29 22:47:33'),
(6, 1, '2025-01-24', 'Squats', 30, 3, '2025-01-29 22:47:33'),
(7, 1, '2025-01-25', 'Jump Rope', 50, 2, '2025-01-29 22:47:33'),
(8, 1, '2025-01-26', 'Running', 5, 1, '2025-01-29 22:47:33'),
(9, 1, '2025-01-27', 'Cycling', 10, 1, '2025-01-29 22:47:33'),
(10, 1, '2025-01-28', 'Plank', 1, 3, '2025-01-29 22:47:33'),
(11, 1, '2025-01-29', 'Bench Press', 10, 4, '2025-01-29 22:47:33'),
(12, 3, '2025-01-30', 'eg', 2, 2, '2025-01-30 00:54:31'),
(13, 1, '2025-01-30', 'Push-Ups', 20, 3, '2025-01-30 01:33:27');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `contact_requests`
--
ALTER TABLE `contact_requests`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `site_settings`
--
ALTER TABLE `site_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `steps_tracker`
--
ALTER TABLE `steps_tracker`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `workouts`
--
ALTER TABLE `workouts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `contact_requests`
--
ALTER TABLE `contact_requests`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `reviews`
--
ALTER TABLE `reviews`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `site_settings`
--
ALTER TABLE `site_settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `steps_tracker`
--
ALTER TABLE `steps_tracker`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `workouts`
--
ALTER TABLE `workouts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `steps_tracker`
--
ALTER TABLE `steps_tracker`
  ADD CONSTRAINT `steps_tracker_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `workouts`
--
ALTER TABLE `workouts`
  ADD CONSTRAINT `workouts_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
