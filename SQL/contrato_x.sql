-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Tempo de geração: 20/04/2025 às 12:12
-- Versão do servidor: 8.2.0
-- Versão do PHP: 8.2.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `contrato_x`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `cadastros`
--

DROP TABLE IF EXISTS `cadastros`;
CREATE TABLE IF NOT EXISTS `cadastros` (
  `timestamp` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `_id_empresa` int NOT NULL,
  `_id_cadastro` int NOT NULL AUTO_INCREMENT,
  `tipo_cadastro` enum('cliente','colaborador','fornecedor','parceiro','outros') NOT NULL,
  `nome_completo` varchar(100) NOT NULL,
  `rg` varchar(20) NOT NULL,
  `cpf` varchar(14) NOT NULL,
  `data_nasc` date NOT NULL,
  `naturalidade` varchar(50) NOT NULL,
  `profissao` varchar(50) NOT NULL,
  `cep` varchar(9) NOT NULL,
  `rua` varchar(100) NOT NULL,
  `numero` varchar(10) NOT NULL,
  `complemento` varchar(50) DEFAULT NULL,
  `bairro` varchar(50) NOT NULL,
  `cidade` varchar(50) NOT NULL,
  `estado` char(2) NOT NULL,
  `telefone` varchar(15) NOT NULL,
  `email` varchar(100) NOT NULL,
  `redes_sociais` varchar(200) DEFAULT NULL,
  `contato_recados` varchar(100) NOT NULL,
  `telefone_recados` varchar(15) NOT NULL,
  `email_recados` varchar(100) NOT NULL,
  `origem` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`_id_cadastro`),
  UNIQUE KEY `cpf` (`cpf`),
  UNIQUE KEY `rg` (`rg`),
  KEY `_id_empresa` (`_id_empresa`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Despejando dados para a tabela `cadastros`
--

INSERT INTO `cadastros` (`timestamp`, `_id_empresa`, `_id_cadastro`, `tipo_cadastro`, `nome_completo`, `rg`, `cpf`, `data_nasc`, `naturalidade`, `profissao`, `cep`, `rua`, `numero`, `complemento`, `bairro`, `cidade`, `estado`, `telefone`, `email`, `redes_sociais`, `contato_recados`, `telefone_recados`, `email_recados`, `origem`) VALUES
('2025-04-14 20:14:45', 1, 1, 'cliente', 'Maria Silva Santos', '12.345.678-9', '123.456.789-01', '1990-05-15', 'São Paulo', 'Professora', '01234-567', 'Rua das Flores', '123', NULL, 'Centro', 'São Paulo', 'SP', '(11)99999-1111', 'maria@email.com', NULL, 'João Silva', '(11)99999-2222', 'joao@email.com', NULL),
('2025-04-14 20:14:46', 2, 2, 'cliente', 'José Santos Silva', '98.765.432-1', '987.654.321-02', '1985-06-20', 'Rio de Janeiro', 'Engenheiro', '12345-678', 'Av Brasil', '456', NULL, 'Jardins', 'São Paulo', 'SP', '(11)99999-3333', 'jose@email.com', NULL, 'Ana Santos', '(11)99999-4444', 'ana@email.com', NULL),
('2025-04-16 13:40:48', 2, 3, 'cliente', 'ROGERIO MORAIS BARBOZA', '347101628', '30329490842', '1981-12-18', 'Santo André', 'Fotografo', '09195-740', 'Travessa Soledade', '19', '0', 'Vila Pires', 'Santo André', 'SP', '11971872119', 'roger.msms@gmail.com', '@abcfotoevideo', 'Adriana Morais', '11-97014-5670', 'testeadriana@mail.com', 'teste'),
('2025-04-16 18:23:57', 1, 4, 'colaborador', 'Tião Cagão', '241554882', '3012957824', '2001-01-01', 'Paraiba', 'Pedreiro', '09135490', 'Rua dos Maristas', '64', 'c2', 'Jardim Santo André', 'Santo André', 'SP', '11971872119', 'teste2@mail.com', '@teste2', 'ROGERIO MORAIS BARBOZA', '11971872119', 'roger.msms@gmail.com', 'teste2'),
('2025-04-19 22:17:55', 1, 5, 'colaborador', 'Daniel Fernandes', '54810902x', '20256498952', '1999-01-18', 'São Paulo', 'Cinegrafista', '02165789', 'Rua Bera', '24', '02', 'Jd. Paulo', 'São Paulo', 'SP', '1196565-4242', 'daniel@mail.com', '@daniel', 'teste recados', '11 98877-6655', 'recadodaniel@email.com', 'teste teste');

-- --------------------------------------------------------

--
-- Estrutura para tabela `empresas`
--

DROP TABLE IF EXISTS `empresas`;
CREATE TABLE IF NOT EXISTS `empresas` (
  `timestamp` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `_id` int NOT NULL AUTO_INCREMENT,
  `empresa` varchar(100) NOT NULL,
  PRIMARY KEY (`_id`),
  UNIQUE KEY `empresa` (`empresa`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Despejando dados para a tabela `empresas`
--

INSERT INTO `empresas` (`timestamp`, `_id`, `empresa`) VALUES
('2025-04-14 20:14:44', 1, 'ABC foto e video'),
('2025-04-14 20:14:44', 2, 'Adriana Morais Assessoria');

-- --------------------------------------------------------

--
-- Estrutura para tabela `pedidos`
--

DROP TABLE IF EXISTS `pedidos`;
CREATE TABLE IF NOT EXISTS `pedidos` (
  `timestamp` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `_id_cadastro` int NOT NULL,
  `_id_pedido` int NOT NULL AUTO_INCREMENT,
  `nome_contratante` varchar(100) NOT NULL,
  `produto_servico` varchar(100) NOT NULL,
  `seguimento` enum('casamento','debutante','aniversario','corporativo','outro') NOT NULL,
  `titulo_evento` varchar(100) NOT NULL,
  `data_reservada` date NOT NULL,
  `descricao_pedido` text NOT NULL,
  `participantes` text,
  `observacoes` text,
  `numero_convidados` int NOT NULL,
  `horario_convite` time NOT NULL,
  `horario_inicio` time NOT NULL,
  `valor_original` decimal(10,2) NOT NULL,
  `valor_desconto` decimal(10,2) DEFAULT '0.00',
  `valor_total` decimal(10,2) NOT NULL,
  `forma_pagamento` enum('dinheiro','cartao','pix','transferencia') NOT NULL,
  `numero_pagamentos` int NOT NULL,
  `data_pagamento_1` date NOT NULL,
  `vencimento_mensal` int NOT NULL,
  `reserva_equipe` text,
  `estimativa_custo` decimal(10,2) DEFAULT NULL,
  PRIMARY KEY (`_id_pedido`),
  KEY `_id_cadastro` (`_id_cadastro`)
) ;

--
-- Despejando dados para a tabela `pedidos`
--

INSERT INTO `pedidos` (`timestamp`, `_id_cadastro`, `_id_pedido`, `nome_contratante`, `produto_servico`, `seguimento`, `titulo_evento`, `data_reservada`, `descricao_pedido`, `participantes`, `observacoes`, `numero_convidados`, `horario_convite`, `horario_inicio`, `valor_original`, `valor_desconto`, `valor_total`, `forma_pagamento`, `numero_pagamentos`, `data_pagamento_1`, `vencimento_mensal`, `reserva_equipe`, `estimativa_custo`) VALUES
('2025-04-14 20:14:46', 1, 1, 'Maria Silva Santos', 'Fotografia e Filmagem', 'casamento', 'Casamento Maria e João', '2024-10-15', 'Cobertura completa', NULL, NULL, 200, '20:00:00', '21:00:00', 5000.00, 0.00, 4500.00, 'pix', 10, '2024-05-01', 5, NULL, NULL),
('2025-04-14 20:14:46', 2, 2, 'José Santos Silva', 'Assessoria Completa', 'debutante', '15 Anos Ana', '2024-08-20', 'Organização completa', NULL, NULL, 150, '19:00:00', '20:00:00', 8000.00, 0.00, 7500.00, 'cartao', 12, '2024-04-01', 10, NULL, NULL),
('2025-04-16 19:19:29', 2, 3, 'José Santos Silva', 'Cobertura fotográfica', 'aniversario', '1 ano Pedrinho', '2025-05-18', 'Exemplo descrição do pedido', 'Papai, mamãe e vovó', 'Cuidado! Acriança não gosta de flash.', 50, '16:00:00', '16:30:00', 500.00, 100.00, 400.00, 'pix', 3, '2025-04-16', 16, '1 foto: Franco filho', 300.00);

-- --------------------------------------------------------

--
-- Estrutura para tabela `transacoes`
--

DROP TABLE IF EXISTS `transacoes`;
CREATE TABLE IF NOT EXISTS `transacoes` (
  `timestamp` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `_id_transacao` int NOT NULL AUTO_INCREMENT,
  `data_venc` date NOT NULL,
  `transacao` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `realizar` enum('sim','nao') COLLATE utf8mb4_unicode_ci DEFAULT 'nao',
  `data_transacao` date DEFAULT NULL,
  `num_pgto` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `valor_pgto` decimal(10,2) DEFAULT NULL,
  `metodo_pgto` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `_id_pedido` int DEFAULT NULL,
  `info_adicional` text COLLATE utf8mb4_unicode_ci,
  PRIMARY KEY (`_id_transacao`),
  KEY `_id_pedido` (`_id_pedido`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Restrições para tabelas despejadas
--

--
-- Restrições para tabelas `cadastros`
--
ALTER TABLE `cadastros`
  ADD CONSTRAINT `cadastros_ibfk_1` FOREIGN KEY (`_id_empresa`) REFERENCES `empresas` (`_id`) ON DELETE RESTRICT;

--
-- Restrições para tabelas `pedidos`
--
ALTER TABLE `pedidos`
  ADD CONSTRAINT `pedidos_ibfk_1` FOREIGN KEY (`_id_cadastro`) REFERENCES `cadastros` (`_id_cadastro`) ON DELETE RESTRICT;

--
-- Restrições para tabelas `transacoes`
--
ALTER TABLE `transacoes`
  ADD CONSTRAINT `transacoes_ibfk_1` FOREIGN KEY (`_id_pedido`) REFERENCES `pedidos` (`_id_pedido`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
