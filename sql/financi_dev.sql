-- phpMyAdmin SQL Dump
-- version 4.0.10deb1
-- http://www.phpmyadmin.net
--
-- Servidor: localhost
-- Tempo de Geração: 04/12/2014 às 10:02
-- Versão do servidor: 5.5.40-0ubuntu0.14.04.1
-- Versão do PHP: 5.5.18-1+deb.sury.org~trusty+1

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
  `escolaridade` int(11) DEFAULT NULL,
  `cbo` int(11) DEFAULT NULL,
  `ocupacao` varchar(100) DEFAULT NULL,
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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Fazendo dump de dados para tabela `cliente`
--

INSERT INTO `cliente` (`id`, `instituicao_id`, `cpf`, `cnpj`, `nome`, `data_nascimento`, `sexo`, `nacionalidade`, `naturalidade_uf`, `naturalidade`, `estado_civil`, `residencia`, `registro_geral`, `expedicao`, `ctps`, `escolaridade`, `cbo`, `ocupacao`, `registro_profissional`, `pai`, `mae`, `nome_fantasia`, `inscricao_estadual`, `inscricao_municipal`, `capital_social`, `cnae`, `regime_tributario`, `data_cadastro`, `status`) VALUES
(1, 1, '04788373564', NULL, 'Fernando Dutra', NULL, '', 'brasileiro', 'BA', '1078', '1', NULL, '323656', '2014-11-19', NULL, NULL, NULL, 'programador', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0000-00-00', 1),
(2, 1, '62356631534', NULL, 'ednalva dutra neres', NULL, '', 'brasileiroa', 'BA', '1078', '1', NULL, 'fdsfsd', '2014-11-19', NULL, NULL, NULL, 'do lar', '54564', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0000-00-00', 1),
(3, 1, NULL, '83324269000150', 'inova2b tec', NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'inova', '54654', 'flskdj', 0.00, 'klfsdj', 'lkfsdjlks', '0000-00-00', 1);

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
(1, 3, '04788376564', 'Fernando dutra', 'M', '2014-11-19', 'brasileir', 'BA', '1078', NULL, 'fsd', NULL, NULL, NULL, NULL, NULL, NULL);

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Fazendo dump de dados para tabela `cliente_endereco`
--

INSERT INTO `cliente_endereco` (`id`, `cliente_id`, `cep`, `tipo`, `logradouro`, `numero`, `complemento`, `bairro`, `uf`, `cidade`, `referencia`) VALUES
(1, 1, '45985160', 1, 'Avenida Marechal Castelo Branco - atÃ© 549 - lado Ã­mpar', '656', NULL, 'Centro', 'BA', '1078', NULL),
(2, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(3, 2, '45985160', 1, 'Avenida Marechal Castelo Branco - atÃ© 549 - lado Ã­mpar', '323', NULL, 'Centro', 'BA', '1078', NULL),
(4, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(5, 3, '45985160', 1, 'Avenida Marechal Castelo Branco - atÃ© 549 - lado Ã­mpar', '545', NULL, 'Centro', 'BA', '1078', NULL),
(6, 3, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);

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
-- Estrutura para tabela `contrato`
--

CREATE TABLE IF NOT EXISTS `contrato` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `lote_id` int(11) NOT NULL,
  `instituicao_id` int(11) NOT NULL,
  `valor` decimal(10,2) NOT NULL,
  `desconto` decimal(10,2) NOT NULL,
  `entrada` decimal(10,2) NOT NULL,
  `intermediarias` decimal(10,2) NOT NULL,
  `intervalo_intermediarias` int(11) DEFAULT NULL,
  `qtd_parcelas` int(11) NOT NULL,
  `primeiro_vencimento` date NOT NULL,
  `data_emissao` datetime NOT NULL,
  `tipo_intermediarias` int(1) NOT NULL,
  `tipo_entrada` int(1) NOT NULL,
  `tipo_desconto` int(1) NOT NULL,
  `entrada_config` text,
  `status` int(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `fk_contrato_lote1_idx` (`lote_id`),
  KEY `fk_contrato_instituicao1_idx` (`instituicao_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estrutura para tabela `contrator_corretor`
--

CREATE TABLE IF NOT EXISTS `contrator_corretor` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `contrato_id` int(11) NOT NULL,
  `corretor_id` int(11) NOT NULL,
  `comissao` decimal(10,2) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_contrator_corretor_contrato1_idx` (`contrato_id`),
  KEY `fk_contrator_corretor_corretor1_idx` (`corretor_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estrutura para tabela `contrato_cliente`
--

CREATE TABLE IF NOT EXISTS `contrato_cliente` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `contrato_id` int(11) NOT NULL,
  `cliente_id` int(11) NOT NULL,
  `participacao` decimal(10,2) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_contrato_cliente_contrato1_idx` (`contrato_id`),
  KEY `fk_contrato_cliente_cliente1_idx` (`cliente_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estrutura para tabela `contrato_parcela`
--

CREATE TABLE IF NOT EXISTS `contrato_parcela` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `contrato_id` int(11) NOT NULL,
  `numero` varchar(45) NOT NULL,
  `vencimento` date DEFAULT NULL,
  `valor` decimal(10,2) NOT NULL,
  `intermediaria` tinyint(1) DEFAULT NULL,
  `status` int(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `fk_contrato_parcela_contrato1_idx` (`contrato_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

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
  `escolaridade` int(11) DEFAULT NULL,
  `residencia` int(11) DEFAULT NULL,
  `registro_profissional` varchar(70) DEFAULT NULL,
  `pai` varchar(100) DEFAULT NULL,
  `mae` varchar(100) DEFAULT NULL,
  `data_cadastro` date NOT NULL,
  `status` int(2) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `fk_corretor_instituicao1_idx` (`instituicao_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

--
-- Fazendo dump de dados para tabela `corretor`
--

INSERT INTO `corretor` (`id`, `instituicao_id`, `cpf`, `nome`, `sexo`, `data_nascimento`, `nacionalidade`, `naturalidade_uf`, `naturalidade`, `estado_civil`, `rg`, `expedicao`, `ctps`, `cbo`, `escolaridade`, `residencia`, `registro_profissional`, `pai`, `mae`, `data_cadastro`, `status`) VALUES
(1, 1, '04788373564', 'Fernando Dutra Neres', 'M', '2014-11-25', 'Brasileiro', 'BA', '1078', '1', '1388769085', '2014-07-07', NULL, 215105, NULL, NULL, '985948', NULL, NULL, '2014-04-08', 0),
(2, 1, '62356631534', 'Amaral Azevedo Neto', NULL, '2014-08-16', 'brasileiro', 'BA', 'Nova Viçosa', '1', '321456465', '2014-08-16', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2014-08-16', 0),
(4, 1, '04688837336', 'Valvir rodrigues da silva', 'M', '2014-09-15', 'brasileiro', 'AP', '322', '1', NULL, NULL, NULL, 223124, 1, NULL, NULL, NULL, NULL, '0000-00-00', 0),
(6, 1, '62356631534', 'Ednalva Dutra Neres', 'F', '2014-11-09', 'brasileiro', 'BA', '1078', '4', NULL, NULL, NULL, 254310, NULL, NULL, '483743', NULL, NULL, '2014-11-10', 0),
(7, 1, '04788373564', 'pedro neto azevendo', 'M', '2014-11-19', 'brasileiro', 'BA', '336', '1', '327498379', NULL, NULL, 254310, 2, 1, '384297842', NULL, NULL, '2014-11-19', 0),
(8, 1, '04788373564', 'Fernando Dutra Neres', 'M', '2014-11-25', 'Brasilieiro', 'BA', '1078', '4', NULL, NULL, NULL, NULL, NULL, NULL, '65646', NULL, NULL, '2014-11-25', 1);

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Fazendo dump de dados para tabela `corretor_email`
--

INSERT INTO `corretor_email` (`id`, `corretor_id`, `tipo`, `email`) VALUES
(1, 4, '1', 'fernando@gmail.com'),
(2, 7, '1', 'ferjiofjds@flksd.com.br');

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=10 ;

--
-- Fazendo dump de dados para tabela `corretor_endereco`
--

INSERT INTO `corretor_endereco` (`id`, `corretor_id`, `cep`, `tipo`, `logradouro`, `numero`, `complemento`, `bairro`, `uf`, `cidade`, `referencia`) VALUES
(1, 1, '45985160', 1, 'Rua teste sa silva', '273', NULL, 'Centro', 'BA', '1078', NULL),
(2, 4, '45985160', 1, 'Avenida Marechal Castelo Branco - atÃ© 549 - lado Ã­mpar', '273', NULL, 'Centro', 'BA', '1078', NULL),
(4, 6, '45985160', 3, 'Avenida Marechal Castelo Branco - atÃ© 549 - lado Ã­mpar', '878', NULL, 'Centro', 'BA', '1078', NULL),
(5, 6, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(6, 7, '45985160', 2, 'Avenida Marechal Castelo Branco - atÃ© 549 - lado Ã­mpar', '4343', NULL, 'Centro', 'BA', '1078', NULL),
(7, 7, '45985160', 1, 'Avenida Marechal Castelo Branco - atÃ© 549 - lado Ã­mpar', '4343', NULL, 'Centro', 'BA', '1078', 'fdsfsdf'),
(8, 8, '45985160', 2, 'Avenida Marechal Castelo Branco - atÃ© 549 - lado Ã­mpar', '273', '', 'Centro', 'BA', '1078', NULL),
(9, 8, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Fazendo dump de dados para tabela `corretor_telefone`
--

INSERT INTO `corretor_telefone` (`id`, `corretor_id`, `tipo`, `ddd`, `numero`) VALUES
(1, 4, '1', '73', '99141430'),
(2, 4, '2', '73', '30134559'),
(3, 7, '2', '73', '99999999');

-- --------------------------------------------------------

--
-- Estrutura para tabela `empreendimento`
--

CREATE TABLE IF NOT EXISTS `empreendimento` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `instituicao_id` int(11) NOT NULL,
  `empreendimento` varchar(255) NOT NULL,
  `tipo` int(11) NOT NULL,
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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=16 ;

--
-- Fazendo dump de dados para tabela `empreendimento`
--

INSERT INTO `empreendimento` (`id`, `instituicao_id`, `empreendimento`, `tipo`, `cri`, `comissao`, `entrada`, `intermediarias`, `periodo`, `qtd_parcelas`, `taxa_financiamento`, `indice_correcao`, `cep`, `logradouro`, `numero`, `complemento`, `bairro`, `cidade`, `uf`, `status`) VALUES
(13, 1, 'dfjsdhfjksh', 2, 'felru7854', 34.00, 43.00, 5.00, 6, 984, 34.00, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0),
(14, 1, 'feijfldks', 1, 'fsdlkjf', 5.00, 54.00, 54.00, 6, 434, 3.00, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0),
(15, 1, 'fksjhfkj', 2, 'fuhiousdf', 8.00, 8.00, 10.00, 6, 120, 1.00, 1, '45985-16', 'Avenida Marechal Castelo Branco - atÃ© 549 - lado Ã­mpar', NULL, NULL, 'Centro', 'Teixeira de Freitas', 'BA', 1);

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Fazendo dump de dados para tabela `empreendimento_corretor`
--

INSERT INTO `empreendimento_corretor` (`id`, `corretor_id`, `empreendimento_id`) VALUES
(1, 8, 15);

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
  `tipo` int(11) NOT NULL,
  `numero` varchar(5) NOT NULL,
  `quadra` varchar(5) NOT NULL,
  `valor` decimal(10,2) NOT NULL,
  `area_total` decimal(10,2) NOT NULL,
  `matricula` varchar(30) DEFAULT NULL,
  `inscricao_municipal` varchar(50) DEFAULT NULL,
  `frente` varchar(30) NOT NULL,
  `frente_metro` decimal(10,2) NOT NULL,
  `fundo` varchar(30) NOT NULL,
  `fundo_metro` decimal(10,2) NOT NULL,
  `lateral_direita` varchar(30) NOT NULL,
  `lateral_direita_metro` decimal(10,2) NOT NULL,
  `lateral_esquerda` varchar(30) NOT NULL,
  `lateral_esquerda_metro` decimal(10,2) NOT NULL,
  `cep` varchar(8) DEFAULT NULL,
  `logradouro` varchar(100) DEFAULT NULL,
  `num` varchar(10) DEFAULT NULL,
  `complemento` varchar(100) DEFAULT NULL,
  `bairro` varchar(30) DEFAULT NULL,
  `cidade` varchar(45) DEFAULT NULL,
  `uf` char(2) DEFAULT NULL,
  `situacao` char(1) DEFAULT NULL,
  `status` int(11) DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `fk_lote_empreendimento1_idx` (`empreendimento_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=14 ;

--
-- Fazendo dump de dados para tabela `lote`
--

INSERT INTO `lote` (`id`, `empreendimento_id`, `tipo`, `numero`, `quadra`, `valor`, `area_total`, `matricula`, `inscricao_municipal`, `frente`, `frente_metro`, `fundo`, `fundo_metro`, `lateral_direita`, `lateral_direita_metro`, `lateral_esquerda`, `lateral_esquerda_metro`, `cep`, `logradouro`, `num`, `complemento`, `bairro`, `cidade`, `uf`, `situacao`, `status`) VALUES
(11, 14, 1, 'w443', '343', 6666.66, 34.00, '5454', '5454', 'fsdfsdf', 8.00, 'fsdfjhsdgjk', 88.00, 'fdjkshfkjsd', 878.00, 'kfjhsklfjhds', 77.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0),
(12, 15, 1, '1239', '23', 420.00, 100.00, 'rewrwer', '1999', 'jhfwfkjsd', 19.00, 'fjsdfklsj', 199.00, 'slkfjds''11', 93.00, 'fklsdjfldsk', 293.00, '45985160', 'Avenida Marechal Castelo Branco - atÃ© 549 - lado Ã­mpar', NULL, NULL, 'Centro', 'Teixeira de Freitas', 'BA', NULL, 1),
(13, 15, 1, '45645', 'fafs', 25000.00, 250.00, '32465465', '5465465', 'dsfsdf', 350.00, 'fdsfsd', 25.00, 'fsdf', 25.00, 'fsdfsd', 250.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1);

-- --------------------------------------------------------

--
-- Estrutura para tabela `parcela_entrada`
--

CREATE TABLE IF NOT EXISTS `parcela_entrada` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `contrato_parcela_id` int(11) NOT NULL,
  `tipo` int(1) NOT NULL,
  `forma` char(1) DEFAULT NULL,
  `numero_cheque` varchar(45) DEFAULT NULL,
  `vencimento` date DEFAULT NULL,
  `valor` decimal(10,2) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_parcela_entrada_contrato_parcela1_idx` (`contrato_parcela_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

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
  `trocar_senha` tinyint(1) DEFAULT NULL,
  `status` int(2) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `instituicao_pk` (`instituicao_id`),
  KEY `grupo_pks` (`grupo_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=21 ;

--
-- Fazendo dump de dados para tabela `usuario`
--

INSERT INTO `usuario` (`id`, `instituicao_id`, `grupo_id`, `usuario`, `nome`, `apelido`, `email`, `senha`, `admin`, `trocar_senha`, `status`) VALUES
(1, 1, 2, 'fernando', 'Fernando Dutra', 'nando', 'nando@inova2b.com.br', '7c4a8d09ca3762af61e59520943dc26494f8941b', NULL, NULL, 1),
(4, 1, 2, 'teste', 'teste blabal ba', 'teste', 'teste@teste.com', 'da39a3ee5e6b4b0d3255bfef95601890afd80709', NULL, NULL, 1),
(5, 1, 1, 'fsdfsd', 'fsdfds', 'fsdfds', 'fdgdfgdfg', 'da39a3ee5e6b4b0d3255bfef95601890afd80709', NULL, NULL, 0),
(6, 1, 1, 'fsdfsd', 'fsdfsd', 'fsdfsdf', 'fsdfsdf', 'da39a3ee5e6b4b0d3255bfef95601890afd80709', NULL, NULL, 1),
(7, 1, 1, 'fsdfsdf', 'fsdfds', 'fsdfsdfsd', 'fssdfsdf', 'da39a3ee5e6b4b0d3255bfef95601890afd80709', NULL, NULL, 0),
(8, 1, 1, 'fsdfsdf', 'fsdfsdf', 'fsdfds', 'sfdsdfds', 'da39a3ee5e6b4b0d3255bfef95601890afd80709', NULL, NULL, 2),
(9, 1, 1, 'fsdfsdfsd', 'fsdfdsfs', 'fsdfsdfsdf', 'fsdsfsdfsd', 'da39a3ee5e6b4b0d3255bfef95601890afd80709', NULL, NULL, 0),
(10, 1, 1, 'sdfadfas', 'fsdfsd', 'sdfsdf', 'dsfsdfds', 'da39a3ee5e6b4b0d3255bfef95601890afd80709', NULL, NULL, 2),
(11, 1, 1, 'sdfsdfsd', 'sfsdfsdf', 'fsdfsdf', 'fsdfsdfsd', 'da39a3ee5e6b4b0d3255bfef95601890afd80709', NULL, NULL, 0),
(12, 1, 1, 'fsdfsdfsd', 'fsdfsdf', 'fsdfsdfs', 'fsdfsdfs', 'da39a3ee5e6b4b0d3255bfef95601890afd80709', NULL, NULL, 2),
(13, 1, 1, 'fssdfds', 'fsdfsdf', 'sfsdfsd', 'sfdfsd', 'da39a3ee5e6b4b0d3255bfef95601890afd80709', NULL, NULL, 2),
(14, 1, 1, 'fsdfsdfsdf', 'sfsdfsd', 'fsdfsdf', 'sfdfsdfsdf', 'da39a3ee5e6b4b0d3255bfef95601890afd80709', NULL, NULL, 1),
(15, 1, 1, 'fsdfsd', 'fsdfds', 'fsdfsd', 'fsdfsd', '55bc82ea7aeaa8dc720252af1f0979a1e372c757', NULL, NULL, 1),
(16, 1, 1, 'fsdfsd', 'fsdfds', 'fsdfs', 'fsdfsd', 'da39a3ee5e6b4b0d3255bfef95601890afd80709', NULL, NULL, 2),
(17, 1, 1, 'fsdfsd', 'fdsfsd', 'fdsfsd', 'fsdfsdfs', '941a02202d05ba09727e91d0e89c48a26b25af13', NULL, NULL, 1),
(18, 1, 1, 'fsdfsdfsd', 'fsdfsd', 'fsdfsd', 'fd@fds.br', '7c4a8d09ca3762af61e59520943dc26494f8941b', NULL, NULL, 1),
(19, 1, 2, 'fsdfsd', 'pedro guerra', 'fsdfsd', 'fsdfsd@fdsfsd', '7c4a8d09ca3762af61e59520943dc26494f8941b', NULL, NULL, 1),
(20, 1, 1, 'fabio', 'fabio', 'fabio', 'fabio@teste.com.br', '7c4a8d09ca3762af61e59520943dc26494f8941b', NULL, NULL, 1);

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
  ADD CONSTRAINT `fk_cliente_conjuge_cliente1` FOREIGN KEY (`cliente_id`) REFERENCES `cliente` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Restrições para tabelas `cliente_email`
--
ALTER TABLE `cliente_email`
  ADD CONSTRAINT `fk_cliente_email_cliente1` FOREIGN KEY (`cliente_id`) REFERENCES `cliente` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Restrições para tabelas `cliente_endereco`
--
ALTER TABLE `cliente_endereco`
  ADD CONSTRAINT `fk_endereco_cliente_cliente1` FOREIGN KEY (`cliente_id`) REFERENCES `cliente` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Restrições para tabelas `cliente_telefone`
--
ALTER TABLE `cliente_telefone`
  ADD CONSTRAINT `fk_cliente_telefone_cliente1` FOREIGN KEY (`cliente_id`) REFERENCES `cliente` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Restrições para tabelas `contrato`
--
ALTER TABLE `contrato`
  ADD CONSTRAINT `fk_contrato_instituicao1` FOREIGN KEY (`instituicao_id`) REFERENCES `instituicao` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_contrato_lote1` FOREIGN KEY (`lote_id`) REFERENCES `lote` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Restrições para tabelas `contrator_corretor`
--
ALTER TABLE `contrator_corretor`
  ADD CONSTRAINT `fk_contrator_corretor_contrato1` FOREIGN KEY (`contrato_id`) REFERENCES `contrato` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_contrator_corretor_corretor1` FOREIGN KEY (`corretor_id`) REFERENCES `corretor` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Restrições para tabelas `contrato_cliente`
--
ALTER TABLE `contrato_cliente`
  ADD CONSTRAINT `fk_contrato_cliente_cliente1` FOREIGN KEY (`cliente_id`) REFERENCES `cliente` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_contrato_cliente_contrato1` FOREIGN KEY (`contrato_id`) REFERENCES `contrato` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Restrições para tabelas `contrato_parcela`
--
ALTER TABLE `contrato_parcela`
  ADD CONSTRAINT `fk_contrato_parcela_contrato1` FOREIGN KEY (`contrato_id`) REFERENCES `contrato` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Restrições para tabelas `corretor`
--
ALTER TABLE `corretor`
  ADD CONSTRAINT `fk_corretor_instituicao1` FOREIGN KEY (`instituicao_id`) REFERENCES `instituicao` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Restrições para tabelas `corretor_email`
--
ALTER TABLE `corretor_email`
  ADD CONSTRAINT `fk_corretor_email_corretor1` FOREIGN KEY (`corretor_id`) REFERENCES `corretor` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Restrições para tabelas `corretor_endereco`
--
ALTER TABLE `corretor_endereco`
  ADD CONSTRAINT `fk_corretor_endereco_corretor1` FOREIGN KEY (`corretor_id`) REFERENCES `corretor` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Restrições para tabelas `corretor_telefone`
--
ALTER TABLE `corretor_telefone`
  ADD CONSTRAINT `fk_corretor_telefone_corretor1` FOREIGN KEY (`corretor_id`) REFERENCES `corretor` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

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

--
-- Restrições para tabelas `parcela_entrada`
--
ALTER TABLE `parcela_entrada`
  ADD CONSTRAINT `fk_parcela_entrada_contrato_parcela1` FOREIGN KEY (`contrato_parcela_id`) REFERENCES `contrato_parcela` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
