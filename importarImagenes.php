<?php
	set_time_limit(6000);


	$link = mysqli_connect("localhost", "root", "", "peliculas");
	
	if (mysqli_connect_errno()) {
	    printf("Connect failed: %s\n", mysqli_connect_error());
	    exit();
	}
	
	$consultaSQL = "SELECT id,urlCartel FROM peliculas";
	// $result = $mysql->query($consultaSQL);
	
	if ($result = mysqli_query($link, $consultaSQL)) {


    while ($obj = mysqli_fetch_object($result)) {
		
        $idPelicula = $obj->id;
		$URLImagen = $obj->urlCartel;
		
		if(!strlen($URLImagen)==0 && !$URLImagen==NULL){
			$cadenas = explode("SY", $URLImagen);
			
			$tamannoExtension = "SY1000.jpg";
			$URLFinal = $cadenas[0].$tamannoExtension;
			
			save_img($URLFinal, $idPelicula);			
		}
		
		
		
    }
    mysqli_free_result($result);
}
	
	
	
	




// save_img("http://www.bbc.co.uk/blogs/spanish/ravsberg_442x330jpg.jpg","fool");


function save_img($image,$name) {
    
    $img_file = file_get_contents($image);

    $image_path = parse_url($image);
    $img_path_parts = pathinfo($image_path['path']);
    
    // $filename = $img_path_parts['filename'];
    $filename = $name;
    $img_ext = $img_path_parts['extension'];

    $path = "imagenes/";
    $filex = $path . $filename . "." .$img_ext;
    $fh = fopen($filex, 'w');
    fputs($fh, $img_file);
    fclose($fh);
    return filesize($filex);
} 

?>