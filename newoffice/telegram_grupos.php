<?php

include 'include/inicio_session.php';

?>

<html>
<head>
<link href="css/menu.css" rel="stylesheet" />


<meta charset=iso-8859-1 />
<link rel="icon" href="favicon.ico" type="image/x-icon">
<link rel="shortcut icon" href="favicon.ico" type="image/x-icon">

<title>Telegram Admin</title>

<link href="css/style.css" rel="stylesheet" type="text/css" />
<link href="css/font-awesome.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" href="css/jquery.lightbox.css"  />
<link rel="stylesheet" type="text/css" href="css/switch.css"  />

<script type="text/javascript" src="js/jquery.min.js"></script>
<script type="text/javascript" src="js/switch.js"></script>

<script type="text/javascript">
$(document).ready(function(e) {
	$('input').lc_switch();
});
</script>
<script type="text/javascript" src="js/jquery.lightbox.js"></script>
<script type="text/javascript">
    jQuery(document).ready(function(){
      jQuery('.lightbox').lightbox();
    });	
</script>
</head>
<body>
		  
<?php

include 'include/conexion.php';
include 'include/session.php';
include 'include/menu.php';


$noRegistros="1";

$f_nombre="";
$f_apellido="";
$f_telefono="";
$f_alias="";
$f_grupos="";
$f_ultimavez="";
$f_online="";
$f_estado="";

$g_nombre="";
$g_apellido="";
$g_telefono="";
$g_alias="";
$g_grupos="";
$g_ultimavez="";
$g_online="";
$g_estado="";


if (isset($_GET['f_nombre'])){
	$f_nombre=$_GET['f_nombre'];
	$g_nombre="f_nombre=".$_GET['f_nombre'];
}
if (isset($_GET['f_apellido'])){
	$f_apellido=$_GET['f_apellido'];
	$g_apellido="f_apellido=".$_GET['f_apellido'];
}
if (isset($_GET['f_telefono'])){
	$f_telefono=$_GET['f_telefono'];
	$g_telefono="f_telefono=".$_GET['f_telefono'];
}
if (isset($_GET['f_alias'])){
	$f_alias=$_GET['f_alias'];
	$g_alias="f_alias=".$_GET['f_alias'];
}
if (isset($_GET['f_grupos'])){
	$f_grupos=$_GET['f_grupos'];
	$g_grupos="f_grupos=".$_GET['f_grupos'];
}
if (isset($_GET['f_ultimavez'])){
	$f_ultimavez=$_GET['f_ultimavez'];
	$g_ultimavez="f_ultimavez=".$_GET['f_ultimavez'];
}

if (isset($_GET['f_online'])){
	$f_online=$_GET['f_online'];
	$g_online="f_online=".$_GET['f_online'];
}
if (isset($_GET['f_estado'])){
	$f_estado=$_GET['f_estado'];
	$g_estado="f_estado=".$_GET['f_estado'];
}



//	echo "<a href='layout_nuevo.php'><button id='agregar_layout' class='btn'><i class='icon-plus-sign'></i>Agregar Layout</button></a><br>";

$condicionurl="";

	$condicion=" id like '%' ";

	if ($f_nombre!=""){
		$condicion.="AND (grp_nombre like '%$f_nombre%') ";
	}
	if ($f_apellido!=""){
		$condicion.="AND (grp_integrantes like '%$f_apellido%') ";
	}
	if ($f_alias!=""){
		$condicion.="AND (grp_bot like '%$f_alias%') ";
	}
	if ($f_telefono!=""){
		$condicion.="AND (grp_icono like '%$f_telefono%') ";
	}

	$condicionurl="$condicion";
	$condicionurl=str_replace("%","|",$condicion);
	$condicionurl=urlencode($condicionurl);

	
	$boton="<a href='telegram.php'><button class='btn'><img src='images/contactos.png' style='width:32px;height:32px'><br>Contactos</button></a> ";
	$boton.="<a href='telegram_grupos.php'><button class='btn_red'><img src='images/grupos.png' style='width:32px;height:32px'><br>Grupos</button></a> ";
	$boton.="<a href='telegram_reglas.php'><button class='btn'><img src='images/reglas.png' style='width:32px;height:32px'><br>Reglas</button></a> ";


	$agregar_boton = "<a href='telegram_contacto_nuevo.php?lightbox[iframe]=true&lightbox[width]=500&lightbox[height]=240' class='lightbox'><button class='btn'><img src='images/agregar.png' style='vertical-align: middle;;width:20px;height:20px'>  Agregar</button></a>";


