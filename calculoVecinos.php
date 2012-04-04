<?php
$mysql = new mysqli('localhost', 'root', '', 'peliculas');
if (!$mysql) {
        die("Error en la conexión a la nueva base de datos");
    }
$vecinos=calculaVecinos(98);
foreach($vecinos as $id=>$distancia){
    echo "<br>$id --> $distancia";
}

    
    
function calculaVecinos($idUsuario) {
    global $mysql;
    
    echo "<p>" . time() . "Empieza la ejecución";
    if (!$mysql = new mysqli('localhost', 'root', '', 'peliculas')) {
        die("Error en la conexión a la nueva base de datos");
    }
    $consulta = "SELECT * FROM usuarios WHERE id=$idUsuario";
    $resultado = $mysql->query($consulta);
    if (!$resultado)
        die("$mysql->error - $consulta");



    $usuario = $resultado->fetch_object(); //El usuario en cuestión
    echo "<p>" . time() . "Recuperado el usuario";


    $misVotosArray = array();
    $consulta = "SELECT * FROM votos WHERE idUsuario=$idUsuario";
    $resultadoMisVotos = $mysql->query($consulta);
    if (!$resultadoMisVotos)
        die("$mysql->error - $consulta");   //Las peliculas a las que el usuario ha votado

    $usuariosConVotos = array();
    while ($misVotos = $resultadoMisVotos->fetch_object()) {

        $misVotosArray[$misVotos->idPelicula] = $misVotos->voto;

        $consultasql = "SELECT * FROM votos WHERE idPelicula=$misVotos->idPelicula and idUsuario!=$idUsuario";
        $resultadoTusVotos = $mysql->query($consultasql);
        if (!$resultadoTusVotos)
            die("$mysql->error - $consultasql");
        while ($registroTusVotos = $resultadoTusVotos->fetch_object()) {

            $usuariosConVotos[$registroTusVotos->idUsuario] = null;  //Almacena todos los usuarios que han votados a mis peliculas
        }
    }
    echo "<p>" . time() . "Calculados los usuarios que han votado lo mismo que yo";


    $distancias = array();
    $peliculasNoVistas = array();


    foreach ($usuariosConVotos as $id => $valor) {
        $peliculasNoVistasUsuario = array();
        $numerador = 0;
        $consultasql = "SELECT * FROM usuarios WHERE id=$id ";
        $resultado = $mysql->query($consultasql);
        if (!$resultado)
            die("$mysql->error - $consultasql");
        $registro = $resultado->fetch_object();
        $usuariosConVotos[$id]["longitudVector"] = $registro->longitudVector;

        $consultasql = "SELECT * FROM votos WHERE idUsuario=$id";
        $resultado = $mysql->query($consultasql);
        if (!$resultado)
            die("$mysql->error - $consultasql");
        while ($registro = $resultado->fetch_object()) {
            if (isset($misVotosArray[$registro->idPelicula])) {
                $numerador+=$misVotosArray[$registro->idPelicula] * $registro->voto;
            } 
        }

        $usuariosConVotos[$id]["numerador"] = $numerador;
        $usuariosConVotos[$id]["denominador"] = $usuario->longitudVector * $usuariosConVotos[$id]["longitudVector"];
        $usuariosConVotos[$id]["fraccion"] = $usuariosConVotos[$id]["numerador"] / $usuariosConVotos[$id]["denominador"];

        if ($usuariosConVotos[$id]["fraccion"] > 0.30) {
            $distancias[$id] = $usuariosConVotos[$id]["fraccion"];
            
        }
    }

    echo "<p>" . time() . "Calculadas las distancias";

    arsort($distancias);
    return $distancias;
    echo "<p>" . time() . "Fin de la ejecución";
    
}

?>
