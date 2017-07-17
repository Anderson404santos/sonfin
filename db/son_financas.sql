-- phpMyAdmin SQL Dump
-- version 4.6.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: 17-Jul-2017 às 15:35
-- Versão do servidor: 5.7.14
-- PHP Version: 7.0.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `son_financas`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `category_costs`
--

CREATE TABLE `category_costs` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `category_costs`
--

INSERT INTO `category_costs` (`id`, `name`, `created_at`, `updated_at`) VALUES
(2, 'Von Moussef', '2017-06-19 00:00:00', '2017-06-19 00:00:00'),
(3, 'Prof. Oscar Rohan I', '2017-04-25 16:14:07', '2017-04-25 16:14:07'),
(4, 'Dr. Maye Waters', '2017-04-25 16:14:07', '2017-04-25 16:14:07'),
(5, 'Roy Mills', '2017-04-25 16:14:07', '2017-04-25 16:14:07'),
(6, 'Bridie Wehner', '2017-04-25 16:14:07', '2017-04-25 16:14:07'),
(7, 'Brannon Champlin', '2017-04-25 16:14:07', '2017-04-25 16:14:07'),
(8, 'Isac Hettinger', '2017-04-25 16:14:07', '2017-04-25 16:14:07'),
(9, 'Mrs. Annette Koch', '2017-04-25 16:14:07', '2017-04-25 16:14:07'),
(10, 'Santos Padberg', '2017-04-25 16:14:07', '2017-04-25 16:14:07'),
(11, 'Maude Kutch', '2017-04-25 16:14:07', '2017-04-25 16:14:07'),
(12, 'Prof. Jonathon Johns Sr.', '2017-04-25 16:14:07', '2017-04-25 16:14:07'),
(13, 'teste', '2017-05-30 23:23:23', '2017-05-30 23:23:23'),
(14, 'teste264', '2017-06-14 15:15:56', '2017-06-14 15:15:56'),
(15, 'Outro Teste', '2017-06-19 15:10:37', '2017-06-19 15:10:37'),
(16, 'teste159', '2017-06-19 16:05:08', '2017-06-19 16:05:08'),
(17, 'cat', '2017-06-19 16:05:29', '2017-06-19 16:05:29'),
(18, 'cat', '2017-06-19 16:06:01', '2017-06-19 16:06:01'),
(19, 'teste112233', '2017-06-19 16:07:48', '2017-06-19 16:07:48');

-- --------------------------------------------------------

--
-- Estrutura da tabela `migrations`
--

CREATE TABLE `migrations` (
  `version` bigint(20) NOT NULL,
  `migration_name` varchar(100) DEFAULT NULL,
  `start_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `end_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `breakpoint` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `migrations`
--

INSERT INTO `migrations` (`version`, `migration_name`, `start_time`, `end_time`, `breakpoint`) VALUES
(20170419164553, 'CreateCategoryCosts', '2017-04-20 18:06:52', '2017-04-20 18:06:53', 0),
(20170710182842, 'CreateUsersTable', '2017-07-11 02:04:27', '2017-07-11 02:04:27', 0);

-- --------------------------------------------------------

--
-- Estrutura da tabela `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `users`
--

INSERT INTO `users` (`id`, `first_name`, `last_name`, `email`, `password`, `created_at`, `updated_at`) VALUES
(2, 'Laurel', 'Schroeder', 'admin@user.com', '12345', '2017-07-10 23:07:30', '2017-07-10 23:07:30'),
(3, 'Dusty', 'Kassulke', 'mavis.homenick@yost.net', '12345', '2017-07-10 23:07:30', '2017-07-10 23:07:30'),
(4, 'Christa', 'Ullrich', 'tina.keebler@homenick.net', '12345', '2017-07-10 23:07:30', '2017-07-10 23:07:30'),
(5, 'Desmond', 'Simonis', 'ubode@orn.com', '12345', '2017-07-10 23:07:30', '2017-07-10 23:07:30');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `category_costs`
--
ALTER TABLE `category_costs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`version`);

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
-- AUTO_INCREMENT for table `category_costs`
--
ALTER TABLE `category_costs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
