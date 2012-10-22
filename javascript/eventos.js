// JavaScript Document

function enviar_form($metodo,$pagina,$id)
{
	document.forms.form1.action=''+$pagina+'';
	document.forms.form1.method=''+$metodo+'';
	document.forms.form1.id.value=''+$id+'';
	document.forms.form1.submit();
}



function nueva_ventana(pagina,alto,ancho,valor)
{
	window.open(""+pagina+"?codigo="+valor, "ventana", "resizable,height="+alto+",width="+ancho+"");
}

function nueva_ventana_parametros(pagina_parametros,alto,ancho)
{
	window.open(""+pagina_parametros+"", "ventana", "resizable,height="+alto+",width="+ancho+"");
}

function centrar_pagina() 
{ 
    iz=(screen.width-document.body.clientWidth) / 2; 
    de=(screen.height-document.body.clientHeight) / 2; 
    moveTo(iz,de); 
}

function cerrar_ventana()
{
	window.close();
}

