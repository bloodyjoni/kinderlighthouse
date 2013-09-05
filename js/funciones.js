// JavaScript Document
//var path = 'http://192.168.0.100/kinderlighthouse/';
var path = 'http://www.kinderlighthouse.info/';
var ori = "portrait";
var isReady = 0;
var ancho = 0;
var alto = 0;
var costados = 0;
var centro = 0;
var acceso = 2;
var user = '';
var pass = '';
var idClick = 0;
var uuid = '';
var tiempos = new Array();
var borrados = 0;
var entrada = 0;

$(function(){
	$('#bienvenidos').fadeTo(5, 0);
	setMedidas();
	var es = setTimeout("enterSite()",1100);
	
    if(window.orientation != 0){
        ori = "landscape";
    }else{
        ori = "portrait";
    }
    changeOrientation(ori);
    $('body').bind('orientationchange',function(event){
		changeOrientation(event.orientation);
    })
	
	$('body').live("pageshow", function(){
		changeOrientation(ori);
	});
	
	$('#home').live("pageshow", function(){
		setMedidas();
		changeOrientation(ori);
	});
		
	$('#bienvenidos').live("pageshow", function(){
		setMedidas();
		changeOrientation(ori);
	});
	
	$('#agenda').live("pageshow", function(){
		if(borrados == 1){
			cargoAgenda();
			borrados = 0;
		}
	});
	
	$('#agenda').live('pagecreate',function(event){
		cargoAgenda();
		var t = setTimeout("timerAgenda()",600000);
	});
	
	$('#ficha').live("pageshow", function(){
		$('#link' + idClick).removeClass('alerta');
		var url = path + 'servicios/evento.php?id=' + idClick + '&uuid=' + uuid;
		var xmlDoc = loadXMLDoc(url);
		
		var fechatitulo = document.getElementById('fechatitulo');
		if(xmlDoc.firstChild.childNodes[0].childNodes[3].firstChild.nodeValue == 1){
			fechatitulo.innerHTML = xmlDoc.firstChild.childNodes[0].childNodes[0].firstChild.nodeValue + ' ' + xmlDoc.firstChild.childNodes[0].childNodes[1].firstChild.nodeValue;
		}else{
			fechatitulo.innerHTML = xmlDoc.firstChild.childNodes[0].childNodes[1].firstChild.nodeValue;
		}
		var texto = document.getElementById('texto');
		texto.innerHTML = xmlDoc.firstChild.childNodes[0].childNodes[2].firstChild.nodeValue;
		if(xmlDoc.firstChild.childNodes[0].childNodes[3].firstChild.nodeValue == 0){
			borrados = 1;
		}
	});
	
    function changeOrientation(ori){
		if(ori == "portrait"){
			$('#landscape').css({display: 'none'});
			$('#portrait').css({display: 'block'});
		}else{
			$('#portrait').css({display: 'none'});
			$('#landscape').css({display: 'block'});
		}
		if(entrada == 0){
			$('#bienvenidos').fadeTo(100, 1);
			entrada = 1;
		}
		setMedidas();
    }
	
	$('#home').live('pageshow',function(){
		if(acceso != 1){
			var url = path + 'servicios/acceso.php?user=' + user + '&pass=' + pass + '&uuid=' + uuid;
			$('#resultado').load(url, function(){
				var resultado = $('#resultado').html();
				if(resultado == 'OK'){
					acceso = 1;
				}else{
					acceso = 2;
					history.go(-1);
				}
			});
		}
	});
})

function setMedidas(){
	ancho = screen.width;
	if(window.innerHeight){
		alto = window.innerHeight;
	}else{
		alto = document.body.clientHeight;
	}
	var wtable = ancho + 'px';
	var htable = (alto - 32) + 'px';
	
	document.getElementById('tablaDibujos').style.height = htable;
	
	costados = (ancho * 30) / 100;
	centro = (ancho * 40) / 100;
	
	loadImagenes();
}

