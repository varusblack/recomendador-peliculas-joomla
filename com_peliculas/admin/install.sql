CREATE TABLE IF NOT EXISTS `#__categorias` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `categoria` varchar(100) COLLATE utf8_spanish2_ci NOT NULL,
  PRIMARY KEY (`id`)
);

CREATE TABLE IF NOT EXISTS `#__famosos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ;

CREATE TABLE IF NOT EXISTS `#__peliculas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `titulo` varchar(255) NOT NULL,
  `anno` varchar(20) NOT NULL,
  `videoRelease` varchar(255) NOT NULL,
  `tituloEspanol` varchar(255) NOT NULL,
  `idDirector` int(11) DEFAULT NULL,
  `resumenEspa` text NOT NULL,
  PRIMARY KEY (`id`),
  KEY `idDirector` (`idDirector`)
);

CREATE TABLE IF NOT EXISTS `#__categoriaspeliculas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `idPelicula` int(11) NOT NULL,
  `idCategoria` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `idPelicula` (`idPelicula`,`idCategoria`),
  KEY `idCategoria` (`idCategoria`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci AUTO_INCREMENT=7453 ;

ALTER TABLE  `#__users` ADD  `vector` FLOAT NOT NULL;

CREATE TABLE IF NOT EXISTS `#__votos` (
  `idUsuario` int(11) NOT NULL,
  `idPelicula` int(11) NOT NULL,
  `voto` decimal(10,2) NOT NULL,
  `timestamp` int(11) NOT NULL,
  KEY `idUsuario` (`idUsuario`),
  KEY `idPelicula` (`idPelicula`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

UPDATE #__USERS SET name=id;