-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Tempo de geração: 12/06/2025 às 18:10
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
-- Estrutura para tabela `clausulas`
--

DROP TABLE IF EXISTS `clausulas`;
CREATE TABLE IF NOT EXISTS `clausulas` (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_pai` int DEFAULT NULL,
  `tipo` enum('clausula','subclausula','item','subitem','texto','observacao') NOT NULL,
  `nome_ref` varchar(50) NOT NULL,
  `titulo` varchar(255) DEFAULT NULL,
  `descricao` text NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id_pai` (`id_pai`)
) ENGINE=MyISAM AUTO_INCREMENT=25 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Despejando dados para a tabela `clausulas`
--

INSERT INTO `clausulas` (`id`, `id_pai`, `tipo`, `nome_ref`, `titulo`, `descricao`) VALUES
(1, NULL, 'observacao', 'Teste', 'Identificação das Partes', 'Por este instrumento particular... (texto completo)\r\nPor este instrumento particular... (texto completo)'),
(2, NULL, 'clausula', 'teste', 'Objeto do Contrato', 'A equipe da CONTRATADA prestará ao CONTRATANTE os serviços... A equipe da CONTRATADA prestará ao CONTRATANTE os serviços... A equipe da CONTRATADA prestará ao CONTRATANTE os serviços... A equipe da CONTRATADA prestará ao CONTRATANTE os serviços... A equipe da CONTRATADA prestará ao CONTRATANTE os serviços... A equipe da CONTRATADA prestará ao CONTRATANTE os serviços... A equipe da CONTRATADA prestará ao CONTRATANTE os serviços...'),
(3, NULL, 'clausula', '', 'Forma de Pagamento', 'O valor total de R$ 2.466,00 será pago como descrito a seguir...'),
(4, NULL, 'clausula', '', 'Prazos de Entrega', 'A CONTRATADA deverá entregar no prazo de até 7 dias úteis...'),
(5, NULL, 'clausula', '', 'Retirada dos Materiais', 'A CONTRATANTE será responsável pela retirada dos produtos...'),
(6, NULL, 'clausula', '', 'Tratamento de Imagens', 'Todas as fotos receberão tratamento básico...'),
(7, NULL, 'clausula', '', 'Álbum Fotográfico', 'Na contratação de Álbum a CONTRATANTE terá direito a...'),
(8, NULL, 'clausula', '', 'Direitos Autorais', 'As imagens do evento são propriedade autoral exclusiva da CONTRATADA...'),
(9, NULL, 'clausula', '', 'Inadimplemento', 'Em caso de falta de pagamento...'),
(10, NULL, 'clausula', '', 'Garantia de Captura', 'As partes estão cientes de que não se pode garantir...'),
(11, NULL, 'clausula', '', 'Cancelamento', 'O presente ajuste é feito em caráter irrevogável e irretratável...'),
(12, NULL, 'clausula', '', 'Legislação Aplicável', 'O presente contrato rege-se pela Lei 8.078 de 11/9/00...'),
(13, NULL, 'clausula', '', 'Foro', 'Fica eleito o foro da comarca de Santo André...'),
(14, 2, 'subclausula', '', 'Descrição do Evento', 'Fotografia e filmagem do evento Aniversário Denise...'),
(15, 2, 'item', '', 'Equipe Contratada', '1 fotógrafo e 1 cinegrafista, cobertura de 6 horas...'),
(16, 2, 'item', '', 'Entrega de Arquivos', 'Arquivos em formato digital via download ou pendrive...'),
(17, 2, 'item', 'para tratar sobre backups', 'Backup dos Arquivos', 'Item Fictício 1 Item Fictício 2 Item Fictício 3'),
(18, 2, 'item', 'Clausula sobre preço teste 3', 'Valor do Serviço', 'Valor original R$ 2.740,00, desconto de 10%, total R$ 2.466,00.'),
(19, 3, 'item', '', 'Pagamento 1', '04/02/2025 - R$ 1.233,00 via Pix ou Boleto.'),
(20, 3, 'item', '', 'Pagamento 2', '24/04/2025 - R$ 1.233,00 via Pix ou Boleto.'),
(22, 3, 'observacao', '', NULL, 'Caso haja alteração no projeto, despesas adicionais serão cobradas (deslocamentos, hospedagem, etc.).'),
(24, 1, 'subclausula', 'Sub clausula teste sub 1', 'teste sub 1', 'Apenas teste subclausula Apenas teste subclausula Apenas teste subclausula Apenas teste subclausula Apenas teste subclausula Apenas teste subclausula Apenas teste subclausula Apenas teste subclausula');

