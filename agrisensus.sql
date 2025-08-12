-- phpMyAdmin SQL Dump
-- version 5.2.1deb3
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Tempo de geração: 11/08/2025 às 22:21
-- Versão do servidor: 10.11.13-MariaDB-0ubuntu0.24.04.1
-- Versão do PHP: 8.3.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `agrisensus`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `criacoes_animais`
--

CREATE TABLE `criacoes_animais` (
  `id` int(11) NOT NULL,
  `id_produtor` int(11) NOT NULL,
  `quantidade` int(11) DEFAULT NULL,
  `especie` varchar(25) DEFAULT NULL,
  `finalidade` varchar(25) DEFAULT NULL,
  `raca` varchar(25) DEFAULT NULL,
  `unidade` varchar(25) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `criacoes_animais`
--

INSERT INTO `criacoes_animais` (`id`, `id_produtor`, `quantidade`, `especie`, `finalidade`, `raca`, `unidade`) VALUES
(196, 686, 56, 'TYU FG', 'FGH', 'FGH', 'Miligrama');

-- --------------------------------------------------------

--
-- Estrutura para tabela `familia_mao_de_obra`
--

CREATE TABLE `familia_mao_de_obra` (
  `id` int(11) NOT NULL,
  `id_produtor` int(11) NOT NULL,
  `ate_sete` int(11) DEFAULT NULL,
  `oito_quinze` int(11) DEFAULT NULL,
  `dezesseis_vintecinco` int(11) DEFAULT NULL,
  `vintecinco_sessentacinco` int(11) DEFAULT NULL,
  `mais_sessentacinco` int(11) DEFAULT NULL,
  `qtd_familia_producao` int(11) DEFAULT NULL,
  `qtd_empregados` int(11) DEFAULT NULL,
  `total_dependentes` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='Armazena dados sobre a composiÃ§Ã£o familiar e mÃ£o de obra do produtor.';

-- --------------------------------------------------------

--
-- Estrutura para tabela `insumos_utilizados`
--

CREATE TABLE `insumos_utilizados` (
  `id` int(11) NOT NULL,
  `id_produtor` int(11) NOT NULL,
  `local_compra` varchar(25) DEFAULT NULL,
  `nome` varchar(25) DEFAULT NULL,
  `preco_str` varchar(25) DEFAULT NULL,
  `quantidade` varchar(25) DEFAULT NULL,
  `unidade` varchar(25) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `manejo_sanitario`
--

CREATE TABLE `manejo_sanitario` (
  `id_criacao` int(11) NOT NULL,
  `id_manejo_sanitario` int(11) NOT NULL,
  `realiza_exame` bit(1) DEFAULT NULL,
  `vacinado` bit(1) DEFAULT NULL,
  `tipo_exame` varchar(25) DEFAULT NULL,
  `tipo_vacinacao` varchar(25) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `perfil_gerencial`
--

CREATE TABLE `perfil_gerencial` (
  `id` int(11) NOT NULL,
  `id_produtor` int(11) NOT NULL,
  `possui_nota` tinyint(1) DEFAULT NULL,
  `faz_declan` tinyint(1) DEFAULT NULL,
  `inscrito_inss` tinyint(1) DEFAULT NULL,
  `faria_curso` tinyint(1) DEFAULT NULL,
  `curso_interesse` longtext DEFAULT NULL,
  `conhece_credito` tinyint(1) DEFAULT NULL,
  `utilizou_credito` tinyint(1) DEFAULT NULL,
  `credito` varchar(25) DEFAULT NULL,
  `varejo_petropolis` tinyint(1) DEFAULT NULL,
  `varejo_cidade` tinyint(1) DEFAULT NULL,
  `atacado_petropolis` tinyint(1) DEFAULT NULL,
  `atacado_cidades` tinyint(1) DEFAULT NULL,
  `comercializar_produtos` tinyint(1) DEFAULT NULL,
  `outras_receitas` longtext DEFAULT NULL,
  `conhece_programas` tinyint(1) DEFAULT NULL,
  `programas` longtext DEFAULT NULL,
  `dificuldade_producao` longtext DEFAULT NULL,
  `dificuldade_infraestrutura` longtext DEFAULT NULL,
  `dificuldade_comercializacao` longtext DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `produtores`
--

CREATE TABLE `produtores` (
  `id` int(11) NOT NULL,
  `cpf` varchar(14) DEFAULT NULL,
  `telefone` varchar(15) DEFAULT NULL,
  `cnpj` varchar(18) DEFAULT NULL,
  `nome` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `produtores`
--

INSERT INTO `produtores` (`id`, `cpf`, `telefone`, `cnpj`, `nome`) VALUES
(684, '222.222.222-22', '(22) 22222-2222', '22.222.222/2222-22', 'DSA'),
(685, '111.111.111-11', '(11) 11111-1111', '11.111.111/1111-11', 'TRE'),
(686, '333.333.333-33', '(33) 33333-3333', '33.333.333/3333-33', 'GFD'),
(688, '999.999.999-99', '(99) 99999-9999', '99.999.999/9999-99', 'IOP RTY');

-- --------------------------------------------------------

--
-- Estrutura para tabela `produtos_cultivados`
--

CREATE TABLE `produtos_cultivados` (
  `id` int(11) NOT NULL,
  `id_produtor` int(11) NOT NULL,
  `preco` decimal(6,2) DEFAULT NULL,
  `producao_anual` decimal(6,2) DEFAULT NULL,
  `receita_total` decimal(6,2) DEFAULT NULL,
  `periodo_colheita` varchar(20) DEFAULT NULL,
  `unidade` varchar(10) DEFAULT NULL,
  `nome` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `produtos_cultivados`
--

INSERT INTO `produtos_cultivados` (`id`, `id_produtor`, `preco`, `producao_anual`, `receita_total`, `periodo_colheita`, `unidade`, `nome`) VALUES
(7912, 684, 345.00, 123.00, 234.00, 'JANEIRO A MARCO', '', 'CVB'),
(7914, 685, 456.00, 456.00, 46.00, 'FG', 'UNIDADE', 'SDF');

-- --------------------------------------------------------

--
-- Estrutura para tabela `propriedades`
--

CREATE TABLE `propriedades` (
  `id_produtor` int(11) NOT NULL,
  `id` int(11) NOT NULL,
  `terreno` bit(1) DEFAULT NULL,
  `area_total` varchar(20) DEFAULT NULL,
  `comunidade` varchar(25) DEFAULT NULL,
  `localidade` varchar(25) DEFAULT NULL,
  `nome_propriedade` varchar(25) DEFAULT NULL,
  `relacao_propriedade` varchar(25) DEFAULT NULL,
  `bairro` varchar(25) DEFAULT NULL,
  `cep` varchar(9) DEFAULT NULL,
  `cidade` varchar(25) DEFAULT NULL,
  `complemento` varchar(25) DEFAULT NULL,
  `estado` varchar(2) DEFAULT NULL,
  `numero` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `propriedades`
--

INSERT INTO `propriedades` (`id_produtor`, `id`, `terreno`, `area_total`, `comunidade`, `localidade`, `nome_propriedade`, `relacao_propriedade`, `bairro`, `cep`, `cidade`, `complemento`, `estado`, `numero`) VALUES
(686, 3, b'0', 'Menos de 1', 'SD FDFG', 'DFG', 'SDF', 'Parceiro', 'SD', '', 'SDF', 'SF', 'GO', 345);

-- --------------------------------------------------------

--
-- Estrutura para tabela `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `cpf` varchar(14) DEFAULT NULL,
  `grupo` tinyint(1) DEFAULT NULL,
  `matricula` varchar(25) DEFAULT NULL,
  `nome` varchar(50) DEFAULT NULL,
  `senha` varchar(70) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `usuarios`
--

INSERT INTO `usuarios` (`id`, `cpf`, `grupo`, `matricula`, `nome`, `senha`) VALUES
(1, '159.859.187-85', 1, '123', 'admin', '$2a$10$UnKbB0DwLkNjgfTMSXWnhOcop2jYN4k/tO2cUwhDTFusD1.mzu602');

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `criacoes_animais`
--
ALTER TABLE `criacoes_animais`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FKhf46gao9epb5xp1t7vv7tq348` (`id_produtor`);

--
-- Índices de tabela `familia_mao_de_obra`
--
ALTER TABLE `familia_mao_de_obra`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id_produtor` (`id_produtor`);

--
-- Índices de tabela `insumos_utilizados`
--
ALTER TABLE `insumos_utilizados`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK3vbdfbdmiqsakq28ickjty894` (`id_produtor`);

--
-- Índices de tabela `manejo_sanitario`
--
ALTER TABLE `manejo_sanitario`
  ADD PRIMARY KEY (`id_manejo_sanitario`),
  ADD UNIQUE KEY `UKid2wb19ruaq6xkkfh60n4d5o` (`id_criacao`);

--
-- Índices de tabela `perfil_gerencial`
--
ALTER TABLE `perfil_gerencial`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uk_perfil_produtor` (`id_produtor`);

--
-- Índices de tabela `produtores`
--
ALTER TABLE `produtores`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `produtos_cultivados`
--
ALTER TABLE `produtos_cultivados`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK1he0s2r95nr0ppiav2ka4ygp1` (`id_produtor`);

--
-- Índices de tabela `propriedades`
--
ALTER TABLE `propriedades`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK20vswqvowy4b9fp4dg0ufiog5` (`id_produtor`);

--
-- Índices de tabela `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `criacoes_animais`
--
ALTER TABLE `criacoes_animais`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=197;

--
-- AUTO_INCREMENT de tabela `familia_mao_de_obra`
--
ALTER TABLE `familia_mao_de_obra`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3791;

--
-- AUTO_INCREMENT de tabela `insumos_utilizados`
--
ALTER TABLE `insumos_utilizados`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=685;

--
-- AUTO_INCREMENT de tabela `manejo_sanitario`
--
ALTER TABLE `manejo_sanitario`
  MODIFY `id_manejo_sanitario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

--
-- AUTO_INCREMENT de tabela `perfil_gerencial`
--
ALTER TABLE `perfil_gerencial`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=596;

--
-- AUTO_INCREMENT de tabela `produtores`
--
ALTER TABLE `produtores`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=689;

--
-- AUTO_INCREMENT de tabela `produtos_cultivados`
--
ALTER TABLE `produtos_cultivados`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7915;

--
-- AUTO_INCREMENT de tabela `propriedades`
--
ALTER TABLE `propriedades`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de tabela `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Restrições para tabelas despejadas
--

--
-- Restrições para tabelas `criacoes_animais`
--
ALTER TABLE `criacoes_animais`
  ADD CONSTRAINT `FKhf46gao9epb5xp1t7vv7tq348` FOREIGN KEY (`id_produtor`) REFERENCES `produtores` (`id`);

--
-- Restrições para tabelas `familia_mao_de_obra`
--
ALTER TABLE `familia_mao_de_obra`
  ADD CONSTRAINT `fk_produtor` FOREIGN KEY (`id_produtor`) REFERENCES `produtores` (`id`) ON DELETE CASCADE;

--
-- Restrições para tabelas `insumos_utilizados`
--
ALTER TABLE `insumos_utilizados`
  ADD CONSTRAINT `FK3vbdfbdmiqsakq28ickjty894` FOREIGN KEY (`id_produtor`) REFERENCES `produtores` (`id`);

--
-- Restrições para tabelas `manejo_sanitario`
--
ALTER TABLE `manejo_sanitario`
  ADD CONSTRAINT `FKsjt2hb7dx1nsy9xd0gfwervtl` FOREIGN KEY (`id_criacao`) REFERENCES `criacoes_animais` (`id`);

--
-- Restrições para tabelas `perfil_gerencial`
--
ALTER TABLE `perfil_gerencial`
  ADD CONSTRAINT `fk_perfil_produtor` FOREIGN KEY (`id_produtor`) REFERENCES `produtores` (`id`) ON DELETE CASCADE;

--
-- Restrições para tabelas `produtos_cultivados`
--
ALTER TABLE `produtos_cultivados`
  ADD CONSTRAINT `FK1he0s2r95nr0ppiav2ka4ygp1` FOREIGN KEY (`id_produtor`) REFERENCES `produtores` (`id`);

--
-- Restrições para tabelas `propriedades`
--
ALTER TABLE `propriedades`
  ADD CONSTRAINT `FK20vswqvowy4b9fp4dg0ufiog5` FOREIGN KEY (`id_produtor`) REFERENCES `produtores` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
