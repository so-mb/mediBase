-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 24, 2024 at 11:38 AM
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
-- Database: `medibase`
--

-- --------------------------------------------------------

--
-- Table structure for table `doctors`
--

CREATE TABLE `doctors` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `birth_date` date DEFAULT NULL,
  `gender` enum('female','male','other','') DEFAULT NULL,
  `nationality` varchar(25) DEFAULT NULL,
  `address` varchar(75) DEFAULT NULL,
  `mobile_phone` varchar(25) DEFAULT NULL,
  `email` varchar(50) NOT NULL,
  `license_no` varchar(10) DEFAULT NULL,
  `department` enum('Cardiology','Orthopedics','Dermatology','Obstetrics and Gynecology (OB/GYN)','Psychiatry','Neurology','Emergency') DEFAULT NULL,
  `position` enum('Medical Doctor (MD)','Consultant') DEFAULT NULL,
  `username` varchar(25) NOT NULL,
  `password` char(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `doctors`
--

INSERT INTO `doctors` (`id`, `name`, `birth_date`, `gender`, `nationality`, `address`, `mobile_phone`, `email`, `license_no`, `department`, `position`, `username`, `password`) VALUES
(2, 'Hania Batt', '2003-08-18', 'female', 'Egypt', NULL, NULL, 'batota.hania@gmail.com', NULL, 'Cardiology', 'Consultant', 'batota', '$2y$10$eaL5phtOVKACqwsQvMHOB.9a4ikjxGv2u4mOFfM1flDYxdNYL.0yO'),
(7, 'Lana Zamel', '1975-07-20', 'female', 'Palestine', '56 Berliner Strasse, 65974', '+491785648965', 'lana@gmail.com', '6598742C', 'Dermatology', 'Consultant', 'lanlona', '$2y$10$xObdgznRNS1dYm/jq97CTu2.NKSS/y2HFtdI4FVXHwVrFM56MqwTi'),
(10, 'Retaj Batt', NULL, NULL, NULL, NULL, NULL, 'retaj.batt@gmail.com', NULL, NULL, NULL, 'dodo24', '$2y$10$DCjJdfAqji3bQ7z0wcHn1O2oUIplacfAIQBYO63vACLcOFJcbDavu'),
(11, 'somto', NULL, NULL, NULL, NULL, NULL, 'somto@gmail.com', NULL, NULL, NULL, 'somb', '$2y$10$YbX8J/iTq.H3pG/bpIWckee8szFIRz3aCVz7FBiCuSvusGqYa43rW'),
(12, 'Paul', NULL, NULL, NULL, NULL, NULL, 'paul@gmail.com', NULL, NULL, NULL, 'Walker', '$2y$10$hRMFk0Zt8Z/A2uC0gIxkXealYIWFM6O6BQPaWey5PXCVwlsL.CK8K'),
(13, 'Elena Walker', NULL, NULL, NULL, NULL, NULL, 'elena@gmail.com', NULL, NULL, NULL, 'elena32', '$2y$10$3SUrTlXtKRRNkLg9sDaAwuOUPmzpj8.VOqzJdPVvNxkuT7jqLy18W');

-- --------------------------------------------------------

--
-- Table structure for table `patients`
--

CREATE TABLE `patients` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `birthdate` date NOT NULL,
  `gender` enum('female','male','other','') NOT NULL,
  `nationality` varchar(25) NOT NULL,
  `health_insurance_no` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `mobile_phone` varchar(25) NOT NULL,
  `emergency_contact_name` varchar(50) NOT NULL,
  `emergency_contact_no` varchar(25) NOT NULL,
  `doctor_id` int(11) NOT NULL,
  `height` int(5) NOT NULL,
  `weight` int(5) NOT NULL,
  `allergies` varchar(255) DEFAULT NULL,
  `chronic_diseases` varchar(255) DEFAULT NULL,
  `disabilities` varchar(255) DEFAULT NULL,
  `vaccines` varchar(255) DEFAULT NULL,
  `medications` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `patients`
--

INSERT INTO `patients` (`id`, `name`, `birthdate`, `gender`, `nationality`, `health_insurance_no`, `email`, `mobile_phone`, `emergency_contact_name`, `emergency_contact_no`, `doctor_id`, `height`, `weight`, `allergies`, `chronic_diseases`, `disabilities`, `vaccines`, `medications`) VALUES
(1, 'Jane Doe', '1985-02-14', 'female', 'Germany', 'HIN1234567890', 'janedoe@example.com', '+491234567891', 'John Doe', '+491234567892', 2, 170, 65, 'Penicillin', 'Hypertension', 'None', 'Influenza, Tetanus', NULL),
(3, 'Michael Jonas', '2000-06-05', 'male', 'Germany', 'HC7468594', 'michaeljonas@gmail.com', '+491563450908', 'Katrina Jonas', '+491763408162', 2, 180, 83, 'Bees', NULL, NULL, 'COVID-19, Tetanus', NULL),
(4, 'Sophie Becker', '1992-09-18', 'female', 'Germany', 'TK987654321', 'sophie.becker@outlook.com', '+491234567892', 'Max Becker', '+491234567893', 7, 165, 60, 'Dust', '', '', 'Influenza, Pneumococcal', ''),
(5, 'Lukas Müller', '1988-03-10', 'male', 'Switzerland', 'TK54867135', 'lukas.mueller@gmail.com', '+491234567890', 'Anna Müller', '+491658743548', 7, 180, 86, '', 'High Cholesterol', '', 'Flu, Hepatitis B', ''),
(6, 'Elena Schmidt', '1995-06-25', 'female', 'France', 'DAK52468367', 'elena.schmidt@gmail.com', '+491234567894', 'Markus Schmidt', '+491234567895', 7, 155, 60, '', '', '', 'Flu, Hepatitis B', 'Monoxidil'),
(9, 'Paul Walker', '1995-01-25', 'male', 'Albania', 'TK2548973', 'paul@outlook.com', '+4935261795', 'Sophia', '+4936527497', 13, 180, 95, '', '', '', 'COVID-19', '');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `doctors`
--
ALTER TABLE `doctors`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD KEY `name` (`name`);

--
-- Indexes for table `patients`
--
ALTER TABLE `patients`
  ADD PRIMARY KEY (`id`),
  ADD KEY `name` (`name`),
  ADD KEY `fk_doctor_id` (`doctor_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `doctors`
--
ALTER TABLE `doctors`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `patients`
--
ALTER TABLE `patients`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `patients`
--
ALTER TABLE `patients`
  ADD CONSTRAINT `fk_doctor_id` FOREIGN KEY (`doctor_id`) REFERENCES `doctors` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
