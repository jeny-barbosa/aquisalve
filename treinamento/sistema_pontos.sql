-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: 31-Jul-2019 às 18:59
-- Versão do servidor: 5.7.26
-- versão do PHP: 5.6.40

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sistema_pontos`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `colaborador`
--

DROP TABLE IF EXISTS `colaborador`;
CREATE TABLE IF NOT EXISTS `colaborador` (
  `ID` int(25) NOT NULL AUTO_INCREMENT,
  `NOME` varchar(50) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `colaborador`
--

INSERT INTO `colaborador` (`ID`, `NOME`) VALUES
(6, 'Jennefer Barbosa');

-- --------------------------------------------------------

--
-- Estrutura da tabela `movidesk`
--

DROP TABLE IF EXISTS `movidesk`;
CREATE TABLE IF NOT EXISTS `movidesk` (
  `ID` int(10) NOT NULL AUTO_INCREMENT,
  `DATA` varchar(10) DEFAULT NULL,
  `HORA_APONTADA` varchar(6) DEFAULT NULL,
  `HORA_TRABALHADA` varchar(10) DEFAULT NULL,
  `ID_USUARIO` int(5) DEFAULT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura da tabela `tangerino`
--

DROP TABLE IF EXISTS `tangerino`;
CREATE TABLE IF NOT EXISTS `tangerino` (
  `ID` int(50) NOT NULL AUTO_INCREMENT,
  `DATA_PONTO` varchar(10) NOT NULL,
  `HORA_PONTO` varchar(10) NOT NULL,
  `ID_USUARIO` int(50) DEFAULT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM AUTO_INCREMENT=786 DEFAULT CHARSET=latin1 COMMENT='2019-07-23\r\n18:00:00';
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
