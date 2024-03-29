SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

CREATE TABLE `cbases` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `admin_email` varchar(255) NOT NULL,
  `token_encrypted` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  `description` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

CREATE TABLE `projects` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `cbase_id` int(10) unsigned NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `image` varchar(255) NOT NULL,
  `type` varchar(255) NOT NULL,
  `country` varchar(255) NOT NULL,
  `category` varchar(255) NOT NULL,
  `organisation` varchar(255) NOT NULL,
  `website` varchar(255) NOT NULL,
  `download` varchar(255) NOT NULL,
  `license` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `cbase_id` (`cbase_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;
