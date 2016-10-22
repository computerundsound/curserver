-- phpMyAdmin SQL Dump
-- version 4.4.7
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Erstellungszeit: 29. Mai 2015 um 17:09
-- Server-Version: 5.6.20
-- PHP-Version: 5.5.15

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Datenbank: `cursystem`
--

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `hosts`
--

CREATE TABLE IF NOT EXISTS `hosts` (
	`host_id` int(11) NOT NULL,
	`tld` varchar(50) NOT NULL,
	`domain` varchar(255) NOT NULL,
	`subdomain` varchar(255) NOT NULL,
	`ip` varchar(30) NOT NULL,
	`comment` text NOT NULL,
	`last_change` datetime NOT NULL,
	`vhost_dir` varchar(255) NOT NULL,
	`vhost_htdocs` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indizes der exportierten Tabellen
--

--
-- Indizes für die Tabelle `hosts`
--
ALTER TABLE `hosts`
ADD PRIMARY KEY (`host_id`);

--
-- AUTO_INCREMENT für exportierte Tabellen
--

--
-- AUTO_INCREMENT für Tabelle `hosts`
--
ALTER TABLE `hosts`
MODIFY `host_id` int(11) NOT NULL AUTO_INCREMENT;