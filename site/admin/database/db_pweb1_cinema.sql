-- TapCine – Sistema de Cinema
-- Banco de Dados: db_pweb1_cinema
-- Disciplina: Programação para Web I – IFSC 2026.1
-- Aluno: Eric Zannini Medeiros Lima

CREATE DATABASE IF NOT EXISTS `db_pweb1_cinema`
  DEFAULT CHARACTER SET utf8mb4
  COLLATE utf8mb4_general_ci;

USE `db_pweb1_cinema`;

-- Tabela de usuários
CREATE TABLE IF NOT EXISTS `usuarios` (
  `id`       INT(11)      NOT NULL AUTO_INCREMENT,
  `nome`     VARCHAR(100) NOT NULL,
  `telefone` VARCHAR(20)  DEFAULT NULL,
  `email`    VARCHAR(100) NOT NULL,
  `login`    VARCHAR(50)  NOT NULL,
  `senha`    VARCHAR(255) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `login` (`login`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Tabela de filmes
CREATE TABLE IF NOT EXISTS `filmes` (
  `id`             INT(11)      NOT NULL AUTO_INCREMENT,
  `titulo`         VARCHAR(150) NOT NULL,
  `genero`         VARCHAR(80)  NOT NULL,
  `duracao`        VARCHAR(20)  NOT NULL,
  `classificacao`  VARCHAR(10)  NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Tabela de sessões
CREATE TABLE IF NOT EXISTS `sessoes` (
  `id`          INT(11)      NOT NULL AUTO_INCREMENT,
  `sala`        VARCHAR(50)  NOT NULL,
  `data_sessao` DATE         NOT NULL,
  `hora_inicio` TIME         NOT NULL,
  `preco`       DECIMAL(6,2) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Tabela de ingressos
CREATE TABLE IF NOT EXISTS `ingressos` (
  `id`             INT(11)     NOT NULL AUTO_INCREMENT,
  `cliente_nome`   VARCHAR(100) NOT NULL,
  `assento`        VARCHAR(10)  NOT NULL,
  `tipo_ingresso`  VARCHAR(30)  NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Usuário padrão para testes: admin / 123
INSERT INTO `usuarios` (`nome`, `telefone`, `email`, `login`, `senha`) VALUES
('Administrador', '(49) 99999-0000', 'admin@tapcine.com', 'admin',
 '$2y$10$ny12Hy1HvEJhG98wcGfr8ubyB3NjZZeTqHlK7U2GeG4qvnPlkYhAi');

-- Filmes pré-cadastrados 
INSERT INTO `filmes` (`titulo`, `genero`, `duracao`, `classificacao`) VALUES
('Super Mario Galaxy O Filme', 'Ação e Aventura', '1h39', '6+'),
('Crepúsculo (Relançamento)',  'Fantasia e Romance', '2h02', '12+'),
('Cara de Um, Focinho de Outro','Animação, Aventura e Comédia', '1h45', '6+'),
('Pânico 7',                   'Terror e Mistério', '1h54', '18+'),
('Devoradores de Estrelas',    'Ação e Aventura', '2h02', '12+'),
('Velhos Bandidos',            'Policial, Ação e Comédia', '1h33', '14+');

-- Sessões de exemplo
INSERT INTO `sessoes` (`sala`, `data_sessao`, `hora_inicio`, `preco`) VALUES
('Sala 1', '2026-06-10', '14:00:00', 25.00),
('Sala 2', '2026-06-10', '16:30:00', 25.00),
('Sala 1', '2026-06-11', '19:00:00', 30.00),
('Sala VIP', '2026-06-12', '20:00:00', 45.00);

-- Ingressos de exemplo
INSERT INTO `ingressos` (`cliente_nome`, `assento`, `tipo_ingresso`) VALUES
('João Silva',    'A1',  'Inteira'),
('Maria Souza',   'B3',  'Meia'),
('Carlos Pereira','C5',  'Inteira');
