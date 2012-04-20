<?php

defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.controller');

class PeliculasControllerFilms extends JController{
	
	function __construct($config = array()){
		parent::__construct($config);
		$this->addModelPath(JPATH_COMPONENT_ADMINISTRATOR . DS .  'films');
	}
	
	function display(){
		$modelo = $this->getModel("films");
		$films = $modelo->obtenerPeliculasLimites();
		
		$modelo2 = $this->getModel("famosos");
		$famosos = $modelo2->obtenerTodosLosFamosos();
		
		$vista = $this->getView("films","html");
		$pagination = $modelo->getPagination();
		$vista->assignRef("pagination", $pagination);
		$vista->assignRef("films",$films);
		$vista->assignRef("famosos",$famosos);
		$vista->display();
	}
	
	function edit(){
		$cid = JRequest::getVar("cid",0,"","array");
        $modelo = $this->getModel("films");
        $film = $modelo->obtenerPeliculaPorId($cid[0]);
		
		$modelo2 = $this->getModel("famosos");
		$director = $modelo2->obtenerFamosoPorId($film["idDirector"]);
		$famosos = $modelo2->obtenerTodosLosFamosos();

        $vista = $this->getView("films","html");
        $vista->assignRef("films", $film);
		$vista->assignRef("famosos",$famosos);
		$vista->assignRef("director",$director);
        $vista->edit();
	}
	
	function remove(){
        $modelo = $this->getModel("films");
		$cid = JRequest::getVar("cid","","array");
		
		$correcto = true;
		foreach ($cid as $id) {
            $resultado = $modelo->borrarPelicula($id);
            if (!$resultado) {
                $correcto = false;
            }
        }
		
		if ($correcto) {
            $aviso = "Se realizaron los cambios";
        } else {
            $aviso = "Error al actualizar";
        }

        $enlace = "index.php?option=com_peliculas&controller=films";
        $this->setRedirect($enlace, $aviso);
	}
	
	function save(){
		$id = JRequest::getVar("id");
		$titulo = JRequest::getVar("titulo");
		$anno = JRequest::getVar("anno");
		$videoRelease = JRequest::getVar("videoRelease");
		$imdbUrl = JRequest::getVar("imdbUrl"); 
		$titulo2 = JRequest::getVar("titulo2");
		$tituloEsp = JRequest::getVar("tituloEsp");
		$urlCartel = JRequest::getVar("urlCartel");
		$idDirector = JRequest::getVar("idDirector");
		
		$modelo = $this->getModel("films");
		
		if($id != ""){
			$correcto = $modelo->actualizarPelicula($idPelicula,$titulo,$anno,$videoRelease,$imdbUrl,$titulo2,$tituloEsp,$urlCartel,$idDirector);
			if($correcto){
				$aviso = "La actualización se ha realizado con exito";
			}else{
				$aviso = "Error en la actualizacion";
			}
		}else{
			$correcto = $modelo->insertarPelicula($titulo,$anno,$videoRelease,$imdbUrl,$titulo2,$tituloEsp,$urlCartel,$idDirector);
			if($correcto){
				$aviso = "La insercion se ha realizado con exito";
			}else{
				$aviso = "Error en la insercion";
			}
		}
		
		$enlace = 'index.php?option=com_peliculas&controller=films';
        $this->setRedirect($enlace, $aviso);
	}
	
	function add() {
        $vista = $this->getView('films', 'html');
		$modelo2 = $this->getModel("famosos");
		$famosos = $modelo2->obtenerTodosLosFamosos();
		$vista->assignRef("famosos",$famosos);
        $vista->add();
    }
	
}

?>