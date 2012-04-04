<?php


set_time_limit(6000);

if (!$mysql = new mysqli('localhost', 'root', '', 'peliculas')) {
    die("Error en la conexión a la nueva base de datos");
}

$mysql->autocommit(true);

$consultasql = "SELECT * FROM peliculas where IMDBurl=''";
$resultado = $mysql->query($consultasql);

while ($registro = $resultado->fetch_object()) {
    echo "$registro->titulo";

    $ch = curl_init();
    $direccion = "http://www.imdb.com/find?q=" . urlencode($registro->titulo2) . "&s=tt";
    echo "<br>";
    echo $direccion;
    curl_setopt($ch, CURLOPT_URL, $direccion);
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $res = curl_exec($ch);
    curl_close($ch);
    $pos1 = strpos($res, "Media from");
    $pos1 = strpos($res, "\"", $pos1);
    $pos2 = strpos($res, "onclick", $pos1);
    $url = "http://www.imdb.com" . substr($res, $pos1 + 1, $pos2 - $pos1 - 3);
    echo "<br>";
    echo htmlentities($url);
    echo "<hr>";
        $consultasql = "UPDATE peliculas SET IMDBurl='" . $mysql->real_escape_string($url) . "' WHERE id=$registro->id";
    
    $mysql->query($consultasql);
}
?>