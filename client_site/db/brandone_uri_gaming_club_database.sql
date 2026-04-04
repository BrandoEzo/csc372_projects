-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Apr 03, 2026 at 03:36 PM
-- Server version: 5.7.44-48
-- PHP Version: 8.3.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `brandone_uri_gaming_club_database`
--

-- --------------------------------------------------------

--
-- Table structure for table `Events`
--

CREATE TABLE `Events` (
  `name` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `day` varchar(40) COLLATE utf8_unicode_ci NOT NULL,
  `time` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `description` text COLLATE utf8_unicode_ci NOT NULL,
  `location` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `special` tinyint(1) NOT NULL,
  `averageAttendees` int(5) NOT NULL,
  `price` float NOT NULL,
  `competition` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `Events`
--

INSERT INTO `Events` (`name`, `day`, `time`, `description`, `location`, `special`, `averageAttendees`, `price`, `competition`) VALUES
('Sugar Rush', 'Wednesday Night in late December', '6:00PM', 'The URI Gaming Club takes part in Sugar Rush, the annual Student Affairs event that takes place around the holidays. This event features several clubs and activities, with the Gaming Club bringing out a few different game consoles like <em>Nintendo Switch</em> and <em>Nintendo Wii</em> for students to play while they enjoy copious amounts of free sugary snacks and drinks. A movie is normally played during this event, as well as music by the URI Radio.', 'Ram\'s Den Dining Hall, located within the URI Memorial Union, 50 Lower College Rd, Kingston, RI, 028', 1, 250, 0, 0),
('URI Rhody Fest', 'First Sunday of Fall Semester', 'TBD', 'The URI Gaming Club is featured at URI\'s Rhody Fest, a welcome event designed for Freshman and new URI students to get to know the clubs and activities available on campus. We bring out a handful of video game consoles and typically run a challenge where if you can beat one of our <em>Super Smash Bros</em> players you win a $5 Dunkin Donuts Gift Card! We bring out some casual games too such as <em>Mario Kart</em> and <em>Mario Party</em>.', 'Outside the URI Memorial Union, 50 Lower College Rd, Kingston, RI, 02881, USA', 1, 800, 0, 0),
('URI Rhody Ruckus Monthly', 'Saturday ', '12:00PM', 'The University of Rhode Island Gaming Club\'s (slighly inconsistent) monthly event, featuring <em>Super Smash Bros Ultimate</em> singles and doubles, <em>Rivals of Aether 2</em>, as well as other fighting game side brackets such as <em>Street Fighter 6</em>, <em>Tekken 8</em>, <em>Guilty Gear: Strive</em>, and more! $5 per main event.\"', 'Atrium 1/2 or Rainville Ballroom of the URI Memorial Union, 50 Lower College Rd, Kingston, RI, 02881', 1, 35, 5, 1),
('URI Rhody Rumble Weekly', 'Friday', '6:00PM', '\"The University of Rhode Island Gaming Club\'s premier weekly <em>Super Smash Bros</em> and <em>Rivals of Aether 2</em> tournament!\"', 'Room 312A / 360 of the URI Memorial Union, 50 Lower College Rd, Kingston, RI, 02881, USA', 0, 20, 0, 1),
('Weekly Game Night', 'Thursday', '6:30PM', 'A new event hosted by Gaming Club to appeal to a more casual audience. Designated times for people to come together and try out some new games they haven\'t played before! Our entire video game and board game selection is available to be played during these events!', 'Room 312A of the URI Memorial Union, 50 Lower College Rd, Kingston, RI, 02881, USA', 0, 12, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `Feedback`
--

CREATE TABLE `Feedback` (
  `firstName` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `lastName` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `age` int(3) NOT NULL,
  `email` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `student` tinyint(1) NOT NULL,
  `interestedTournaments` tinyint(1) NOT NULL,
  `interestedGameNight` tinyint(1) NOT NULL,
  `interestedClubroom` tinyint(1) NOT NULL,
  `interestedOther` tinyint(1) NOT NULL,
  `feedback` text COLLATE utf8_unicode_ci NOT NULL,
  `datetime` timestamp(4) NOT NULL DEFAULT CURRENT_TIMESTAMP(4) ON UPDATE CURRENT_TIMESTAMP(4)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `Feedback`
--

INSERT INTO `Feedback` (`firstName`, `lastName`, `age`, `email`, `student`, `interestedTournaments`, `interestedGameNight`, `interestedClubroom`, `interestedOther`, `feedback`, `datetime`) VALUES
('Brandon', 'Ezovski', 21, 'brandon_ezovski@uri.edu', 1, 1, 1, 1, 1, 'This club is the best!!!', '2026-04-01 22:32:16.7600'),
('Kennedy', 'Miller', 22, 'kennedy_miller@uri.edu', 1, 0, 1, 1, 1, 'The room provides a nice space to relax between classes', '2026-04-01 22:32:16.7600');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `Events`
--
ALTER TABLE `Events`
  ADD PRIMARY KEY (`name`);

--
-- Indexes for table `Feedback`
--
ALTER TABLE `Feedback`
  ADD PRIMARY KEY (`email`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
