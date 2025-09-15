-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 13, 2025 at 03:29 PM
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
-- Database: `library_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `book`
--

CREATE TABLE `book` (
  `book_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `author` varchar(255) NOT NULL,
  `year` int(11) DEFAULT NULL,
  `condition` enum('new','used','unknown') NOT NULL,
  `copies` int(11) NOT NULL,
  `description` text DEFAULT NULL,
  `categories` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `book`
--

INSERT INTO `book` (`book_id`, `title`, `author`, `year`, `condition`, `copies`, `description`, `categories`) VALUES
(59, 'Dune', 'Frank Herbert', 1965, 'new', 27, 'A sci-fi epic set on the desert planet Arrakis, where Paul Atreides becomes entwined in a battle for control of the planet\'s spice, a substance vital to interstellar travel. It explores themes of politics, religion, ecology, and human ambition.', 'Science Fiction'),
(60, 'Atomic Habits', 'James Clear', 2018, 'used', 17, 'A practical guide to building good habits and breaking bad ones. Clear emphasizes the power of small, consistent changes and explains strategies like habit stacking, cues, and rewards to create lasting behavior change for personal and professional growth.', 'Personal Development'),
(61, 'The Richest Man in Babylon', 'George S. Clason', NULL, 'unknown', 0, 'A classic book offering timeless financial wisdom through parables set in ancient Babylon. It covers principles like saving, investing, and living within your means, conveyed through engaging stories that make complex financial concepts easy to understand.', 'Personal Finance'),
(62, 'Χαμογέλα, ρε... τι σου ζητάνε', 'Χρόνης Μίσσιος', 1988, 'new', 9, 'A deeply personal and philosophical reflection on life, love, freedom, and the human condition, written as a monologue. It blends humor and tragedy, portraying the struggles of an individual against societal constraints and injustices in post-war Greece.', 'Literature'),
(64, 'Χνότα στο τζάμι', 'Παπαθεοδώρου Βασίλης', 2007, 'used', 7, 'Χνότα στο τζάμι by Παπαθεοδώρου Βασίλης is a poignant and thought-provoking novel that reflects on the themes of resilience, survival, and human dignity in the face of adversity. Set against the backdrop of historical and social turbulence, the story unfolds through interconnected narratives that reveal the impact of personal choices and external circumstances on individuals\' lives. With vivid imagery and emotional depth, Papatheodorou crafts a tale that lingers in the reader\'s mind, much like the fleeting mark of breath on glass, symbolizing both fragility and endurance.', 'Literacy Fiction'),
(65, 'Rich Dad Poor Dad', 'Robert T. Kiyosaki', 1997, 'new', 6, 'Rich Dad Poor Dad by Robert T. Kiyosaki explores the contrasting financial mindsets of two father figures. The \"Poor Dad\" values traditional education, job security, and saving money, while the \"Rich Dad\" emphasizes financial education, investing, and creating passive income to build wealth. Kiyosaki explains the difference between assets, which generate income, and liabilities, which drain resources, encouraging readers to focus on acquiring assets.', 'Personal Finance');

-- --------------------------------------------------------

--
-- Table structure for table `borrow`
--

CREATE TABLE `borrow` (
  `borrow_id` int(11) NOT NULL,
  `book_id` int(11) DEFAULT NULL,
  `title` varchar(255) NOT NULL,
  `borrow_date` date NOT NULL,
  `return_date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `borrow`
--

INSERT INTO `borrow` (`borrow_id`, `book_id`, `title`, `borrow_date`, `return_date`) VALUES
(48, 59, 'Dune', '2025-01-11', NULL),
(49, 59, 'Dune', '2025-01-11', NULL),
(50, 59, 'Dune', '2025-01-11', NULL),
(51, 59, 'Dune', '2025-01-11', NULL),
(52, 61, 'The Richest Man in Babylon', '2025-01-12', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `category_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`category_id`, `name`) VALUES
(1, 'Fiction'),
(6, 'Literacy Fiction'),
(7, 'Literature'),
(3, 'Non-Fiction'),
(5, 'Personal Development'),
(4, 'Personal Finance'),
(2, 'Science Fiction');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `book`
--
ALTER TABLE `book`
  ADD PRIMARY KEY (`book_id`);

--
-- Indexes for table `borrow`
--
ALTER TABLE `borrow`
  ADD PRIMARY KEY (`borrow_id`),
  ADD KEY `book_id` (`book_id`);

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`category_id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `book`
--
ALTER TABLE `book`
  MODIFY `book_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=70;

--
-- AUTO_INCREMENT for table `borrow`
--
ALTER TABLE `borrow`
  MODIFY `borrow_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=53;

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `borrow`
--
ALTER TABLE `borrow`
  ADD CONSTRAINT `borrow_ibfk_1` FOREIGN KEY (`book_id`) REFERENCES `book` (`book_id`) ON DELETE SET NULL ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
