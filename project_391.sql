-- phpMyAdmin SQL Dump
-- version 4.9.7
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Dec 28, 2021 at 07:20 PM
-- Server version: 10.3.31-MariaDB-cll-lve
-- PHP Version: 7.3.32

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `project_391`
--

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(5, '2021_12_26_225455_create_properties_table', 1),
(6, '2021_12_26_225926_create_saved_searches_table', 1),
(7, '2021_12_26_230552_create_notifications_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` int(10) UNSIGNED NOT NULL,
  `seen` int(11) NOT NULL,
  `user` int(10) UNSIGNED NOT NULL,
  `property` int(10) UNSIGNED NOT NULL,
  `saved_search` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `notifications`
--

INSERT INTO `notifications` (`id`, `seen`, `user`, `property`, `saved_search`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 12, 12, '2021-12-27 16:21:15', '2021-12-28 03:15:32'),
(2, 1, 1, 13, 11, '2021-12-27 16:23:15', '2021-12-28 03:15:32');

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `properties`
--

CREATE TABLE `properties` (
  `id` int(10) UNSIGNED NOT NULL,
  `street` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `district` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `city` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `postal` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `cost` int(11) NOT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `bath` int(11) NOT NULL,
  `bed` int(11) NOT NULL,
  `size` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `house_details` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `flat_details` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `img_urls` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `lat` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `lng` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `loc` point NOT NULL,
  `user` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `properties`
--

INSERT INTO `properties` (`id`, `street`, `district`, `city`, `postal`, `cost`, `type`, `bath`, `bed`, `size`, `description`, `house_details`, `flat_details`, `img_urls`, `lat`, `lng`, `loc`, `user`, `created_at`, `updated_at`) VALUES
(1, 'Road 21', 'Dhaka', 'Gulshan', '1212', 5000000, 'Flat', 2, 2, '2000 sqft', 'This is a description', '200/B', '10/A', '/storage/images/dDmPNUeriMps8AK7GcoZKMWVq236vTuzBRnqlK8f.jpg~-~/storage/images/DsLbJB0PXnmqzmujznWrarQMDzdTNrP4UhatxS4X.jpg~-~/storage/images/bwZS1UiBOtYu6JPwDuKogSeKBbpsUCA3R0UBrfEP.jpg~-~/storage/images/z9vXiWZb4F9UEu918kTPd5VCEIXHa3tzKSJEAG6S.jpg', '23.781488288697144', '-269.5839675673857', 0x0000000001010000004729d29d0fc837408a3d60ee57d970c0, 1, '2021-12-27 14:22:13', '2021-12-27 14:22:13'),
(2, 'Road 128', 'Dhaka', 'Gulshan', '1212', 50000, 'Rent', 3, 3, '2100 sqft', 'Testing', '100/E', '2/B', '/storage/images/YLjrINDxYINr9dYlkXtz4wEuIFWZQpCSoZo5hbE8.jpg~-~/storage/images/O537UTfmRss9078CQfJLYQPmvVXIeEngstaCLVxb.jpg~-~/storage/images/SWgbba6VI3cbVrHneLDlVemNOSKMqWVXzkiapwzf.jpg~-~/storage/images/FMsmQ8t5S8jRkeRROFIyUhblTMIRiBXBlVJKcra5.jpg', '23.783053306026492', '-269.58156912586986', 0x0000000001010000009168742e76c83740977f6d1b4ed970c0, 1, '2021-12-27 14:23:27', '2021-12-27 14:23:27'),
(3, '1/A', 'Dhaka', 'Gulshan', '1212', 500000000, 'House', 4, 4, '4000 sqft', 'Testing', '112/A', NULL, '/storage/images/IpvgCf5nZBsHweiyjD49cgtNNV8zsHImQ1nBemJr.jpg~-~/storage/images/eFAdusP5dxhdI0EdSRf9jKp9kC6qGyhflhMizCrs.jpg~-~/storage/images/QaOPiJG8uYWOgKPwa3nQ0mvZN9BDH924wrIF05RG.jpg~-~/storage/images/swOUbLZ3YRwZVNoMZgpOJcjZbWCBEcjEkmtWv0pa.jpg', '23.775193973697487', '-269.585132631954', 0x0000000001010000004516bd1c73c637400ae108b45cd970c0, 1, '2021-12-27 14:27:31', '2021-12-27 14:27:31'),
(4, '10A', 'Dhaka', 'Banani', '1210', 1000000, 'Flat', 4, 4, '2000 sqft', 'Test', '112/A', '1 A', '/storage/images/36hbLpQMkbYTI5Fu6yCNM1LS4QFK24yGJCQrqN8U.jpg~-~/storage/images/be8qYN2N4qfwg90SIPgCRvR4GgEmtGTPFmmvDr4X.jpg~-~/storage/images/z2d03q9QzBCQOPSTPqkm4ZJ3OYBt9YNVsaBoDf4G.jpg~-~/storage/images/VsO99JiWkozK4MhWDCCdv4dISZK6f29ct7qaqGLe.jpg', '23.789297233898743', '-269.59312596873946', 0x0000000001010000001a6b2e620fca37404fe2a7717dd970c0, 1, '2021-12-27 14:29:28', '2021-12-27 14:29:28'),
(5, 'Road 21', 'Dhaka', 'Banani', '1210', 20000000, 'Rent', 5, 5, '2000 sqft', 'Test', '40/A', '2 B', '/storage/images/2dXzHsbsPPhPnOgJJn81MB1fCkmX8UCnMiT2nZkm.jpg~-~/storage/images/UG0hXf8Lb9SlmUD0Pc6NljPEz3swSQUSWiHGZM5O.jpg~-~/storage/images/RjemuzVKqDzL9R0mKn9FXnG3D3NVNlRvcsp7qWfz.jpg~-~/storage/images/7vtZQOMBrW1oQe6srnzzDomdEmDBtGdVQkX8zCmc.jpg', '23.7940830604507', '-269.59407997955327', 0x0000000001010000007ff1060749cb37403c36025a81d970c0, 1, '2021-12-27 14:30:46', '2021-12-27 14:30:46'),
(12, 'Road 8', 'Dhaka', 'Gulshan', '1212', 5000000, 'House', 2, 2, '2000 sqft', 'testing notification', '123/A', NULL, '/storage/images/GDvmbFJ0o4wlW8CQri0y6aWhEE4t7Y4YOIUwb24L.jpg~-~/storage/images/avf1y5mUj549Gj6xAqkMWz9ilsy9OjZswza67caQ.jpg~-~/storage/images/QWAs43QpQppbjroWPJoxPAhhwakCrCZ7m8yayCCq.jpg~-~/storage/images/s3ZLrpOAPrr6xaFIFGIWLsMHnIGN5QoboG1RsCkc.jpg', '23.772862100408958', '-269.59026023902595', 0x0000000001010000000893654adac53740ee6bb8b471d970c0, 2, '2021-12-27 16:21:11', '2021-12-27 16:21:11'),
(13, 'Road 10 b', 'Dhaka', 'Banani', '1210', 5000000, 'Flat', 2, 2, '2000 sqft', 'Testing notification 2', '123/B', '2 A', '/storage/images/Ap6x9DIWYQwY7mdE2dfHVaSXOoXu9ikeicyIyAIs.jpg~-~/storage/images/lEmDIVVzNkpSUfxdSBUU5ykOJV7OBwOqdFUzQotd.jpg~-~/storage/images/HhHwYpG9JjgCEkwa4tdtVn8nOWNNjmvWWVIYqTrC.jpg~-~/storage/images/bS9i3lpjMEcmue3gmQRafksA3XSZjKofxhvY0olD.jpg', '23.789823376658216', '-269.5927671921633', 0x000000000101000000035d64dd31ca3740bb8773f97bd970c0, 2, '2021-12-27 16:23:11', '2021-12-27 16:23:11');

-- --------------------------------------------------------

--
-- Table structure for table `saved_searches`
--

CREATE TABLE `saved_searches` (
  `id` int(10) UNSIGNED NOT NULL,
  `save_search_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `bed` int(11) DEFAULT NULL,
  `bath` int(11) DEFAULT NULL,
  `city` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `coords` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `layer_type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `district` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `min` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `max` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `postal` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `property_type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `img` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `saved_searches`
--

INSERT INTO `saved_searches` (`id`, `save_search_name`, `bed`, `bath`, `city`, `coords`, `layer_type`, `district`, `min`, `max`, `postal`, `property_type`, `img`, `user`, `created_at`, `updated_at`) VALUES
(11, 'Banani Area (Flat)', NULL, NULL, NULL, '23.79052039748881 -269.5941281318665,23.78993136604569 -269.59082365036016,23.78891037188709 -269.5909953117371,23.78936196644644 -269.5943427085877,23.79052039748881 -269.5941281318665', 'polygon', NULL, NULL, NULL, NULL, 'Flat', '33d0a08264dc7cef7ffa091d6f4a0693.png', 1, '2021-12-27 16:19:03', '2021-12-28 03:15:47'),
(12, 'Niketon Area (House)', NULL, NULL, NULL, '23.772514463612957,-269.5906519889832,0.12973287795685762', 'circle', NULL, NULL, NULL, NULL, 'House', '6ef71a7d26d3b145030a37f95de24554.png', 1, '2021-12-27 16:19:48', '2021-12-28 03:15:47');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `phone`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Muaz', 'smuazali1998@gmail.com', '01301767913', NULL, '$2y$10$fPWappeWinu6XM1rY0yfFuz0mPXhEu97/UV8il4Ew13/U7M4oprw.', NULL, '2021-12-27 14:21:10', '2021-12-27 14:21:10'),
(2, 'Syed Ali', 'syedali1998bd@gmail.com', '01301767913', NULL, '$2y$10$iRMwi60MYnT8a4c2l5ombO.V8Gw1LdvfUZNeWHmG5TJmbWWhl4CXO', NULL, '2021-12-27 16:20:22', '2021-12-27 16:20:22');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `notifications_user_foreign` (`user`),
  ADD KEY `notifications_property_foreign` (`property`),
  ADD KEY `notifications_saved_search_foreign` (`saved_search`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `properties`
--
ALTER TABLE `properties`
  ADD PRIMARY KEY (`id`),
  ADD KEY `properties_user_foreign` (`user`);

--
-- Indexes for table `saved_searches`
--
ALTER TABLE `saved_searches`
  ADD PRIMARY KEY (`id`),
  ADD KEY `saved_searches_user_foreign` (`user`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `properties`
--
ALTER TABLE `properties`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `saved_searches`
--
ALTER TABLE `saved_searches`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `notifications`
--
ALTER TABLE `notifications`
  ADD CONSTRAINT `notifications_property_foreign` FOREIGN KEY (`property`) REFERENCES `properties` (`id`),
  ADD CONSTRAINT `notifications_saved_search_foreign` FOREIGN KEY (`saved_search`) REFERENCES `saved_searches` (`id`),
  ADD CONSTRAINT `notifications_user_foreign` FOREIGN KEY (`user`) REFERENCES `users` (`id`);

--
-- Constraints for table `properties`
--
ALTER TABLE `properties`
  ADD CONSTRAINT `properties_user_foreign` FOREIGN KEY (`user`) REFERENCES `users` (`id`);

--
-- Constraints for table `saved_searches`
--
ALTER TABLE `saved_searches`
  ADD CONSTRAINT `saved_searches_user_foreign` FOREIGN KEY (`user`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
