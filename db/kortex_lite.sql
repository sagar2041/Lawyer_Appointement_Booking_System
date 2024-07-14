-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 27, 2024 at 08:08 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `kortex_lite`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(10) NOT NULL,
  `name` varchar(50) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `photo` varchar(100) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `name`, `username`, `password`, `photo`) VALUES
(1, 'sagar patil', 'patilsagar1722@gmail.com', 'aa7f019c326413d5b8bcad4314228bcd33ef557f5d81c7cc977f7728156f4357', '05profile.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `appointments`
--

CREATE TABLE `appointments` (
  `id` int(11) NOT NULL,
  `client_name` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `start` varchar(255) NOT NULL,
  `end` varchar(255) NOT NULL,
  `description` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `bookings`
--

CREATE TABLE `bookings` (
  `id` int(11) NOT NULL,
  `clientname` varchar(11) NOT NULL,
  `transaction_id` varchar(255) NOT NULL,
  `payee` varchar(255) NOT NULL,
  `payment_date` datetime NOT NULL,
  `lawyer_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `bookings`
--

INSERT INTO `bookings` (`id`, `clientname`, `transaction_id`, `payee`, `payment_date`, `lawyer_name`) VALUES
(32, 'yash jain', 'dfgredffbg', 'Sagar Patil', '2024-06-08 18:18:42', '12'),
(33, 'yash jain', 'roiepjdjfue[ir', 'mayur tongle', '2024-06-08 18:21:15', '12'),
(34, 'yash jain', '98598636838773', 'mayur tongle', '2024-06-08 18:28:54', '12'),
(35, 'yash jain', 'ifuhiewf', 'fkdhfhds', '2024-06-10 21:41:47', '12'),
(36, 'Yash Jain', '456446464516', 'yash jain', '2024-06-12 18:44:56', '18'),
(37, 'Yash Jain', '54511456365', 'Yash jain', '2024-06-12 18:56:25', '17'),
(38, 'Atul Masule', '98556538773', 'Atul Masule', '2024-06-12 19:17:48', '15'),
(39, 'Atul Masule', '545121455', 'atul masule', '2024-06-12 19:34:54', '14'),
(40, 'Atul Masule', '51521484', 'atul masule', '2024-06-12 19:43:29', '16'),
(41, 'Harshal Pat', '5121254452', 'Harshal  Patil', '2024-06-12 19:51:51', '14'),
(42, 'Harshal Pat', '4', 'Harshal Patil', '2024-06-12 19:57:12', '18'),
(43, 'Harshal Pat', '415545454245', 'Harshal Patil', '2024-06-12 19:57:18', '18'),
(44, 'Nikhil Daud', '4', 'nikhil daud', '2024-06-12 20:57:52', '18'),
(45, 'Nikhil Daud', '4512111211', 'nikhil daud', '2024-06-12 20:57:58', '18'),
(46, 'Aakansha Pa', '5458542', 'Aakanasha patil', '2024-06-12 21:31:06', '16'),
(47, 'Aakansha Pa', '155454121541', 'Aakanasha patil', '2024-06-12 21:46:02', '18'),
(48, 'Manoj Thaka', '212154212', 'Manoj thakare', '2024-06-12 21:55:41', '14'),
(49, 'Kunal Kate', '556328622', 'kunal kate', '2024-06-13 09:08:32', '18'),
(50, 'Ganesh Chau', '542154151', 'ganesh chaudhari', '2024-06-13 14:36:26', '18'),
(51, 'Ganesh Chau', '8573478568365677', 'ganesh chaudhari', '2024-06-13 14:44:28', '17'),
(52, 'Ganesh Chau', '336364776656', 'Harshal Patil', '2024-06-13 14:49:39', '18'),
(53, 'Yash Jain', '5', 'Yash jain', '2024-06-13 19:01:49', '14'),
(54, 'Yash Jain', '564646645', 'Yash jain', '2024-06-13 19:01:56', '14');

-- --------------------------------------------------------

--
-- Table structure for table `case_register`
--

CREATE TABLE `case_register` (
  `id` int(11) NOT NULL,
  `title` varchar(50) NOT NULL,
  `case_no` varchar(20) NOT NULL,
  `client_name` varchar(50) NOT NULL,
  `court` varchar(50) NOT NULL,
  `case_type` varchar(50) NOT NULL,
  `case_stage` varchar(50) NOT NULL,
  `legel_acts` varchar(50) NOT NULL,
  `description` varchar(100) NOT NULL,
  `lawyer_name` varchar(255) NOT NULL,
  `filling_date` date NOT NULL,
  `hearing_date` date NOT NULL,
  `opposite_lawyer` varchar(50) NOT NULL,
  `total_fees` int(20) NOT NULL,
  `unpaid` int(20) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `case_register`
--

INSERT INTO `case_register` (`id`, `title`, `case_no`, `client_name`, `court`, `case_type`, `case_stage`, `legel_acts`, `description`, `lawyer_name`, `filling_date`, `hearing_date`, `opposite_lawyer`, `total_fees`, `unpaid`) VALUES
(63, 'Employment Case', '752081', '24', '3', '8', '2', '10', 'Employment case under equal pay act', '16', '2024-06-14', '2024-07-25', 'Manish Chavan', 8500, 0),
(54, 'Tax Case', '186204', '30', '2', '6', '3', '10', 'Yash Jain tax case centers on his argument that all his financial activities into the tax laws and r', '18', '2024-06-12', '2024-06-12', 'Manish Chavan', 8000, 0),
(55, 'Business Case', '94708', '30', '2', '8', '1', '9', 'Business case which under the National Environmental Policy Act', '17', '2024-06-14', '2024-07-30', 'Manish Chavan', 9500, 0),
(58, 'Criminal Case', '669410', '22', '2', '2', '2', '4', 'The person is alleged to have physically attacked another individual.', '14', '2024-06-13', '2024-06-13', 'Manish Chavan', 6000, 0),
(57, 'Family Issue Case', '277045', '22', '6', '3', '1', '2', 'Family Issues in Property ', '15', '2024-06-12', '2024-06-12', 'Manish Chavan', 7500, 0),
(59, 'Labor Case', '146611', '22', '3', '4', '2', '10', 'Labor Case  for Employment under the Equal  Pay Act', '16', '2024-06-13', '2024-06-13', 'Manish Chavan', 8500, 0),
(60, 'Criminal Case', '53851', '20', '2', '2', '2', '7', 'criminal case under the safety and health act', '14', '2024-06-13', '2024-06-13', 'Manish chavan', 6000, 0),
(61, 'Tax Case', '463781', '20', '7', '6', '2', '10', 'Tax Case under the equal pay act', '18', '2024-06-13', '2024-06-13', 'Manish Chavan', 8000, 0),
(62, 'Tax Case', '917387', '28', '7', '6', '2', '10', 'Tax case under the equal pay act', '18', '2024-06-19', '2024-08-13', 'Manish Chavan', 8000, 0),
(64, 'Tax Case', '549056', '24', '7', '6', '2', '10', 'Tax Case under Equal pay act', '18', '2024-06-18', '2024-07-24', 'Manish Chavan', 8000, 0),
(65, 'Criminal Case', '579062', '18', '2', '2', '2', '11', 'Criminal case under the criminal act', '14', '2024-06-26', '2024-08-14', 'Manish Chavan', 6000, 0),
(66, 'Tax Case', '246648', '31', '7', '6', '2', '5', 'Tax case under the fair labor standards act', '18', '2024-06-13', '2024-07-23', 'Manish Chavan', 8000, 0),
(67, 'Family case', '976534', '21', '5', '3', '3', '8', 'Family case under the freedom of information act', '18', '2024-06-14', '2024-08-20', 'Manish Chavan', 8000, 0),
(68, 'Cheque Bounce', '193911', '21', '7', '6', '2', '10', 'Cheque Bounce Case under Equal Pay Act', '17', '2024-06-13', '2024-06-13', 'Manish Chavan', 9500, 0),
(70, 'Harassment Case', '763770', '30', '2', '2', '2', '11', 'Harassment case under the criminal act ', '14', '2024-06-17', '2024-08-13', 'Manisha Pawar', 6000, 0);

-- --------------------------------------------------------

--
-- Table structure for table `case_stage`
--

CREATE TABLE `case_stage` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `status` varchar(50) NOT NULL COMMENT '0-active,1-deactive'
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `case_stage`
--

INSERT INTO `case_stage` (`id`, `name`, `status`) VALUES
(1, 'Initial Review', '0'),
(2, 'Investigation', '0'),
(3, 'Legal Review', '0'),
(4, 'Resolution Negotiation', '1'),
(5, 'Final Decision', 'Pending'),
(6, 'Appeal Process', 'Pending'),
(7, 'Settlement', 'Completed'),
(8, 'Closure', '0'),
(9, 'Reopening', 'Pending'),
(10, 'Litigation', 'Active');

-- --------------------------------------------------------

--
-- Table structure for table `case_types`
--

CREATE TABLE `case_types` (
  `id` int(11) NOT NULL,
  `case_type` varchar(50) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `case_types`
--

INSERT INTO `case_types` (`id`, `case_type`) VALUES
(1, 'Civil'),
(2, 'Criminal'),
(3, 'Family'),
(4, 'Employment'),
(5, 'Personal Injury'),
(6, 'Tax'),
(7, 'Environmental'),
(8, 'Contract'),
(9, 'Intellectual Property'),
(10, 'Immigration');

-- --------------------------------------------------------

--
-- Table structure for table `clients`
--

CREATE TABLE `clients` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `gender` varchar(10) NOT NULL,
  `dob` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(255) DEFAULT NULL,
  `mobile` varchar(20) NOT NULL,
  `address` varchar(100) NOT NULL,
  `status` varchar(20) NOT NULL COMMENT '0-active,1-deactive'
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `clients`
--

INSERT INTO `clients` (`id`, `name`, `gender`, `dob`, `email`, `password`, `mobile`, `address`, `status`) VALUES
(22, 'Atul Masule', 'Male', '2001-06-29', 'atulmasule@gmail.com', '0390024610415f44c9d5ca4a01dd96bb09fc95e6450bfd740a9a4cf4abcc8130', '8007682785', 'Dhule', '0'),
(23, 'Priyanka Pawar', 'Female', '1995-01-25', 'priyankapawar@gmail.com', '0390024610415f44c9d5ca4a01dd96bb09fc95e6450bfd740a9a4cf4abcc8130', '7773999534', 'Mumbai', '1'),
(24, 'Aakansha Patil', 'Female', '1997-10-29', 'aakanshapatil@gmail.com', '0390024610415f44c9d5ca4a01dd96bb09fc95e6450bfd740a9a4cf4abcc8130', '8737847454', 'Pune', '0'),
(25, 'Prachi Mane', 'Female', '1998-05-28', 'prachimane@gmail.com', '0390024610415f44c9d5ca4a01dd96bb09fc95e6450bfd740a9a4cf4abcc8130', '8574653520', 'Satara', '0'),
(26, 'Dhanraj Pimple', 'Male', '1994-05-24', 'dhanrajpimple@gmail.com', '0390024610415f44c9d5ca4a01dd96bb09fc95e6450bfd740a9a4cf4abcc8130', '7773999534', 'Solapur', '1'),
(28, 'Nikhil Daud', 'Male', '1997-04-22', 'nikhildaud@gmail.com', '0390024610415f44c9d5ca4a01dd96bb09fc95e6450bfd740a9a4cf4abcc8130', '8737847343', 'Chattrapati Samabhaji Nagar', '0'),
(17, 'Mayur Tongle', 'Male', '1999-06-16', 'mayurtongle1234@gmail.com', '0390024610415f44c9d5ca4a01dd96bb09fc95e6450bfd740a9a4cf4abcc8130', '7773943534', 'At Bhusawal , Jalgaon', '0'),
(18, 'Manoj Thakare', 'Male', '2000-12-20', 'manojthakare@gmail.com', '0390024610415f44c9d5ca4a01dd96bb09fc95e6450bfd740a9a4cf4abcc8130', '7773999534', 'At Parola , Jalgaon', '0'),
(19, 'Rushikesh Marathe', 'Male', '1998-07-22', 'rushikeshmarathe@gmail.com', '0390024610415f44c9d5ca4a01dd96bb09fc95e6450bfd740a9a4cf4abcc8130', '8737847343', 'Amruthdham, Nashik', '0'),
(20, 'Harshal Patil', 'Male', '2001-06-28', 'harshalpatil@gmail.com', '0390024610415f44c9d5ca4a01dd96bb09fc95e6450bfd740a9a4cf4abcc8130', '9420121435', 'Amalner, Jalgaon', '0'),
(21, 'Ganesh Chaudhari', 'Male', '1999-10-22', 'ganeshchaudhari@gmail.com', '0390024610415f44c9d5ca4a01dd96bb09fc95e6450bfd740a9a4cf4abcc8130', '8666598545', 'Amalner, Jalgaon', '0'),
(31, 'Kunal Kate', 'Male', '2001-04-20', 'kunalkate@gmail.com', '0390024610415f44c9d5ca4a01dd96bb09fc95e6450bfd740a9a4cf4abcc8130', '8752432150', 'Nashik', ''),
(30, 'Yash Jain', 'Male', '1998-06-23', 'yashjain@gmail.com', '0390024610415f44c9d5ca4a01dd96bb09fc95e6450bfd740a9a4cf4abcc8130', '9856324510', 'Dhule', '0');

-- --------------------------------------------------------

--
-- Table structure for table `court`
--

CREATE TABLE `court` (
  `id` int(11) NOT NULL,
  `court_category` varchar(50) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `court`
--

INSERT INTO `court` (`id`, `court_category`) VALUES
(1, 'Supreme Court'),
(2, 'High Court'),
(3, 'District Court'),
(4, 'Appellate Court'),
(5, 'Juvenile Court'),
(6, 'Family Court'),
(7, 'Tax Court'),
(8, 'Administrative Court'),
(9, 'Magistrate Court'),
(10, 'Probate Court');

-- --------------------------------------------------------

--
-- Table structure for table `lawyers`
--

CREATE TABLE `lawyers` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `gender` varchar(10) NOT NULL,
  `email` varchar(100) NOT NULL,
  `dob` varchar(255) NOT NULL,
  `password` varchar(256) NOT NULL,
  `mobile` varchar(15) NOT NULL,
  `lawyer_type` varchar(50) NOT NULL,
  `fees` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `lawyers`
--

INSERT INTO `lawyers` (`id`, `name`, `gender`, `email`, `dob`, `password`, `mobile`, `lawyer_type`, `fees`, `created_at`) VALUES
(14, 'Vedant Bhamare', 'Male', 'vedantbhamare@gmail.com', '1985-05-22', '0390024610415f44c9d5ca4a01dd96bb09fc95e6450bfd740a9a4cf4abcc8130', '8600573888', 'Criminal Lawyer', 6000, '2024-06-12 10:48:25'),
(15, 'Mahesh Agrawal', 'Male', 'maheshagrawal@gmail.com', '1980-06-24', '0390024610415f44c9d5ca4a01dd96bb09fc95e6450bfd740a9a4cf4abcc8130', '8574922530', 'Family Lawyer', 7500, '2024-06-12 16:22:29'),
(16, 'ujjawal Nikam', 'Male', 'ujjawalnikam@gmail.com', '1972-02-15', '0390024610415f44c9d5ca4a01dd96bb09fc95e6450bfd740a9a4cf4abcc8130', '9685745241', 'Employment and labor lawyer', 8500, '2024-06-12 16:26:34'),
(17, 'Amit Jain', 'Male', 'amitjain@gmail.com', '1978-04-16', '0390024610415f44c9d5ca4a01dd96bb09fc95e6450bfd740a9a4cf4abcc8130', '7854635214', 'Business Lawyer', 9500, '2024-06-12 16:29:13'),
(18, 'Sagar Bagul', 'Male', 'sagarbagul@gmail.com', '1987-05-19', '0390024610415f44c9d5ca4a01dd96bb09fc95e6450bfd740a9a4cf4abcc8130', '7448018482', 'Tax Lawyer', 8000, '2024-06-12 16:34:16');

-- --------------------------------------------------------

--
-- Table structure for table `legel_acts`
--

CREATE TABLE `legel_acts` (
  `id` int(11) NOT NULL,
  `act_name` varchar(50) NOT NULL,
  `status` int(20) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `legel_acts`
--

INSERT INTO `legel_acts` (`id`, `act_name`, `status`) VALUES
(1, 'Consumer Protection Act', 0),
(2, 'Family and Medical Leave Act', 0),
(3, 'Americans with Disabilities Act', 1),
(4, 'Civil Rights Act', 0),
(5, 'Fair Labor Standards Act', 0),
(6, 'Clean Air Act', 0),
(7, 'Occupational Safety and Health Act', 0),
(8, 'Freedom of Information Act', 0),
(9, 'National Environmental Policy Act', 0),
(10, 'Equal Pay Act', 0),
(11, 'Criminal Act', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `appointments`
--
ALTER TABLE `appointments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bookings`
--
ALTER TABLE `bookings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `case_register`
--
ALTER TABLE `case_register`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `case_stage`
--
ALTER TABLE `case_stage`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `case_types`
--
ALTER TABLE `case_types`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `clients`
--
ALTER TABLE `clients`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `court`
--
ALTER TABLE `court`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `lawyers`
--
ALTER TABLE `lawyers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `legel_acts`
--
ALTER TABLE `legel_acts`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `appointments`
--
ALTER TABLE `appointments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT for table `bookings`
--
ALTER TABLE `bookings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=55;

--
-- AUTO_INCREMENT for table `case_register`
--
ALTER TABLE `case_register`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=71;

--
-- AUTO_INCREMENT for table `case_stage`
--
ALTER TABLE `case_stage`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `case_types`
--
ALTER TABLE `case_types`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `clients`
--
ALTER TABLE `clients`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `court`
--
ALTER TABLE `court`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `lawyers`
--
ALTER TABLE `lawyers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `legel_acts`
--
ALTER TABLE `legel_acts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
