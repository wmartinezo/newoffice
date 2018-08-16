<?php

include 'include/inicio_session.php';

?>

<html>
<head>
<link href="css/menu.css" rel="stylesheet" />


<meta charset=iso-8859-1 />
<link rel="icon" href="favicon.ico" type="image/x-icon">
<link rel="shortcut icon" href="favicon.ico" type="image/x-icon">

<title>NewOffice - Inventario</title>

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
		$condicion.="AND (usr_nombre like '%$f_nombre%') ";
	}
	if ($f_apellido!=""){
		$condicion.="AND (usr_apellido like '%$f_apellido%') ";
	}
	if ($f_alias!=""){
		$condicion.="AND (usr_alias like '%$f_alias%') ";
	}
	if ($f_telefono!=""){
		$condicion.="AND (usr_fono like '%$f_telefono%') ";
	}
	if ($f_grupos!=""){
		$condicion.="AND (usr_grupos like '%$f_grupos%') ";
	}
	if ($f_ultimavez!=""){
		$condicion.="AND (usr_ultimaconexion like '%$f_ultimavez%') ";
	}
	if ($f_online!=""){
		$condicion.="AND (usr_online like '%$f_online%') ";
	}
	if ($f_estado!=""){
		$condicion.="AND (usr_activo='$f_estado') ";
	}

	$condicionurl="$condicion";
	$condicionurl=str_replace("%","|",$condicion);
	$condicionurl=urlencode($condicionurl);

	
	$boton="<a href='inventario.php'><button class='btn_red'><img src='images/impresoras.png' style='width:32px;height:32px'><br>Impresoras</button></a> ";
	$boton.="<a href='suministros.php'><button class='btn'><img src='images/suministros.png' style='width:32px;height:32px'><br>Suministros</button></a> ";
	$boton.="<a href='bodega.php'><button class='btn'><img src='images/bodega.png' style='width:32px;height:32px'><br>Bodega</button></a> ";


	$agregar_boton = "<a href='impresora_nuevo.php?lightbox[iframe]=true&lightbox[width]=500&lightbox[height]=240' class='lightbox'><button class='btn'><img src='images/agregar.png' style='vertical-align: middle;;width:20px;height:20px'>  Agregar</button></a>";



$tabla="NewOff_Impresoras";

	
$Os_mysql_rp= "SELECT * FROM $tabla ORDER BY id ASC";
 
$Os_query_rp = $Os_mysql_rp or die("Error al consultar la base de datos" . mysqli_error($Os_link));
$Os_result_rp = $Os_link->query($Os_query_rp);

	
	include 'include/paginacion_telegram.php';
	
	echo "<form id='buscador' method='get' action='#'><table border=1 id='customers'><tr>";
	echo "<th>ID</th>";
	echo "<th>Nombre <br><input type='text' class='textbox' id='f_nombre' name='f_nombre' value='$f_nombre' size='10'></th>";
	echo "<th>IP / Puerto <br><input type='text' class='textbox' id='f_apellido' name='f_apellido' value='$f_apellido' size='10'></th>";
	echo "<th>Comunidad SNMP <br><input type='text' class='textbox' id='f_telefono' name='f_telefono' value='$f_telefono' size='10'></th>";
	echo "<th>Cliente <br><input type='text' class='textbox' id='f_alias' name='f_alias' value='$f_alias' size='10'></th>";
	echo "<th>Marca <br><input type='text' name='f_grupos' class='textbox' id='f_grupos' class='styled'>";
	echo "<th>Modelo <br><input type='text' class='textbox' id='f_ultimavez' name='f_ultimavez' value='$f_ultimavez' size='10'></th>";
	echo "<th>Serial <br><select name='f_online' class='textbox' id='f_online' class='styled'>";
	echo "<option value=''>-</option>";
	
	echo "<th>Estado <br><select name='f_estado' class='textbox' id='f_estado' class='styled'>
	<option value=''>-</option>
	<option value='1'>o</option>
	<option value='0'>x</option>
	</select></th>";
	echo "<th><input type='submit' value='BUSCAR' class='btn' id='f_buscar' name='f_buscar' /></th></tr></form><tr>";



