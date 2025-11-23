-- Script para popular o catálogo com produtos de exemplo
-- Execute este script no phpMyAdmin ou via linha de comando

-- Primeiro, vamos garantir que temos vendedores
-- (ajuste os IDs conforme necessário)

-- Produtos Nike
INSERT INTO produto (id_vendedor, nome, descricao, tamanho, imagem_url, valor, estoque, estado) VALUES
(1, 'Nike Air Max 90 Branco', 'Tênis clássico Nike Air Max 90 na cor branca, em ótimo estado. Conforto e estilo para o dia a dia.', '40', 'https://cdn.runrepeat.com/storage/gallery/product_primary/25010/nike-air-max-90-main-22584742-720.jpg', 599.90, 1, 'Novo'),
(1, 'Nike Air Force 1 Preto', 'Air Force 1 todo preto, nunca saem de moda. Modelo atemporal e versátil.', '42', 'https://cdn.runrepeat.com/storage/gallery/product_primary/25153/nike-air-force-1-07-lv-8-main-22215415-720.jpg', 499.90, 1, 'Semi-Novo'),
(1, 'Nike Dunk Low Panda', 'Dunk Low no colorway Panda (preto e branco), um dos mais procurados. Edição limitada.', '41', 'https://cdn.runrepeat.com/storage/gallery/product_primary/25696/nike-dunk-low-lab-test-and-review-2-21438148-720.jpg', 899.90, 1, 'Novo'),
(1, 'Nike Air Jordan 1 Chicago', 'Jordan 1 no icônico colorway Chicago. Peça de colecionador em excelente estado.', '43', 'https://cdn.runrepeat.com/storage/gallery/product_content/25696/nike-dunk-low-profile-21438137-720.jpg', 1499.90, 1, 'Semi-Novo'),
(1, 'Nike Air Max 97 Prata', 'Air Max 97 na cor prata metálica. Design futurista dos anos 90.', '39', 'https://cdn.runrepeat.com/storage/gallery/product_content/25010/nike-air-max-90-outdoor-01-22584784-720.jpg', 699.90, 1, 'Usado'),
(1, 'Nike SB Dunk Low Travis Scott', 'Colaboração especial Nike SB x Travis Scott. Edição limitadíssima.', '42', 'https://cdn.runrepeat.com/storage/gallery/product_content/25696/nike-dunk-low-cut-in-half-21438121-120.jpg', 2999.90, 1, 'Novo'),
(1, 'Nike Air Max Plus TN', 'Air Max Plus (TN) na cor preta com detalhes em laranja. Amortecimento máximo.', '44', 'https://cdn.runrepeat.com/storage/gallery/product_content/25010/nike-air-max-90-pieces-22584783-720.jpg', 549.90, 1, 'Semi-Novo'),
(1, 'Nike Blazer Mid 77 Vintage', 'Blazer Mid 77 estilo vintage, branco com swoosh azul marinho.', '40', 'https://cdn.runrepeat.com/storage/gallery/product_content/25153/nike-air-force-1-07-lv-8-outdoor-01-22215294-720.jpg', 449.90, 1, 'Novo');

-- Produtos Adidas
INSERT INTO produto (id_vendedor, nome, descricao, tamanho, imagem_url, valor, estoque, estado) VALUES
(1, 'Adidas Yeezy Boost 350 V2', 'Yeezy 350 V2 colorway Zebra. Colaboração Kanye West. Ultra raro.', '41', 'https://cdn.runrepeat.com/storage/gallery/product_primary/25204/adidas-samba-21161572-720.jpg', 1899.90, 1, 'Novo'),
(1, 'Adidas Superstar Branco', 'Clássico Superstar todo branco com as 3 listras pretas. Icônico desde os anos 70.', '39', 'https://cdn.runrepeat.com/storage/gallery/product_primary/25218/adidas-superstar-21161575-720.jpg', 399.90, 1, 'Semi-Novo'),
(1, 'Adidas Stan Smith Verde', 'Stan Smith branco com detalhes verdes. Minimalista e elegante.', '42', 'https://cdn.runrepeat.com/storage/gallery/product_content/25204/adidas-samba-review-20885455-720.jpg', 449.90, 1, 'Novo'),
(1, 'Adidas Ultra Boost 4.0', 'Ultra Boost com tecnologia Boost de amortecimento. Conforto extremo.', '43', 'https://cdn.runrepeat.com/storage/gallery/product_content/25218/adidas-superstar-20950826-720.jpg', 699.90, 1, 'Usado'),
(1, 'Adidas NMD R1 Preto', 'NMD R1 todo preto. Design moderno e urbano.', '40', 'https://cdn.runrepeat.com/storage/gallery/product_content/25204/adidas-samba-lab-test-20885453-720.jpg', 599.90, 1, 'Novo'),
(1, 'Adidas Samba OG Preto', 'Samba OG na versão preta. Clássico do futebol adaptado para street.', '41', 'https://cdn.runrepeat.com/storage/gallery/product_content/25204/adidas-samba-cut-in-half-20885443-120.jpg', 499.90, 1, 'Semi-Novo'),
(1, 'Adidas Forum Low Bad Bunny', 'Colaboração especial com Bad Bunny. Edição limitada rosa/azul.', '42', 'https://cdn.runrepeat.com/storage/gallery/product_content/25218/adidas-superstar-erliuql-20950800-120.jpg', 1299.90, 1, 'Novo'),
(1, 'Adidas Gazelle Azul Marinho', 'Gazelle em camurça azul marinho. Estilo retrô dos anos 60.', '39', 'https://cdn.runrepeat.com/storage/gallery/product_content/25204/adidas-samba-silhouette-20885458-720.jpg', 449.90, 1, 'Novo');

