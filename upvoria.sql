-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 23, 2025 at 10:33 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.3.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `upvoria`
--

-- --------------------------------------------------------

--
-- Table structure for table `company`
--

CREATE TABLE `company` (
  `id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `category` varchar(100) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `logo` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `company`
--

INSERT INTO `company` (`id`, `name`, `category`, `description`, `logo`) VALUES
(3, 'Lumora Tech Inc.', 'Information Technology', 'Lumora Tech Inc. is a cutting-edge software solutions company specializing in AI-driven enterprise tools and cloud infrastructure. With a focus on innovation, Lumora empowers businesses to scale efficiently through intelligent automation and data integration.', 'uploads/687ff54d62708.png'),
(4, 'Velora Food', 'Food', 'Velora Foods is a health-focused food company committed to creating delicious, plant-based snacks and meals. Sourcing natural ingredients with sustainable practices, Velora aims to make nutritious eating easy, accessible, and flavorful for everyone.', 'uploads/687ff57173139.png'),
(5, 'NexaSphere', 'Information Technology', 'NexaSphere is a next-gen telecommunications company developing advanced network solutions, including 5G integration, IoT connectivity, and secure data transfer systems. Their mission is to shape the future of digital communication through reliable, scalable infrastructure.', 'uploads/687ff5c144283.png'),
(6, 'Genovance Labs', 'Healthcare', 'Genovance Labs is a biotech innovator at the forefront of genetic research and personalized medicine. Specializing in genome analysis and bioinformatics tools, Genovance is redefining how healthcare providers diagnose and treat complex diseases.', 'uploads/687ff5e014860.png'),
(7, 'Bravura Collective', 'Retail', 'Bravura Collective is a contemporary fashion brand known for its minimalist design and ethical production. The company blends modern aesthetics with sustainable materials to create timeless wardrobe staples for eco-conscious consumers.', 'uploads/687ff6122205a.png'),
(8, 'Strive Mobility Solutions', 'Transportation', 'Strive Mobility Solutions develops electric vehicle (EV) infrastructure and smart transportation systems. From EV charging networks to mobility-as-a-service (MaaS) platforms, Strive is committed to driving the future of sustainable urban transit.', 'uploads/687ff6353933a.png');

-- --------------------------------------------------------

--
-- Table structure for table `job_fairs`
--

CREATE TABLE `job_fairs` (
  `id` int(11) NOT NULL,
  `job_fair_name` varchar(255) DEFAULT NULL,
  `short_desc` text DEFAULT NULL,
  `long_desc` text DEFAULT NULL,
  `users_joined` mediumtext DEFAULT NULL,
  `quota_total` int(11) DEFAULT NULL,
  `quota_remaining` int(11) DEFAULT NULL,
  `gmeet_link` varchar(255) DEFAULT NULL,
  `datetime` datetime DEFAULT NULL,
  `company_name` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `job_fairs`
--

INSERT INTO `job_fairs` (`id`, `job_fair_name`, `short_desc`, `long_desc`, `users_joined`, `quota_total`, `quota_remaining`, `gmeet_link`, `datetime`, `company_name`) VALUES
(7, 'Tech Innovators Fair 2025', 'Explore IT careers', 'Meet leading IT companies offering jobs in AI, Web Development, Cybersecurity, and more.', NULL, 100, 100, NULL, '2025-07-25 10:00:00', NULL),
(8, 'Digital Future Expo', 'Discover digital careers', 'Companies in blockchain, cloud computing, and IoT are hiring passionate tech talents.', NULL, 90, 90, NULL, '2025-08-01 11:00:00', NULL),
(9, 'Culinary & Food Business Fair', 'Opportunities in F&B industry', 'A job fair for aspiring chefs, baristas, and foodpreneurs with top restaurants and food chains.', NULL, 80, 79, NULL, '2025-07-26 14:00:00', NULL),
(10, 'FoodTech Career Day', 'Innovation in food meets opportunity', 'Explore careers in food technology, packaging innovation, and quality assurance.', NULL, 70, 70, NULL, '2025-08-02 13:30:00', NULL),
(11, 'Health Careers Expo', 'Medical and wellness careers', 'Connect with hospitals, clinics, and pharmaceutical companies for careers in healthcare.', NULL, 120, 120, NULL, '2025-07-27 09:30:00', NULL),
(12, 'Nursing & Medical Support Fair', 'Entry-level health jobs', 'Perfect for fresh grads in nursing, lab, and pharmacy looking for hospital work.', NULL, 100, 100, NULL, '2025-08-04 10:00:00', NULL),
(13, 'Retail & Commerce Job Day', 'Jobs in retail and sales', 'Find positions in retail operations, sales, and store management with top retail brands.', NULL, 90, 90, NULL, '2025-07-28 11:00:00', NULL),
(14, 'Transport & Logistics Careers', 'Jobs in logistics and mobility', 'Discover careers in delivery, freight, and transport management with leading logistic firms.', NULL, 75, 75, NULL, '2025-07-29 13:00:00', NULL),
(15, 'Smart Mobility Fair', 'Transport meets technology', 'Join transport startups and mobility service providers to innovate the way people move.', NULL, 60, 60, NULL, '2025-08-05 15:00:00', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `job_fair_companies`
--

CREATE TABLE `job_fair_companies` (
  `id` int(11) NOT NULL,
  `job_fair_id` int(11) NOT NULL,
  `company_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `job_fair_companies`
--

INSERT INTO `job_fair_companies` (`id`, `job_fair_id`, `company_name`) VALUES
(11, 7, 'Lumora Tech Inc.'),
(12, 7, 'NexaSphere'),
(13, 8, 'Lumora Tech Inc.'),
(14, 8, 'NexaSphere'),
(15, 9, 'Velora Food'),
(16, 10, 'Velora Food'),
(17, 10, 'Genovance Labs'),
(18, 11, 'Genovance Labs'),
(19, 12, 'Genovance Labs'),
(20, 13, 'Bravura Collective'),
(21, 14, 'Strive Mobility Solutions'),
(22, 15, 'Strive Mobility Solutions');

-- --------------------------------------------------------

--
-- Table structure for table `job_fair_registrations`
--

CREATE TABLE `job_fair_registrations` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `job_fair_id` int(11) NOT NULL,
  `registered_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `job_fair_registrations`
--

INSERT INTO `job_fair_registrations` (`id`, `user_id`, `job_fair_id`, `registered_at`) VALUES
(15, 4, 9, '2025-07-24 03:19:50');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `created_at`) VALUES
(1, 'akasyah', 'akasyah@gmail.com', '$2y$10$UsXzJ36qd1GP0Vhk6eN.de9Uxc5Kqu1/UIB75QqV9Vhpc6ILNFbd6', '2025-07-10 18:37:05'),
(3, 'syamil', 'syamilchalifah123@gmail.com', '$2y$10$j6jeOu75CyOuQBsH3fzTVOoW87.Z/XSlA5yLs2su4foBTw5Feje7C', '2025-07-22 20:53:20'),
(4, 'user', 'user@gmail.com', '$2y$10$DwUboHNo9rBnMDz8/5ol5e8no0nrN00gNryeBgXCuMUG051.nu4Lm', '2025-07-23 18:11:31');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `company`
--
ALTER TABLE `company`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `job_fairs`
--
ALTER TABLE `job_fairs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `job_fair_companies`
--
ALTER TABLE `job_fair_companies`
  ADD PRIMARY KEY (`id`),
  ADD KEY `job_fair_id` (`job_fair_id`);

--
-- Indexes for table `job_fair_registrations`
--
ALTER TABLE `job_fair_registrations`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_registration` (`user_id`,`job_fair_id`),
  ADD KEY `job_fair_id` (`job_fair_id`);

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
-- AUTO_INCREMENT for table `company`
--
ALTER TABLE `company`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `job_fairs`
--
ALTER TABLE `job_fairs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `job_fair_companies`
--
ALTER TABLE `job_fair_companies`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `job_fair_registrations`
--
ALTER TABLE `job_fair_registrations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `job_fair_companies`
--
ALTER TABLE `job_fair_companies`
  ADD CONSTRAINT `job_fair_companies_ibfk_1` FOREIGN KEY (`job_fair_id`) REFERENCES `job_fairs` (`id`);

--
-- Constraints for table `job_fair_registrations`
--
ALTER TABLE `job_fair_registrations`
  ADD CONSTRAINT `job_fair_registrations_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `job_fair_registrations_ibfk_2` FOREIGN KEY (`job_fair_id`) REFERENCES `job_fairs` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