$tabla="NewOff_Grupos";


$Os_mysql_rp= "SELECT * FROM $tabla ORDER BY id ASC";
 
$Os_query_rp = $Os_mysql_rp or die("Error al consultar la base de datos" . mysqli_error($Os_link));
$Os_result_rp = $Os_link->query($Os_query_rp);

	
	include 'include/paginacion_telegram.php';
	
	echo "<form id='buscador' method='get' action='#'><table border=1 id='customers'><tr>";
	echo "<th>ID</th>";
	echo "<th>Nombre <br><input type='text' class='textbox' id='f_nombre' name='f_nombre' value='$f_nombre' size='10'></th>";
	echo "<th>Integrantes <br><input type='text' class='textbox' id='f_apellido' name='f_apellido' value='$f_apellido' size='10'></th>";
	echo "<th>Bot <br><input type='text' class='textbox' id='f_telefono' name='f_telefono' value='$f_telefono' size='10'></th>";
	echo "<th>Icono <br><input type='text' class='textbox' id='f_alias' name='f_alias' value='$f_alias' size='10'></th>";
	
	echo "<th><input type='submit' value='BUSCAR' class='btn' id='f_buscar' name='f_buscar' /></th></tr></form><tr>";




$Os_mysql= "SELECT * FROM $tabla WHERE $condicion ORDER by id LIMIT ".($pagina-1)*$noRegistros.",$noRegistros ";
$Os_query = $Os_mysql or die("Error al consultar la base de datos" . mysqli_error($Os_link));
$Os_result = $Os_link->query($Os_query);

	$alt=false;

while($Os_row = mysqli_fetch_array($Os_result)) {

    $Os_id=$Os_row['id'];
	$Os_nombre=$Os_row['grp_nombre'];
	$Os_integrantes=$Os_row['grp_integrantes'];
	$Os_bot=$Os_row['grp_bot'];
	$Os_icono=$Os_row['grp_icono'];
	$Os_estado=$Os_row['usr_activo'];

		
if ($Os_estado==0){
	$estado="CC0000";
}else{
	$estado="75b936";
}

	if ($alt==false){
		echo "<tr><td><font class='font-cuerpo'>$Os_id</font></td>
		<th><font class='font-cuerpo'>$Os_nombre</font></th>
		<td><font class='font-cuerpo'>$Os_integrantes</font></td>
		<td><font class='font-cuerpo'>$Os_bot</font></td>
		<td><font class='font-cuerpo'>$Os_icono</font></td>
		<td><a href='grupo_editar.php?lightbox[iframe]=true&lightbox[width]=510&lightbox[height]=240&id=$Os_id' class='lightbox'>
		<button class='btn'><img src='images/editar.png' style='width:20px;height:20px'></button></a> 
		<a href='telegram_contacto_eliminar.php?lightbox[iframe]=true&lightbox[width]=500&lightbox[height]=200&id=$Os_id' class='lightbox'>
		<button class='btn_red'><img src='images/eliminar.png' style='width:20px;height:20px'></button></a></td></tr>";
		$alt=true;
	}else{
                echo "<tr><td><font class='font-cuerpo'>$Os_id</font></td>
                <th><font class='font-cuerpo'>$Os_nombre</font></th>
                <td><font class='font-cuerpo'>$Os_integrantes</font></td>
                <td><font class='font-cuerpo'>$Os_bot</font></td>
                <td><font class='font-cuerpo'>$Os_icono</font></td>
                <td><a href='grupo_editar.php?lightbox[iframe]=true&lightbox[width]=510&lightbox[height]=240&id=$Os_id' class='lightbox'>
                <button class='btn'><img src='images/editar.png' style='width:20px;height:20px'></button></a> 
                <a href='telegram_contacto_eliminar.php?lightbox[iframe]=true&lightbox[width]=500&lightbox[height]=200&id=$Os_id' class='lightbox'>
                <button class='btn_red'><img src='images/eliminar.png' style='width:20px;height:20px'></button></a></td></tr>";
		$alt=false;

		
		
	}


	
}

echo "</table>";

echo $paginacion;

mysqli_close($Os_link);

?>



</body>
</html>

