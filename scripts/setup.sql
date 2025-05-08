CREATE TABLE IF NOT EXISTS usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    senha VARCHAR(255) NOT NULL,
    cargo VARCHAR(50) NOT NULL,
    criado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Inserir um usuário de teste com senha '123456'
INSERT INTO usuarios (nome, email, senha, cargo)
VALUES (
    'Usuário Teste',
    'teste_inicial@teste.com.br',
    '$2y$10$6sK1DASsSw3mC0X1AqNwuexZGH1AopdKrYZpAphZe2n0P3wHFQqzG', -- senha: 123456
    'Administrador'
);
