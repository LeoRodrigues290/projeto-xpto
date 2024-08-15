-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Tempo de geração: 15/08/2024 às 22:58
-- Versão do servidor: 10.4.28-MariaDB
-- Versão do PHP: 8.0.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `sistema_xpto`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `chamados`
--

CREATE TABLE `chamados` (
  `id` int(11) NOT NULL,
  `cliente` varchar(100) NOT NULL,
  `produto` varchar(100) NOT NULL,
  `descricao` text NOT NULL,
  `status` enum('Pendente','Em Andamento','Concluído') NOT NULL DEFAULT 'Pendente',
  `tecnico_responsavel` int(11) DEFAULT NULL,
  `data_registro` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `materiais_solicitados`
--

CREATE TABLE `materiais_solicitados` (
  `id` int(11) NOT NULL,
  `nome_material` varchar(100) NOT NULL,
  `quantidade` int(11) NOT NULL,
  `data_solicitacao` timestamp NOT NULL DEFAULT current_timestamp(),
  `solicitado_por` int(11) DEFAULT NULL,
  `status` enum('Pendente','Recebido') NOT NULL DEFAULT 'Pendente'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `materiais_usados`
--

CREATE TABLE `materiais_usados` (
  `id` int(11) NOT NULL,
  `chamado_id` int(11) NOT NULL,
  `peca_equipamento_id` int(11) NOT NULL,
  `quantidade` int(11) NOT NULL,
  `data_uso` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `orcamentos`
--

CREATE TABLE `orcamentos` (
  `id` int(11) NOT NULL,
  `chamado_id` int(11) NOT NULL,
  `valor` decimal(10,2) NOT NULL,
  `prazo` int(11) NOT NULL,
  `status` enum('Enviado','Aprovado','Recusado') NOT NULL DEFAULT 'Enviado',
  `data_envio` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `pecas_equipamentos`
--

CREATE TABLE `pecas_equipamentos` (
  `id` int(11) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `quantidade` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `pedidos`
--

CREATE TABLE `pedidos` (
  `id` int(11) NOT NULL,
  `peca_equipamento` varchar(100) NOT NULL,
  `quantidade` int(11) NOT NULL,
  `data` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` enum('Pendente','Aprovado','Recusado') NOT NULL DEFAULT 'Pendente',
  `tecnico_solicitante` int(11) DEFAULT NULL,
  `almoxarifado_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `nome` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `senha` varchar(100) DEFAULT NULL,
  `cargo` enum('Balcão','Técnico de Laboratório','Analista Contábil','Almoxarifado') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `usuarios`
--

INSERT INTO `usuarios` (`id`, `nome`, `email`, `senha`, `cargo`) VALUES
(2, 'Leo', 'leozinho.290@hotmail.com', '$2y$10$yGf8km1NCM1nk8IvZknxxOPRj8kim6aVQn4EEVwgS4DhLwLHmfoTe', 'Balcão');

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `chamados`
--
ALTER TABLE `chamados`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tecnico_responsavel` (`tecnico_responsavel`);

--
-- Índices de tabela `materiais_solicitados`
--
ALTER TABLE `materiais_solicitados`
  ADD PRIMARY KEY (`id`),
  ADD KEY `solicitado_por` (`solicitado_por`);

--
-- Índices de tabela `materiais_usados`
--
ALTER TABLE `materiais_usados`
  ADD PRIMARY KEY (`id`),
  ADD KEY `chamado_id` (`chamado_id`),
  ADD KEY `peca_equipamento_id` (`peca_equipamento_id`);

--
-- Índices de tabela `orcamentos`
--
ALTER TABLE `orcamentos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `chamado_id` (`chamado_id`);

--
-- Índices de tabela `pecas_equipamentos`
--
ALTER TABLE `pecas_equipamentos`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `pedidos`
--
ALTER TABLE `pedidos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tecnico_solicitante` (`tecnico_solicitante`),
  ADD KEY `almoxarifado_id` (`almoxarifado_id`);

--
-- Índices de tabela `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `chamados`
--
ALTER TABLE `chamados`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `materiais_solicitados`
--
ALTER TABLE `materiais_solicitados`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `materiais_usados`
--
ALTER TABLE `materiais_usados`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `orcamentos`
--
ALTER TABLE `orcamentos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `pecas_equipamentos`
--
ALTER TABLE `pecas_equipamentos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `pedidos`
--
ALTER TABLE `pedidos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Restrições para tabelas despejadas
--

--
-- Restrições para tabelas `chamados`
--
ALTER TABLE `chamados`
  ADD CONSTRAINT `chamados_ibfk_1` FOREIGN KEY (`tecnico_responsavel`) REFERENCES `usuarios` (`id`);

--
-- Restrições para tabelas `materiais_solicitados`
--
ALTER TABLE `materiais_solicitados`
  ADD CONSTRAINT `materiais_solicitados_ibfk_1` FOREIGN KEY (`solicitado_por`) REFERENCES `usuarios` (`id`);

--
-- Restrições para tabelas `materiais_usados`
--
ALTER TABLE `materiais_usados`
  ADD CONSTRAINT `materiais_usados_ibfk_1` FOREIGN KEY (`chamado_id`) REFERENCES `chamados` (`id`),
  ADD CONSTRAINT `materiais_usados_ibfk_2` FOREIGN KEY (`peca_equipamento_id`) REFERENCES `pecas_equipamentos` (`id`);

--
-- Restrições para tabelas `orcamentos`
--
ALTER TABLE `orcamentos`
  ADD CONSTRAINT `orcamentos_ibfk_1` FOREIGN KEY (`chamado_id`) REFERENCES `chamados` (`id`);

--
-- Restrições para tabelas `pedidos`
--
ALTER TABLE `pedidos`
  ADD CONSTRAINT `pedidos_ibfk_1` FOREIGN KEY (`tecnico_solicitante`) REFERENCES `usuarios` (`id`),
  ADD CONSTRAINT `pedidos_ibfk_2` FOREIGN KEY (`almoxarifado_id`) REFERENCES `usuarios` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
