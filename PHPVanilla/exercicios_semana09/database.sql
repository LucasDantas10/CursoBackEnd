DROP TABLE IF EXISTS movimentacoes_estoque;
DROP TABLE IF EXISTS pecas_industriais;
DROP TABLE IF EXISTS ferramentas;
DROP TABLE IF EXISTS laboratorio_sqli;

CREATE TABLE ferramentas (
    id SERIAL PRIMARY KEY,
    nome VARCHAR(120) NOT NULL,
    categoria VARCHAR(60) NOT NULL,
    quantidade INT NOT NULL DEFAULT 0,
    preco_unitario NUMERIC(10, 2) NOT NULL DEFAULT 0,
    ativo BOOLEAN NOT NULL DEFAULT TRUE
);

CREATE TABLE laboratorio_sqli (
    id SERIAL PRIMARY KEY,
    usuario VARCHAR(60) NOT NULL,
    senha VARCHAR(60) NOT NULL,
    nivel VARCHAR(30) NOT NULL
);

CREATE TABLE pecas_industriais (
    id SERIAL PRIMARY KEY,
    codigo_sku VARCHAR(40) NOT NULL,
    descricao VARCHAR(120) NOT NULL,
    categoria VARCHAR(60) NOT NULL,
    quantidade INT NOT NULL DEFAULT 0,
    preco_unitario NUMERIC(10, 2) NOT NULL DEFAULT 0
);

CREATE TABLE movimentacoes_estoque (
    id SERIAL PRIMARY KEY,
    peca_id INT NOT NULL REFERENCES pecas_industriais (id),
    tipo VARCHAR(20) NOT NULL,
    quantidade INT NOT NULL,
    data_movimentacao TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
);

ALTER TABLE pecas_industriais ADD COLUMN ativo BOOLEAN DEFAULT TRUE;

INSERT INTO ferramentas (nome, categoria, quantidade, preco_unitario) VALUES
    ('Martelo de Uniao 27mm', 'Manual', 34, 45.90),
    ('Chave de Fenda 1/4 x 6"', 'Manual', 51, 18.50),
    ('Alicate Universal 8"', 'Manual', 27, 62.75),
    ('Broca Aco Rapido 8mm', 'Consumivel', 120, 12.00),
    ('Trena 5m', 'Medicao', 9, 39.90),
    ('Multimetro Digital', 'Eletrica', 6, 189.90),
    ('Estrela 3/8 x 19mm', 'Manual', 42, 27.30),
    ('Disco de Corte 4.1/2"', 'Consumivel', 75, 15.75);

INSERT INTO laboratorio_sqli (usuario, senha, nivel) VALUES
    ('auditor', 'audit@2026', 'administrador'),
    ('operador', 'oper@2026', 'suporte'),
    ('visitante', 'visit@2026', 'leitura'),
    ('estoquista', 'estoq@2026', 'operacional');

INSERT INTO pecas_industriais (codigo_sku, descricao, categoria, quantidade, preco_unitario) VALUES
    ('IND-0001', 'Rolamento SKF 6205-2RS', 'Rolamentos', 48, 89.90),
    ('IND-0002', 'Correia sincronizadora HTD-5M', 'Transmissao', 16, 145.00),
    ('IND-0003', 'Corrente ASA 40', 'Transmissao', 22, 210.50),
    ('IND-0004', 'Engrenate reta Z=30 modulo 2', 'Transmissao', 9, 320.00),
    ('IND-0005', 'Poleia dupla V', 'Transmissao', 14, 175.30),
    ('IND-0006', 'Bucha flangeada 25mm', 'Eixos', 60, 64.90),
    ('IND-0007', 'Mancal bipartido SFU 20', 'Eixos', 8, 498.00),
    ('IND-0008', 'Retentor 35x52x7', 'Vedacao', 75, 38.40),
    ('IND-0009', 'O-ring NBR kit 382', 'Vedacao', 33, 52.00),
    ('IND-0010', 'Gaxeta grafitada 10mm', 'Vedacao', 26, 96.75),
    ('IND-0011', 'Parafuso sextavado M12x60', 'Fixacao', 240, 6.80),
    ('IND-0012', 'Porca sextavada M12', 'Fixacao', 320, 1.90),
    ('IND-0013', 'Arruela plana M12', 'Fixacao', 410, 0.70),
    ('IND-0014', 'Filtro de ar comprimido 1"', 'Hidraulica', 5, 118.00),
    ('IND-0015', 'Vedante bipartido 24x32', 'Hidraulica', 45, 27.60);
