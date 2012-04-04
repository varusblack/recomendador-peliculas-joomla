<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title></title>
    </head>
    <body>
        <?php
        set_time_limit(600);
        echo "<p>" . time();
        if (!$mysql = new mysqli('localhost', 'root', '', 'peliculas')) {
            die("Error en la conexión a la nueva base de datos");
        }

        $mysql->autocommit(true);

        $votos = fopen($_SERVER["DOCUMENT_ROOT"] . "/queveo/datosAImportar/ml-10M100K/ratings.dat", "r");
        while (!feof($votos)) {
            echo "<p>";
            $lineaVotos = fgets($votos);
//            $voto = explode("::", $lineaVotos);
//            $usuario = $voto[0];
//            $pelicula = $voto[1];
//            $nota = $voto[2];
//            $tiempo = $voto[3];

//            $consulta = "INSERT INTO votos SET idUsuario=$usuario,idPelicula=$pelicula,voto='$nota',timestamp=$tiempo";
//            
//            $mysql->query($consulta);
        }
        echo "<p>" . time();
        ?>
    </body>
</html>
