// JavaScript Document
function borrarEvento(id,p,key){
	var pregunta = 'Esta seguro de querer borrar este evento?';
	if(confirm(pregunta)){
		window.location = "agenda_lista.php?accion=borrar&id=" + id + "&p=" + p + "&key=" + key;
	}
}