-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: 27-Nov-2014 às 17:34
-- Versão do servidor: 5.6.17
-- PHP Version: 5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `cfp`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `categoria`
--

CREATE TABLE IF NOT EXISTS `categoria` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(255) NOT NULL,
  `id_pai` int(11) DEFAULT NULL,
  `tipo` char(1) NOT NULL COMMENT 'D - Despesa; R - Receita',
  PRIMARY KEY (`id`),
  KEY `id_pai` (`id_pai`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=50 ;

--
-- Extraindo dados da tabela `categoria`
--

INSERT INTO `categoria` (`id`, `nome`, `id_pai`, `tipo`) VALUES
(2, 'Moradia', NULL, 'D'),
(3, 'Alimentação', NULL, 'D'),
(4, 'Transporte', NULL, 'D'),
(5, 'Saúde', NULL, 'D'),
(6, 'Lazer', NULL, 'D'),
(7, 'Animais de estimação', NULL, 'D'),
(8, 'Vida cristã', NULL, 'D'),
(9, 'Aluguel/Financiamento', 2, 'D'),
(10, 'Telefone / Internet', 2, 'D'),
(11, 'Água', 2, 'D'),
(12, 'Luz', 2, 'D'),
(13, 'Reparos / Manutenção', 2, 'D'),
(14, 'Supermercado', 3, 'D'),
(15, 'Padaria', 3, 'D'),
(16, 'Combustível', 4, 'D'),
(17, 'Licenciamento', 4, 'D'),
(18, 'Manutenção / Reparos', 4, 'D'),
(19, 'Passagens / Passes', 4, 'D'),
(20, 'Pedágios', 4, 'D'),
(21, 'Dízimos', 8, 'D'),
(22, 'Ofertas', 8, 'D'),
(23, 'Doações', 8, 'D'),
(24, 'Cuidados Pessoais', NULL, 'D'),
(25, 'Salão de Beleza', 24, 'D'),
(26, 'Cosméticos', 24, 'D'),
(27, 'Pet-shop', 7, 'D'),
(28, 'Ração', 7, 'D'),
(29, 'Lanchonetes / Restaurantes', 6, 'D'),
(30, 'Cinema', 6, 'D'),
(31, 'Viagens', 6, 'D'),
(32, 'Consultas', 5, 'D'),
(33, 'Odontologia', 5, 'D'),
(34, 'Remédios', 5, 'D'),
(35, 'Receitas', NULL, 'R'),
(36, 'Salários', 35, 'R'),
(37, 'Adiantamentos', 35, 'R'),
(38, 'Férias', 35, 'R'),
(39, '13º Salário', 35, 'R'),
(40, 'Desenvolvimento', 35, 'R'),
(41, 'Manutenção', 35, 'R'),
(42, 'Outras', 35, 'R'),
(43, 'Vestuário', NULL, 'D'),
(44, 'Roupas', 43, 'D'),
(45, 'Calçados', 43, 'D'),
(46, 'Aquisição de bens', 2, 'D'),
(47, 'Serviços Financeiros', NULL, 'D'),
(48, 'Emprestimos', 47, 'D'),
(49, 'Encontros / Congressos', 8, 'D');

-- --------------------------------------------------------

--
-- Estrutura da tabela `conta`
--

CREATE TABLE IF NOT EXISTS `conta` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(255) NOT NULL,
  `descricao` text,
  `saldoInicial` float NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Extraindo dados da tabela `conta`
--

INSERT INTO `conta` (`id`, `nome`, `descricao`, `saldoInicial`) VALUES
(1, 'Banco Itaú', 'Conta para gerenciamento de transações referentes ao banco Itaú', 5.95),
(2, 'Banco Hsbc', 'Conta para gerenciamento de transações referentes ao banco HSBC', -73.79),
(3, 'Carteira', 'Conta para gerenciamento do dinheiro em carteira', 0),
(4, 'Banco Caixa', '', 0);

-- --------------------------------------------------------

--
-- Estrutura da tabela `extrato_caixa`
--

CREATE TABLE IF NOT EXISTS `extrato_caixa` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `dataTransacao` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `id_conta` int(11) NOT NULL,
  `valor` float NOT NULL DEFAULT '0',
  `historico` text,
  `id_lancamento` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `id_conta` (`id_conta`),
  KEY `id_lancamento` (`id_lancamento`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Extraindo dados da tabela `extrato_caixa`
--

INSERT INTO `extrato_caixa` (`id`, `dataTransacao`, `id_conta`, `valor`, `historico`, `id_lancamento`) VALUES
(1, '2014-11-26 13:28:37', 1, -145, 'Pagamento referente a Cheque Reencontro com Deus Fabiana', 9),
(2, '2014-11-26 13:39:57', 1, 298.66, 'Recebimento referente a Recebimento via cheque - aulas IVB', 10);

-- --------------------------------------------------------

--
-- Estrutura da tabela `lancamento`
--

CREATE TABLE IF NOT EXISTS `lancamento` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `dataLancamento` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `titulo` varchar(255) NOT NULL,
  `tipo` char(1) NOT NULL,
  `id_categoria` int(11) DEFAULT NULL,
  `id_subcategoria` int(11) DEFAULT NULL,
  `vencimento` date DEFAULT NULL,
  `valor` decimal(15,2) NOT NULL,
  `situacao` int(11) NOT NULL DEFAULT '0',
  `parcelas` int(11) NOT NULL DEFAULT '1',
  `numeroParcela` int(11) NOT NULL DEFAULT '1',
  `id_conta` int(11) DEFAULT NULL,
  `dataPagamento` timestamp NULL DEFAULT NULL,
  `conta_origem` int(11) DEFAULT NULL,
  `conta_destino` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `id_categoria` (`id_categoria`),
  KEY `id_subcategoria` (`id_subcategoria`),
  KEY `id_conta` (`id_conta`),
  KEY `conta_origem` (`conta_origem`),
  KEY `conta_destino` (`conta_destino`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=24 ;

--
-- Extraindo dados da tabela `lancamento`
--

INSERT INTO `lancamento` (`id`, `dataLancamento`, `titulo`, `tipo`, `id_categoria`, `id_subcategoria`, `vencimento`, `valor`, `situacao`, `parcelas`, `numeroParcela`, `id_conta`, `dataPagamento`, `conta_origem`, `conta_destino`) VALUES
(1, '2014-11-26 13:21:05', 'Adiantamento Emerson', 'R', 35, 37, '2014-11-20', '1200.00', 0, 0, 1, 2, NULL, NULL, NULL),
(2, '2014-11-26 13:21:40', 'Aluguel', 'D', 2, 9, '2014-11-25', '630.00', 0, 0, 1, 3, NULL, NULL, NULL),
(3, '2014-11-26 13:21:40', 'Aluguel', 'D', 2, 9, '2014-12-25', '630.00', 0, 0, 1, 3, NULL, NULL, NULL),
(4, '2014-11-26 13:21:40', 'Aluguel', 'D', 2, 9, '2015-01-25', '630.00', 0, 0, 1, 3, NULL, NULL, NULL),
(5, '2014-11-26 13:21:40', 'Aluguel', 'D', 2, 9, '2015-02-25', '630.00', 0, 0, 1, 3, NULL, NULL, NULL),
(6, '2014-11-26 13:21:40', 'Aluguel', 'D', 2, 9, '2015-03-25', '630.00', 0, 0, 1, 3, NULL, NULL, NULL),
(7, '2014-11-26 13:21:40', 'Aluguel', 'D', 2, 9, '2015-04-25', '630.00', 0, 0, 1, 3, NULL, NULL, NULL),
(8, '2014-11-26 13:22:56', 'Emprestimo ITAU Fabiana', 'D', 47, 48, '2014-11-30', '250.00', 0, 0, 1, 2, NULL, NULL, NULL),
(9, '2014-11-26 13:26:43', 'Cheque Reencontro com Deus Fabiana', 'D', 8, 49, '2014-11-26', '145.00', 1, 0, 1, 1, '2014-11-26 02:00:00', NULL, NULL),
(10, '2014-11-26 13:39:57', 'Recebimento via cheque - aulas IVB', 'R', 35, 36, '2014-11-26', '298.66', 1, 0, 1, 1, '2014-11-26 02:00:00', NULL, NULL),
(11, '2014-11-26 13:42:06', 'Emprestimo Emerson', 'D', 47, 48, '2014-12-08', '212.59', 0, 0, 1, 1, NULL, NULL, NULL),
(12, '2014-11-26 13:42:06', 'Emprestimo Emerson', 'D', 47, 48, '2015-01-08', '212.59', 0, 0, 1, 1, NULL, NULL, NULL),
(13, '2014-11-26 13:42:06', 'Emprestimo Emerson', 'D', 47, 48, '2015-02-08', '212.59', 0, 0, 1, 1, NULL, NULL, NULL),
(14, '2014-11-26 13:42:06', 'Emprestimo Emerson', 'D', 47, 48, '2015-03-08', '212.59', 0, 0, 1, 1, NULL, NULL, NULL),
(15, '2014-11-26 13:42:06', 'Emprestimo Emerson', 'D', 47, 48, '2015-04-08', '212.59', 0, 0, 1, 1, NULL, NULL, NULL),
(16, '2014-11-26 13:42:06', 'Emprestimo Emerson', 'D', 47, 48, '2015-05-08', '212.59', 0, 0, 1, 1, NULL, NULL, NULL),
(18, '2014-11-26 13:44:09', 'Aluguel', 'D', 2, 9, '2015-05-25', '630.00', 0, 0, 1, 3, NULL, NULL, NULL),
(19, '2014-11-26 13:44:09', 'Aluguel', 'D', 2, 9, '2015-06-25', '630.00', 0, 0, 1, 3, NULL, NULL, NULL),
(20, '2014-11-26 13:44:09', 'Aluguel', 'D', 2, 9, '2015-07-25', '630.00', 0, 0, 1, 3, NULL, NULL, NULL),
(21, '2014-11-26 13:44:09', 'Aluguel', 'D', 2, 9, '2015-08-25', '630.00', 0, 0, 1, 3, NULL, NULL, NULL),
(22, '2014-11-26 13:44:09', 'Aluguel', 'D', 2, 9, '2015-09-25', '630.00', 0, 0, 1, 3, NULL, NULL, NULL),
(23, '2014-11-26 13:44:09', 'Aluguel', 'D', 2, 9, '2015-10-25', '630.00', 0, 0, 1, 3, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Estrutura da tabela `phinxlog`
--

CREATE TABLE IF NOT EXISTS `phinxlog` (
  `version` bigint(14) NOT NULL,
  `start_time` timestamp NOT NULL,
  `end_time` timestamp NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Constraints for dumped tables
--

--
-- Limitadores para a tabela `categoria`
--
ALTER TABLE `categoria`
  ADD CONSTRAINT `categoria_ibfk_1` FOREIGN KEY (`id_pai`) REFERENCES `categoria` (`id`);

--
-- Limitadores para a tabela `extrato_caixa`
--
ALTER TABLE `extrato_caixa`
  ADD CONSTRAINT `extrato_caixa_ibfk_1` FOREIGN KEY (`id_conta`) REFERENCES `conta` (`id`),
  ADD CONSTRAINT `extrato_caixa_ibfk_2` FOREIGN KEY (`id_lancamento`) REFERENCES `lancamento` (`id`);

--
-- Limitadores para a tabela `lancamento`
--
ALTER TABLE `lancamento`
  ADD CONSTRAINT `lancamento_ibfk_1` FOREIGN KEY (`id_categoria`) REFERENCES `categoria` (`id`),
  ADD CONSTRAINT `lancamento_ibfk_2` FOREIGN KEY (`id_subcategoria`) REFERENCES `categoria` (`id`),
  ADD CONSTRAINT `lancamento_ibfk_3` FOREIGN KEY (`id_conta`) REFERENCES `conta` (`id`),
  ADD CONSTRAINT `lancamento_ibfk_4` FOREIGN KEY (`conta_origem`) REFERENCES `conta` (`id`),
  ADD CONSTRAINT `lancamento_ibfk_5` FOREIGN KEY (`conta_destino`) REFERENCES `conta` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
