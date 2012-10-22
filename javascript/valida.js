
function operacion(pagina,id)
{
    document.forms.form1.id.value=id;
	document.forms.form1.method='post';
	document.forms.form1.action=pagina;
	document.forms.form1.submit();
}

function  operacion_get(pagina,id)
{
    document.forms.form1.id.value=id;
	document.forms.form1.method='get';
	document.forms.form1.action=pagina;
	document.forms.form1.submit();
}

function centrar_pagina() { 
    iz=(screen.width-document.body.clientWidth) / 2; 
    de=(screen.height-document.body.clientHeight) / 2; 
    moveTo(iz,de); 
}
function Esnum(obj)
{
	var checkChr= "0123456789";
	var checkStr=obj;
	var allvalid=true;
	for (i=0;i < checkStr.length;i++ )
	{
		ch =checkStr.charAt(i);
		for (j=0; j< checkChr.length; j++)
		{
			if (ch==checkChr.charAt(j))
			break;
			if (ch==".")
			break;

		}	
		if (j==checkChr.length){
		allvalid=false;
		break;
		}
	}
	return allvalid;
}

function nuevoAjax()
{ 
	/* Crea el objeto AJAX. Esta funcion es generica para cualquier utilidad de este tipo, por
	lo que se puede copiar tal como esta aqui */
	var xmlhttp=false; 
	try 
	{ 
		// Creacion del objeto AJAX para navegadores no IE
		xmlhttp=new ActiveXObject("Msxml2.XMLHTTP"); 
	}
	catch(e)
	{ 
		try
		{ 
			// Creacion del objet AJAX para IE 
			xmlhttp=new ActiveXObject("Microsoft.XMLHTTP"); 
		} 
		catch(E) { xmlhttp=false; }
	}
	if (!xmlhttp && typeof XMLHttpRequest!='undefined') { xmlhttp=new XMLHttpRequest(); } 

	return xmlhttp; 
}



function IsNumeric(valor)
{
var log=valor.length; var sw="S";
for (x=0; x<log; x++)
{ v1=valor.substr(x,1);
v2 = parseInt(v1);
//Compruebo si es un valor numérico
if (isNaN(v2)) { sw= "N";}
}
if (sw=="S") {return true;} else {return false; }
}

var primerslap=false;
var segundoslap=false;
function formateafecha(fecha)
{
var long = fecha.length;
var dia;
var mes;
var ano;

if ((long>=2) && (primerslap==false)) { dia=fecha.substr(0,2);
if ((IsNumeric(dia)==true) && (dia<=31) && (dia!="00")) { fecha=fecha.substr(0,2)+"/"+fecha.substr(3,7); primerslap=true; }
else { fecha=""; primerslap=false;}
}
else
{ dia=fecha.substr(0,1);
if (IsNumeric(dia)==false)
{fecha="";}
if ((long<=2) && (primerslap=true)) {fecha=fecha.substr(0,1); primerslap=false; }
}
if ((long>=5) && (segundoslap==false))
{ mes=fecha.substr(3,2);
if ((IsNumeric(mes)==true) &&(mes<=12) && (mes!="00")) { fecha=fecha.substr(0,5)+"/"+fecha.substr(6,4); segundoslap=true; }
else { fecha=fecha.substr(0,3);; segundoslap=false;}
}
else { if ((long<=5) && (segundoslap=true)) { fecha=fecha.substr(0,4); segundoslap=false; } }
if (long>=7)
{ ano=fecha.substr(6,4);
if (IsNumeric(ano)==false) { fecha=fecha.substr(0,6); }
else { if (long==10){ if ((ano==0) || (ano<1900) || (ano>2100)) { fecha=fecha.substr(0,6); } } }
}

if (long>=10)
{
fecha=fecha.substr(0,10);
dia=fecha.substr(0,2);
mes=fecha.substr(3,2);
ano=fecha.substr(6,4);
// Año no viciesto y es febrero y el dia es mayor a 28
if ( (ano%4 != 0) && (mes ==02) && (dia > 28) ) { fecha=fecha.substr(0,2)+"/"; }
}
return (fecha);
} 


