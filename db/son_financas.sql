-- phpMyAdmin SQL Dump
-- version 4.6.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: 16-Ago-2017 às 18:18
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
  `updated_at` datetime NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `category_costs`
--

INSERT INTO `category_costs` (`id`, `name`, `created_at`, `updated_at`, `user_id`) VALUES
(1, 'Agua', '2017-08-16 18:14:06', '2017-08-16 18:14:06', 3),
(2, 'Luz', '2017-08-16 18:14:06', '2017-08-16 18:14:06', 3),
(3, 'Cartao', '2017-08-16 18:14:06', '2017-08-16 18:14:06', 3),
(4, 'Imposto de Renda', '2017-08-16 18:14:06', '2017-08-16 18:14:06', 2),
(5, 'Supermercado', '2017-08-16 18:14:06', '2017-08-16 18:14:06', 1),
(6, 'Vertuario', '2017-08-16 18:14:06', '2017-08-16 18:14:06', 4),
(7, 'Cartao', '2017-08-16 18:14:06', '2017-08-16 18:14:06', 2),
(8, 'Cartao', '2017-08-16 18:14:06', '2017-08-16 18:14:06', 2),
(9, 'Vertuario', '2017-08-16 18:14:06', '2017-08-16 18:14:06', 4),
(10, 'Entretenimento', '2017-08-16 18:14:06', '2017-08-16 18:14:06', 2);

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
(20170419164553, 'CreateCategoryCosts', '2017-08-16 21:14:05', '2017-08-16 21:14:05', 0),
(20170710182842, 'CreateUsersTable', '2017-08-16 21:14:05', '2017-08-16 21:14:05', 0),
(20170816160527, 'AddUserToCategoryCosts', '2017-08-16 21:14:05', '2017-08-16 21:14:06', 0);

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
(1, 'Aaron', 'Zaragoça', 'admin@user.com', '$2y$10$MBw2d3tqXMgamFweQhS5zO5WgUSwY9W6byZXuzlkwHAo7mIAVwLJe', '2017-08-16 18:14:06', '2017-08-16 18:14:06'),
(2, 'Olívia', 'Quintana', 'mascarenhas.daniel@rodrigues.com.br', '$2y$10$AOD7Sx.c1cekP89DUSg.2uHMWJTZ/qQT6I.Q9752jlXGHDWD6.9wq', '2017-08-16 18:14:06', '2017-08-16 18:14:06'),
(3, 'Olívia', 'Vila', 'ymontenegro@corona.net', '$2y$10$Zf625cmwe1B1rRsvj2T49u.mzKZ5sjWo2AoEzlL8yhgPobDhpThZ6', '2017-08-16 18:14:06', '2017-08-16 18:14:06'),
(4, 'Suzana', 'Bezerra', 'darosa.abgail@hotmail.com', '$2y$10$tYt//lMCrfyD8CdDUcwtXuU35H9oLvC7V99RiiEOA31473PhycMWy', '2017-08-16 18:14:06', '2017-08-16 18:14:06');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `category_costs`
--
ALTER TABLE `category_costs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- Constraints for dumped tables
--

--
-- Limitadores para a tabela `category_costs`
--
ALTER TABLE `category_costs`
  ADD CONSTRAINT `category_costs_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