-- --------------------------------------------------------

--
-- Estrutura para tabela `contatos`
--

DROP TABLE IF EXISTS `contatos`;
CREATE TABLE IF NOT EXISTS `contatos` (
  `timestamp` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `modificado` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
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

INSERT INTO `contatos` (`timestamp`, `modificado`, `_id_empresa`, `_id_contato`, `tipo_contato`, `nome_completo`, `rg`, `cpf`, `data_nasc`, `naturalidade`, `profissao`, `cep`, `rua`, `numero`, `complemento`, `bairro`, `cidade`, `estado`, `telefone`, `email`, `redes_sociais`, `contato_recados`, `telefone_recados`, `email_recados`, `origem`) VALUES
('2025-04-14 20:14:45', '2025-05-17 13:30:08', 1, 1, 'cliente', 'Maria Silva Santos', '12.345.678-9', '123.456.789-01', '1990-05-15', 'São Paulo', 'Professora', '01234-567', 'Rua das Flores', '123', 'c2', 'Centro', 'São Paulo', 'SP', '(11)99999-1111', 'maria@email.com', '@maria', 'João Silva', '(11)99999-2222', 'joao@email.com', 'insta'),
('2025-04-14 20:14:46', '2025-05-16 09:44:25', 2, 2, 'cliente', 'José Santos Silva', '98.765.432-1', '987.654.321-02', '1985-06-20', 'Rio de Janeiro', 'Engenheiro', '12345-678', 'Av Brasil', '456', NULL, 'Jardins', 'São Paulo', 'SP', '(11)99999-3333', 'jose@email.com', NULL, 'Ana Santos', '(11)99999-4444', 'ana@email.com', NULL),
('2025-04-16 13:40:48', '2025-05-16 09:44:25', 2, 3, 'cliente', 'ROGERIO MORAIS BARBOZA', '347101628', '30329490842', '1981-12-18', 'Santo André', 'Fotografo', '09195-740', 'Travessa Soledade', '19', '0', 'Vila Pires', 'Santo André', 'SP', '11971872119', 'roger.msms@gmail.com', '@abcfotoevideo', 'Adriana Morais', '11-97014-5670', 'testeadriana@mail.com', 'teste'),
('2025-04-16 18:23:57', '2025-05-17 13:39:42', 1, 4, 'cliente', 'Tião Cagão', '241554882', '3012957824', '2001-01-01', 'Paraiba', 'Pedreiro', '09135490', 'Rua dos Maristas', '64', 'c2', 'Jardim Santo André', 'Santo André', 'SP', '11971872119', 'teste2@mail.com', '@teste2', 'ROGERIO MORAIS BARBOZA', '11971872119', 'roger.msms@gmail.com', 'site'),
('2025-04-19 22:17:55', '2025-05-16 09:44:25', 1, 5, 'colaborador', 'Daniel Fernandes', '54810902x', '20256498952', '1999-01-18', 'São Paulo', 'Cinegrafista', '02165789', 'Rua Bera', '24', '02', 'Jd. Paulo', 'São Paulo', 'SP', '1196565-4242', 'daniel@mail.com', '@daniel', 'teste recados', '11 98877-6655', 'recadodaniel@email.com', 'teste teste');

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
-- Estrutura para tabela `modelos_contratos`
--

DROP TABLE IF EXISTS `modelos_contratos`;
CREATE TABLE IF NOT EXISTS `modelos_contratos` (
  `id_modelo` int NOT NULL AUTO_INCREMENT,
  `nome_modelo` varchar(255) NOT NULL,
  PRIMARY KEY (`id_modelo`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Despejando dados para a tabela `modelos_contratos`
--

INSERT INTO `modelos_contratos` (`id_modelo`, `nome_modelo`) VALUES
(1, 'Modelo Contrato Aniversário Denise'),
(3, 'Modelo com Base em outro'),
(5, 'novo modelo teste');

-- --------------------------------------------------------

--
-- Estrutura para tabela `modelos_contratos_clausulas`
--

DROP TABLE IF EXISTS `modelos_contratos_clausulas`;
CREATE TABLE IF NOT EXISTS `modelos_contratos_clausulas` (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_modelo` int NOT NULL,
  `id_clausula` int NOT NULL,
  `ordem` int NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `id_modelo` (`id_modelo`),
  KEY `id_clausula` (`id_clausula`)
) ENGINE=MyISAM AUTO_INCREMENT=68 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Despejando dados para a tabela `modelos_contratos_clausulas`
--

INSERT INTO `modelos_contratos_clausulas` (`id`, `id_modelo`, `id_clausula`, `ordem`) VALUES
(1, 1, 1, 0),
(2, 1, 2, 0),
(3, 1, 3, 0),
(4, 1, 4, 0),
(5, 1, 5, 0),
(6, 1, 6, 0),
(7, 1, 7, 0),
(8, 1, 8, 0),
(9, 1, 9, 0),
(10, 1, 10, 0),
(11, 1, 11, 0),
(12, 1, 12, 0),
(13, 1, 13, 0),
(67, 5, 17, 6),
(66, 5, 14, 5),
(65, 5, 11, 4),
(64, 5, 18, 3),
(63, 5, 14, 2),
(62, 5, 2, 1),
(54, 0, 4, 4),
(53, 0, 3, 3),
(52, 0, 2, 2),
(51, 0, 1, 1),
(50, 3, 3, 3),
(49, 3, 2, 2),
(48, 3, 1, 1);

-- --------------------------------------------------------

--
-- Estrutura para tabela `pacotes`
--

DROP TABLE IF EXISTS `pacotes`;
CREATE TABLE IF NOT EXISTS `pacotes` (
  `criado` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `modificado` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
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

INSERT INTO `pacotes` (`criado`, `modificado`, `_id_pacote`, `_id_empresa`, `nome_pacote`, `descr_pacote`, `detalhar_pacote`, `_ids_produtos`, `custo_pacote`, `preco_pacote`, `status`) VALUES
('2025-04-24 17:28:53', NULL, 1, 1, 'Pacote Casamento Platinum', 'Cobertura completa de casamento', 'Inclui ensaio pré-wedding, making of, fotos e vídeos do evento, álbum premium', '1,2,3,4,5', 1800.00, 4500.00, 'ativo'),
('2025-04-24 17:28:53', NULL, 2, 1, 'Pacote Aniversário Gold', 'Cobertura de aniversário', 'Fotos e vídeos do evento, álbum digital', '3,5', 1000.00, 2800.00, 'ativo'),
('2025-04-24 17:28:53', NULL, 3, 2, 'Pacote Festa Completo', 'Organização completa de eventos', 'Assessoria completa + decoração + buffet', '7,8,9,10', 1750.00, 4800.00, 'ativo'),
('2025-04-24 17:28:53', NULL, 4, 2, 'Pacote Consultoria Básica', 'Consultoria para pequenos eventos', 'Consultoria inicial + day use', '6,7', 450.00, 1200.00, 'ativo');

-- --------------------------------------------------------

--
-- Estrutura para tabela `pedidos`
--

DROP TABLE IF EXISTS `pedidos`;
CREATE TABLE IF NOT EXISTS `pedidos` (
  `criado` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `modificado` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
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
) ENGINE=InnoDB AUTO_INCREMENT=66 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Despejando dados para a tabela `pedidos`
--

INSERT INTO `pedidos` (`criado`, `modificado`, `_id_contato`, `_id_pedido`, `nome_contato`, `produto_servico`, `seguimento`, `titulo_evento`, `data_reservada`, `descricao_pedido`, `participantes`, `observacoes`, `numero_convidados`, `horario_convite`, `horario_inicio`, `valor_original`, `valor_desconto`, `valor_total`, `forma_pagamento`, `numero_pagamentos`, `valor_pagamento_1`, `data_pagamento_1`, `vencimento_mensal`, `reserva_equipe`, `estimativa_custo`) VALUES
('2025-05-08 20:18:18', '2025-06-04 21:31:15', 2, 57, 'José Santos Silva', 'Pack ouro', 'casamento', 'Festa dos Ursos', '2026-01-01', 'foto e video', 'todos participantes', 'obsobsobsd', 100, '18:00', '18:30', 6000.00, 500.00, 5500.00, 'cartao', 5, 1500.00, '2025-05-08', '2025-06-05', 'equipe aqui', 1000.00),
('2025-05-08 21:19:21', '2025-06-04 21:31:15', 3, 58, 'ROGERIO MORAIS BARBOZA', 'Pack ouro', 'casamento', 'Festa dos Ursos', '2026-01-01', 'foto e video', 'todos participantes', 'obsobsobsd', 100, '18:00', '18:30', 6000.00, 500.00, 5500.00, 'cartao', 5, 1500.00, '2025-05-08', '2025-06-05', 'equipe aqui', 1000.00),
('2025-05-09 09:57:41', '2025-06-04 21:31:15', 4, 59, 'Tião Cagão', 'Pack Diamante', 'corporativo', 'Festa dos Ursos', '2025-05-31', 'jdjdjtyjsjk', 'todos participantes', 'obsgstrh', 200, '12:00', '12:30', 10000.00, 0.00, 10000.00, 'transferencia', 10, 1000.00, '2025-05-09', '2025-05-31', 'eeeeeee', 3000.00),
('2025-06-05 14:33:25', '2025-06-05 14:33:25', 3, 61, 'ROGERIO MORAIS BARBOZA', 'Pack Personalizado', 'outro', 'Casamento dos Ursos', '2025-06-30', 'Produto: Ensaio Pré-Wedding\nCategoria: Fotografia\nDescrição: Sessão fotográfica para noivos\nitem: Ensaio em 2 locações, 50 fotos tratadas, álbum digital\nPreço: R$ 1800.00\nStatus: ativo\n-----------------------------\n\nProduto: Making Of\nCategoria: Filmagem\nDescrição: Filmagem dos bastidores\nitem: Vídeo resumo de 3-5 minutos, edição completa\nitem: Preço: R$ 600.00\nitem: Status: ativo\n-----------------------------\n\nProduto: Cobertura Básica\nCategoria: Fotografia\nDescrição: Cobertura fotográfica evento\nitem: Até 4 horas de cobertura, 100 fotos tratadas\nPreço: R$ 1200.00\nStatus: ativo\n-----------------------------\n', 'Papai, mamãe e vovó', 'obs obs obs obs', 300, '11:15', '11:30', 5000.00, 500.00, 4500.00, 'pix', 10, 450.00, '2025-06-06', '2025-07-10', 'Os mano', 1000.00),
('2025-06-05 21:04:02', '2025-06-05 21:04:02', 1, 65, 'Maria Silva Santos', 'Pack PRATA', 'casamento', 'festinha', '2025-12-05', 'Produto: Ensaio Pré-Wedding\nCategoria: Fotografia\nDescrição: Sessão fotográfica para noivos\nitem: Ensaio em 2 locações, 50 fotos tratadas, item: álbum digital\nPreço: R$ 1800.00\nStatus: ativo\n-----------------------------\n\nProduto: Making Of\nCategoria: Filmagem\nDescrição: Filmagem dos bastidores\nitem: Vídeo resumo de 3-5 minutos, edição completa\nPreço: R$ 600.00\nStatus: ativo\n-----------------------------\n\nProduto: Cobertura Básica\nCategoria: Fotografia\nDescrição: Cobertura fotográfica evento\nitem: Até 4 horas de cobertura, 100 fotos tratadas\nPreço: R$ 1200.00\nStatus: ativo\n-----------------------------\n', 'todos participantes', 'obssss', 100, '18:03', '18:03', 1000.00, 0.00, 1000.00, 'dinheiro', 1, 1000.00, '2025-06-05', '2025-06-05', 'noixxxx', 500.00);

-- --------------------------------------------------------

--
-- Estrutura para tabela `produtos`
--

DROP TABLE IF EXISTS `produtos`;
CREATE TABLE IF NOT EXISTS `produtos` (
  `criado` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `modificado` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
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
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Despejando dados para a tabela `produtos`
--

INSERT INTO `produtos` (`criado`, `modificado`, `_id_empresa`, `_id_produto`, `categoria`, `nome_produto`, `descr_prod`, `detalhar_prod`, `custo_prod`, `preco_prod`, `status`) VALUES
('2025-04-24 17:28:52', '2025-05-14 21:40:31', 1, 1, 'Fotografia', 'Ensaio Pré-Wedding', 'Sessão fotográfica para noivos', 'Ensaio em 2 locações, 50 fotos tratadas, álbum digital', 300.00, 1800.00, 'ativo'),
('2025-04-24 17:28:52', '0000-00-00 00:00:00', 1, 2, 'Filmagem', 'Making Of', 'Filmagem dos bastidores', 'Vídeo resumo de 3-5 minutos, edição completa', 200.00, 600.00, 'ativo'),
('2025-04-24 17:28:52', '0000-00-00 00:00:00', 1, 3, 'Fotografia', 'Cobertura Básica', 'Cobertura fotográfica evento', 'Até 4 horas de cobertura, 100 fotos tratadas', 400.00, 1200.00, 'ativo'),
('2025-04-24 17:28:52', '0000-00-00 00:00:00', 1, 4, 'Impressão', 'Álbum Premium', 'Álbum fotográfico encadernado', '30x30cm, capa dura, 20 páginas', 250.00, 800.00, 'ativo'),
('2025-04-24 17:28:52', '0000-00-00 00:00:00', 1, 5, 'Filmagem', 'Vídeo Completo', 'Filmagem completa do evento', 'Vídeo completo editado + highlights', 600.00, 1800.00, 'ativo'),
('2025-04-24 17:28:52', '2025-05-14 21:42:31', 2, 6, 'Assessoria', 'Consultoria Inicial', 'Planejamento inicial do evento', '2 reuniões presenciais, cronograma básico', 150.00, 800.00, 'ativo'),
('2025-04-24 17:28:52', '0000-00-00 00:00:00', 2, 7, 'Assessoria', 'Day Use', 'Assessoria no dia do evento', 'Coordenação completa no dia', 300.00, 900.00, 'ativo'),
('2025-04-24 17:28:52', '0000-00-00 00:00:00', 2, 8, 'Decoração', 'Decoração Básica', 'Decoração evento pequeno', 'Mesa principal + 2 arranjos laterais', 400.00, 1200.00, 'ativo'),
('2025-04-24 17:28:52', '0000-00-00 00:00:00', 2, 9, 'Buffet', 'Coffee Break', 'Serviço de coffee break', 'Café, água, 3 tipos de salgados, 2 doces', 250.00, 800.00, 'ativo'),
('2025-04-24 17:28:52', '0000-00-00 00:00:00', 2, 10, 'Assessoria', 'Assessoria Completa', 'Planejamento completo', 'Desde o planejamento até execução', 800.00, 2500.00, 'ativo'),
('2025-05-11 22:12:30', '0000-00-00 00:00:00', 1, 11, 'casamento', 'Produto teste', 'descrição teste', 'detalhar produto teste', 300.00, 600.00, 'ativo');

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
) ENGINE=InnoDB AUTO_INCREMENT=3618 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `transacoes`
--

INSERT INTO `transacoes` (`timestamp`, `_id_transacao`, `_id_pedido`, `_id_contato`, `venc_mensal`, `transacao`, `situacao`, `data_transacao`, `num_pgto`, `valor_pgto`, `metodo_pgto`, `pedido`, `contato`, `metodos_contato`, `info_adicional`) VALUES
('2025-05-08 20:18:18', 3566, 57, 2, '2025-05-08', 'RECEITA', 'A RECEBER', NULL, 1, 1500.00, 'cartao', 'Festa dos Ursos', 'José Santos Silva', '(11)99999-3333, jose@email.com', 'Entrada | info adicional teste'),
('2025-05-08 20:18:18', 3567, 57, 2, '2025-06-05', 'RECEITA', 'A RECEBER', NULL, 2, 1000.00, 'cartao', 'Festa dos Ursos', 'José Santos Silva', '(11)99999-3333, jose@email.com', 'info adicional teste'),
('2025-05-08 20:18:18', 3568, 57, 2, '2025-07-05', 'RECEITA', 'A RECEBER', NULL, 3, 1000.00, 'cartao', 'Festa dos Ursos', 'José Santos Silva', '(11)99999-3333, jose@email.com', 'info adicional teste'),
('2025-05-08 20:18:19', 3569, 57, 2, '2025-08-05', 'RECEITA', 'A RECEBER', NULL, 4, 1000.00, 'cartao', 'Festa dos Ursos', 'José Santos Silva', '(11)99999-3333, jose@email.com', 'info adicional teste'),
('2025-05-08 20:18:19', 3570, 57, 2, '2025-09-05', 'RECEITA', 'A RECEBER', NULL, 5, 1000.00, 'cartao', 'Festa dos Ursos', 'José Santos Silva', '(11)99999-3333, jose@email.com', 'info adicional teste'),
('2025-05-08 21:19:21', 3571, 58, 3, '2025-05-08', 'RECEITA', 'A RECEBER', NULL, 1, 1500.00, 'cartao', 'Festa dos Ursos', 'ROGERIO MORAIS BARBOZA', '11971872119, roger.msms@gmail.com', 'Entrada | info adicional teste'),
('2025-05-08 21:19:21', 3572, 58, 3, '2025-06-05', 'RECEITA', 'A RECEBER', NULL, 2, 1000.00, 'cartao', 'Festa dos Ursos', 'ROGERIO MORAIS BARBOZA', '11971872119, roger.msms@gmail.com', 'info adicional teste'),
('2025-05-08 21:19:21', 3573, 58, 3, '2025-07-05', 'RECEITA', 'A RECEBER', NULL, 3, 1000.00, 'cartao', 'Festa dos Ursos', 'ROGERIO MORAIS BARBOZA', '11971872119, roger.msms@gmail.com', 'info adicional teste'),
('2025-05-08 21:19:21', 3574, 58, 3, '2025-08-05', 'RECEITA', 'A RECEBER', NULL, 4, 1000.00, 'cartao', 'Festa dos Ursos', 'ROGERIO MORAIS BARBOZA', '11971872119, roger.msms@gmail.com', 'info adicional teste'),
('2025-05-08 21:19:21', 3575, 58, 3, '2025-09-05', 'RECEITA', 'A RECEBER', NULL, 5, 1000.00, 'cartao', 'Festa dos Ursos', 'ROGERIO MORAIS BARBOZA', '11971872119, roger.msms@gmail.com', 'info adicional teste'),
('2025-05-09 09:57:41', 3576, 59, 4, '2025-05-09', 'RECEITA', 'A RECEBER', NULL, 1, 1000.00, 'transferencia', 'Festa dos Ursos', 'Tião Cagão', '11971872119, teste2@mail.com', 'Entrada | adadadadadad'),
('2025-05-09 09:57:41', 3577, 59, 4, '2025-05-31', 'RECEITA', 'A RECEBER', NULL, 2, 1000.00, 'transferencia', 'Festa dos Ursos', 'Tião Cagão', '11971872119, teste2@mail.com', 'adadadadadad'),
('2025-05-09 09:57:42', 3578, 59, 4, '2025-07-01', 'RECEITA', 'A RECEBER', NULL, 3, 1000.00, 'transferencia', 'Festa dos Ursos', 'Tião Cagão', '11971872119, teste2@mail.com', 'adadadadadad'),
('2025-05-09 09:57:42', 3579, 59, 4, '2025-07-31', 'RECEITA', 'A RECEBER', NULL, 4, 1000.00, 'transferencia', 'Festa dos Ursos', 'Tião Cagão', '11971872119, teste2@mail.com', 'adadadadadad'),
('2025-05-09 09:57:42', 3580, 59, 4, '2025-08-31', 'RECEITA', 'A RECEBER', NULL, 5, 1000.00, 'transferencia', 'Festa dos Ursos', 'Tião Cagão', '11971872119, teste2@mail.com', 'adadadadadad'),
('2025-05-09 09:57:42', 3581, 59, 4, '2025-10-01', 'RECEITA', 'A RECEBER', NULL, 6, 1000.00, 'transferencia', 'Festa dos Ursos', 'Tião Cagão', '11971872119, teste2@mail.com', 'adadadadadad'),
('2025-05-09 09:57:42', 3582, 59, 4, '2025-10-31', 'RECEITA', 'A RECEBER', NULL, 7, 1000.00, 'transferencia', 'Festa dos Ursos', 'Tião Cagão', '11971872119, teste2@mail.com', 'adadadadadad'),
('2025-05-09 09:57:42', 3583, 59, 4, '2025-12-01', 'RECEITA', 'A RECEBER', NULL, 8, 1000.00, 'transferencia', 'Festa dos Ursos', 'Tião Cagão', '11971872119, teste2@mail.com', 'adadadadadad'),
('2025-05-09 09:57:42', 3584, 59, 4, '2025-12-31', 'RECEITA', 'A RECEBER', NULL, 9, 1000.00, 'transferencia', 'Festa dos Ursos', 'Tião Cagão', '11971872119, teste2@mail.com', 'adadadadadad'),
('2025-05-09 09:57:42', 3585, 59, 4, '2026-01-31', 'RECEITA', 'A RECEBER', NULL, 10, 1000.00, 'transferencia', 'Festa dos Ursos', 'Tião Cagão', '11971872119, teste2@mail.com', 'adadadadadad'),
('2025-06-05 14:33:25', 3586, 61, 3, '2025-06-06', 'RECEITA', 'A RECEBER', NULL, 1, 450.00, 'pix', 'Casamento dos Ursos', 'ROGERIO MORAIS BARBOZA', '11971872119, roger.msms@gmail.com', 'Entrada | Somente teste'),
('2025-06-05 14:33:26', 3587, 61, 3, '2025-07-10', 'RECEITA', 'A RECEBER', NULL, 2, 450.00, 'pix', 'Casamento dos Ursos', 'ROGERIO MORAIS BARBOZA', '11971872119, roger.msms@gmail.com', 'Somente teste'),
('2025-06-05 14:33:26', 3588, 61, 3, '2025-08-10', 'RECEITA', 'A RECEBER', NULL, 3, 450.00, 'pix', 'Casamento dos Ursos', 'ROGERIO MORAIS BARBOZA', '11971872119, roger.msms@gmail.com', 'Somente teste'),
('2025-06-05 14:33:26', 3589, 61, 3, '2025-09-10', 'RECEITA', 'A RECEBER', NULL, 4, 450.00, 'pix', 'Casamento dos Ursos', 'ROGERIO MORAIS BARBOZA', '11971872119, roger.msms@gmail.com', 'Somente teste'),
('2025-06-05 14:33:26', 3590, 61, 3, '2025-10-10', 'RECEITA', 'A RECEBER', NULL, 5, 450.00, 'pix', 'Casamento dos Ursos', 'ROGERIO MORAIS BARBOZA', '11971872119, roger.msms@gmail.com', 'Somente teste'),
('2025-06-05 14:33:26', 3591, 61, 3, '2025-11-10', 'RECEITA', 'A RECEBER', NULL, 6, 450.00, 'pix', 'Casamento dos Ursos', 'ROGERIO MORAIS BARBOZA', '11971872119, roger.msms@gmail.com', 'Somente teste'),
('2025-06-05 14:33:26', 3592, 61, 3, '2025-12-10', 'RECEITA', 'A RECEBER', NULL, 7, 450.00, 'pix', 'Casamento dos Ursos', 'ROGERIO MORAIS BARBOZA', '11971872119, roger.msms@gmail.com', 'Somente teste'),
('2025-06-05 14:33:26', 3593, 61, 3, '2026-01-10', 'RECEITA', 'A RECEBER', NULL, 8, 450.00, 'pix', 'Casamento dos Ursos', 'ROGERIO MORAIS BARBOZA', '11971872119, roger.msms@gmail.com', 'Somente teste'),
('2025-06-05 14:33:26', 3594, 61, 3, '2026-02-10', 'RECEITA', 'A RECEBER', NULL, 9, 450.00, 'pix', 'Casamento dos Ursos', 'ROGERIO MORAIS BARBOZA', '11971872119, roger.msms@gmail.com', 'Somente teste'),
('2025-06-05 14:33:26', 3595, 61, 3, '2026-03-10', 'RECEITA', 'A RECEBER', NULL, 10, 450.00, 'pix', 'Casamento dos Ursos', 'ROGERIO MORAIS BARBOZA', '11971872119, roger.msms@gmail.com', 'Somente teste'),
('2025-06-05 21:04:02', 3617, 65, 1, '2025-06-05', 'RECEITA', 'A RECEBER', NULL, 1, 1000.00, 'dinheiro', 'festinha', 'Maria Silva Santos', '(11)99999-1111, maria@email.com', 'Entrada | add info');

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