function loadImagenes(){
	if(ori == "portrait"){
		$('#portrait').css({display: 'block'});
	}else{
		$('#landscape').css({display: 'block'});
	}
	
	var arbol = document.getElementById('arbol');
	var logo = document.getElementById('logo');
	var maiz = document.getElementById('maiz');
	var cerezas = document.getElementById('cerezas');
	var ardilla = document.getElementById('ardilla');
	var mariposa = document.getElementById('mariposa');
	var flor = document.getElementById('flor');
	var abeja = document.getElementById('abeja');
	
	arbol.width = costados;
	logo.width = centro;
	maiz.width = costados;
	cerezas.width = costados;
	ardilla.width = costados;
	mariposa.width = costados;
	flor.width = costados;
	abeja.width = costados;
	
	var pagina = document.getElementById('bienvenidos');
}

function setPass(){
	var input1 = document.getElementById('user');
	var input2 = document.getElementById('pass');
	user = input1.value;
	pass = input2.value;
}

function loadXMLDoc(dname){
	if(window.XMLHttpRequest){
		var xhttp = new XMLHttpRequest();
	}else{
		var xhttp = new ActiveXObject("Microsoft.XMLHTTP");
	}
	xhttp.open("GET", dname, false);
	xhttp.send();
	return xhttp.responseXML;
}

function getParameter(parameter){
	var respuesta;
	var url = location.href;
	var index = url.indexOf("?");
	index = url.indexOf(parameter,index) + parameter.length;
	if(url.charAt(index) == "="){
		var result = url.indexOf("&",index);
		if(result == -1){
			result=url.length;
		}
		respuesta = url.substring(index + 1,result);
	}
	return respuesta;
}

function cargoAgenda(){
	var url = path + 'servicios/calendario.php?uuid=' + uuid;
	var xmlDoc = loadXMLDoc(url);
	var listado = document.getElementById('listado');
	var contenido = '';
	var aviso = 0;
	//var cantidad = xmlDoc.childNodes.length;
	var links_tag = xmlDoc.getElementsByTagName("root")[0].getElementsByTagName("item");
	for(i=0;i<links_tag.length;i++){
		var fecha = links_tag[i].getElementsByTagName("fecha")[0].childNodes[0].nodeValue;
		var titulo = links_tag[i].getElementsByTagName("titulo")[0].childNodes[0].nodeValue;
		var leido = links_tag[i].getElementsByTagName("leido")[0].childNodes[0].nodeValue;
		if(leido == 1){
			var estilo = 'lista';
		}else{
			var estilo = 'lista alerta';
			aviso++;
		}
		contenido += '<a href="#ficha" data-transition="slide" class="' + estilo + '" onClick="linkClick(' + links_tag[i].getAttribute("id") + ')" id="link' + links_tag[i].getAttribute("id") + '">' + fecha + ' ' + titulo + '</a>';
	}
	if(contenido == ''){
		contenido = '<p class="lista">No hay noticias disponibles</p>';
	}
	listado.innerHTML = contenido;
	if(aviso > 0 && isReady == 1){
		playAudio("beep.wav");
		navigator.notification.beep(1);
		navigator.notification.vibrate(2000);
	}
}

function linkClick(id){
	idClick = id;
}

function onDeviceReady(){
	isReady = 1;
	uuid = device.uuid;
	checkUuid();
}

function checkUuid(){
	var url = path + 'servicios/uuid.php?uuid=' + uuid;
	$('#resultado').load(url, function(){
		var resultado = $('#resultado').html();
		if(resultado > 0){
			var ingresar = document.getElementById('ingresar');
			ingresar.href = '#home';
			acceso = 1;
		}
	});
}

function timerAgenda(){
	cargoAgenda();
	var t = setTimeout("timerAgenda()",600000);
}

function enterSite(){
	$('#onoffportrait').click();
}

function playAudio(url) {
    var my_media = new Media(url,
        function(){
            console.log("playAudio():Audio correcto");
        },
        function(err) {
            console.log("playAudio():Audio Error: "+err);
    });
    my_media.play();
}

document.addEventListener("deviceready", onDeviceReady, false);
