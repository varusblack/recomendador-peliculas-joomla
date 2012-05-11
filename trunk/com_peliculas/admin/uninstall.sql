DROP TABLE IF EXISTS `#__categoriasPeliculas`;
DROP TABLE IF EXISTS `#__famosos`;
DROP TABLE IF EXISTS `#__categorias`;
DROP TABLE IF EXISTS `#__actorespelicula`;
DROP TABLE IF EXISTS `#__peliculas`;
DELETE FROM `#__users`WHERE id>100000;
ALTER TABLE `#__users`  DROP `vector`;
DROP TABLE IF EXISTS `#__votos`;