-- Produtos Puma
INSERT INTO produto (id_vendedor, nome, descricao, tamanho, imagem_url, valor, estoque, estado) VALUES
(1, 'Puma Suede Classic', 'Puma Suede clássico na cor preta. Ícone do hip-hop dos anos 80.', '40', 'https://cdn.runrepeat.com/storage/gallery/product_content/25204/adidas-samba-toebox-durability-test-20885778-120.jpg', 349.90, 1, 'Semi-Novo'),
(1, 'Puma RS-X Colorido', 'RS-X com design colorido e futurista. Chunky sneaker em alta.', '42', 'https://cdn.runrepeat.com/storage/gallery/product_content/25218/adidas-superstar-heel-20950815-720.jpg', 499.90, 1, 'Novo'),
(1, 'Puma Clyde Court Disrupt', 'Modelo de basquete Clyde Court na cor vermelha.', '43', 'https://cdn.runrepeat.com/storage/gallery/product_content/25010/nike-air-max-90-cutting-22584774-120.jpg', 599.90, 1, 'Novo'),
(1, 'Puma Thunder Spectra', 'Thunder Spectra com mix de cores vibrantes. Dad shoe estiloso.', '41', 'https://cdn.runrepeat.com/storage/gallery/product_content/25696/nike-dunk-low-style-21438145-720.jpg', 449.90, 1, 'Semi-Novo');

-- Produtos New Balance
INSERT INTO produto (id_vendedor, nome, descricao, tamanho, imagem_url, valor, estoque, estado) VALUES
(1, 'New Balance 550 Branco Verde', 'NB 550 branco com detalhes verdes. Modelo retrô de basquete.', '42', 'https://cdn.runrepeat.com/storage/gallery/product_content/25696/nike-dunk-low-review-21438139-120.jpg', 699.90, 1, 'Novo'),
(1, 'New Balance 574 Cinza', 'Clássico 574 na cor cinza. Conforto e durabilidade New Balance.', '40', 'https://cdn.runrepeat.com/storage/gallery/product_content/25696/nike-dunk-low-lab-test-21438140-120.jpg', 499.90, 1, 'Semi-Novo'),
(1, 'New Balance 990v5 Made in USA', 'Premium 990v5 fabricado nos EUA. Qualidade superior.', '43', 'https://cdn.runrepeat.com/storage/gallery/product_content/25010/nike-air-max-90-outdoor-07-22584791-720.jpg', 899.90, 1, 'Novo'),
(1, 'New Balance 327 Preto Branco', 'NB 327 com design inspirado nos anos 70. Preto e branco.', '41', 'https://cdn.runrepeat.com/storage/gallery/product_content/25218/adidas-superstar-weight-20950813-720.jpg', 599.90, 1, 'Novo'),
(1, 'New Balance 2002R Protection Pack', 'NB 2002R da coleção Protection Pack. Design premium.', '42', 'https://cdn.runrepeat.com/storage/gallery/product_content/25696/nike-dunk-low-flexibility-21438142-720.jpg', 799.90, 1, 'Semi-Novo');

-- Produtos Vans
INSERT INTO produto (id_vendedor, nome, descricao, tamanho, imagem_url, valor, estoque, estado) VALUES
(1, 'Vans Old Skool Preto Branco', 'Old Skool clássico preto com listra branca. Ícone do skate.', '40', 'https://cdn.runrepeat.com/storage/gallery/product_content/25010/nike-air-max-90-outdoor-015-22584796-720.jpg', 299.90, 1, 'Novo'),
(1, 'Vans Sk8-Hi Xadrez', 'Sk8-Hi no padrão xadrez preto e branco (checkerboard).', '41', 'https://cdn.runrepeat.com/storage/gallery/product_content/25204/adidas-samba-on-feet-20885448-120.jpg', 349.90, 1, 'Semi-Novo'),
(1, 'Vans Authentic Off White', 'Authentic na cor off-white. Minimalista e versátil.', '39', 'https://cdn.runrepeat.com/storage/gallery/product_content/25696/nike-dunk-low-fit-21438146-720.jpg', 249.90, 1, 'Novo'),
(1, 'Vans Slip-On Platform', 'Slip-On com plataforma, todo preto. Praticidade com estilo.', '38', 'https://cdn.runrepeat.com/storage/gallery/product_content/25218/adidas-superstar-outsole-thickness-20950812-720.jpg', 329.90, 1, 'Novo');

