-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 24/11/2025 às 04:02
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
(3, 10, 'Rua', 0, '', 'Ribeirão Pires', 'BR'),
(5, 1, 'Av Paulista', 144, 'Bela Vista', 'São Paulo', 'SP');

-- --------------------------------------------------------

--
-- Estrutura para tabela `favoritos`
--

CREATE TABLE `favoritos` (
  `id_favorito` int(11) NOT NULL,
  `id_cliente` int(11) NOT NULL,
  `id_produto` int(11) NOT NULL,
  `data_adicionado` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `favoritos`
--

INSERT INTO `favoritos` (`id_favorito`, `id_cliente`, `id_produto`, `data_adicionado`) VALUES
(6, 1, 16, '2025-11-23 15:46:51');

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
(3, 16, 1, 999.90, 999.90),
(4, 16, 1, 999.90, 999.90),
(5, 16, 1, 999.90, 999.90),
(6, 16, 1, 999.90, 999.90),
(7, 16, 1, 999.90, 999.90);

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
(1, 3, '', 'aprovado', 1048.90, '2025-11-21 15:22:43'),
(2, 4, 'pix', 'aprovado', 1048.90, '2025-11-22 18:06:17'),
(3, 5, 'pix', 'aprovado', 1048.90, '2025-11-22 18:06:49'),
(4, 6, '', 'aprovado', 1048.90, '2025-11-22 21:49:10'),
(5, 7, '', 'aprovado', 1048.90, '2025-11-23 18:10:04');

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
(3, 10, 3, '2025-11-21 15:22:43', 'pago', 1048.90),
(4, 1, 5, '2025-11-22 18:06:17', 'pago', 1048.90),
(5, 1, 5, '2025-11-22 18:06:48', 'pago', 1048.90),
(6, 1, 5, '2025-11-22 21:49:10', 'pago', 1048.90),
(7, 1, 5, '2025-11-23 18:10:04', 'pago', 1048.90);

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
(21, 5, 'New Balance Fresh Foam X', 'O New Balance Fresh Foam X representa o ápice do conforto e da maciez dentro da linha de corrida da marca. Projetado para oferecer uma sensação ultraconfortável sob os pés, ele utiliza a tecnologia Fresh Foam X, a versão mais avançada da famosa espuma da New Balance, garantindo amortecimento superior, suavidade extrema e um impacto reduzido a cada passada.\r\n\r\nO cabedal em mesh técnico envolve o pé com leveza e respirabilidade, proporcionando ajuste seguro sem sacrificar a flexibilidade. A geometria da entressola foi cuidadosamente esculpida para otimizar a transição da passada, tornando a corrida mais fluida e natural. Já a sola externa, com borracha estrategicamente posicionada, aumenta a durabilidade e oferece tração consistente.\r\n\r\nPerfeito para corredores que buscam amortecimento máximo, conforto contínuo e uma experiência de corrida estável e macia, o Fresh Foam X eleva o padrão de performance do dia a dia.', 'assets/uploads/prod_69207ebfb86665.47685336.webp,assets/uploads/prod_69207ebfb89e83.79034942.webp', 499.00, 1, '2025-11-21 12:01:19', 'Semi-Novo', '41'),
(22, 5, 'Adidas Samba', 'Adidas Samba', 'assets/uploads/prod_692259ca0ecc02.64488298.webp,assets/uploads/prod_692259ca0efaf4.81151981.jpg', 345.00, 1, '2025-11-22 21:48:10', 'Usado', '42'),
(28, 1, 'Nike Air Max 90 Branco', 'Tênis clássico Nike Air Max 90 na cor branca, em ótimo estado. Conforto e estilo para o dia a dia.', 'https://dcdn-us.mitiendanube.com/stores/902/111/products/img_20230501_120903_3621-4136b53cccfebda0d716829555202112-1024-1024.jpg', 599.90, 1, '2025-11-23 20:24:04', 'Novo', '40'),
(29, 1, 'Nike Air Force 1 Preto', 'Air Force 1 todo preto, nunca saem de moda. Modelo atemporal e versátil.', 'https://cdn.awsli.com.br/2500x2500/2058/2058636/produto/173875326/b3a1ebb3e7.jpg', 499.90, 1, '2025-11-23 20:24:04', 'Semi-Novo', '42'),
(30, 1, 'Nike Dunk Low Panda', 'Dunk Low no colorway Panda (preto e branco), um dos mais procurados. Edição limitada.', 'https://acdn-us.mitiendanube.com/stores/003/099/932/products/img_7193-6b48a195cfa175316b17192531468069-480-0.webp', 899.90, 1, '2025-11-23 20:24:04', 'Novo', '41'),
(31, 1, 'Nike Air Jordan 1 Chicago', 'Jordan 1 no icônico colorway Chicago. Peça de colecionador em excelente estado.', 'https://i.redd.it/0ebicjvlxc851.jpg', 1499.90, 1, '2025-11-23 20:24:04', 'Semi-Novo', '43'),
(32, 1, 'Nike Air Max 97 Prata', 'Air Max 97 na cor prata metálica. Design futurista dos anos 90.', 'https://dcdn-us.mitiendanube.com/stores/902/111/products/lin_fornecedor_tenis-20230501-00011-918ebe8e3bbda36cf616829964166728-1024-1024.jpg', 699.90, 1, '2025-11-23 20:24:04', 'Usado', '39'),
(33, 1, 'Nike SB Dunk Low Travis Scott', 'Colaboração especial Nike SB x Travis Scott. Edição limitadíssima.', 'https://photos.enjoei.com.br/tenis-travis-scott-sb-dunk-low-cactus-jack-76993050/800x800/czM6Ly9waG90b3MuZW5qb2VpLmNvbS5ici9wcm9kdWN0cy8yODg0ODk3MS85NzQ1ZjFkNmUyNWRlZjVhMWIwN2Q4MGQ1ZDNmNzY5Yy5qcGc', 2999.90, 1, '2025-11-23 20:24:04', 'Novo', '42'),
(34, 1, 'Nike Air Max Plus TN', 'Air Max Plus (TN) na cor preta com detalhes em laranja. Amortecimento máximo.', 'https://images-cdn.ubuy.co.mz/6617f6b793d111553402a98a-new-nike-air-max-plus-tn-classic.jpg', 549.90, 1, '2025-11-23 20:24:04', 'Semi-Novo', '44'),
(35, 1, 'Nike Blazer Mid 77 Vintage', 'Blazer Mid 77 estilo vintage, branco com swoosh azul marinho.', 'https://m.media-amazon.com/images/I/41QnrgiZdfL._AC_SY900_.jpg', 449.90, 1, '2025-11-23 20:24:04', 'Novo', '40'),
(36, 1, 'Adidas Yeezy Boost 350 V2', 'Yeezy 350 V2 colorway Zebra. Colaboração Kanye West. Ultra raro.', 'https://photos.enjoei.com.br/tenis-adidas-yeezy-boost-350-v2-cream-white-111027213/800x800/czM6Ly9waG90b3MuZW5qb2VpLmNvbS5ici9wcm9kdWN0cy8xMTI2NDkyNC9iMjJlNDg2ODU0ZjgwMTc1NmU5MWE2YjE5YTA2NzgxZS5qcGc', 1899.90, 1, '2025-11-23 20:24:04', 'Novo', '41'),
(37, 1, 'Adidas Superstar Branco', 'Clássico Superstar todo branco com as 3 listras pretas. Icônico desde os anos 70.', 'https://cdn.dooca.store/35121/products/bmraraq9t4yhbx3ouyblrrs0mtpbrbsdzt0r_1600x1600+fill_ffffff.jpeg?v=1676325136&webp=0', 399.90, 1, '2025-11-23 20:24:04', 'Semi-Novo', '39'),
(38, 1, 'Adidas Stan Smith Verde', 'Stan Smith branco com detalhes verdes. Minimalista e elegante.', 'https://uploadedfiles.yviews.com.br/imageupload/13d2a035-8d67-4ed0-97e0-f69007842f79/c051e529-546b-48e1-8fc3-2314cf5bdb7c.jpg', 449.90, 1, '2025-11-23 20:24:04', 'Novo', '42'),
(39, 1, 'Adidas Ultra Boost 4.0', 'Ultra Boost com tecnologia Boost de amortecimento. Conforto extremo.', 'https://acdn-us.mitiendanube.com/stores/001/808/148/products/fb7db286-4355-426c-8bac-606fea9f8afd1-0444badda269a5d25816292134733272-1024-1024.jpeg', 699.90, 1, '2025-11-23 20:24:04', 'Usado', '43'),
(40, 1, 'Adidas NMD R1 Preto', 'NMD R1 todo preto. Design moderno e urbano.', 'https://dcdn-us.mitiendanube.com/stores/902/111/products/img_20190125_1844221-2f2f41cd272305e50315484491916320-640-0.jpg', 599.90, 1, '2025-11-23 20:24:04', 'Novo', '40'),
(41, 1, 'Adidas Samba OG Preto', 'Samba OG na versão preta. Clássico do futebol adaptado para street.', 'https://espacocon.fbitsstatic.net/img/p/tenis-adidas-samba-og-preto-branco-b75807-153300/376054-5.jpg?w=1200&h=1200&v=202504141450', 499.90, 1, '2025-11-23 20:24:04', 'Semi-Novo', '41'),
(42, 1, 'Adidas Forum Low Bad Bunny', 'Colaboração especial com Bad Bunny. Edição limitada rosa/azul.', 'https://droper-media.us-southeast-1.linodeobjects.com/2582022135421538.webp', 1299.90, 1, '2025-11-23 20:24:04', 'Novo', '42'),
(43, 1, 'Adidas Gazelle Azul Marinho', 'Gazelle em camurça azul marinho. Estilo retrô dos anos 60.', 'https://photos.enjoei.com.br/public/1200x1200/czM6Ly9waG90b3MuZW5qb2VpLmNvbS5ici9wcm9kdWN0cy8yNDAwOTcvYzc5ODQ2NTUxNjI1MDFjNWMwODVlZjAxODMwYjEwZjMuanBn', 449.90, 1, '2025-11-23 20:24:04', 'Novo', '39'),
(44, 1, 'Puma Suede Classic', 'Puma Suede clássico na cor preta. Ícone do hip-hop dos anos 80.', 'https://cdn.awsli.com.br/2500x2500/644/644155/produto/348193024/img_5472-tlsag7y0cc.jpeg', 349.90, 1, '2025-11-23 20:24:05', 'Semi-Novo', '40'),
(45, 1, 'Puma RS-X Colorido', 'RS-X com design colorido e futurista. Chunky sneaker em alta.', 'https://photos.enjoei.com.br/tenis-puma-rs-x-preto-com-colorido-usado-poucas-vezes/1200xN/czM6Ly9waG90b3MuZW5qb2VpLmNvbS5ici9wcm9kdWN0cy80NTUwNTY1LzdhN2MyMmQwMDA1ZTM3ZjljN2VkYzU2MmUzM2EzZjVlLmpwZw', 499.90, 1, '2025-11-23 20:24:05', 'Novo', '42'),
(46, 1, 'Puma Clyde Court Disrupt', 'Modelo de basquete Clyde Court na cor vermelha.', 'https://u-mercari-images.mercdn.net/photos/m55431084680_2.jpg', 599.90, 1, '2025-11-23 20:24:05', 'Novo', '43'),
(47, 1, 'Puma Thunder Spectra', 'Thunder Spectra com mix de cores vibrantes. Dad shoe estiloso.', 'https://i.pinimg.com/736x/23/06/73/230673635097a850ffde3d42405c165e.jpg', 449.90, 1, '2025-11-23 20:24:05', 'Semi-Novo', '41'),
(48, 1, 'New Balance 550 Branco Verde', 'NB 550 branco com detalhes verdes. Modelo retrô de basquete.', 'https://cdn.awsli.com.br/800x800/1203/1203218/produto/307899425/whatsapp-image-2024-10-01-at-18-19-24--1--tt9aiabyuk.jpeg', 699.90, 1, '2025-11-23 20:24:05', 'Novo', '42'),
(49, 1, 'New Balance 574 Cinza', 'Clássico 574 na cor cinza. Conforto e durabilidade New Balance.', 'https://cdn.vnda.com.br/mariacanela/2024/12/30/15_38_44_944_15_12_9_995_1.png?v=1735583924', 499.90, 1, '2025-11-23 20:24:05', 'Semi-Novo', '40'),
(50, 1, 'New Balance 990v5 Made in USA', 'Premium 990v5 fabricado nos EUA. Qualidade superior.', 'https://image-cdn.hypb.st/https%3A%2F%2Fhypebeast.com%2Fimage%2F2019%2F04%2Fnew-balance-990-v5-made-in-us-grey-00.jpg?w=960&cbr=1&q=90&fit=max', 899.90, 1, '2025-11-23 20:24:05', 'Novo', '43'),
(51, 1, 'New Balance 327 Preto Branco', 'NB 327 com design inspirado nos anos 70. Preto e branco.', 'https://cdn.awsli.com.br/2500x2500/644/644155/produto/327318486/img_4387-ilkpyzz3gs.jpeg', 599.90, 1, '2025-11-23 20:24:05', 'Novo', '41'),
(52, 1, 'New Balance 2002R Protection Pack', 'NB 2002R da coleção Protection Pack. Design premium.', 'https://i.ebayimg.com/images/g/bUIAAOSw8tJnNL64/s-l1200.jpg', 799.90, 1, '2025-11-23 20:24:05', 'Semi-Novo', '42'),
(53, 1, 'Vans Old Skool Preto Branco', 'Old Skool clássico preto com listra branca. Ícone do skate.', 'https://images.tcdn.com.br/img/img_prod/705238/tenis_vans_old_skool_black_white_2541_1_d2d2b2b7a8bcbee6bf750d408f84a99a.jpg', 299.90, 1, '2025-11-23 20:24:06', 'Novo', '40'),
(54, 1, 'Vans Sk8-Hi Xadrez', 'Sk8-Hi no padrão xadrez preto e branco (checkerboard).', 'https://acdn.mitiendanube.com/stores/003/345/346/products/whatsapp-image-2024-07-10-at-13-21-58-00ad3dffb4340ab04417206362051290-1024-1024.jpeg', 349.90, 1, '2025-11-23 20:24:06', 'Semi-Novo', '41'),
(55, 1, 'Vans Authentic Off White', 'Authentic na cor off-white. Minimalista e versátil.', 'https://di2ponv0v5otw.cloudfront.net/posts/2022/02/09/62042e26800f641fdc99114a/m_wp_62042ea693649f4f976e4571.webp', 249.90, 1, '2025-11-23 20:24:06', 'Novo', '39'),
(56, 1, 'Vans Slip-On Platform', 'Slip-On com plataforma, todo preto. Praticidade com estilo.', 'https://images.tcdn.com.br/img/img_prod/705238/tenis_vans_slip_on_platform_checkerboard_4763_1_7a8db5e5a2e53d5ee6febd526d05b0e2.jpg', 329.90, 1, '2025-11-23 20:24:06', 'Novo', '38'),
(57, 1, 'Converse Chuck Taylor All Star Preto', 'Chuck Taylor clássico cano alto, todo preto. Atemporal.', 'https://converse.com.br/media/catalog/product/m/5/m5039_l_08x1.jpg?optimize=high&bg-color=255,255,255&fit=bounds&height=&width=', 299.90, 1, '2025-11-23 20:24:06', 'Semi-Novo', '42'),
(58, 1, 'Converse Chuck 70 Branco', 'Chuck 70 premium na cor branca. Versão melhorada do clássico.', 'https://converse.com.br/media/catalog/product/1/6/162062c_a_08x1_1_.jpg?optimize=high&bg-color=255,255,255&fit=bounds&height=&width=', 399.90, 1, '2025-11-23 20:24:06', 'Novo', '41'),
(59, 1, 'Converse One Star Golf Le Fleur', 'Colaboração Tyler, The Creator. One Star colorido.', 'https://i.ebayimg.com/images/g/KUYAAOSwU51mKmq8/s-l1200.jpg', 599.90, 1, '2025-11-23 20:24:06', 'Novo', '40'),
(60, 1, 'Converse Run Star Hike Plataforma', 'Run Star Hike com plataforma dentada. Estilo ousado.', 'https://m.media-amazon.com/images/I/41tajOPcMXL._AC_SY900_.jpg', 499.90, 1, '2025-11-23 20:24:06', 'Novo', '39'),
(61, 1, 'Asics Gel-Lyte III Cinza', 'Gel-Lyte III na cor cinza. Conforto e design japonês.', 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQy9r9CWU2AuST9qHn0IrRqnyL2LT3kTPe_Gw&s', 499.90, 1, '2025-11-23 20:24:06', 'Semi-Novo', '42'),
(62, 1, 'Asics Gel-Kayano 14 Branco Prata', 'Gel-Kayano 14 branco com detalhes prata. Vintage tech.', 'https://photos.enjoei.com.br/tenis-asics-gel-kayano-14-branco-104934971/800x800/czM6Ly9waG90b3MuZW5qb2VpLmNvbS5ici9wcm9kdWN0cy8xMDcyNTI3My81MDNkNDExMGRlYzI0NTU0ZjJjYWI2NjgwNzk1NmNiMy5qcGc', 599.90, 1, '2025-11-23 20:24:06', 'Novo', '43'),
(63, 1, 'Asics Gel-Quantum 360', 'Gel-Quantum com amortecimento GEL 360 graus. Tecnologia máxima.', 'https://teniscorrida.com.br/app/media/images_product/big/127487771/tenis-asics-gel-quantum-360-6-azul-escuro-e-preto-masculino-746accec.jpg', 699.90, 1, '2025-11-23 20:24:06', 'Novo', '41'),
(64, 1, 'Reebok Club C 85 Branco Verde', 'Club C 85 branco com detalhes verdes. Clássico minimalista.', 'https://photos.enjoei.com.br/public/1200x1200/czM6Ly9waG90b3MuZW5qb2VpLmNvbS5ici9wcm9kdWN0cy82NTUwODE2LzgzYzMxODA0M2ZjNmYxNTRjNzFlNzliY2VjMDU3OTI3LmpwZw', 399.90, 1, '2025-11-23 20:24:06', 'Novo', '40'),
(65, 1, 'Reebok Classic Leather Preto', 'Classic Leather todo preto. Icônico desde 1983.', 'https://photos.enjoei.com.br/reebok-classic-leather-preto-64794516/800x800/czM6Ly9waG90b3MuZW5qb2VpLmNvbS5ici9wcm9kdWN0cy8xMDUzNzk2My81Nzg3OTY1OTQxN2IwZjJkMGJiYWVlNzBmOTY2NTI5ZS5qcGc', 349.90, 1, '2025-11-23 20:24:06', 'Semi-Novo', '42'),
(66, 1, 'Reebok Instapump Fury', 'Instapump Fury com sistema de bomba inflável. Futurista.', 'https://static.ftshp.digital/img/p/5/4/1/8/5/54185.jpg', 799.90, 1, '2025-11-23 20:24:06', 'Novo', '41'),
(67, 1, 'Off-White Out of Office Branco', 'Off-White Out of Office na cor branca. Design Virgil Abloh.', 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQFM_wFIO-4FMus3z6zBCYGmjp1mTyzz745nw&s', 2499.90, 1, '2025-11-23 20:24:07', 'Novo', '42'),
(68, 1, 'Balenciaga Triple S Preto', 'Triple S todo preto. Chunky sneaker de luxo.', 'https://images-cdn.ubuy.com.br/64beb4d13e2f7517eb7308c2-balenciaga-triple-s-black-non-distressed.jpg', 3999.90, 1, '2025-11-23 20:24:07', 'Novo', '43'),
(69, 1, 'Golden Goose Superstar', 'Golden Goose Superstar com efeito usado proposital. Luxo italiano.', 'https://static2.goldengoose.com/public/Style/ECOMM/GMF00102.F000318-10220-5.jpg', 1899.90, 1, '2025-11-23 20:24:07', 'Novo', '41'),
(70, 1, 'Fear of God Essentials Preto', 'FOG Essentials na cor preta. Minimalista premium.', 'https://media-assets.grailed.com/prd/listing/temp/484997533ae04841a882f224604ee38a', 1299.90, 1, '2025-11-23 20:24:07', 'Semi-Novo', '42');

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
(5, 'teste', 'teste@example.com', '$2y$10$gqB6lKpMWseMv7sYMOExBOFFl5SSk1e.RK62LQYBnPJ6eTjcqH4EC', '12345678921');

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
-- Índices de tabela `favoritos`
--
ALTER TABLE `favoritos`
  ADD PRIMARY KEY (`id_favorito`),
  ADD UNIQUE KEY `unique_favorito` (`id_cliente`,`id_produto`),
  ADD KEY `id_cliente` (`id_cliente`),
  ADD KEY `id_produto` (`id_produto`);

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
  MODIFY `id_endereco` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de tabela `favoritos`
--
ALTER TABLE `favoritos`
  MODIFY `id_favorito` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de tabela `pagamento`
--
ALTER TABLE `pagamento`
  MODIFY `id_pagamento` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de tabela `pedido`
--
ALTER TABLE `pedido`
  MODIFY `id_pedido` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de tabela `produto`
--
ALTER TABLE `produto`
  MODIFY `id_produto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=73;

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
-- Restrições para tabelas `favoritos`
--
ALTER TABLE `favoritos`
  ADD CONSTRAINT `fk_favoritos_cliente` FOREIGN KEY (`id_cliente`) REFERENCES `usuario` (`id_cliente`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_favoritos_produto` FOREIGN KEY (`id_produto`) REFERENCES `produto` (`id_produto`) ON DELETE CASCADE;

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
