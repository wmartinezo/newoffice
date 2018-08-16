<?php

$p_activa=str_replace("","",$_SERVER['PHP_SELF']);

$web_actual = "http://".$_SERVER['SERVER_NAME'] . ":" . $_SERVER['SERVER_PORT']  . str_replace("&","[_amp_]",$_SERVER['REQUEST_URI']);

if(preg_match('/(?i)msie/',$_SERVER['HTTP_USER_AGENT']))
{
    echo("Navegador no soportado, favor modernizate!");
    die();
}

$l1_activo="";
$l2_activo="";
$l3_activo="";
$l4_activo="";
$l5_activo="";
$l6_activo="";
$l7_activo="";



if (strpos("off".$p_activa,"index.php")>="2"){$l1_activo=" class='active'";}
if (strpos("off".$p_activa,"clientes.php")>="2"){$l2_activo=" class='active'";}
if (strpos("off".$p_activa,"inventario.php")>="2"){$l3_activo=" class='active'";}
if (strpos("off".$p_activa,"gestion.php")>="2"){$l4_activo=" class='active'";}
if (strpos("off".$p_activa,"usuarios.php")>="2"){$l5_activo=" class='active'";}
if (strpos("off".$p_activa,"telegram.php")>="2"){$l6_activo=" class='active'";}
if (strpos("off".$p_activa,"configuracion.php")>="2"){$l7_activo=" class='active'";}

echo "<table border=0 width='100%'><tr><th valign=bottom>";
echo "<div id='cssmenu'>";
echo "<ul>";
echo "   <li><a href='index.php'><img src='images/logo.png' style='width:100px'></a></li>";
echo "   <li $l1_activo><a href='index.php'><span>Principal</span></a></li>";
echo "   <li $l2_activo><a href='clientes.php'><span>Clientes</span></a></li>";
echo "   <li $l3_activo><a href='inventario.php'><span>Inventario</span></a></li>";
echo "   <li $l4_activo><a href='gestion.php'><span>Gestion</span></a></li>";
echo "   <li $l5_activo><a href='usuarios.php'><span>Usuarios</span></a></li>";
echo "   <li $l6_activo><a href='telegram.php'><span>Telegram</span></a></li>";
echo "   <li $l7_activo><a href='configuracion.php'><span>Configuracion</span></a></li>";

echo "</ul>";
echo "</div></th></tr></table>";


echo "<img src='images/logo_mini.png' style='position: fixed; _position: absolute; bottom: 0px; right: 0px; _top:expression(eval(document.body.scrollTop));'>";

// gethostbyaddr($_SERVER['REMOTE_ADDR'])

echo "<table border='0' style='position: absolute; top: 0px; left: 0px; background: #EEEEEE; opacity:0.6;'>";
echo "<tr><td>";
echo "<a href='include/cerrar_sesion.php'><b><img src='images/cerrar.png' border=0 style='vertical-align:middle;width:15px'></b></a><font class='font-titulo'> Usuario: $global_userOs desde IP: ".$_SERVER['REMOTE_ADDR']." </font></td>";
echo "</tr>";
echo "</table>";

?>
