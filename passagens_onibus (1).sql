-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 04/02/2025 às 23:37
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
-- Banco de dados: `passagens_onibus`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `onibus`
--

CREATE TABLE `onibus` (
  `id` int(11) NOT NULL,
  `modelo` varchar(30) NOT NULL,
  `marca` varchar(30) NOT NULL,
  `total_assentos` int(11) NOT NULL,
  `usuarios_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Despejando dados para a tabela `onibus`
--

INSERT INTO `onibus` (`id`, `modelo`, `marca`, `total_assentos`, `usuarios_id`) VALUES
(1, 'Corsa 2012', 'Volkswagen', 14, 2);

-- --------------------------------------------------------

--
-- Estrutura para tabela `passagens`
--

CREATE TABLE `passagens` (
  `id` int(11) NOT NULL,
  `viagens_id` int(11) NOT NULL,
  `usuarios_id` int(11) NOT NULL,
  `nome` varchar(70) NOT NULL,
  `cpf` varchar(20) NOT NULL,
  `data_venda` date NOT NULL,
  `status` enum('EM ANDAMENTO','PAGO') NOT NULL,
  `compPix` varchar(255) NOT NULL,
  `valor` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Despejando dados para a tabela `passagens`
--

INSERT INTO `passagens` (`id`, `viagens_id`, `usuarios_id`, `nome`, `cpf`, `data_venda`, `status`, `compPix`, `valor`) VALUES
(1, 1, 2, 'Matheus Cardoso', '12412193975', '2025-02-04', 'EM ANDAMENTO', 'arquivo_1d92a89f-65ae-de58-e15a-d1f84be52fe4.jfif', 40),
(2, 1, 2, 'Matheus Cardoso', '12412193975', '2025-02-04', 'EM ANDAMENTO', 'arquivo_c3b36f16-b4cd-52ca-04b6-603ede203161.webp', 40);

-- --------------------------------------------------------

--
-- Estrutura para tabela `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `tipo` enum('MANTENEDOR','MOTORISTA','CLIENTE') NOT NULL,
  `nome` varchar(70) NOT NULL,
  `cpf` varchar(20) NOT NULL,
  `email` varchar(70) NOT NULL,
  `senha` varchar(255) NOT NULL,
  `rg` varchar(45) NOT NULL,
  `tel_fixo` varchar(20) DEFAULT NULL,
  `tel_celular` varchar(20) NOT NULL,
  `situacao` enum('ATIVO','INATIVO') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Despejando dados para a tabela `usuarios`
--

INSERT INTO `usuarios` (`id`, `tipo`, `nome`, `cpf`, `email`, `senha`, `rg`, `tel_fixo`, `tel_celular`, `situacao`) VALUES
(1, 'MANTENEDOR', 'ADM', '123', 'luisgostoso@gmail.com', '123', '123', '123', '123', 'ATIVO'),
(2, 'MOTORISTA', 'Matheus Cardoso', '12412193975', 'mathcardoso792@gmail.com', 'muito064', '12412193975', '45999286562', '45999286562', 'ATIVO');

-- --------------------------------------------------------

--
-- Estrutura para tabela `viagens`
--

CREATE TABLE `viagens` (
  `id` int(11) NOT NULL,
  `onibus_id` int(11) NOT NULL,
  `data_horario` datetime NOT NULL,
  `cidade_origem` varchar(50) NOT NULL,
  `cidade_destino` varchar(45) NOT NULL,
  `preco` float NOT NULL,
  `total_passagens` int(11) NOT NULL,
  `situacao` enum('PROGRAMADA','FINALIZADA') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Despejando dados para a tabela `viagens`
--

INSERT INTO `viagens` (`id`, `onibus_id`, `data_horario`, `cidade_origem`, `cidade_destino`, `preco`, `total_passagens`, `situacao`) VALUES
(1, 1, '2025-11-20 11:50:00', 'foz do iguaçu', 'matelandia', 40, 20, 'PROGRAMADA');

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `onibus`
--
ALTER TABLE `onibus`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_onibus_usuarios1_idx` (`usuarios_id`);

--
-- Índices de tabela `passagens`
--
ALTER TABLE `passagens`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_compra_usuarios1_idx` (`usuarios_id`),
  ADD KEY `fk_passagens_viagens1_idx` (`viagens_id`);

--
-- Índices de tabela `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uk_usuario` (`email`);

--
-- Índices de tabela `viagens`
--
ALTER TABLE `viagens`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_viagens_onibus1_idx` (`onibus_id`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `onibus`
--
ALTER TABLE `onibus`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de tabela `passagens`
--
ALTER TABLE `passagens`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de tabela `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de tabela `viagens`
--
ALTER TABLE `viagens`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Restrições para tabelas despejadas
--

--
-- Restrições para tabelas `onibus`
--
ALTER TABLE `onibus`
  ADD CONSTRAINT `fk_onibus_usuarios1` FOREIGN KEY (`usuarios_id`) REFERENCES `usuarios` (`id`);

--
-- Restrições para tabelas `passagens`
--
ALTER TABLE `passagens`
  ADD CONSTRAINT `fk_compra_usuarios1` FOREIGN KEY (`usuarios_id`) REFERENCES `usuarios` (`id`),
  ADD CONSTRAINT `fk_passagens_viagens1` FOREIGN KEY (`viagens_id`) REFERENCES `viagens` (`id`);

--
-- Restrições para tabelas `viagens`
--
ALTER TABLE `viagens`
  ADD CONSTRAINT `fk_viagens_onibus1` FOREIGN KEY (`onibus_id`) REFERENCES `onibus` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
