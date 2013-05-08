-- phpMyAdmin SQL Dump
-- version 3.5.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generato il: Mag 16, 2012 alle 22:55
-- Versione del server: 5.5.22-0ubuntu1
-- Versione PHP: 5.3.10-1ubuntu3.1

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `wordpress`
--

-- --------------------------------------------------------

--
-- Struttura della tabella `wp_syg`
--

CREATE TABLE IF NOT EXISTS `wp_syg` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `syg_youtube_username` varchar(255) NOT NULL,
  `syg_youtube_videoformat` varchar(255) NOT NULL,
  `syg_youtube_maxvideocount` int(11) NOT NULL,
  `syg_thumbnail_height` int(11) NOT NULL,
  `syg_thumbnail_width` int(11) NOT NULL,
  `syg_thumbnail_bordersize` int(11) NOT NULL,
  `syg_thumbnail_bordercolor` varchar(255) NOT NULL,
  `syg_thumbnail_borderradius` int(11) NOT NULL,
  `syg_thumbnail_distance` int(11) NOT NULL,
  `syg_thumbnail_overlaysize` int(11) NOT NULL,
  `syg_thumbnail_image` varchar(255) NOT NULL,
  `syg_thumbnail_buttonopacity` float NOT NULL,
  `syg_description_width` int(11) NOT NULL,
  `syg_description_fontsize` int(11) NOT NULL,
  `syg_description_fontcolor` varchar(255) NOT NULL,
  `syg_description_show` tinyint(1) NOT NULL,
  `syg_description_showduration` tinyint(1) NOT NULL,
  `syg_description_showtags` tinyint(1) NOT NULL,
  `syg_description_showratings` tinyint(1) NOT NULL,
  `syg_description_showcategories` tinyint(1) NOT NULL,
  `syg_box_width` int(11) NOT NULL,
  `syg_box_background` varchar(255) NOT NULL,
  `syg_box_radius` int(11) NOT NULL,
  `syg_box_padding` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Dump dei dati per la tabella `wp_syg`
--

INSERT INTO `wp_syg` (`id`, `syg_youtube_username`, `syg_youtube_videoformat`, `syg_youtube_maxvideocount`, `syg_thumbnail_height`, `syg_thumbnail_width`, `syg_thumbnail_bordersize`, `syg_thumbnail_bordercolor`, `syg_thumbnail_borderradius`, `syg_thumbnail_distance`, `syg_thumbnail_overlaysize`, `syg_thumbnail_image`, `syg_thumbnail_buttonopacity`, `syg_description_width`, `syg_description_fontsize`, `syg_description_fontcolor`, `syg_description_show`, `syg_description_showduration`, `syg_description_showtags`, `syg_description_showratings`, `syg_description_showcategories`, `syg_box_width`, `syg_box_background`, `syg_box_radius`, `syg_box_padding`) VALUES
(1, 'acdc', '420n', 20, 133, 100, 2, '#cccccc', 10, 10, 32, 'test.png', 0.1, 100, 11, '#cccccc', 1, 1, 1, 1, 1, 400, 'test.png', 10, 10);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
