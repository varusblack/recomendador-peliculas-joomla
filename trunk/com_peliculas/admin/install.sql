CREATE TABLE IF NOT EXISTS `#__categorias` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `categoria` varchar(100) COLLATE utf8_spanish2_ci NOT NULL,
  PRIMARY KEY (`id`)
);

CREATE TABLE IF NOT EXISTS `#__famosos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `nombre` (`nombre`)
) ;

CREATE TABLE IF NOT EXISTS `#_peliculas` (
  `id` int(11) NOT NULL,
  `titulo` varchar(255) NOT NULL,
  `anno` varchar(20) NOT NULL,
  `videoRelease` varchar(255) NOT NULL,
  `IMDBurl` varchar(255) NOT NULL,
  `titulo2` varchar(255) NOT NULL,
  `tituloEspanol` varchar(255) NOT NULL,
  `urlCartel` varchar(255) NOT NULL,
  `idDirector` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `idDirector` (`idDirector`)
);
