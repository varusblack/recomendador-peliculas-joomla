CREATE TABLE IF NOT EXISTS `#__categorias` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `categoria` varchar(100) COLLATE utf8_spanish2_ci NOT NULL,
  PRIMARY KEY (`id`)
);
INSERT INTO `#__categorias`(`categoria`) VALUES 
(' '),
('Gore');

CREATE TABLE IF NOT EXISTS `#__famosos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `nombre` (`nombre`)
) ;

INSERT INTO `#__famosos`(`nombre`) VALUES 
(' '),
('Quentin Tarantino'),
('Leonardo Dicaprio');

CREATE TABLE IF NOT EXISTS `#__peliculas` (
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

CREATE TABLE IF NOT EXISTS `#__categoriaspeliculas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `idPelicula` int(11) NOT NULL,
  `idCategoria` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `idPelicula` (`idPelicula`,`idCategoria`),
  KEY `idCategoria` (`idCategoria`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci AUTO_INCREMENT=7453 ;

INSERT INTO `#__categoriaspeliculas`(`idPelicula`,`idCategoria`) VALUES (3,1);

CREATE TABLE IF NOT EXISTS `#__actorespelicula` (
`id` int(11) NOT NULL AUTO_INCREMENT,
  `idFamoso` int(11) NOT NULL,
  `idPelicula` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `famosoPelicula` (`idFamoso`,`idPelicula`),
  KEY `idFamoso` (`idFamoso`),
  KEY `idPelicula` (`idPelicula`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=23972 ;
