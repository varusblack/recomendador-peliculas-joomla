<?php
//Rechazado: Mucho más eficiente en mysql


set_time_limit(600);
echo "<p>" . time();
if (!$mysql = new mysqli('localhost', 'root', '', 'peliculas')) {
    die("Error en la conexión a la nueva base de datos");
}

$mysql->autocommit(false);
$idUsuario=1;
$consulta="SELECT * FROM usuarios WHERE longitudVector=0";
$resultadoUsuarios=$mysql->query($consulta);
if(!$resultadoUsuarios) die($mysql->error - $consulta);

$tablaVotos=array();

while($usuarios=$resultadoUsuarios->fetch_object()){
   echo "<p>";
   $sumaCuadrada=0;
   echo $usuarios->id. " - ";
   $consulta="SELECT * FROM votos WHERE idUsuario=$usuarios->id";
   $resultadoVotos=$mysql->query($consulta);
   if(!$resultadoVotos) die($mysql->error - $consulta);
   while($registroVotos=$resultadoVotos->fetch_object()){
       $sumaCuadrada+=$registroVotos->voto*$registroVotos->voto;
       $longitudVector=sqrt($sumaCuadrada);
   }
   $consulta="UPDATE usuarios SET longitudVector=$longitudVector WHERE id=$usuarios->id";
   $mysql->query($consulta);
   $mysql->commit();
   echo $sumaCuadrada." - ".$longitudVector;
}

echo "<p>" . time();
?>
