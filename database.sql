-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 12/09/2025 às 16:36
-- Versão do servidor: 10.4.32-MariaDB
-- Versão do PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `teste3007`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `alunos`
--

CREATE TABLE `alunos` (
  `matricula` varchar(120) NOT NULL,
  `nome` varchar(120) NOT NULL,
  `turma` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `alunos`
--

INSERT INTO `alunos` (`matricula`, `nome`, `turma`) VALUES
('21620110089', 'JOÃO VITOR CANGUÇU REIS', 'EM2AM'),
('21620110095', 'ALICE BEATRIZ XAVIER', 'EM2AM'),
('21620110096', 'BRUNO CARLOS YAMADA', 'EM2BM'),
('21620110097', 'CAMILA DANTAS ZULEIKA', 'EM2AM'),
('21620110098', 'DIEGO EDUARDO WAGNER', 'EM2BM'),
('21620110099', 'ELISA FERNANDA VIEIRA', 'EM2AM'),
('21620110100', 'FELIPE GUILHERME URBANO', 'EM2BM'),
('21620110101', 'GABRIELA HENRIQUE TORRES', 'EM2AM'),
('21620110102', 'HEITOR ISABELLA SILVA', 'EM2BM'),
('21620110103', 'ISADORA JOÃO XAVIER', 'EM2AM'),
('21620110104', 'JULIANA KARINA YAMAMOTO', 'EM2BM'),
('21620110105', 'KAIO LUCAS ZANELLA', 'EM2AM'),
('21620110106', 'LAURA MATEUS WANDERLEY', 'EM2BM'),
('21620110107', 'MARIANA NATHANIEL VASCONCELOS', 'EM2AM'),
('21620110108', 'NICOLE OLIVEIRA UCHOA', 'EM2BM'),
('21620110109', 'OTÁVIO PEREIRA TORRES', 'EM2AM'),
('21620110110', 'PAULA QUARESMA XAVIER', 'EM2BM'),
('21620110111', 'RAFAEL SANTOS YOKOYAMA', 'EM2AM'),
('21620110112', 'SOPHIA TEIXEIRA ZANELLA', 'EM2BM'),
('21620110113', 'THIAGO URBANO WANDERLEY', 'EM2AM'),
('21620110114', 'VITORIA VANESSA XAVIER', 'EM2BM'),
('21620110115', 'WANDERLEY XANDRA YOKOYAMA', 'EM2AM'),
('21620110116', 'YASMIN ZULEIKA ALMEIDA', 'EM2BM'),
('21620110117', 'ZANIELA ALEXANDRE BEZERRA', 'EM2AM'),
('21620110118', 'ADRIANO BIANCA CASTRO', 'EM2BM'),
('21620110119', 'BRUNA CARLOS DANTAS', 'EM2AM'),
('21620110120', 'CLAUDIA DANIEL EDUARDO', 'EM2BM'),
('21620110121', 'DANIELA EDUARDO FERNANDES', 'EM2AM'),
('21620110122', 'EDUARDO FABIANA GONÇALVES', 'EM2BM'),
('21620110123', 'FABIANO GUILHERME HENRIQUE', 'EM2AM'),
('21620110124', 'GISELE HELENA ISABELA', 'EM2BM'),
('21620110125', 'HELOÍSA IGOR JOÃO', 'EM2AM'),
('21620110126', 'IGOR JULIANA KAMILA', 'EM2BM'),
('21620110127', 'JULIO KAIO LORENZO', 'EM2AM'),
('21620110128', 'KAMILA LAURA MATEUS', 'EM2BM'),
('21620110129', 'LEONARDO MARIA NATHAN', 'EM2AM'),
('21620110130', 'MATEUS NICOLE OLIVEIRA', 'EM2BM'),
('21620110131', 'NATHAN OTÁVIO PAULO', 'EM2AM'),
('21620110132', 'OLÍVIA PAULA QUARESMA', 'EM2BM'),
('21620110133', 'PAULO RAFAEL SANTOS', 'EM2AM'),
('21620110134', 'QUIMBERLY SOPHIA TEIXEIRA', 'EM2BM'),
('21620110135', 'RENAN THIAGO URBANO', 'EM2AM'),
('21620110136', 'SANDRA VITORIA VANESSA', 'EM2BM'),
('21620110137', 'TIAGO WANDERLEY XANDRA', 'EM2AM'),
('21620110138', 'URSULA YASMIN ZULEIKA', 'EM2BM'),
('21620110139', 'VALENTINA ZANIELA ADRIANO', 'EM2AM'),
('21620110140', 'WESLEY ALICE BEATRIZ', 'EM2BM'),
('21620110141', 'XAVIER BRUNO CARLOS', 'EM2AM'),
('21620110142', 'YARA CAMILA DANTAS', 'EM2BM'),
('21620110143', 'ZACK DIEGO EDUARDO', 'EM2AM'),
('21620110144', 'AMANDA ELISA FERNANDA', 'EM2BM'),
('21620110145', 'BRUNO FELIPE GUILHERME', 'EM2AM'),
('21620110146', 'CARLA GABRIELA HENRIQUE', 'EM2BM'),
('21620110147', 'DANIEL HEITOR ISABELLA', 'EM2AM');


-- --------------------------------------------------------

--
-- Estrutura para tabela `sosatraso`
--

CREATE TABLE `sosatraso` (
  `id` int(10) UNSIGNED NOT NULL,
  `nome` varchar(120) NOT NULL,
  `turma` varchar(15) NOT NULL,
  `motivo` varchar(255) NOT NULL,
  `data` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `sosatraso`
--

INSERT INTO `sosatraso` (`id`, `nome`, `turma`, `motivo`, `data`) VALUES
(1, 'EDUARDO MACHADO FERLA', 'EM3AM', 'Chuva', '2025-04-07 22:31:08'),
(2, 'DAVI FRITZEN SOARES', 'EF7AT', 'Chuva', '2025-06-06 21:23:33'),
(3, 'DANIELY MACHADO FERLA', 'EF8AT', 'Chuva', '2025-06-06 21:23:39'),
(4, 'EDUARDO MACHADO FERLA', 'EM3AM', 'Imprevisto com o meio de transporte', '2025-06-06 21:49:30'),
(5, 'EDUARDO MACHADO FERLA', 'EM3AM', 'Chuva', '2025-06-06 21:49:35'),
(6, 'EDUARDO MACHADO FERLA', 'EM3AM', 'Chuva', '2025-07-01 20:44:09'),
(7, 'EDUARDO MACHADO FERLA', 'EM3AM', 'Chuva', '2025-07-01 20:44:42'),
(8, 'VALENTINA GOMES ARGENTON', 'EF5AM', 'Perdi o horário', '2025-07-01 21:42:33'),
(9, 'EDUARDA FERREIRA LIMA ALVES', 'EF7AT', 'Imprevisto com o meio de transporte', '2025-07-01 21:42:45'),
(10, 'DAVI FRITZEN SOARES', 'EF7AT', 'Chuva', '2025-07-01 21:47:06'),
(11, 'ÁMON PEDROSO LACOVIC', 'EI5AM', 'Perdi o horário', '2025-07-01 21:47:21'),
(12, 'MATHEUS GABRIEL DE SOUZA FERNANDES', 'EM1AM', 'Chuva', '2025-07-01 21:47:34'),
(13, 'DANIELY MACHADO FERLA', 'EF8AT', 'Chuva', '2025-07-01 21:47:56'),
(14, 'DAVI FRITZEN SOARES', 'EF7AT', 'Chuva', '2025-07-01 21:48:38'),
(15, 'DAVI FRITZEN SOARES', 'EF7AT', 'Outro: ska', '2025-07-01 21:48:56'),
(16, 'EDWARD SCHMITZ MAIA', 'EF7AT', 'Imprevisto com o meio de transporte', '2025-07-01 21:49:08'),
(17, 'VICTOR GABRIEL DAMASIO DE ANDRADE', 'EM3AM', 'Perdi o horário', '2025-07-01 21:49:25'),
(18, 'DAVI FRITZEN SOARES', 'EF7AT', 'Chuva', '2025-07-01 21:49:57'),
(19, 'ÁMON PEDROSO LACOVIC', 'EI5AM', 'Perdi o horário', '2025-07-01 21:50:10'),
(20, 'VICTOR GABRIEL DAMASIO DE ANDRADE', 'EM3AM', 'Perdi o horário', '2025-07-01 21:50:22'),
(21, 'MARIA CLARA RIBEIRO DE BRITO', 'EF6AT', 'Chuva', '2025-07-01 21:50:34'),
(22, 'KEVIN HENRIQUE DE SOUZA', 'EF3AM', 'Chuva', '2025-07-01 21:50:47'),
(23, 'EDUARDO MACHADO FERLA', 'EM3AM', 'Perdi o horário', '2025-07-03 22:41:35'),
(24, 'EDUARDO MACHADO FERLA', 'EM3AM', 'Chuva', '2025-07-03 22:46:15'),
(25, 'EDUARDO MACHADO FERLA', 'EM3AM', 'Perdi o horário', '2025-08-18 07:27:15'),
(26, 'GABRIELLY MACHADO', 'EM3AM', 'Imprevisto com o meio de transporte', '2025-08-18 07:38:24'),
(27, 'EDUARDO MACHADO FERLA', 'EM3AM', 'Imprevisto com o meio de transporte', '2025-09-08 08:04:48'),
(28, 'EDUARDO MACHADO FERLA', 'EM3AM', 'Chuva', '2025-09-12 10:59:38');

-- --------------------------------------------------------

--
-- Estrutura para tabela `turmas`
--

CREATE TABLE `turmas` (
  `id` varchar(12) NOT NULL,
  `turma` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `turmas`
--

INSERT INTO `turmas` (`id`, `turma`) VALUES
('EF1AT', 'Ensino Fundamental 1'),
('EF2AM', 'Ensino Fundamental 2'),
('EF3AM', 'Ensino Fundamental 3'),
('EF4AM', 'Ensino Fundamental 4'),
('EF5AM', 'Ensino Fundamental 5'),
('EF6AT', 'Ensino Fundamental 6'),
('EF7AT', 'Ensino Fundamental 7'),
('EF8AT', 'Ensino Fundamental 8'),
('EF9AT', 'Ensino Fundamental 9	'),
('EI1AM', 'Ensino Infantil 1'),
('EI2AM', 'Ensino Infantil 2'),
('EI3AM', 'Ensino Infantil 3'),
('EI4AM', 'Ensino Infantil 4'),
('EI5AM', 'Ensino Infantil 5'),
('EM1AM', 'Ensino Médio 1'),
('EM2AM', 'Ensino Médio 2'),
('EM3AM', 'Ensino Médio 3');

-- --------------------------------------------------------

--
-- Estrutura para tabela `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(10) UNSIGNED NOT NULL,
  `nome` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `senha` varchar(255) NOT NULL,
  `setor` varchar(50) DEFAULT NULL,
  `permissao` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `usuarios`
--

INSERT INTO `usuarios` (`id`, `nome`, `email`, `senha`, `setor`, `permissao`) VALUES
(4, 'admin', 'admin@gmail.com', '$2y$10$5pWhq4EWAI5NYQKTlZF8q.y5jRb3vA9VEfkPBIMWZG/MOyOuDkJza', 'admin', 'admin'),
(47, 'eduardo', 'emachadoferla@gmail.com', '$2y$10$AuukOE8JzbDROuq6mAWa0.8X3oCDb1BE18wHDi63oGerH60z2XrZO', 'admin', 'gerenciar_alunos,ver_relatorios,editar_turmas,administrar_usuarios');

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `alunos`
--
ALTER TABLE `alunos`
  ADD PRIMARY KEY (`matricula`),
  ADD UNIQUE KEY `matricula` (`matricula`);

--
-- Índices de tabela `sosatraso`
--
ALTER TABLE `sosatraso`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `turmas`
--
ALTER TABLE `turmas`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `sosatraso`
--
ALTER TABLE `sosatraso`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT de tabela `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
