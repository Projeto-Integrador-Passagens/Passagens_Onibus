-- phpMyAdmin SQL Dump
-- version 5.1.1deb5ubuntu1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Tempo de geração: 08-Nov-2024 às 15:42
-- Versão do servidor: 8.0.39-0ubuntu0.22.04.1
-- versão do PHP: 8.1.2-1ubuntu2.19

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `passagens_onibus`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `onibus`
--

CREATE TABLE `onibus` (
  `id` int NOT NULL,
  `modelo` varchar(30) NOT NULL,
  `marca` varchar(30) NOT NULL,
  `total_assentos` int NOT NULL,
  `usuarios_id` int NOT NULL
);

-- --------------------------------------------------------

--
-- Estrutura da tabela `passagens`
--

CREATE TABLE `passagens` (
  `id` int NOT NULL,
  `viagens_id` int NOT NULL,
  `usuarios_id` int NOT NULL,
  `comentario` text,
  `avaliacao` int DEFAULT NULL,
  nome VARCHAR(70) NOT NULL,
  cpf VARCHAR(20) NOT NULL,
  data_venda DATE NOT NULL,
  status ENUM('EM ANDAMENTO', 'PAGO') NOT NULL
);

-- --------------------------------------------------------

--
-- Estrutura da tabela `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int NOT NULL,
  `tipo` enum('MANTENEDOR','MOTORISTA','CLIENTE') NOT NULL,
  `nome` varchar(70) NOT NULL,
  `cpf` varchar(20) NOT NULL,
  `email` varchar(70) NOT NULL,
  `senha` varchar(255) NOT NULL,
  `rg` varchar(45) NOT NULL,
  `tel_fixo` varchar(20) DEFAULT NULL,
  `tel_celular` varchar(20) NOT NULL,
  `situacao` enum('ATIVO','INATIVO') NOT NULL
);

--
-- Extraindo dados da tabela `usuarios`
--

INSERT INTO `usuarios` (`id`, `tipo`, `nome`, `cpf`, `email`, `senha`, `rg`, `tel_fixo`, `tel_celular`, `situacao`) VALUES
(1, 'MANTENEDOR', 'ADM', '123', 'luisgostoso@gmail.com', '123', '123', '123', '123', 'ATIVO');

-- --------------------------------------------------------

--
-- Estrutura da tabela `viagens`
--

CREATE TABLE `viagens` (
  `id` int NOT NULL,
  `onibus_id` int NOT NULL,
  `data_horario` datetime NOT NULL,
  `cidade_origem` varchar(50) NOT NULL,
  `cidade_destino` varchar(45) NOT NULL,
  `preco` float NOT NULL,
  `total_passagens` int NOT NULL,
  `situacao` enum('PROGRAMADA','FINALIZADA') NOT NULL
);

--
-- Índices para tabelas despejadas
--

--
-- Índices para tabela `onibus`
--
ALTER TABLE `onibus`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_onibus_usuarios1_idx` (`usuarios_id`);

--
-- Índices para tabela `passagens`
--
ALTER TABLE `passagens`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_compra_usuarios1_idx` (`usuarios_id`),
  ADD KEY `fk_passagens_viagens1_idx` (`viagens_id`);

--
-- Índices para tabela `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uk_usuario` (`email`);

--
-- Índices para tabela `viagens`
--
ALTER TABLE `viagens`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_viagens_onibus1_idx` (`onibus_id`);

--
-- AUTO_INCREMENT de tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `onibus`
--
ALTER TABLE `onibus`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `passagens`
--
ALTER TABLE `passagens`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de tabela `viagens`
--
ALTER TABLE `viagens`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- Restrições para despejos de tabelas
--

--
-- Limitadores para a tabela `onibus`
--
ALTER TABLE `onibus`
  ADD CONSTRAINT `fk_onibus_usuarios1` FOREIGN KEY (`usuarios_id`) REFERENCES `usuarios` (`id`);

--
-- Limitadores para a tabela `passagens`
--
ALTER TABLE `passagens`
  ADD CONSTRAINT `fk_compra_usuarios1` FOREIGN KEY (`usuarios_id`) REFERENCES `usuarios` (`id`),
  ADD CONSTRAINT `fk_passagens_viagens1` FOREIGN KEY (`viagens_id`) REFERENCES `viagens` (`id`);

--
-- Limitadores para a tabela `viagens`
--
ALTER TABLE `viagens`
  ADD CONSTRAINT `fk_viagens_onibus1` FOREIGN KEY (`onibus_id`) REFERENCES `onibus` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
