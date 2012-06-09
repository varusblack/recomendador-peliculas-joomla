function objetoAjax(){
    var xmlhttp=false;
    try {
        xmlhttp = new ActiveXObject("Msxml2.XMLHTTP");
    }
    catch (e) {
        try {
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        catch (E) {
            xmlhttp = false;
        }
    }
    if (!xmlhttp && typeof XMLHttpRequest!='undefined') {
        xmlhttp = new XMLHttpRequest();
    }
    return xmlhttp;
}

function votar(idPelicula,voto){

    ajax=objetoAjax();
    url="index.php?option=com_peliculas&task=votarUnaPelicula&pelicula="+idPelicula+"&voto="+voto;
	alert(url);
    ajax.open("GET",url,true) ;
    ajax.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    ajax.setRequestHeader("encoding", "ISO-8859-1");
	ajax.onreadystatechange=stateChangedVoto;
    ajax.send();
	
	
 }
 
 function stateChangedVoto(){

    if (ajax.readyState==4 || ajax.readyState=="complete"){

        res=ajax.responseText;
		alert(res);
		}
    else {
    //alert(xmlHttp.status);
    }
}
