-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: 24-Nov-2014 às 19:30
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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=47 ;

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
(46, 'Aquisição de bens', 2, 'D');

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
(1, 'Banco Itaú', 'Conta para gerenciamento de transações referentes ao banco Itaú', -10.56),
(2, 'Banco Hsbc', 'Conta para gerenciamento de transações referentes ao banco HSBC', 0),
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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=9 ;

--
-- Extraindo dados da tabela `extrato_caixa`
--

INSERT INTO `extrato_caixa` (`id`, `dataTransacao`, `id_conta`, `valor`, `historico`, `id_lancamento`) VALUES
(1, '2014-11-24 18:04:10', 3, 300, 'Recebimento referente a Aulas IVB', 61),
(2, '2014-11-24 18:05:18', 2, -50, 'Pagamento referente a Supermercado Semanal', 62),
(4, '2014-11-24 18:21:41', 1, -10, 'Pagamento referente a teste não pago', 7),
(5, '2014-11-24 18:21:44', 2, -100, 'Pagamento referente a Teste de lançamento Parcelado', 16),
(6, '2014-11-24 18:27:44', 1, -600, 'Pagamento referente a Aluguel mes 11', 1),
(7, '2014-11-24 18:30:00', 1, 600, 'Estorno Recebimento referente a Aluguel mes 11', 1),
(8, '2014-11-24 18:30:13', 1, -600, 'Pagamento referente a Aluguel mes 11', 1);

-- --------------------------------------------------------

--
-- Estrutura da tabela `lancamento`
--

CREATE TABLE IF NOT EXISTS `lancamento` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `dataLancamento` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `titulo` varchar(255) NOT NULL,
  `tipo` char(1) NOT NULL,
  `id_categoria` int(11) NOT NULL,
  `id_subcategoria` int(11) NOT NULL,
  `vencimento` date NOT NULL,
  `valor` decimal(15,2) NOT NULL,
  `situacao` int(11) NOT NULL DEFAULT '0',
  `parcelas` int(11) NOT NULL DEFAULT '1',
  `numeroParcela` int(11) NOT NULL DEFAULT '1',
  `id_conta` int(11) NOT NULL,
  `dataPagamento` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `id_categoria` (`id_categoria`),
  KEY `id_subcategoria` (`id_subcategoria`),
  KEY `id_conta` (`id_conta`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=63 ;

--
-- Extraindo dados da tabela `lancamento`
--

INSERT INTO `lancamento` (`id`, `dataLancamento`, `titulo`, `tipo`, `id_categoria`, `id_subcategoria`, `vencimento`, `valor`, `situacao`, `parcelas`, `numeroParcela`, `id_conta`, `dataPagamento`) VALUES
(1, '2014-11-20 16:54:54', 'Aluguel mes 11', 'D', 2, 9, '2014-11-25', '600.00', 1, 1, 1, 1, '2014-11-24 02:00:00'),
(2, '2014-11-20 16:56:00', 'Supermercado semana 1 mes 11', 'D', 3, 14, '2014-11-20', '60.00', 1, 1, 1, 1, '2014-11-20 02:00:00'),
(3, '2014-11-20 17:51:44', 'Recebimento de salario Emerson', 'R', 35, 36, '2014-11-06', '1300.00', 1, 1, 1, 1, '2014-11-14 02:00:00'),
(4, '2014-10-01 03:00:00', 'TEste Mes anterior', 'D', 2, 6, '2014-10-01', '150.00', 1, 1, 1, 1, '2014-10-01 03:00:00'),
(5, '2014-11-24 14:04:51', 'Banho e tosa Boris', 'D', 7, 27, '2014-11-24', '70.00', 1, 0, 1, 1, NULL),
(6, '2014-11-24 14:07:23', 'teste com pagamento', 'D', 2, 11, '2014-11-24', '10.00', 1, 0, 1, 1, '2014-11-24 02:00:00'),
(7, '2014-11-24 14:07:49', 'teste não pago', 'D', 2, 12, '2014-11-24', '10.00', 1, 0, 1, 1, '2014-11-24 02:00:00'),
(16, '2014-11-24 14:24:39', 'Teste de lançamento Parcelado', 'D', 43, 45, '2014-11-25', '100.00', 1, 3, 1, 2, '2014-11-24 02:00:00'),
(17, '2014-11-24 14:24:39', 'Teste de lançamento Parcelado', 'D', 43, 45, '2014-12-25', '100.00', 0, 3, 2, 2, NULL),
(18, '2014-11-24 14:24:39', 'Teste de lançamento Parcelado', 'D', 43, 45, '2015-01-25', '100.00', 0, 3, 3, 2, NULL),
(61, '2014-11-24 18:04:10', 'Aulas IVB', 'R', 35, 36, '2014-11-24', '300.00', 1, 0, 1, 3, '2014-11-24 02:00:00'),
(62, '2014-11-24 18:05:18', 'Supermercado Semanal', 'D', 3, 14, '2014-11-24', '50.00', 1, 0, 1, 2, '2014-11-24 02:00:00');

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
  ADD CONSTRAINT `extrato_caixa_ibfk_2` FOREIGN KEY (`id_lancamento`) REFERENCES `lancamento` (`id`),
  ADD CONSTRAINT `extrato_caixa_ibfk_1` FOREIGN KEY (`id_conta`) REFERENCES `conta` (`id`);

--
-- Limitadores para a tabela `lancamento`
--
ALTER TABLE `lancamento`
  ADD CONSTRAINT `lancamento_ibfk_1` FOREIGN KEY (`id_categoria`) REFERENCES `categoria` (`id`),
  ADD CONSTRAINT `lancamento_ibfk_2` FOREIGN KEY (`id_subcategoria`) REFERENCES `categoria` (`id`),
  ADD CONSTRAINT `lancamento_ibfk_3` FOREIGN KEY (`id_conta`) REFERENCES `conta` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
