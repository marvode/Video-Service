-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Aug 20, 2019 at 04:40 PM
-- Server version: 10.3.16-MariaDB
-- PHP Version: 7.3.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `Video_Stream`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`) VALUES
(1, 'Film & Animation'),
(2, 'Autos & Vehicles'),
(3, 'Music'),
(4, 'Pets & Animals'),
(5, 'Sports'),
(6, 'Travel & Events'),
(7, 'Gaming'),
(8, 'People & Blogs'),
(9, 'Comedy'),
(10, 'Entertainment'),
(11, 'News & Politics'),
(12, 'Howto & Style'),
(13, 'Education'),
(14, 'Science & Technology'),
(15, 'Nonprofits & Activism');

-- --------------------------------------------------------

--
-- Table structure for table `thumbnails`
--

CREATE TABLE `thumbnails` (
  `id` int(11) NOT NULL,
  `videoId` int(11) NOT NULL,
  `filePath` varchar(250) NOT NULL,
  `selected` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `thumbnails`
--

INSERT INTO `thumbnails` (`id`, `videoId`, `filePath`, `selected`) VALUES
(9, 30, 'uploads/videos/thumbnails/30-5d5bdfbb09d54.jpg', 1),
(10, 31, 'uploads/videos/thumbnails/31-5d5be1700dea3.jpg', 1),
(12, 33, 'uploads/videos/thumbnails/33-5d5be3eb389d5.jpg', 1),
(13, 34, 'uploads/videos/thumbnails/34-5d5be5498329d.jpg', 1),
(14, 35, 'uploads/videos/thumbnails/35-5d5be5b2501aa.jpg', 1);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `first_name` varchar(25) NOT NULL,
  `last_name` varchar(25) NOT NULL,
  `user_name` varchar(25) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `signUpDate` datetime NOT NULL DEFAULT current_timestamp(),
  `profilePic` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `first_name`, `last_name`, `user_name`, `email`, `password`, `signUpDate`, `profilePic`) VALUES
(1, 'Marvellous', 'Odemwingie', 'marvode', 'odemwingiemarv@gmail.com', '88baee8fdbbb39fca619bac126512946f0dd4ea18a8955a5a0f889ee2b1acc0abca67a643d882cb471bad6d7d64f4e120ee06379ff0f3cda0fabcdcf7e301279', '2019-08-15 14:21:41', 'assets/images/profilePictures/default.png');

-- --------------------------------------------------------

--
-- Table structure for table `videos`
--

CREATE TABLE `videos` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `uploadedBy` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `filePath` varchar(255) NOT NULL,
  `category` int(11) DEFAULT 1,
  `uploadDate` datetime NOT NULL DEFAULT current_timestamp(),
  `views` int(11) DEFAULT 0,
  `duration` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `videos`
--

INSERT INTO `videos` (`id`, `title`, `uploadedBy`, `description`, `filePath`, `category`, `uploadDate`, `views`, `duration`) VALUES
(30, 'Georgia Why', 'marvode', 'how to play Georgia Why by John Mayer', 'uploads/videos/How_to_Play_Why_Georgia_by_John_Mayer_on_Guitar.mp4', 13, '2019-08-20 12:55:37', 0, '15:35'),
(31, 'Learn how to play adele day dreamer', 'marvode', 'How to play Adele\'s Daydreamer', 'uploads/videos/Learn_How_to_Play_Adele_Day_Dreamer_Easy_Guitar_Tutorial_Free_PDF_Guitar_Ta.mp4', 3, '2019-08-20 13:02:55', 0, '01:34'),
(33, 'Thinking About You (lyrics)', 'marvode', 'the lyrics to Thinking About You by Frank Ocean', 'uploads/videos/Frank_Ocean_-_Thinkin_Bout_You.mp4', 3, '2019-08-20 13:13:30', 0, '03:20'),
(34, 'How to make money as a programmer', 'marvode', 'How to make money as a programmer by Siraj Raval', 'uploads/videos/How_to_Make_Money_as_a_Programmer_in_2018.mp4', 13, '2019-08-20 13:19:21', 0, '06:59'),
(35, 'File saving with pyqt4', 'marvode', 'Saving files with pyqt4 ', 'uploads/videos/File_Saving_-_PyQt_with_Python_GUI__Programming_tutorial_15.mp4', 13, '2019-08-20 13:21:06', 0, '05:18');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `thumbnails`
--
ALTER TABLE `thumbnails`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `videos`
--
ALTER TABLE `videos`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `thumbnails`
--
ALTER TABLE `thumbnails`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `videos`
--
ALTER TABLE `videos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