function Esnum(obj)
{
var checkChr= "0123456789";
var checkStr=obj;
var allvalid=true;
for (i=0;i < checkStr.length;i++ )
{
ch =checkStr.charAt(i);
for (j=0; j< checkChr.length; j++)
{
	if (ch==checkChr.charAt(j))
	break;
	if (ch==".")
	break;

}	
	if (j==checkChr.length){
	allvalid=false;
	break;
	}
}
return allvalid;
}


//convertir mayusculas
function pasarMayusculas(cadena) {
    var result="";
    var str = cadena.split('');
 
    for(i=0; i<=str.length-1; i++) {
        str[i] = str[i].toUpperCase();
        result+=str[i];
    }
    //alert(result); 
	return result;
}

function mayusculas(obj){
	obj.value=obj.value.toUpperCase();
}



//funcion que controla los enters como tabs en la cajas de texto

function fn(form,field)
{
var next=0, found=false
var f=form
if(event.keyCode!=13) return;
for(var i=0;i<f.length;i++) {
if(field.name==f.item(i).name){
next=i+1;
found=true
break;
}
}
while(found){
if( f.item(next).disabled==false && f.item(next).type!='hidden'){
f.item(next).focus();
break;
}
else{
if(next<f.length-1)
next=next+1;
else
break;
}
}
}

//valiudar fechas
function esDigito(sChr){ 
    var sCod = sChr.charCodeAt(0); 
    return ((sCod > 47) && (sCod < 58)); 
   } 

   function valSep(oTxt){ 
    var bOk = false; 
    var sep1 = oTxt.value.charAt(2); 
    var sep2 = oTxt.value.charAt(5); 
    bOk = bOk || ((sep1 == "-") && (sep2 == "-")); 
    bOk = bOk || ((sep1 == "/") && (sep2 == "/")); 
    return bOk; 
   } 

   function finMes(oTxt){ 
    var nMes = parseInt(oTxt.value.substr(3, 2), 10); 
    var nAno = parseInt(oTxt.value.substr(6), 10); 
    var nRes = 0; 
    switch (nMes){ 
     case 1: nRes = 31; break; 
     case 2: nRes = 28; break; 
     case 3: nRes = 31; break; 
     case 4: nRes = 30; break; 
     case 5: nRes = 31; break; 
     case 6: nRes = 30; break; 
     case 7: nRes = 31; break; 
     case 8: nRes = 31; break; 
     case 9: nRes = 30; break; 
     case 10: nRes = 31; break; 
     case 11: nRes = 30; break; 
     case 12: nRes = 31; break; 
    } 
    return nRes + (((nMes == 2) && (nAno % 4) == 0)? 1: 0); 
   } 

   function valDia(oTxt){ 
    var bOk = false; 
    var nDia = parseInt(oTxt.value.substr(0, 2), 10); 
    bOk = bOk || ((nDia >= 1) && (nDia <= finMes(oTxt))); 
    return bOk; 
   } 

   function valMes(oTxt){ 
    var bOk = false; 
    var nMes = parseInt(oTxt.value.substr(3, 2), 10); 
    bOk = bOk || ((nMes >= 1) && (nMes <= 12)); 
    return bOk; 
   } 

   function valAno(oTxt){ 
    var bOk = true; 
    var nAno = oTxt.value.substr(6); 
    bOk = bOk && ((nAno.length == 2) || (nAno.length == 4)); 
    if (bOk){ 
     for (var i = 0; i < nAno.length; i++){ 
      bOk = bOk && esDigito(nAno.charAt(i)); 
     } 
    } 
    return bOk; 
   } 

   function valFecha(oTxt){ 
    var bOk = true; 
    if (oTxt.value != ""){ 
     bOk = bOk && (valAno(oTxt)); 
     bOk = bOk && (valMes(oTxt)); 
     bOk = bOk && (valDia(oTxt)); 
     bOk = bOk && (valSep(oTxt)); 
     if (!bOk){ 
      alert("Fecha inválida"); 
      oTxt.value = ""; 
      oTxt.focus(); 
     } else alert("Fecha correcta"); 
    } 
   } 

//validar email

function validar_email() 
{ 
	if (document.forms.form1.email.value != "")
	{
		
		if (document.forms.form1.email.value.indexOf('@') == -1)
		{ 
			alert ("Debes colocar una \"Dirección de Email\" válida"); 
			document.forms.form1.email.focus(); //Esto recorna el cursor al campo "Email" 
		}
		else
		{ 
//document.form1.submit(); 
		}
	}	
} 
