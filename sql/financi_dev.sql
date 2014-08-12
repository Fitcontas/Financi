-- phpMyAdmin SQL Dump
-- version 4.0.10deb1
-- http://www.phpmyadmin.net
--
-- Servidor: localhost
-- Tempo de Geração: 11/08/2014 às 23:47
-- Versão do servidor: 5.5.38-0ubuntu0.14.04.1
-- Versão do PHP: 5.5.15-1+deb.sury.org~trusty+1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Banco de dados: `financi_dev`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `cliente`
--

CREATE TABLE IF NOT EXISTS `cliente` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `instituicao_id` int(11) NOT NULL,
  `cpf` varchar(11) DEFAULT NULL,
  `cnpj` varchar(18) DEFAULT NULL,
  `nome` varchar(100) DEFAULT NULL,
  `data_nascimento` date DEFAULT NULL,
  `sexo` char(1) NOT NULL,
  `nacionalidade` varchar(20) DEFAULT NULL,
  `naturalidade_uf` char(2) DEFAULT NULL,
  `naturalidade` varchar(45) DEFAULT NULL,
  `estado_civil` char(1) DEFAULT NULL,
  `rg` varchar(45) DEFAULT NULL,
  `expedicao` date DEFAULT NULL,
  `ctps` varchar(45) DEFAULT NULL,
  `cbo` int(11) DEFAULT NULL,
  `registro_profissional` varchar(70) DEFAULT NULL,
  `pai` varchar(100) DEFAULT NULL,
  `mae` varchar(100) DEFAULT NULL,
  `nome_fantasia` varchar(100) DEFAULT NULL,
  `inscricao_estadual` varchar(45) DEFAULT NULL,
  `inscricao_municipal` varchar(45) DEFAULT NULL,
  `capital_social` decimal(10,2) DEFAULT NULL,
  `cnae` varchar(45) DEFAULT NULL,
  `regime_tributario` varchar(45) DEFAULT NULL,
  `data_cadastro` date NOT NULL,
  `status` int(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `fk_cliente_instituicao1_idx` (`instituicao_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

--
-- Fazendo dump de dados para tabela `cliente`
--

INSERT INTO `cliente` (`id`, `instituicao_id`, `cpf`, `cnpj`, `nome`, `data_nascimento`, `sexo`, `nacionalidade`, `naturalidade_uf`, `naturalidade`, `estado_civil`, `rg`, `expedicao`, `ctps`, `cbo`, `registro_profissional`, `pai`, `mae`, `nome_fantasia`, `inscricao_estadual`, `inscricao_municipal`, `capital_social`, `cnae`, `regime_tributario`, `data_cadastro`, `status`) VALUES
(1, 1, '04788373564', NULL, 'Fernando Dutra Neres', '1987-04-03', '', 'Brasileiro', 'BA', 'Nova Viçosa', '1', '1388769085', '2014-07-07', NULL, NULL, NULL, 'Nelson Ferreira Neres', 'Ednalva Dutra Neres', NULL, NULL, NULL, NULL, NULL, NULL, '2014-08-04', 1),
(2, 1, '04788373564', NULL, 'fernando dutra neres', '2014-09-08', 'M', 'brasileiro', 'BA', '330', '1', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0000-00-00', 1),
(3, 1, '56465465465', NULL, 'pedro amaral', '2014-09-08', 'M', 'brasileio', 'BA', '336', '3', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0000-00-00', 1),
(4, 1, '54654654665', NULL, 'vania pereira dutra', '2014-09-08', 'F', 'brasiliero', 'MA', '2377', '2', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0000-00-00', 1),
(5, 1, '56468749846', NULL, 'george cabral', '2014-09-08', 'M', 'brasileiro', 'BA', '1078', '2', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0000-00-00', 1),
(6, 1, '56465465465', NULL, 'pedro azevendo', '2014-09-08', 'M', 'brasileiro', 'AP', '287', '2', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0000-00-00', 1),
(7, 1, '56465465465', NULL, 'Fernando amral neto', '2014-09-08', 'M', 'brasileiro', 'BA', '335', '3', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0000-00-00', 1);

-- --------------------------------------------------------

--
-- Estrutura para tabela `cliente_conjuge`
--

CREATE TABLE IF NOT EXISTS `cliente_conjuge` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cliente_id` int(11) NOT NULL,
  `cpf` varchar(11) DEFAULT NULL,
  `nome` varchar(100) DEFAULT NULL,
  `data_nascimento` date DEFAULT NULL,
  `nacionalidade` varchar(20) DEFAULT NULL,
  `uf` char(2) DEFAULT NULL,
  `naturalidade` varchar(45) DEFAULT NULL,
  `estado_civil` char(1) DEFAULT NULL,
  `rg` varchar(45) DEFAULT NULL,
  `expedicao` date DEFAULT NULL,
  `ctps` varchar(45) DEFAULT NULL,
  `cbo` int(11) DEFAULT NULL,
  `registro_profissional` varchar(70) DEFAULT NULL,
  `pai` varchar(100) DEFAULT NULL,
  `mae` varchar(100) DEFAULT NULL,
  `data_cadastro` date NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_cliente_conjuge_cliente1_idx` (`cliente_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estrutura para tabela `cliente_email`
--

CREATE TABLE IF NOT EXISTS `cliente_email` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cliente_id` int(11) NOT NULL,
  `tipo` char(1) NOT NULL,
  `email` varchar(100) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_cliente_email_cliente1_idx` (`cliente_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estrutura para tabela `cliente_endereco`
--

CREATE TABLE IF NOT EXISTS `cliente_endereco` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cliente_id` int(11) NOT NULL,
  `cep` varchar(8) DEFAULT NULL,
  `tipo` int(11) DEFAULT NULL,
  `logradouro` varchar(100) DEFAULT NULL,
  `numero` varchar(15) DEFAULT NULL,
  `complemento` varchar(45) DEFAULT NULL,
  `bairro` varchar(30) DEFAULT NULL,
  `uf` char(2) DEFAULT NULL,
  `cidade` varchar(60) DEFAULT NULL,
  `referencia` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_endereco_cliente_cliente1_idx` (`cliente_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Fazendo dump de dados para tabela `cliente_endereco`
--

INSERT INTO `cliente_endereco` (`id`, `cliente_id`, `cep`, `tipo`, `logradouro`, `numero`, `complemento`, `bairro`, `uf`, `cidade`, `referencia`) VALUES
(1, 7, '45985-10', 1, 'Rua Marechal Eurico Gaspar Dutra', '273', NULL, 'Centro', 'BA', '331', NULL);

-- --------------------------------------------------------

--
-- Estrutura para tabela `cliente_telefone`
--

CREATE TABLE IF NOT EXISTS `cliente_telefone` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cliente_id` int(11) NOT NULL,
  `tipo` char(1) NOT NULL,
  `ddd` varchar(3) NOT NULL,
  `numero` varchar(12) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_cliente_telefone_cliente1_idx` (`cliente_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estrutura para tabela `grupo_usuario`
--

CREATE TABLE IF NOT EXISTS `grupo_usuario` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `descricao` varchar(45) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Fazendo dump de dados para tabela `grupo_usuario`
--

INSERT INTO `grupo_usuario` (`id`, `descricao`) VALUES
(1, 'Administrador');

-- --------------------------------------------------------

--
-- Estrutura para tabela `instituicao`
--

CREATE TABLE IF NOT EXISTS `instituicao` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome_fantasia` varchar(45) NOT NULL,
  `razao_social` varchar(45) NOT NULL,
  `cnpj` varchar(18) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Fazendo dump de dados para tabela `instituicao`
--

INSERT INTO `instituicao` (`id`, `nome_fantasia`, `razao_social`, `cnpj`) VALUES
(1, 'Financi Imóveis', 'Financi Imóveis', '035656565654656');

-- --------------------------------------------------------

--
-- Estrutura para tabela `usuario`
--

CREATE TABLE IF NOT EXISTS `usuario` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `usuario` varchar(45) NOT NULL,
  `nome` varchar(30) NOT NULL,
  `apelido` varchar(15) NOT NULL,
  `email` varchar(60) NOT NULL,
  `senha` varchar(64) NOT NULL,
  `admin` tinyint(1) DEFAULT NULL,
  `instituicao_id` int(11) NOT NULL,
  `grupo_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `instituicao_pk` (`instituicao_id`),
  KEY `grupo_pks` (`grupo_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Fazendo dump de dados para tabela `usuario`
--

INSERT INTO `usuario` (`id`, `usuario`, `nome`, `apelido`, `email`, `senha`, `admin`, `instituicao_id`, `grupo_id`) VALUES
(1, 'nandodutra', 'Fernando Dutra', 'Fernando', 'fernando@inova2b.com.br', '7c4a8d09ca3762af61e59520943dc26494f8941b', 1, 1, 1),
(4, 'teste', 'teste blabal ba', 'teste', 'teste@teste.com.br', 'da39a3ee5e6b4b0d3255bfef95601890afd80709', NULL, 1, 1);

--
-- Restrições para dumps de tabelas
--

--
-- Restrições para tabelas `cliente`
--
ALTER TABLE `cliente`
  ADD CONSTRAINT `fk_cliente_instituicao1` FOREIGN KEY (`instituicao_id`) REFERENCES `instituicao` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Restrições para tabelas `cliente_conjuge`
--
ALTER TABLE `cliente_conjuge`
  ADD CONSTRAINT `fk_cliente_conjuge_cliente1` FOREIGN KEY (`cliente_id`) REFERENCES `cliente` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Restrições para tabelas `cliente_email`
--
ALTER TABLE `cliente_email`
  ADD CONSTRAINT `fk_cliente_email_cliente1` FOREIGN KEY (`cliente_id`) REFERENCES `cliente` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Restrições para tabelas `cliente_endereco`
--
ALTER TABLE `cliente_endereco`
  ADD CONSTRAINT `fk_endereco_cliente_cliente1` FOREIGN KEY (`cliente_id`) REFERENCES `cliente` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Restrições para tabelas `cliente_telefone`
--
ALTER TABLE `cliente_telefone`
  ADD CONSTRAINT `fk_cliente_telefone_cliente1` FOREIGN KEY (`cliente_id`) REFERENCES `cliente` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
