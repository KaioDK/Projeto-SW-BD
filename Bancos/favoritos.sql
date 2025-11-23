-- Tabela de favoritos
CREATE TABLE IF NOT EXISTS `favoritos` (
  `id_favorito` int(11) NOT NULL AUTO_INCREMENT,
  `id_cliente` int(11) NOT NULL,
  `id_produto` int(11) NOT NULL,
  `data_adicionado` datetime DEFAULT current_timestamp(),
  PRIMARY KEY (`id_favorito`),
  UNIQUE KEY `unique_favorito` (`id_cliente`, `id_produto`),
  KEY `id_cliente` (`id_cliente`),
  KEY `id_produto` (`id_produto`),
  CONSTRAINT `fk_favoritos_cliente` FOREIGN KEY (`id_cliente`) REFERENCES `usuario` (`id_cliente`) ON DELETE CASCADE,
  CONSTRAINT `fk_favoritos_produto` FOREIGN KEY (`id_produto`) REFERENCES `produto` (`id_produto`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
