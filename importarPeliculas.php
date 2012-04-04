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

        $mysql->autocommit(false);

        $peliculas = fopen($_SERVER["DOCUMENT_ROOT"] . "/queveo/datosAImportar/ml-10M100K/movies.dat", "r");
        while (!feof($peliculas)) {
            echo "<p>";
            $lineaLeida = fgets($peliculas);
            $pelicula = explode("::", $lineaLeida);
            $idPelicula = $pelicula[0];
            $tituloPelicula = $mysql->real_escape_string(trim(substr($pelicula[1], 0, strlen($pelicula[1]) - 6)));
            $añoPelicula = substr($pelicula[1], -5, 4);
            $categorias = explode("|", $pelicula[2]);

            $consulta = "INSERT INTO peliculas SET id=$idPelicula,titulo='$tituloPelicula',anno=$añoPelicula";
            $resultado = $mysql->query($consulta);
            if (!$resultado)
                die($mysql->error . $consulta);

            foreach ($categorias as $cat) {
                $consulta = "SELECT * FROM categorias WHERE categoria='$cat'";
                $resultado = $mysql->query($consulta);
                if (!$resultado)
                    die($mysql->error . $consulta);
                if ($resultado->num_rows > 0) {
                    $registro = $resultado->fetch_object();
                    $idCategoria = $registro->id;
                } else {
                    $consulta = "INSERT INTO categorias SET categoria='$cat'";
                    $resultado = $mysql->query($consulta);
                    if (!$resultado)
                        die($mysql->error . $consulta);
                    $idCategoria=$mysql->insert_id;
                }
                $consulta="INSERT INTO categoriaspeliculas SET idPelicula=$idPelicula,idCategoria=$idCategoria";
                $resultado = $mysql->query($consulta);
                if (!$resultado)
                        die($mysql->error . $consulta);
            }

            $mysql->commit();
            echo "$idPelicula - $tituloPelicula - $añoPelicula - ";
            print_r($categorias);
        }

        echo "<p>" . time();
        ?>
    </body>
</html>
