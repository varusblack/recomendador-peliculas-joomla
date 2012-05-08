<?php

defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.model');

class PeliculasModelVotacionesPelicula extends JModel {
	
	
	
	function votarPelicula ($idUsuario, $idPelicula, $puntuacion) {
		$timestamp = time();
		$db = &JFactory::getDbo();
		$query = "INSERT INTO #__votos SET idUsuario='{$idUsuario}', idPelicula='{$idPelicula}', voto='{$puntuacion}', timestamp='{$timestamp}'";
		$db->setQuery($query);
        $db->query();

        if ($db->getErrorNum()) {
            return false;
        } else {
            return true;
        }
	}
	
	function actualizarVoto ($idUsuario, $idPelicula, $puntuacion){
		$timestamp = time();
		$db = &JFactory::getDbo();
		$query = "UPDATE #__votos SET voto='{$puntuacion}', timestamp='{$timestamp}' WHERE idUsuario='{$idUsuario}' AND idPelicula='{$idPelicula}'";
		$db->setQuery($query);
        $db->query();

        if ($db->getErrorNum()) {
            return false;
        } else {
            return true;
        }
	}
	
	function borrarVotosPorPelicula ($idPelicula){
		$db = &JFactory::getDbo();
		$query = "DELETE FROM #__votos WHERE idPelicula='{$idPelicula}'";
		$db->setQuery($query);
        $db->query();

        if ($db->getErrorNum()) {
            return false;
        } else {
            return true;
        }
	}
	
	function borrarVotosPorUsuario ($idUsuario){
		$db = &JFactory::getDbo();
		$query = "DELETE FROM #__votos WHERE idUsuario='{$idUsuario}'";
		$db->setQuery($query);
        $db->query();

        if ($db->getErrorNum()) {
            return false;
        } else {
            return true;
        }
	}
	
	function obtenerPeliculasVotadasPorUsuario ($idUsuario) {
		$db = &JFactory::getDbo();
// 		Devuelve: id,titulo,anno,videoRelease,tituloEspanol,director,puntuacion,timestamp
        $query = "SELECT #__peliculas.id AS id, #__peliculas.titulo AS titulo, #__peliculas.anno AS anno, #__peliculas.videoRelease AS videoRelease, #__peliculas.tituloEspanol AS tituloEspanol,#__famosos.nombre AS director, #__votos.voto AS puntuacion, #__votos.timestamp AS timestamp FROM #__votos INNER JOIN #__peliculas ON #__votos.idPelicula=#__peliculas.id INNER JOIN #__famosos ON #__peliculas.idDirector=#__famosos.id WHERE #__votos.idUsuario='{$idUsuario}'";
        $db->setQuery($query);
        return $db->loadAssocList();
	}
	
	function obtenerPeliculasAleatoriasNoVotadasPorUsuario ($idUsuario) {
		$db = &JFactory::getDbo();
// 		Devuelve: id,titulo,anno,videoRelease,tituloEspanol,director
        $query = "SELECT #__peliculas.id AS id, #__peliculas.titulo AS titulo, #__peliculas.anno AS anno,  #__peliculas.videoRelease AS videoRelease, #__peliculas.tituloEspanol AS tituloEspanol, #__famosos.nombre AS director FROM #__peliculas LEFT JOIN #__famosos ON #__famosos.id=#__peliculas.idDirector WHERE #__peliculas.id NOT IN (SELECT idPelicula FROM #__votos WHERE idUsuario='{$idUsuario}') ORDER BY RAND() LIMIT 10";
        $db->setQuery($query);
        return $db->loadAssocList();
	}


}

?>