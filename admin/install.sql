DROP TABLE IF EXISTS `#__libros`;

CREATE TABLE IF NOT EXISTS `#__libros` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `titulo` varchar(300) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Volcado de datos para la tabla `libros`
--

INSERT INTO `#__libros` (`titulo`) VALUES
('Don Quijote de la Mancha'),
('Fortunata y Jacinta'),
('La celestina'),
('La regenta');