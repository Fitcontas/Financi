-- phpMyAdmin SQL Dump
-- version 4.0.10deb1
-- http://www.phpmyadmin.net
--
-- Servidor: localhost
-- Tempo de Geração: 25/08/2014 às 22:48
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
  `residencia` int(11) DEFAULT NULL,
  `registro_geral` varchar(45) DEFAULT NULL,
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
  `status` int(2) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `fk_cliente_instituicao1_idx` (`instituicao_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=21 ;

--
-- Fazendo dump de dados para tabela `cliente`
--

INSERT INTO `cliente` (`id`, `instituicao_id`, `cpf`, `cnpj`, `nome`, `data_nascimento`, `sexo`, `nacionalidade`, `naturalidade_uf`, `naturalidade`, `estado_civil`, `residencia`, `registro_geral`, `expedicao`, `ctps`, `cbo`, `registro_profissional`, `pai`, `mae`, `nome_fantasia`, `inscricao_estadual`, `inscricao_municipal`, `capital_social`, `cnae`, `regime_tributario`, `data_cadastro`, `status`) VALUES
(20, 1, '04788373564', NULL, 'fernando dutra neres', '2014-08-12', 'M', 'brasileiro', 'BA', '877', '1', 1, '1388769085', NULL, '545646546546', 254310, '234654787', 'nelson Ferreira Neres', 'Ednalva Dutra Neres', NULL, NULL, NULL, NULL, NULL, NULL, '0000-00-00', 1);

-- --------------------------------------------------------

--
-- Estrutura para tabela `cliente_conjuge`
--

CREATE TABLE IF NOT EXISTS `cliente_conjuge` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cliente_id` int(11) NOT NULL,
  `cpf` varchar(11) DEFAULT NULL,
  `nome` varchar(100) DEFAULT NULL,
  `sexo` char(1) DEFAULT NULL,
  `data_nascimento` date DEFAULT NULL,
  `nacionalidade` varchar(20) DEFAULT NULL,
  `naturalidade_uf` char(2) DEFAULT NULL,
  `naturalidade` varchar(45) DEFAULT NULL,
  `estado_civil` char(1) DEFAULT NULL,
  `registro_geral` varchar(45) DEFAULT NULL,
  `expedicao` date DEFAULT NULL,
  `ctps` varchar(45) DEFAULT NULL,
  `cbo` int(11) DEFAULT NULL,
  `registro_profissional` varchar(70) DEFAULT NULL,
  `pai` varchar(100) DEFAULT NULL,
  `mae` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_cliente_conjuge_cliente1_idx` (`cliente_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Fazendo dump de dados para tabela `cliente_conjuge`
--

INSERT INTO `cliente_conjuge` (`id`, `cliente_id`, `cpf`, `nome`, `sexo`, `data_nascimento`, `nacionalidade`, `naturalidade_uf`, `naturalidade`, `estado_civil`, `registro_geral`, `expedicao`, `ctps`, `cbo`, `registro_profissional`, `pai`, `mae`) VALUES
(1, 20, '23154654654', 'Elivane pereira da silva', NULL, NULL, NULL, 'AP', '284', NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL);

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Fazendo dump de dados para tabela `cliente_email`
--

INSERT INTO `cliente_email` (`id`, `cliente_id`, `tipo`, `email`) VALUES
(1, 20, '1', 'fernando@inova2b.com.br');

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Fazendo dump de dados para tabela `cliente_endereco`
--

INSERT INTO `cliente_endereco` (`id`, `cliente_id`, `cep`, `tipo`, `logradouro`, `numero`, `complemento`, `bairro`, `uf`, `cidade`, `referencia`) VALUES
(1, 20, '45985-16', 1, 'Avenida Marechal Castelo Branco - atÃ© 549 - lado Ã­mpar', '273', NULL, 'Centro', 'BA', '1078', NULL),
(2, 20, '45985106', 3, 'Rua Marechal Eurico Gaspar Dutra', '6564', NULL, 'Centro', 'BA', '1078', NULL);

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

--
-- Fazendo dump de dados para tabela `cliente_telefone`
--

INSERT INTO `cliente_telefone` (`id`, `cliente_id`, `tipo`, `ddd`, `numero`) VALUES
(8, 20, '1', '73', '99261430');

-- --------------------------------------------------------

--
-- Estrutura para tabela `corretor`
--

CREATE TABLE IF NOT EXISTS `corretor` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `instituicao_id` int(11) NOT NULL,
  `cpf` varchar(11) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `sexo` char(1) DEFAULT NULL,
  `data_nascimento` date DEFAULT NULL,
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
  `data_cadastro` date NOT NULL,
  `status` int(2) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `fk_corretor_instituicao1_idx` (`instituicao_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Fazendo dump de dados para tabela `corretor`
--

INSERT INTO `corretor` (`id`, `instituicao_id`, `cpf`, `nome`, `sexo`, `data_nascimento`, `nacionalidade`, `naturalidade_uf`, `naturalidade`, `estado_civil`, `rg`, `expedicao`, `ctps`, `cbo`, `registro_profissional`, `pai`, `mae`, `data_cadastro`, `status`) VALUES
(1, 1, '04788373564', 'Fernando Dutra Neres', NULL, NULL, 'Brasileiro', 'BA', 'Nova Vicosa', '1', '1388769085', '2014-07-07', NULL, NULL, NULL, NULL, NULL, '2014-04-08', 1),
(2, 1, '62356631534', 'Amaral Azevedo Neto', NULL, '2014-08-16', 'brasileiro', 'BA', 'Nova Viçosa', '1', '321456465', '2014-08-16', NULL, NULL, NULL, NULL, NULL, '2014-08-16', 1),
(4, 1, '04788837356', 'Valvir rodrigues da silva', 'M', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 223124, NULL, NULL, NULL, '0000-00-00', 1);

-- --------------------------------------------------------

--
-- Estrutura para tabela `corretor_email`
--

CREATE TABLE IF NOT EXISTS `corretor_email` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `corretor_id` int(11) NOT NULL,
  `tipo` char(1) NOT NULL,
  `email` varchar(100) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_corretor_email_corretor1_idx` (`corretor_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Fazendo dump de dados para tabela `corretor_email`
--

INSERT INTO `corretor_email` (`id`, `corretor_id`, `tipo`, `email`) VALUES
(1, 4, '1', 'fernando@gmail.com');

-- --------------------------------------------------------

--
-- Estrutura para tabela `corretor_endereco`
--

CREATE TABLE IF NOT EXISTS `corretor_endereco` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `corretor_id` int(11) NOT NULL,
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
  KEY `fk_corretor_endereco_corretor1_idx` (`corretor_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Fazendo dump de dados para tabela `corretor_endereco`
--

INSERT INTO `corretor_endereco` (`id`, `corretor_id`, `cep`, `tipo`, `logradouro`, `numero`, `complemento`, `bairro`, `uf`, `cidade`, `referencia`) VALUES
(1, 1, '45985160', 1, 'Rua teste sa silva', '273', NULL, 'Centro', 'BA', 'Teixeira de Freitas', NULL),
(2, 4, '45985-16', 1, 'Avenida Marechal Castelo Branco - atÃ© 549 - lado Ã­mpar', '273', NULL, 'Centro', 'DF', '1778', NULL);

-- --------------------------------------------------------

--
-- Estrutura para tabela `corretor_telefone`
--

CREATE TABLE IF NOT EXISTS `corretor_telefone` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `corretor_id` int(11) NOT NULL,
  `tipo` char(1) NOT NULL,
  `ddd` varchar(3) NOT NULL,
  `numero` varchar(12) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_corretor_telefone_corretor1_idx` (`corretor_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Fazendo dump de dados para tabela `corretor_telefone`
--

INSERT INTO `corretor_telefone` (`id`, `corretor_id`, `tipo`, `ddd`, `numero`) VALUES
(1, 4, '1', '73', '99141430'),
(2, 4, '2', '73', '30134559');

-- --------------------------------------------------------

--
-- Estrutura para tabela `empreendimento`
--

CREATE TABLE IF NOT EXISTS `empreendimento` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `instituicao_id` int(11) NOT NULL,
  `empreendimento` varchar(255) NOT NULL,
  `cri` varchar(45) NOT NULL,
  `comissao` decimal(10,2) NOT NULL,
  `entrada` decimal(10,2) NOT NULL,
  `intermediarias` decimal(10,2) NOT NULL,
  `periodo` int(11) NOT NULL,
  `qtd_parcelas` int(11) NOT NULL,
  `taxa_financiamento` decimal(10,2) NOT NULL,
  `indice_correcao` int(11) NOT NULL,
  `cep` varchar(8) DEFAULT NULL,
  `logradouro` varchar(100) DEFAULT NULL,
  `numero` varchar(10) DEFAULT NULL,
  `complemento` varchar(100) DEFAULT NULL,
  `bairro` varchar(30) DEFAULT NULL,
  `cidade` varchar(45) DEFAULT NULL,
  `uf` char(2) DEFAULT NULL,
  `status` int(2) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `fk_empreendimento_instituicao1_idx` (`instituicao_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Fazendo dump de dados para tabela `empreendimento`
--

INSERT INTO `empreendimento` (`id`, `instituicao_id`, `empreendimento`, `cri`, `comissao`, `entrada`, `intermediarias`, `periodo`, `qtd_parcelas`, `taxa_financiamento`, `indice_correcao`, `cep`, `logradouro`, `numero`, `complemento`, `bairro`, `cidade`, `uf`, `status`) VALUES
(1, 1, 'Village dos Lagos', '19.560, livro A2', 5.00, 15.00, 3.00, 4, 96, 0.00, 1, '45985160', 'Rua Eurico Gaspar DUtra', '273', NULL, 'Centro', 'Teixeira de Freitas', 'BA', 1),
(3, 1, 'residencial italia', 'ita ld949. ijkel', 30.00, 0.00, 15.00, 4, 96, 15.00, 1, '45985-16', 'Avenida Marechal Castelo Branco - atÃ© 549 - lado Ã­mpar', '273', NULL, 'Centro', 'Teixeira de Freitas', 'BA', 1),
(4, 1, 'Vila FEliz', '4554', 15.00, 0.00, 45.00, 4, 45, 1.00, 1, '45985-16', 'Avenida Marechal Castelo Branco - atÃ© 549 - lado Ã­mpar', '273', NULL, 'Centro', 'Teixeira de Freitas', 'BA', 1);

-- --------------------------------------------------------

--
-- Estrutura para tabela `empreendimento_corretor`
--

CREATE TABLE IF NOT EXISTS `empreendimento_corretor` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `corretor_id` int(11) NOT NULL,
  `empreendimento_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_empreendimento_corretor_empreendimento1_idx` (`empreendimento_id`),
  KEY `fk_empreendimento_corretor_corretor1_idx` (`corretor_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=11 ;

--
-- Fazendo dump de dados para tabela `empreendimento_corretor`
--

INSERT INTO `empreendimento_corretor` (`id`, `corretor_id`, `empreendimento_id`) VALUES
(4, 1, 3),
(5, 2, 3),
(6, 1, 1),
(7, 2, 1),
(8, 1, 4),
(9, 4, 4),
(10, 2, 4);

-- --------------------------------------------------------

--
-- Estrutura para tabela `grupo_usuario`
--

CREATE TABLE IF NOT EXISTS `grupo_usuario` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `descricao` varchar(45) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Fazendo dump de dados para tabela `grupo_usuario`
--

INSERT INTO `grupo_usuario` (`id`, `descricao`) VALUES
(1, 'Administrador'),
(2, 'Corretor');

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
-- Estrutura para tabela `lote`
--

CREATE TABLE IF NOT EXISTS `lote` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `empreendimento_id` int(11) NOT NULL,
  `numero` varchar(30) NOT NULL,
  `quadra` varchar(30) NOT NULL,
  `valor` decimal(10,2) NOT NULL,
  `area_total` varchar(30) NOT NULL,
  `matricula` varchar(50) DEFAULT NULL,
  `inscricao_municipal` varchar(50) DEFAULT NULL,
  `frente` varchar(255) NOT NULL,
  `frente_metro` decimal(10,2) NOT NULL,
  `fundo` varchar(255) NOT NULL,
  `fundo_metro` decimal(10,2) NOT NULL,
  `lateral_direita` varchar(255) NOT NULL,
  `lateral_direita_metro` decimal(10,2) NOT NULL,
  `lateral_esquerda` varchar(255) NOT NULL,
  `lateral_esquerda_metro` decimal(10,2) NOT NULL,
  `cep` varchar(8) DEFAULT NULL,
  `logradouro` varchar(100) DEFAULT NULL,
  `num` varchar(10) DEFAULT NULL,
  `complemento` varchar(100) DEFAULT NULL,
  `bairro` varchar(30) DEFAULT NULL,
  `cidade` varchar(45) DEFAULT NULL,
  `uf` char(2) DEFAULT NULL,
  `status` int(11) DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `fk_lote_empreendimento1_idx` (`empreendimento_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Fazendo dump de dados para tabela `lote`
--

INSERT INTO `lote` (`id`, `empreendimento_id`, `numero`, `quadra`, `valor`, `area_total`, `matricula`, `inscricao_municipal`, `frente`, `frente_metro`, `fundo`, `fundo_metro`, `lateral_direita`, `lateral_direita_metro`, `lateral_esquerda`, `lateral_esquerda_metro`, `cep`, `logradouro`, `num`, `complemento`, `bairro`, `cidade`, `uf`, `status`) VALUES
(1, 1, '0001', 'A9', 250000.00, '1500', '12345687', '468798789', 'fd', 2.00, 'fd', 2.00, 'fd', 3.00, 'fd', 2.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1),
(2, 3, '001', 'a5', 450000.00, '2500', '65656', '56565', 'fdfsfds', 2.00, 'fsdfsd', 4.00, 'fsdsd', 4.00, 'fsdfds', 5.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1);

-- --------------------------------------------------------

--
-- Estrutura para tabela `usuario`
--

CREATE TABLE IF NOT EXISTS `usuario` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `instituicao_id` int(11) NOT NULL,
  `grupo_id` int(11) DEFAULT NULL,
  `usuario` varchar(45) NOT NULL,
  `nome` varchar(30) NOT NULL,
  `apelido` varchar(15) NOT NULL,
  `email` varchar(60) NOT NULL,
  `senha` varchar(64) NOT NULL,
  `admin` tinyint(1) DEFAULT NULL,
  `status` int(2) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `instituicao_pk` (`instituicao_id`),
  KEY `grupo_pks` (`grupo_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=20 ;

--
-- Fazendo dump de dados para tabela `usuario`
--

INSERT INTO `usuario` (`id`, `instituicao_id`, `grupo_id`, `usuario`, `nome`, `apelido`, `email`, `senha`, `admin`, `status`) VALUES
(1, 1, 1, 'nandodutra', 'Fernando Dutra', 'Fernando', 'fernando@inova2b.com.br', '7c4a8d09ca3762af61e59520943dc26494f8941b', 1, 0),
(4, 1, 2, 'teste', 'teste blabal ba', 'teste', 'teste@teste.com', 'da39a3ee5e6b4b0d3255bfef95601890afd80709', NULL, 1),
(5, 1, 1, 'fsdfsd', 'fsdfds', 'fsdfds', 'fdgdfgdfg', 'da39a3ee5e6b4b0d3255bfef95601890afd80709', NULL, 0),
(6, 1, 1, 'fsdfsd', 'fsdfsd', 'fsdfsdf', 'fsdfsdf', 'da39a3ee5e6b4b0d3255bfef95601890afd80709', NULL, 1),
(7, 1, 1, 'fsdfsdf', 'fsdfds', 'fsdfsdfsd', 'fssdfsdf', 'da39a3ee5e6b4b0d3255bfef95601890afd80709', NULL, 2),
(8, 1, 1, 'fsdfsdf', 'fsdfsdf', 'fsdfds', 'sfdsdfds', 'da39a3ee5e6b4b0d3255bfef95601890afd80709', NULL, 2),
(9, 1, 1, 'fsdfsdfsd', 'fsdfdsfs', 'fsdfsdfsdf', 'fsdsfsdfsd', 'da39a3ee5e6b4b0d3255bfef95601890afd80709', NULL, 2),
(10, 1, 1, 'sdfadfas', 'fsdfsd', 'sdfsdf', 'dsfsdfds', 'da39a3ee5e6b4b0d3255bfef95601890afd80709', NULL, 2),
(11, 1, 1, 'sdfsdfsd', 'sfsdfsdf', 'fsdfsdf', 'fsdfsdfsd', 'da39a3ee5e6b4b0d3255bfef95601890afd80709', NULL, 2),
(12, 1, 1, 'fsdfsdfsd', 'fsdfsdf', 'fsdfsdfs', 'fsdfsdfs', 'da39a3ee5e6b4b0d3255bfef95601890afd80709', NULL, 2),
(13, 1, 1, 'fssdfds', 'fsdfsdf', 'sfsdfsd', 'sfdfsd', 'da39a3ee5e6b4b0d3255bfef95601890afd80709', NULL, 2),
(14, 1, 1, 'fsdfsdfsdf', 'sfsdfsd', 'fsdfsdf', 'sfdfsdfsdf', 'da39a3ee5e6b4b0d3255bfef95601890afd80709', NULL, 1),
(15, 1, 1, 'fsdfsd', 'fsdfds', 'fsdfsd', 'fsdfsd', '55bc82ea7aeaa8dc720252af1f0979a1e372c757', NULL, 1),
(16, 1, 1, 'fsdfsd', 'fsdfds', 'fsdfs', 'fsdfsd', 'da39a3ee5e6b4b0d3255bfef95601890afd80709', NULL, 1),
(17, 1, 1, 'fsdfsd', 'fdsfsd', 'fdsfsd', 'fsdfsdfs', '941a02202d05ba09727e91d0e89c48a26b25af13', NULL, 1),
(18, 1, 1, 'fsdfsdfsd', 'fsdfsd', 'fsdfsd', 'fd@fds.br', '7c4a8d09ca3762af61e59520943dc26494f8941b', NULL, 1),
(19, 1, 2, 'fsdfsd', 'pedro guerra', 'fsdfsd', 'fsdfsd@fdsfsd', '7c4a8d09ca3762af61e59520943dc26494f8941b', NULL, 1);

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

--
-- Restrições para tabelas `corretor`
--
ALTER TABLE `corretor`
  ADD CONSTRAINT `fk_corretor_instituicao1` FOREIGN KEY (`instituicao_id`) REFERENCES `instituicao` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Restrições para tabelas `corretor_email`
--
ALTER TABLE `corretor_email`
  ADD CONSTRAINT `fk_corretor_email_corretor1` FOREIGN KEY (`corretor_id`) REFERENCES `corretor` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Restrições para tabelas `corretor_endereco`
--
ALTER TABLE `corretor_endereco`
  ADD CONSTRAINT `fk_corretor_endereco_corretor1` FOREIGN KEY (`corretor_id`) REFERENCES `corretor` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Restrições para tabelas `corretor_telefone`
--
ALTER TABLE `corretor_telefone`
  ADD CONSTRAINT `fk_corretor_telefone_corretor1` FOREIGN KEY (`corretor_id`) REFERENCES `corretor` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Restrições para tabelas `empreendimento`
--
ALTER TABLE `empreendimento`
  ADD CONSTRAINT `fk_empreendimento_instituicao1` FOREIGN KEY (`instituicao_id`) REFERENCES `instituicao` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Restrições para tabelas `empreendimento_corretor`
--
ALTER TABLE `empreendimento_corretor`
  ADD CONSTRAINT `fk_empreendimento_corretor_corretor1` FOREIGN KEY (`corretor_id`) REFERENCES `corretor` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_empreendimento_corretor_empreendimento1` FOREIGN KEY (`empreendimento_id`) REFERENCES `empreendimento` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Restrições para tabelas `lote`
--
ALTER TABLE `lote`
  ADD CONSTRAINT `fk_lote_empreendimento1` FOREIGN KEY (`empreendimento_id`) REFERENCES `empreendimento` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
