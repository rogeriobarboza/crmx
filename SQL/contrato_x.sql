-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Tempo de geração: 08/05/2025 às 17:55
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
-- Estrutura para tabela `contatos`
--

DROP TABLE IF EXISTS `contatos`;
CREATE TABLE IF NOT EXISTS `contatos` (
  `timestamp` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `_id_empresa` int NOT NULL,
  `_id_contato` int NOT NULL AUTO_INCREMENT,
  `tipo_contato` enum('cliente','colaborador','fornecedor','parceiro','outros') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
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
  PRIMARY KEY (`_id_contato`),
  UNIQUE KEY `cpf` (`cpf`),
  UNIQUE KEY `rg` (`rg`),
  KEY `_id_empresa` (`_id_empresa`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Despejando dados para a tabela `contatos`
--

INSERT INTO `contatos` (`timestamp`, `_id_empresa`, `_id_contato`, `tipo_contato`, `nome_completo`, `rg`, `cpf`, `data_nasc`, `naturalidade`, `profissao`, `cep`, `rua`, `numero`, `complemento`, `bairro`, `cidade`, `estado`, `telefone`, `email`, `redes_sociais`, `contato_recados`, `telefone_recados`, `email_recados`, `origem`) VALUES
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
('2025-04-14 20:14:45', 2, 'Adriana Morais Assessoria');

-- --------------------------------------------------------

--
-- Estrutura para tabela `pacotes`
--

DROP TABLE IF EXISTS `pacotes`;
CREATE TABLE IF NOT EXISTS `pacotes` (
  `timestamp` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `_id_pacote` int NOT NULL AUTO_INCREMENT,
  `_id_empresa` int NOT NULL,
  `nome_pacote` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `descr_pacote` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL COMMENT 'Descrição curta do pacote',
  `detalhar_pacote` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci COMMENT 'Detalhamento completo do pacote',
  `_ids_produtos` varchar(255) DEFAULT NULL COMMENT 'IDs dos produtos separados por vírgula',
  `custo_pacote` decimal(10,2) NOT NULL DEFAULT '0.00',
  `preco_pacote` decimal(10,2) NOT NULL DEFAULT '0.00',
  `status` enum('ativo','inativo') NOT NULL DEFAULT 'ativo',
  PRIMARY KEY (`_id_pacote`),
  KEY `_id_empresa` (`_id_empresa`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Despejando dados para a tabela `pacotes`
--

INSERT INTO `pacotes` (`timestamp`, `_id_pacote`, `_id_empresa`, `nome_pacote`, `descr_pacote`, `detalhar_pacote`, `_ids_produtos`, `custo_pacote`, `preco_pacote`, `status`) VALUES
('2025-04-24 17:28:53', 1, 1, 'Pacote Casamento Platinum', 'Cobertura completa de casamento', 'Inclui ensaio pré-wedding, making of, fotos e vídeos do evento, álbum premium', '1,2,3,4,5', 1800.00, 4500.00, 'ativo'),
('2025-04-24 17:28:53', 2, 1, 'Pacote Aniversário Gold', 'Cobertura de aniversário', 'Fotos e vídeos do evento, álbum digital', '3,5', 1000.00, 2800.00, 'ativo'),
('2025-04-24 17:28:53', 3, 2, 'Pacote Festa Completo', 'Organização completa de eventos', 'Assessoria completa + decoração + buffet', '7,8,9,10', 1750.00, 4800.00, 'ativo'),
('2025-04-24 17:28:53', 4, 2, 'Pacote Consultoria Básica', 'Consultoria para pequenos eventos', 'Consultoria inicial + day use', '6,7', 450.00, 1200.00, 'ativo');

-- --------------------------------------------------------

--
-- Estrutura para tabela `pedidos`
--

DROP TABLE IF EXISTS `pedidos`;
CREATE TABLE IF NOT EXISTS `pedidos` (
  `timestamp` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `_id_contato` int NOT NULL,
  `_id_pedido` int NOT NULL AUTO_INCREMENT,
  `nome_contato` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `produto_servico` varchar(100) NOT NULL,
  `seguimento` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `titulo_evento` varchar(100) NOT NULL,
  `data_reservada` varchar(12) NOT NULL,
  `descricao_pedido` text NOT NULL,
  `participantes` text,
  `observacoes` text,
  `numero_convidados` int NOT NULL,
  `horario_convite` varchar(12) NOT NULL,
  `horario_inicio` varchar(12) NOT NULL,
  `valor_original` decimal(10,2) NOT NULL,
  `valor_desconto` decimal(10,2) DEFAULT '0.00',
  `valor_total` decimal(10,2) NOT NULL,
  `forma_pagamento` enum('dinheiro','cartao','pix','transferencia') NOT NULL,
  `numero_pagamentos` int NOT NULL,
  `valor_pagamento_1` decimal(10,2) DEFAULT NULL,
  `data_pagamento_1` varchar(12) NOT NULL,
  `vencimento_mensal` varchar(12) NOT NULL,
  `reserva_equipe` text,
  `estimativa_custo` decimal(10,2) DEFAULT NULL,
  PRIMARY KEY (`_id_pedido`),
  KEY `pedidos_ibfk_1` (`_id_contato`)
) ENGINE=InnoDB AUTO_INCREMENT=54 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Despejando dados para a tabela `pedidos`
--

INSERT INTO `pedidos` (`timestamp`, `_id_contato`, `_id_pedido`, `nome_contato`, `produto_servico`, `seguimento`, `titulo_evento`, `data_reservada`, `descricao_pedido`, `participantes`, `observacoes`, `numero_convidados`, `horario_convite`, `horario_inicio`, `valor_original`, `valor_desconto`, `valor_total`, `forma_pagamento`, `numero_pagamentos`, `valor_pagamento_1`, `data_pagamento_1`, `vencimento_mensal`, `reserva_equipe`, `estimativa_custo`) VALUES
('2025-05-08 12:47:23', 1, 53, 'Maria Santos Silva', 'Pack ouro', 'casamento', 'Casamento Paulo', '2026-10-20', 'Foto vieo album', 'padrinhos e madrinhas', 'retrato com padrinhos no altar', 120, '19:00', '19:30', 6000.00, 500.00, 5500.00, 'pix', 12, 1500.00, '2025-05-05', '2025-06-01', 'xxx', 2000.00);

-- --------------------------------------------------------

--
-- Estrutura para tabela `produtos`
--

DROP TABLE IF EXISTS `produtos`;
CREATE TABLE IF NOT EXISTS `produtos` (
  `timestamp` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `_id_empresa` int NOT NULL,
  `_id_produto` int NOT NULL AUTO_INCREMENT,
  `categoria` varchar(50) NOT NULL,
  `nome_produto` varchar(100) NOT NULL,
  `descr_prod` varchar(255) NOT NULL,
  `detalhar_prod` text,
  `custo_prod` decimal(10,2) DEFAULT '0.00',
  `preco_prod` decimal(10,2) NOT NULL,
  `status` varchar(12) NOT NULL,
  PRIMARY KEY (`_id_produto`),
  KEY `_id_empresa` (`_id_empresa`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Despejando dados para a tabela `produtos`
--

INSERT INTO `produtos` (`timestamp`, `_id_empresa`, `_id_produto`, `categoria`, `nome_produto`, `descr_prod`, `detalhar_prod`, `custo_prod`, `preco_prod`, `status`) VALUES
('2025-04-24 17:28:52', 1, 1, 'Fotografia', 'Ensaio Pré-Wedding', 'Sessão fotográfica para noivos', 'Ensaio em 2 locações, 50 fotos tratadas, álbum digital', 300.00, 800.00, 'ativo'),
('2025-04-24 17:28:52', 1, 2, 'Filmagem', 'Making Of', 'Filmagem dos bastidores', 'Vídeo resumo de 3-5 minutos, edição completa', 200.00, 600.00, 'ativo'),
('2025-04-24 17:28:52', 1, 3, 'Fotografia', 'Cobertura Básica', 'Cobertura fotográfica evento', 'Até 4 horas de cobertura, 100 fotos tratadas', 400.00, 1200.00, 'ativo'),
('2025-04-24 17:28:52', 1, 4, 'Impressão', 'Álbum Premium', 'Álbum fotográfico encadernado', '30x30cm, capa dura, 20 páginas', 250.00, 800.00, 'ativo'),
('2025-04-24 17:28:52', 1, 5, 'Filmagem', 'Vídeo Completo', 'Filmagem completa do evento', 'Vídeo completo editado + highlights', 600.00, 1800.00, 'ativo'),
('2025-04-24 17:28:52', 2, 6, 'Assessoria', 'Consultoria Inicial', 'Planejamento inicial do evento', '2 reuniões presenciais, cronograma básico', 150.00, 400.00, 'ativo'),
('2025-04-24 17:28:52', 2, 7, 'Assessoria', 'Day Use', 'Assessoria no dia do evento', 'Coordenação completa no dia', 300.00, 900.00, 'ativo'),
('2025-04-24 17:28:52', 2, 8, 'Decoração', 'Decoração Básica', 'Decoração evento pequeno', 'Mesa principal + 2 arranjos laterais', 400.00, 1200.00, 'ativo'),
('2025-04-24 17:28:52', 2, 9, 'Buffet', 'Coffee Break', 'Serviço de coffee break', 'Café, água, 3 tipos de salgados, 2 doces', 250.00, 800.00, 'ativo'),
('2025-04-24 17:28:52', 2, 10, 'Assessoria', 'Assessoria Completa', 'Planejamento completo', 'Desde o planejamento até execução', 800.00, 2500.00, 'ativo');

-- --------------------------------------------------------

--
-- Estrutura para tabela `transacoes`
--

DROP TABLE IF EXISTS `transacoes`;
CREATE TABLE IF NOT EXISTS `transacoes` (
  `timestamp` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `_id_transacao` int NOT NULL AUTO_INCREMENT,
  `_id_pedido` int DEFAULT NULL,
  `_id_contato` int DEFAULT NULL,
  `venc_mensal` varchar(12) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `transacao` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `situacao` varchar(12) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `data_transacao` varchar(12) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `num_pgto` int DEFAULT NULL,
  `valor_pgto` decimal(10,2) DEFAULT NULL,
  `metodo_pgto` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pedido` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `contato` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `metodos_contato` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `info_adicional` text COLLATE utf8mb4_unicode_ci,
  PRIMARY KEY (`_id_transacao`),
  KEY `_id_pedido` (`_id_pedido`)
) ENGINE=InnoDB AUTO_INCREMENT=3555 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `transacoes`
--

INSERT INTO `transacoes` (`timestamp`, `_id_transacao`, `_id_pedido`, `_id_contato`, `venc_mensal`, `transacao`, `situacao`, `data_transacao`, `num_pgto`, `valor_pgto`, `metodo_pgto`, `pedido`, `contato`, `metodos_contato`, `info_adicional`) VALUES
('2025-05-08 12:47:23', 3543, 53, 1, '2025-05-05', 'RECEITA', 'A RECEBER', NULL, 1, 1500.00, 'pix', 'Casamento Paulo', 'Maria Santos Silva', '(11)99999-1111, maria@email.com', 'Entrada | info adicional teste'),
('2025-05-08 12:47:23', 3544, 53, 1, '2025-06-01', 'RECEITA', 'A RECEBER', NULL, 2, 363.64, 'pix', 'Casamento Paulo', 'Maria Santos Silva', '(11)99999-1111, maria@email.com', 'info adicional teste'),
('2025-05-08 12:47:23', 3545, 53, 1, '2025-07-01', 'RECEITA', 'A RECEBER', NULL, 3, 363.64, 'pix', 'Casamento Paulo', 'Maria Santos Silva', '(11)99999-1111, maria@email.com', 'info adicional teste'),
('2025-05-08 12:47:23', 3546, 53, 1, '2025-08-01', 'RECEITA', 'A RECEBER', NULL, 4, 363.64, 'pix', 'Casamento Paulo', 'Maria Santos Silva', '(11)99999-1111, maria@email.com', 'info adicional teste'),
('2025-05-08 12:47:23', 3547, 53, 1, '2025-09-01', 'RECEITA', 'A RECEBER', NULL, 5, 363.64, 'pix', 'Casamento Paulo', 'Maria Santos Silva', '(11)99999-1111, maria@email.com', 'info adicional teste'),
('2025-05-08 12:47:23', 3548, 53, 1, '2025-10-01', 'RECEITA', 'A RECEBER', NULL, 6, 363.64, 'pix', 'Casamento Paulo', 'Maria Santos Silva', '(11)99999-1111, maria@email.com', 'info adicional teste'),
('2025-05-08 12:47:23', 3549, 53, 1, '2025-11-01', 'RECEITA', 'A RECEBER', NULL, 7, 363.64, 'pix', 'Casamento Paulo', 'Maria Santos Silva', '(11)99999-1111, maria@email.com', 'info adicional teste'),
('2025-05-08 12:47:23', 3550, 53, 1, '2025-12-01', 'RECEITA', 'A RECEBER', NULL, 8, 363.64, 'pix', 'Casamento Paulo', 'Maria Santos Silva', '(11)99999-1111, maria@email.com', 'info adicional teste'),
('2025-05-08 12:47:23', 3551, 53, 1, '2026-01-01', 'RECEITA', 'A RECEBER', NULL, 9, 363.64, 'pix', 'Casamento Paulo', 'Maria Santos Silva', '(11)99999-1111, maria@email.com', 'info adicional teste'),
('2025-05-08 12:47:24', 3552, 53, 1, '2026-02-01', 'RECEITA', 'A RECEBER', NULL, 10, 363.64, 'pix', 'Casamento Paulo', 'Maria Santos Silva', '(11)99999-1111, maria@email.com', 'info adicional teste'),
('2025-05-08 12:47:24', 3553, 53, 1, '2026-03-01', 'RECEITA', 'A RECEBER', NULL, 11, 363.64, 'pix', 'Casamento Paulo', 'Maria Santos Silva', '(11)99999-1111, maria@email.com', 'info adicional teste'),
('2025-05-08 12:47:24', 3554, 53, 1, '2026-04-01', 'RECEITA', 'A RECEBER', NULL, 12, 363.64, 'pix', 'Casamento Paulo', 'Maria Santos Silva', '(11)99999-1111, maria@email.com', 'info adicional teste');

--
-- Restrições para tabelas despejadas
--

--
-- Restrições para tabelas `contatos`
--
ALTER TABLE `contatos`
  ADD CONSTRAINT `contatos_ibfk_1` FOREIGN KEY (`_id_empresa`) REFERENCES `empresas` (`_id`) ON DELETE RESTRICT;

--
-- Restrições para tabelas `pacotes`
--
ALTER TABLE `pacotes`
  ADD CONSTRAINT `pacotes_ibfk_1` FOREIGN KEY (`_id_empresa`) REFERENCES `empresas` (`_id`) ON DELETE RESTRICT;

--
-- Restrições para tabelas `pedidos`
--
ALTER TABLE `pedidos`
  ADD CONSTRAINT `pedidos_ibfk_1` FOREIGN KEY (`_id_contato`) REFERENCES `contatos` (`_id_contato`) ON DELETE RESTRICT;

--
-- Restrições para tabelas `produtos`
--
ALTER TABLE `produtos`
  ADD CONSTRAINT `produtos_ibfk_1` FOREIGN KEY (`_id_empresa`) REFERENCES `empresas` (`_id`) ON DELETE RESTRICT;

--
-- Restrições para tabelas `transacoes`
--
ALTER TABLE `transacoes`
  ADD CONSTRAINT `transacoes_ibfk_1` FOREIGN KEY (`_id_pedido`) REFERENCES `pedidos` (`_id_pedido`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