$Os_mysql= "SELECT * FROM $tabla WHERE $condicion ORDER by id LIMIT ".($pagina-1)*$noRegistros.",$noRegistros ";
$Os_query = $Os_mysql or die("Error al consultar la base de datos" . mysqli_error($Os_link));
$Os_result = $Os_link->query($Os_query);

	$alt=false;

while($Os_row = mysqli_fetch_array($Os_result)) {

    $Os_id=$Os_row['id'];
	$Os_imp_nombre=$Os_row['imp_nombre'];
	$Os_imp_ip=$Os_row['imp_hostname'];
	$Os_imp_puerto=$Os_row['imp_puerto'];
	$Os_imp_comunidad=$Os_row['imp_comunidad'];
	$Os_imp_cliente=$Os_row['imp_cliente'];
	$Os_imp_modelo=$Os_row['imp_modelo'];
	$Os_imp_marca=$Os_row['imp_marca'];
	$Os_imp_serial=$Os_row['imp_serial'];


if ($Os_estado==0){
	$estado="CC0000";
}else{
	$estado="75b936";
}

	if ($alt==false){
		echo "<tr><td><font class='font-cuerpo'>$Os_id</font></td>
		<th><font class='font-cuerpo'>$Os_imp_nombre</font></th>
		<td><font class='font-cuerpo'>$Os_imp_ip puerto $Os_imp_puerto</font></td>
		<td><font class='font-cuerpo'>$Os_imp_comunidad</font></td>
		<td><font class='font-cuerpo'>$Os_imp_cliente</font></td>
		<td><font class='font-cuerpo'>$Os_imp_marca</font></td>
		<td><font class='font-cuerpo'>$Os_imp_modelo</font></td>
		<td><font class='font-cuerpo'>$Os_imp_serial</font></td>
		<td><div style='background:#$estado;width:10px;height:10px;border-radius:50%'></td>
		<td><a href='inventario_editar.php?lightbox[iframe]=true&lightbox[width]=510&lightbox[height]=240&id=$Os_id' class='lightbox'>
		<button class='btn'><img src='images/editar.png' style='width:20px;height:20px'></button></a> 
		<a href='inventario_eliminar.php?lightbox[iframe]=true&lightbox[width]=500&lightbox[height]=200&id=$Os_id' class='lightbox'>
		<button class='btn_red'><img src='images/eliminar.png' style='width:20px;height:20px'></button></a></td></tr>";
		$alt=true;
	}else{
                echo "<tr><td><font class='font-cuerpo'>$Os_id</font></td>
                <th><font class='font-cuerpo'>$Os_imp_nombre</font></th>
                <td><font class='font-cuerpo'>$Os_imp_ip puerto $Os_imp_puerto</font></td>
                <td><font class='font-cuerpo'>$Os_imp_comunidad</font></td>
                <td><font class='font-cuerpo'>$Os_imp_cliente</font></td>
                <td><font class='font-cuerpo'>$Os_imp_marca</font></td>
                <td><font class='font-cuerpo'>$Os_imp_modelo</font></td>
                <td><font class='font-cuerpo'>$Os_imp_serial</font></td>
                <td><div style='background:#$estado;width:10px;height:10px;border-radius:50%'></td>
                <td><a href='inventario_editar.php?lightbox[iframe]=true&lightbox[width]=510&lightbox[height]=240&id=$Os_id' class='lightbox'>
                <button class='btn'><img src='images/editar.png' style='width:20px;height:20px'></button></a> 
                <a href='inventario_eliminar.php?lightbox[iframe]=true&lightbox[width]=500&lightbox[height]=200&id=$Os_id' class='lightbox'>
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

