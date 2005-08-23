-- phpMyAdmin SQL Dump
-- version 2.6.3-pl1
-- http://www.phpmyadmin.net
-- 
-- Serveur: localhost
-- Généré le : Samedi 20 Août 2005 à 10:13
-- Version du serveur: 4.1.11
-- Version de PHP: 4.3.10
-- 
-- Base de données: `spip_avion`
-- 

-- --------------------------------------------------------

-- 
-- Structure de la table `spip_avion_data`
-- 

CREATE TABLE `spip_avion_data` (
  `id_avion_data` bigint(20) NOT NULL auto_increment,
  `date` datetime NOT NULL default '0000-00-00 00:00:00',
  `x` float NOT NULL default '0',
  `y` float NOT NULL default '0',
  `altitude` float NOT NULL default '0',
  `roulis` float NOT NULL default '0',
  `tangage` float NOT NULL default '0',
  `lacet` float NOT NULL default '0',
  `vx` float NOT NULL default '0',
  `vz` float NOT NULL default '0',
  `temps` bigint(11) NOT NULL default '0',
  PRIMARY KEY  (`id_avion_data`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_bin AUTO_INCREMENT=1388 ;
