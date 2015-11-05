-- phpMyAdmin SQL Dump
-- version 2.11.6
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Oct 04, 2014 at 06:58 AM
-- Server version: 5.0.51
-- PHP Version: 5.2.6

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
use almashines_events;
--
-- Database: `almashines_events`
--

-- --------------------------------------------------------

--
-- Table structure for table `event`
--

CREATE TABLE `event` (
  `event_id` int(11) NOT NULL auto_increment,
  `creator` varchar(50) NOT NULL,
  `title` varchar(255) NOT NULL,
  `location` varchar(256) NOT NULL,
  `sdate` varchar(15) NOT NULL,
  `stime` varchar(10) NOT NULL,
  `fdate` varchar(15) default NULL,
  `ftime` varchar(10) default NULL,
  `desc` text NOT NULL,
  `event_public` char(1) NOT NULL,
  `approved` char(1) NOT NULL,
  `event_logo` varchar(255) default NULL,
  `hashtag_id` int(11) NOT NULL,
  PRIMARY KEY  (`event_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `event`
--

INSERT INTO `event` (`event_id`, `creator`, `title`, `location`, `sdate`, `stime`, `fdate`, `ftime`, `desc`, `event_public`, `approved`, `event_logo`, `hashtag_id`) VALUES
(1, 'abhishek@gmail.com', 'Pantheon', 'Birla Institute of Technology,Mesra', '2014/10/14', '9:45', '2014/10/16', '0:45', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry''s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.', '1', 'y', 'abhishek@gmail.com0931542001412405466.jpg', 1);

-- --------------------------------------------------------

--
-- Table structure for table `event_guests`
--

CREATE TABLE `event_guests` (
  `Event_ID` int(11) NOT NULL,
  `Guest_ID` varchar(50) NOT NULL,
  `isAttending` char(1) NOT NULL,
  `isInvited` char(1) NOT NULL,
  PRIMARY KEY  (`Event_ID`,`Guest_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `event_guests`
--


-- --------------------------------------------------------

--
-- Table structure for table `event_organiser_details`
--

CREATE TABLE `event_organiser_details` (
  `Event_Id` int(11) NOT NULL,
  `Name` varchar(50) NOT NULL,
  `Description` text NOT NULL,
  `User_Id` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `event_organiser_details`
--

INSERT INTO `event_organiser_details` (`Event_Id`, `Name`, `Description`, `User_Id`) VALUES
(1, 'Abhishek Anand ', 'contact : 8864038598', ' abhishek@gmail.com');

-- --------------------------------------------------------

--
-- Table structure for table `event_other_links`
--

CREATE TABLE `event_other_links` (
  `event_id` int(11) NOT NULL,
  `link` varchar(200) NOT NULL,
  `link_detail` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `event_other_links`
--

INSERT INTO `event_other_links` (`event_id`, `link`, `link_detail`) VALUES
(1, 'http://www.facebook.com/pantheon14', 'facebook page'),
(1, 'http://www.pantheon14.in', 'Website');

-- --------------------------------------------------------

--
-- Table structure for table `hashtag_details`
--

CREATE TABLE `hashtag_details` (
  `hashtag_id` int(11) NOT NULL auto_increment,
  `hashtag` varchar(50) NOT NULL,
  PRIMARY KEY  (`hashtag_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `hashtag_details`
--

INSERT INTO `hashtag_details` (`hashtag_id`, `hashtag`) VALUES
(1, 'GODS_MUST_BE_CRAZY');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(250) NOT NULL,
  `email` varchar(250) NOT NULL,
  `password` varchar(50) NOT NULL,
  `created` date NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `created`) VALUES
(1, 'Abhishek Anand', 'abhishek@gmail.com', '$1$5t2.oN0.$AObSvdTt4IPX0dXV8JjnQ.', '2014-10-04');
