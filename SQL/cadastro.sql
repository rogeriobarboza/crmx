-- Criação do banco de dados
DROP DATABASE IF EXISTS contrato_x;
CREATE DATABASE contrato_x;
USE contrato_x;

-- Criação da tabela EMPRESAS
CREATE TABLE EMPRESAS (
    timestamp TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    _id INT PRIMARY KEY AUTO_INCREMENT,
    empresa VARCHAR(100) NOT NULL,
    UNIQUE KEY (empresa)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Inserção das empresas
INSERT INTO EMPRESAS (empresa) VALUES 
('ABC foto e video'),
('Adriana Morais Assessoria');

-- Criação da tabela cadastros
CREATE TABLE cadastros (
    timestamp TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    _id_empresa INT NOT NULL,
    _id_cadastro INT PRIMARY KEY AUTO_INCREMENT,
    tipo_cadastro ENUM('cliente', 'colaborador', 'fornecedor', 'parceiro', 'outros') NOT NULL,
    nome_completo VARCHAR(100) NOT NULL,
    rg VARCHAR(20) NOT NULL,
    cpf VARCHAR(14) NOT NULL,
    data_nasc DATE NOT NULL,
    naturalidade VARCHAR(50) NOT NULL,
    profissao VARCHAR(50) NOT NULL,
    cep VARCHAR(9) NOT NULL,
    rua VARCHAR(100) NOT NULL,
    numero VARCHAR(10) NOT NULL,
    complemento VARCHAR(50),
    bairro VARCHAR(50) NOT NULL,
    cidade VARCHAR(50) NOT NULL,
    estado CHAR(2) NOT NULL,
    telefone VARCHAR(15) NOT NULL,
    email VARCHAR(100) NOT NULL,
    redes_sociais VARCHAR(200),
    contato_recados VARCHAR(100) NOT NULL,
    telefone_recados VARCHAR(15) NOT NULL,
    email_recados VARCHAR(100) NOT NULL,
    origem VARCHAR(100),
    FOREIGN KEY (_id_empresa) REFERENCES EMPRESAS(_id) ON DELETE RESTRICT,
    UNIQUE KEY (cpf),
    UNIQUE KEY (rg)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Criação da tabela pedidos
CREATE TABLE pedidos (
    timestamp TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    _id_cadastro INT NOT NULL,
    _id_pedido INT PRIMARY KEY AUTO_INCREMENT,
    nome_contratante VARCHAR(100) NOT NULL,
    produto_servico VARCHAR(100) NOT NULL,
    seguimento ENUM('casamento', 'debutante', 'aniversario', 'corporativo', 'outro') NOT NULL,
    titulo_evento VARCHAR(100) NOT NULL,
    data_reservada DATE NOT NULL,
    descricao_pedido TEXT NOT NULL,
    participantes TEXT,
    observacoes TEXT,
    numero_convidados INT NOT NULL,
    horario_convite TIME NOT NULL,
    horario_inicio TIME NOT NULL,
    valor_original DECIMAL(10,2) NOT NULL,
    valor_desconto DECIMAL(10,2) DEFAULT 0.00,
    valor_total DECIMAL(10,2) NOT NULL,
    forma_pagamento ENUM('dinheiro', 'cartao', 'pix', 'transferencia') NOT NULL,
    numero_pagamentos INT NOT NULL,
    data_pagamento_1 DATE NOT NULL,
    vencimento_mensal INT NOT NULL CHECK (vencimento_mensal BETWEEN 1 AND 31),
    reserva_equipe TEXT,
    estimativa_custo DECIMAL(10,2),
    FOREIGN KEY (_id_cadastro) REFERENCES cadastros(_id_cadastro) ON DELETE RESTRICT,
    CHECK (valor_total >= 0),
    CHECK (valor_original >= 0),
    CHECK (valor_desconto >= 0),
    CHECK (numero_pagamentos > 0)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Inserção de dados de teste para cadastros
INSERT INTO cadastros (_id_empresa, tipo_cadastro, nome_completo, rg, cpf, data_nasc, naturalidade, profissao, cep, rua, numero, bairro, cidade, estado, telefone, email, contato_recados, telefone_recados, email_recados) VALUES
(1, 'cliente', 'Maria Silva Santos', '12.345.678-9', '123.456.789-01', '1990-05-15', 'São Paulo', 'Professora', '01234-567', 'Rua das Flores', '123', 'Centro', 'São Paulo', 'SP', '(11)99999-1111', 'maria@email.com', 'João Silva', '(11)99999-2222', 'joao@email.com'),
(2, 'cliente', 'José Santos Silva', '98.765.432-1', '987.654.321-02', '1985-06-20', 'Rio de Janeiro', 'Engenheiro', '12345-678', 'Av Brasil', '456', 'Jardins', 'São Paulo', 'SP', '(11)99999-3333', 'jose@email.com', 'Ana Santos', '(11)99999-4444', 'ana@email.com');

-- Inserção de dados de teste para pedidos
INSERT INTO pedidos (_id_cadastro, nome_contratante, produto_servico, seguimento, titulo_evento, data_reservada, descricao_pedido, numero_convidados, horario_convite, horario_inicio, valor_original, valor_total, forma_pagamento, numero_pagamentos, data_pagamento_1, vencimento_mensal) VALUES
(1, 'Maria Silva Santos', 'Fotografia e Filmagem', 'casamento', 'Casamento Maria e João', '2024-10-15', 'Cobertura completa', 200, '20:00', '21:00', 5000.00, 4500.00, 'pix', 10, '2024-05-01', 5),
(2, 'José Santos Silva', 'Assessoria Completa', 'debutante', '15 Anos Ana', '2024-08-20', 'Organização completa', 150, '19:00', '20:00', 8000.00, 7500.00, 'cartao', 12, '2024-04-01', 10);