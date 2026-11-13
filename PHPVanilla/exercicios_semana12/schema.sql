-- Semana 12 - MVC com PHP Vanilla
-- Banco de dados e tabela de produtos

CREATE DATABASE semana12;

CREATE TABLE IF NOT EXISTS produtos (
    id SERIAL PRIMARY KEY,
    nome VARCHAR(120) NOT NULL,
    categoria VARCHAR(60) NOT NULL,
    preco NUMERIC(10,2) NOT NULL CHECK (preco >= 0),
    estoque INTEGER NOT NULL DEFAULT 0 CHECK (estoque >= 0),
    criado_em TIMESTAMP WITHOUT TIME ZONE DEFAULT CURRENT_TIMESTAMP
);

-- Carga inicial de demonstracao
INSERT INTO produtos (nome, categoria, preco, estoque) VALUES
('Fresa de Metal Duro 4 Cortes 6mm', 'Usinagem', 89.50, 25),
('Broca Escalonada HSS 4-20mm', 'Furacao', 145.00, 12),
('Paquimetro Digital de Precisao 150mm', 'Metrologia', 280.00, 8),
('Oleo Soluvel Sintetico para Corte 5L', 'Lubrificacao', 115.90, 40),
('Mesa de Furacao CNC', 'Usinagem', 3200.00, 2),
('Micrometro 0-25mm', 'Metrologia', 450.00, 6)
ON CONFLICT (id) DO NOTHING;
