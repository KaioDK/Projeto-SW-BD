-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 22/11/2025 às 20:05
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
-- Banco de dados: `sola_roxa`
--
CREATE DATABASE IF NOT EXISTS `sola_roxa` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `sola_roxa`;

-- --------------------------------------------------------

--
-- Estrutura para tabela `endereco`
--

CREATE TABLE `endereco` (
  `id_endereco` int(11) NOT NULL,
  `id_cliente` int(11) NOT NULL,
  `rua` varchar(255) NOT NULL,
  `numero` int(11) NOT NULL,
  `bairro` varchar(255) NOT NULL,
  `cidade` varchar(255) NOT NULL,
  `estado` varchar(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `endereco`
--

INSERT INTO `endereco` (`id_endereco`, `id_cliente`, `rua`, `numero`, `bairro`, `cidade`, `estado`) VALUES
(1, 10, 'Rua', 0, '', 'Ribeirão Pires', 'BR'),
(2, 1, '', 0, '', '', ''),
(3, 10, 'Rua', 0, '', 'Ribeirão Pires', 'BR');

-- --------------------------------------------------------

--
-- Estrutura para tabela `item_pedido`
--

CREATE TABLE `item_pedido` (
  `id_pedido` int(11) NOT NULL,
  `id_produto` int(11) NOT NULL,
  `quantidade` int(11) DEFAULT NULL,
  `preco_unitario` decimal(10,2) DEFAULT NULL,
  `subtotal` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `item_pedido`
--

INSERT INTO `item_pedido` (`id_pedido`, `id_produto`, `quantidade`, `preco_unitario`, `subtotal`) VALUES
(1, 19, 1, 489.00, 489.00),
(2, 16, 1, 999.90, 999.90),
(3, 16, 1, 999.90, 999.90);

-- --------------------------------------------------------

--
-- Estrutura para tabela `pagamento`
--

CREATE TABLE `pagamento` (
  `id_pagamento` int(11) NOT NULL,
  `id_pedido` int(11) NOT NULL,
  `metodo` enum('cartao','pix','boleto') NOT NULL,
  `status` enum('pendente','aprovado','recusado','estornado') DEFAULT 'pendente',
  `valor_pago` decimal(10,2) NOT NULL,
  `data_pagamento` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `pagamento`
--

INSERT INTO `pagamento` (`id_pagamento`, `id_pedido`, `metodo`, `status`, `valor_pago`, `data_pagamento`) VALUES
(1, 3, '', 'aprovado', 1048.90, '2025-11-21 15:22:43');

-- --------------------------------------------------------

--
-- Estrutura para tabela `pedido`
--

CREATE TABLE `pedido` (
  `id_pedido` int(11) NOT NULL,
  `id_cliente` int(11) NOT NULL,
  `id_endereco` int(11) NOT NULL,
  `data_pedido` datetime DEFAULT current_timestamp(),
  `status` enum('pendente','pago','enviado','entregue','cancelado') DEFAULT 'pendente',
  `valor_total` decimal(10,2) DEFAULT 0.00
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `pedido`
--

INSERT INTO `pedido` (`id_pedido`, `id_cliente`, `id_endereco`, `data_pedido`, `status`, `valor_total`) VALUES
(1, 10, 1, '2025-11-21 12:57:13', 'pendente', 538.00),
(2, 1, 2, '2025-11-21 15:03:08', 'pendente', 1048.90),
(3, 10, 3, '2025-11-21 15:22:43', 'pago', 1048.90);

-- --------------------------------------------------------

--
-- Estrutura para tabela `produto`
--

CREATE TABLE `produto` (
  `id_produto` int(11) NOT NULL,
  `id_vendedor` int(11) NOT NULL,
  `nome` varchar(255) NOT NULL,
  `descricao` text DEFAULT NULL,
  `imagem_url` varchar(255) DEFAULT NULL,
  `valor` decimal(10,2) NOT NULL,
  `estoque` int(11) NOT NULL DEFAULT 0,
  `data_cadastro` datetime DEFAULT current_timestamp(),
  `estado` enum('Novo','Semi-Novo','Usado','Sem caixa') DEFAULT 'Novo',
  `tamanho` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `produto`
--

INSERT INTO `produto` (`id_produto`, `id_vendedor`, `nome`, `descricao`, `imagem_url`, `valor`, `estoque`, `data_cadastro`, `estado`, `tamanho`) VALUES
(13, 5, 'Under Armour SlipSpeed', 'O Under Armour SlipSpeed é o tênis versátil projetado para acompanhar qualquer ritmo do seu dia. Com design inovador 2 em 1, ele funciona tanto como tênis de treino quanto como um slip-on confortável, graças ao calcanhar dobrável que permite alternar entre os modos com facilidade. Sua estrutura leve e resistente oferece suporte ideal para treinos intensos, enquanto a palmilha interna com tecnologia Iso-Chill mantém os pés frescos mesmo nas sessões mais pesadas.\r\n\r\nA entressola com amortecimento responsivo garante pisadas mais macias e seguras, e a sola em borracha de alta tração proporciona estabilidade em diversos tipos de superfície. Estilo, conforto e desempenho em um único produto — perfeito para quem quer treinar forte e viver com praticidade.', 'assets/uploads/prod_691e63b07b1a84.71484186.webp', 879.00, 1, '2025-11-19 21:41:20', 'Novo', '40'),
(16, 1, 'Nike Dunk Low', 'Tênis clássico de colecionador', 'https://cdn.runrepeat.com/storage/gallery/product_content/25696/nike-dunk-low-review-21438139-720.jpg', 999.90, 5, '2025-10-20 21:12:41', 'Novo', '40'),
(18, 5, 'Nike Vomero 18', 'O Nike Vomero 18 chega como a evolução perfeita para quem busca máximo conforto, amortecimento premium e uma corrida suave todos os dias. Reconhecido como um dos modelos mais confortáveis da Nike, o Vomero 18 mantém essa tradição com uma espuma ainda mais macia e responsiva, oferecendo transições suaves e absorção de impacto ideal para treinos longos.\r\n\r\nO cabedal em mesh respirável foi refinado para proporcionar melhor ajuste, ventilação constante e sensação de leveza. A palmilha macia se adapta ao formato do pé, garantindo suporte desde o primeiro passo. Na sola, borracha durável com zonas estratégicas de tração assegura estabilidade e firmeza em diferentes superfícies.\r\n\r\nIdeal para corredores que buscam conforto duradouro, amortecimento premium e um tênis confiável para qualquer ritmo, o Vomero 18 combina tecnologia avançada e sensação luxuosa em cada passada.', 'assets/uploads/prod_69206f5187b7b6.11420720.webp', 789.00, 1, '2025-11-21 10:55:29', 'Semi-Novo', '40'),
(19, 5, 'Hoka Bondi 9', 'O Hoka Bondi 9 é um dos tênis mais icônicos da marca — e não é por acaso. Projetado para quem busca máximo amortecimento, ele entrega uma corrida extremamente macia e suave do início ao fim. Sua entressola atualizada com espuma ainda mais leve e responsiva proporciona uma sensação de flutuar a cada passada, reduzindo o impacto e aumentando o conforto em treinos longos.\r\n\r\nO cabedal em mesh respirável garante ventilação eficiente, mantendo seus pés frescos mesmo em quilometragens elevadas. A geometria Meta-Rocker aprimorada impulsiona o movimento natural da passada, tornando sua corrida mais fluida e eficiente. Além disso, a sola reforçada oferece excelente durabilidade e aderência.\r\n\r\nPerfeito para corredores que priorizam conforto absoluto, estabilidade e proteção, o Bondi 9 eleva o padrão de tênis de amortecimento máximo.', 'assets/uploads/prod_692073a425e656.33077412.webp', 489.00, 1, '2025-11-21 11:13:56', 'Usado', '38'),
(21, 5, 'New Balance Fresh Foam X', 'O New Balance Fresh Foam X representa o ápice do conforto e da maciez dentro da linha de corrida da marca. Projetado para oferecer uma sensação ultraconfortável sob os pés, ele utiliza a tecnologia Fresh Foam X, a versão mais avançada da famosa espuma da New Balance, garantindo amortecimento superior, suavidade extrema e um impacto reduzido a cada passada.\r\n\r\nO cabedal em mesh técnico envolve o pé com leveza e respirabilidade, proporcionando ajuste seguro sem sacrificar a flexibilidade. A geometria da entressola foi cuidadosamente esculpida para otimizar a transição da passada, tornando a corrida mais fluida e natural. Já a sola externa, com borracha estrategicamente posicionada, aumenta a durabilidade e oferece tração consistente.\r\n\r\nPerfeito para corredores que buscam amortecimento máximo, conforto contínuo e uma experiência de corrida estável e macia, o Fresh Foam X eleva o padrão de performance do dia a dia.', 'assets/uploads/prod_69207ebfb86665.47685336.webp,assets/uploads/prod_69207ebfb89e83.79034942.webp', 499.00, 1, '2025-11-21 12:01:19', 'Semi-Novo', '41');

-- --------------------------------------------------------

--
-- Estrutura para tabela `usuario`
--

CREATE TABLE `usuario` (
  `id_cliente` int(11) NOT NULL,
  `nome` varchar(255) DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `senha` varchar(255) NOT NULL,
  `CPF` varchar(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `usuario`
--

INSERT INTO `usuario` (`id_cliente`, `nome`, `email`, `senha`, `CPF`) VALUES
(1, 'teste', 'teste@example.com', '$2y$10$6/pwT6jrTz5mnxrbHEyqJOCNSPdaMCQ.7c.1eCPMUXl5ZkGrMpOae', '12345678921'),
(7, 'Novo Usuario', 'novo@example.com', '$2y$10$4yhZ8U6PeSTbyQf6SIgwPeDLLtQNVGMzyifeT3ytX2pMH19AbnQn.', '14716143652'),
(8, 'Novo Usuario', 'novo2@example.com', '$2y$10$zecCDTwlwp9.J4QLx6KnX.2v9VfxcQprnFCWEm.R6vmxsLdgeJuEa', '25292864669'),
(9, 'admin', 'admin@example.com', '$2y$10$wFK36RGgTBIR3lejDolyKekBZ3v.WkX9poCKeGvHJNEhffdnUo.N.', '90860822878'),
(10, 'Vitor', 'etec@gmail.com', '$2y$10$TjWL6q1gvgPAW1iUJnCr..uV3V5Mu80dAnlakpZFMnDRFVQmq9g4y', '45487976759');

-- --------------------------------------------------------

--
-- Estrutura para tabela `vendedor`
--

CREATE TABLE `vendedor` (
  `id_vendedor` int(11) NOT NULL,
  `nome` varchar(255) DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `senha` varchar(255) NOT NULL,
  `CPF` varchar(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `vendedor`
--

INSERT INTO `vendedor` (`id_vendedor`, `nome`, `email`, `senha`, `CPF`) VALUES
(1, 'Vitor Sneaker', 'vitor@example.com', 'senha123', '12345678901'),
(4, 'Loja Vitor 2', 'loja.vitor2@test.com', '$2y$10$qI.b7gYJEJkQceWPY9mXP.rGvUjqWLhkctbtVjDrDIpc1rBdkNKV.', '98765432109'),
(5, 'Asdawd', 'teste@gmail.com', '$2y$10$gqB6lKpMWseMv7sYMOExBOFFl5SSk1e.RK62LQYBnPJ6eTjcqH4EC', '12345678921');

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `endereco`
--
ALTER TABLE `endereco`
  ADD PRIMARY KEY (`id_endereco`),
  ADD KEY `id_cliente` (`id_cliente`);

--
-- Índices de tabela `item_pedido`
--
ALTER TABLE `item_pedido`
  ADD PRIMARY KEY (`id_pedido`,`id_produto`),
  ADD KEY `id_produto` (`id_produto`);

--
-- Índices de tabela `pagamento`
--
ALTER TABLE `pagamento`
  ADD PRIMARY KEY (`id_pagamento`),
  ADD KEY `id_pedido` (`id_pedido`);

--
-- Índices de tabela `pedido`
--
ALTER TABLE `pedido`
  ADD PRIMARY KEY (`id_pedido`),
  ADD KEY `id_cliente` (`id_cliente`),
  ADD KEY `id_endereco` (`id_endereco`);

--
-- Índices de tabela `produto`
--
ALTER TABLE `produto`
  ADD PRIMARY KEY (`id_produto`),
  ADD KEY `id_vendedor` (`id_vendedor`);

--
-- Índices de tabela `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`id_cliente`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `CPF` (`CPF`);

--
-- Índices de tabela `vendedor`
--
ALTER TABLE `vendedor`
  ADD PRIMARY KEY (`id_vendedor`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `CPF` (`CPF`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `endereco`
--
ALTER TABLE `endereco`
  MODIFY `id_endereco` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de tabela `pagamento`
--
ALTER TABLE `pagamento`
  MODIFY `id_pagamento` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de tabela `pedido`
--
ALTER TABLE `pedido`
  MODIFY `id_pedido` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de tabela `produto`
--
ALTER TABLE `produto`
  MODIFY `id_produto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT de tabela `usuario`
--
ALTER TABLE `usuario`
  MODIFY `id_cliente` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de tabela `vendedor`
--
ALTER TABLE `vendedor`
  MODIFY `id_vendedor` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- Restrições para tabelas despejadas
--

--
-- Restrições para tabelas `endereco`
--
ALTER TABLE `endereco`
  ADD CONSTRAINT `endereco_ibfk_1` FOREIGN KEY (`id_cliente`) REFERENCES `usuario` (`id_cliente`) ON DELETE CASCADE;

--
-- Restrições para tabelas `item_pedido`
--
ALTER TABLE `item_pedido`
  ADD CONSTRAINT `item_pedido_ibfk_1` FOREIGN KEY (`id_pedido`) REFERENCES `pedido` (`id_pedido`),
  ADD CONSTRAINT `item_pedido_ibfk_2` FOREIGN KEY (`id_produto`) REFERENCES `produto` (`id_produto`);

--
-- Restrições para tabelas `pagamento`
--
ALTER TABLE `pagamento`
  ADD CONSTRAINT `pagamento_ibfk_1` FOREIGN KEY (`id_pedido`) REFERENCES `pedido` (`id_pedido`) ON DELETE CASCADE;

--
-- Restrições para tabelas `pedido`
--
ALTER TABLE `pedido`
  ADD CONSTRAINT `pedido_ibfk_1` FOREIGN KEY (`id_cliente`) REFERENCES `usuario` (`id_cliente`) ON DELETE CASCADE,
  ADD CONSTRAINT `pedido_ibfk_2` FOREIGN KEY (`id_endereco`) REFERENCES `endereco` (`id_endereco`) ON DELETE CASCADE;

--
-- Restrições para tabelas `produto`
--
ALTER TABLE `produto`
  ADD CONSTRAINT `produto_ibfk_1` FOREIGN KEY (`id_vendedor`) REFERENCES `vendedor` (`id_vendedor`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
