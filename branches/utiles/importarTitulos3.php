<?php

set_time_limit(6000);

if (!$mysql = new mysqli('localhost', 'root', '', 'peliculas')) {
    die("Error en la conexión a la nueva base de datos");
}

$mysql->autocommit(true);

$consultasql = "SELECT * FROM peliculas WHERE tituloEspanol=''";
$resultado = $mysql->query($consultasql);
if (!$resultado)
    die($mysql->error);

while ($registro = $resultado->fetch_object()) {

    $ch = curl_init();
    $direccion = "$registro->IMDBurl";
    curl_setopt($ch, CURLOPT_URL, $direccion);
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    //curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    $res = curl_exec($ch);

    $pos1 = strpos($res, "<h1");
    $pos1 = strpos($res, ">", $pos1);
    $pos2 = strpos($res, "<span", $pos1);
    $titulo = trim(substr($res, $pos1 + 1, $pos2 - $pos1 - 1));

    $pos1 = strpos($res, "<img src=\"http://ia.media-imdb.com/images");
    if ($pos1) {
        $pos1 = strpos($res, "http", $pos1);
        $pos2 = strpos($res, ".jpg", $pos1);
        $imagen = trim(substr($res, $pos1, $pos2 - $pos1 + 4));
    } else {
        $imagen = null;
    }

    $pos1 = strpos($res, "Director");
    $pos1 = strpos($res, "<a", $pos1);
    $pos1 = strpos($res, ">", $pos1);
    $pos2 = strpos($res, "</a>", $pos1);
    $director = trim(substr($res, $pos1 + 1, $pos2 - $pos1 - 1));

    $pos1 = strpos($res, "Cast overview, first billed only:");
    $actores = array();
    $arrayActores = explode("<td class=\"name\">", $res);
    for ($i = 1; $i < count($arrayActores); $i++) {
        $pos1 = strpos($arrayActores[$i], ">");
        $pos2 = strpos($arrayActores[$i], "<", $pos1);
        $actor = trim(substr($arrayActores[$i], $pos1 + 1, $pos2 - $pos1 - 1));
        $actores[] = trim(htmlentities($actor));
    }

    echo "<br>";
    echo htmlentities($titulo);
    echo "<br>";
    echo htmlentities($imagen);
    echo "<br>";
    echo "Director: " . htmlentities($director);
    echo "<br>";
    print_r($actores);

    $consultasql = "SELECT * FROM persona WHERE nombre='".$mysql->real_escape_string($director)."'";
    $resultadoDirector = $mysql->query($consultasql);
    echo $consultasql."¿Existe el director?";
    if (!$resultadoDirector)
        die($mysql->error);
    if ($resultadoDirector->num_rows > 0) {
        $registroDirector = $resultadoDirector->fetch_object();
        $idDirector = $registroDirector->id;
    } else {
        $consultasql = "INSERT INTO persona SET nombre='" . $mysql->real_escape_string($director) . "'";
        echo $consultasql." Insertando director";
        $resu = $mysql->query($consultasql);
        if (!$resu)
            die($mysql->error);
        $idDirector = $mysql->insert_id;
    }


    $consultasql = "UPDATE peliculas SET tituloEspanol='" . $mysql->real_escape_string($titulo) . "',urlCartel='" . $mysql->real_escape_string($imagen) . "',idDirector=$idDirector WHERE id=$registro->id";
    $resu = $mysql->query($consultasql);
    if (!$resu)
        die($mysql->error);

    $consultasql = "INSERT INTO paginasIMDB SET id=$registro->id,paginaIMDB='" . $mysql->real_escape_string($res)."'";
    $resu = $mysql->query($consultasql);
    if (!$resu)
        die($mysql->error);

    foreach ($actores as $actor) {
        $consultasql = "SELECT * FROM persona WHERE nombre='".$mysql->real_escape_string($actor)."'";
        $resultadoActores = $mysql->query($consultasql);
        echo $consultasql;
        if (!$resultadoActores)
            die($mysql->error.$consultasql);
        if ($resultadoActores->num_rows > 0) {
            $registroActores = $resultadoActores->fetch_object();
            $idActor = $registroActores->id;
        } else {
            $consultasql = "INSERT INTO persona SET nombre='" . $mysql->real_escape_string($actor) . "'";
            $resu = $mysql->query($consultasql);
            echo $consultasql;
            if (!$resu)
                die($mysql->error.$consultasql);
            $idActor = $mysql->insert_id;
        }
        $consultasql = "INSERT INTO actoresPelicula SET idPelicula=$registro->id,idPersona=$idActor";
        $resu = $mysql->query($consultasql);
        if (!$resu)
            die($mysql->error);
    }

    echo "<hr>";
//    $consultasql = "UPDATE peliculas SET IMDBurl='" . $mysql->real_escape_string($url) . "' WHERE id=$registro->id";
//
//    $mysql->query($consultasql);
}
?>