-- Produtos Converse
INSERT INTO produto (id_vendedor, nome, descricao, tamanho, imagem_url, valor, estoque, estado) VALUES
(1, 'Converse Chuck Taylor All Star Preto', 'Chuck Taylor clássico cano alto, todo preto. Atemporal.', '42', 'https://cdn.runrepeat.com/storage/gallery/product_content/25153/nike-air-force-1-07-lv-8-pieces-22215293-720.jpg', 299.90, 1, 'Semi-Novo'),
(1, 'Converse Chuck 70 Branco', 'Chuck 70 premium na cor branca. Versão melhorada do clássico.', '41', 'https://cdn.runrepeat.com/storage/gallery/product_content/25696/nike-dunk-low-shoe-pieces-21438138-720.jpg', 399.90, 1, 'Novo'),
(1, 'Converse One Star Golf Le Fleur', 'Colaboração Tyler, The Creator. One Star colorido.', '40', 'https://cdn.runrepeat.com/storage/gallery/product_content/25010/nike-air-max-90-upper-22584776-120.jpg', 599.90, 1, 'Novo'),
(1, 'Converse Run Star Hike Plataforma', 'Run Star Hike com plataforma dentada. Estilo ousado.', '39', 'https://cdn.runrepeat.com/storage/gallery/product_content/25204/adidas-samba-upper-20885450-120.jpg', 499.90, 1, 'Novo');

-- Produtos Asics
INSERT INTO produto (id_vendedor, nome, descricao, tamanho, imagem_url, valor, estoque, estado) VALUES
(1, 'Asics Gel-Lyte III Cinza', 'Gel-Lyte III na cor cinza. Conforto e design japonês.', '42', 'https://cdn.runrepeat.com/storage/gallery/product_content/25153/nike-air-force-1-07-lv-8-outdoor-06-22215300-720.jpg', 499.90, 1, 'Semi-Novo'),
(1, 'Asics Gel-Kayano 14 Branco Prata', 'Gel-Kayano 14 branco com detalhes prata. Vintage tech.', '43', 'https://cdn.runrepeat.com/storage/gallery/product_content/25696/nike-dunk-low-background-21444876-720.jpg', 599.90, 1, 'Novo'),
(1, 'Asics Gel-Quantum 360', 'Gel-Quantum com amortecimento GEL 360 graus. Tecnologia máxima.', '41', 'https://cdn.runrepeat.com/storage/gallery/product_content/25010/nike-air-max-90-gel-22584775-120.jpg', 699.90, 1, 'Novo');

-- Produtos Reebok
INSERT INTO produto (id_vendedor, nome, descricao, tamanho, imagem_url, valor, estoque, estado) VALUES
(1, 'Reebok Club C 85 Branco Verde', 'Club C 85 branco com detalhes verdes. Clássico minimalista.', '40', 'https://cdn.runrepeat.com/storage/gallery/product_content/25153/nike-air-force-1-07-lv-8-outdoor-012-22215305-720.jpg', 399.90, 1, 'Novo'),
(1, 'Reebok Classic Leather Preto', 'Classic Leather todo preto. Icônico desde 1983.', '42', 'https://cdn.runrepeat.com/storage/gallery/product_content/25696/nike-dunk-low-laces-21438143-720.jpg', 349.90, 1, 'Semi-Novo'),
(1, 'Reebok Instapump Fury', 'Instapump Fury com sistema de bomba inflável. Futurista.', '41', 'https://cdn.runrepeat.com/storage/gallery/product_content/25010/nike-air-max-90-outdoor-6-22584782-120.jpg', 799.90, 1, 'Novo');

-- Produtos diversos/streetwear
INSERT INTO produto (id_vendedor, nome, descricao, tamanho, imagem_url, valor, estoque, estado) VALUES
(1, 'Off-White Out of Office Branco', 'Off-White Out of Office na cor branca. Design Virgil Abloh.', '42', 'https://cdn.runrepeat.com/storage/gallery/product_content/25153/nike-air-force-1-07-lv-8-outdoor-016-22215310-720.jpg', 2499.90, 1, 'Novo'),
(1, 'Balenciaga Triple S Preto', 'Triple S todo preto. Chunky sneaker de luxo.', '43', 'https://cdn.runrepeat.com/storage/gallery/product_content/25696/nike-dunk-low-durable-outsole-21438151-720.jpg', 3999.90, 1, 'Novo'),
(1, 'Golden Goose Superstar', 'Golden Goose Superstar com efeito usado proposital. Luxo italiano.', '41', 'https://cdn.runrepeat.com/storage/gallery/product_content/25218/adidas-superstar-ervaraer-20950825-120.jpg', 1899.90, 1, 'Novo'),
(1, 'Fear of God Essentials Preto', 'FOG Essentials na cor preta. Minimalista premium.', '42', 'https://cdn.runrepeat.com/storage/gallery/product_content/25010/nike-air-max-90-style-21438145-720.jpg', 1299.90, 1, 'Semi-Novo');

-- Total: 50+ produtos adicionados!
