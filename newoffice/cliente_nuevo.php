<?php

include 'include/inicio_session.php';

?>

<html>
<head>
<meta charset=iso-8859-1 />
<link rel="icon" href="favicon.ico" type="image/x-icon">
<link rel="shortcut icon" href="favicon.ico" type="image/x-icon">

<title>NewOffice - Nuevo Contacto</title>
<link href="css/style.css" rel="stylesheet" type="text/css" />
<link href="css/font-awesome.css" rel="stylesheet" type="text/css" />


<script src="jscolor/jscolor.js"></script>
<script type="text/javascript" src="js/jquery.min.js"></script>
	
<?php

include 'include/conexion.php';
include 'include/session.php'; 
 
 
if (isset($_POST['f_guardar'])==true){
 
    $f_nombre=$_POST['f_nombre_1'];
    $f_direccion=$_POST['f_direccion'];
    $f_impresoras=$_POST['f_impresoras'];
    $f_costo_hoja=$_POST['f_costo'];
    $f_admin=$_POST['f_admin'];
    $f_tecnico=$_POST['f_tecnico'];
    $f_activo="1";

$Os_mysql_ly= "SELECT * FROM NewOff_Clientes WHERE cli_nombre='$f_nombre' LIMIT 1"; 
$Os_query_ly = $Os_mysql_ly or die("Error al consultar la base de datos" . mysqli_error($Os_link));
$Os_result_ly = $Os_link->query($Os_query_ly);

	while($Os_row_ly = mysqli_fetch_array($Os_result_ly)) {

    $Os_id_ly=$Os_row_ly['id'];

		if($Os_id_ly>="0"){
			echo "<br><table class='round_table_container' style='width: 400px; height: 25; background-color: #CC0000; display: table-cell; vertical-align: middle; text-align: center'>
			<tr><td><div><font style='color:#FFFFFF;font-family: Verdana'>Ya Existe.</font></div></td></tr></table><br>";	
		
			die();
		}
	
	}

		$ahora=time();
		$sql_insertar="INSERT INTO NewOff_Clientes (cli_nombre, cli_direccion, cli_impresoras, cli_costo_hoja, cli_contacto_admin, cli_contacto_tecnico, cli_activo) VALUES";
        	$sql_insertar.="('$f_nombre', '$f_direccion', '$f_impresoras', '$f_costo_hoja', '$f_admin', '$f_tecnico', '$f_activo');";
			
    		$Os_query_insertar = $sql_insertar or die("Error al escribir en la base de datos" . mysqli_error($Os_link));
    		$Os_result_insertar = $Os_link->query($sql_insertar);       




if ($Os_link->affected_rows==1){
    echo "<br><table class='round_table_container' style='width: 400px; height: 25; background-color: #31B404; display: table-cell; vertical-align: middle; text-align: center'><tr><td><div><font style='color:#FFFFFF;font-family: Verdana'>Guardado con éxito</font></div></td></tr></table><br>";	


	$ip_host=$_SERVER['REMOTE_ADDR'];
	$fecha_act=date("d-m-Y");
	$hora_act=date("H:i:s");
	$tipo_act="insercion de contacto - TELEGRAM";
	$nuevo_log=str_replace("'","",$sql_insertar);
	$times = time();
	
	$Os_mysql_hy= "INSERT INTO hy_table (hy_usuario,hy_fecha,hy_hora,hy_ip,hy_tipo,hy_log,hy_timestamp) VALUES ('$global_userOs', '$fecha_act', '$hora_act', '$ip_host', '$tipo_act', '$nuevo_log', '$times');";
	$Os_query_hy = $Os_mysql_hy or die("Error al consultar la base de datos" . mysqli_error($Os_link));
	$Os_result_hy = $Os_link->query($Os_query_hy);

	die();
}else{
    echo "<br><table class='round_table_container' style='width: 400px; height: 25; background-color: #CC0000; display: table-cell; vertical-align: middle; text-align: center'><tr><td><div><font style='color:#FFFFFF;font-family: Verdana'>No se ha agregado, comprueba que el Layout no exista.</font></div></td></tr></table><br>";	
	salir:
    echo "<br><table class='round_table_container' style='width: 400px; height: 25; background-color: #CC0000; display: table-cell; vertical-align: middle; text-align: center'><tr><td><div><font style='color:#FFFFFF;font-family: Verdana'>No se ha agregado, comprueba que el Nombre que pusiste es válido.</font></div></td></tr></table><br>";	
	die();
}


 
}
 
 
 
    echo "<font class='font-titulo'>Nuevo Cliente</font><br><br>";
    echo "<form id='nuevo_contacto' method='post' action='#'><table border='1' id='customers' width='50%'><thead>";

    echo "<tr><th>*Nombre: </th><td><input type='text' size='20' id='f_nombre_1' name='f_nombre_1' class='textbox' required></td></tr>";
    echo "<tr><th>*Dirección: </th><td><input type='text' size='20' id='f_direccion' name='f_direccion' class='textbox' required></td></tr>";
    echo "<tr><th>*Impresoras: </th><td><input type='text' size='30' id='f_impresoras' name='f_impresoras' class='textbox' required></td></tr>";

    echo "<tr><th>*Costo Hoja Impresa: </th><td><input type='text' size='30' id='f_costo' name='f_costo' class='textbox' required></td></tr>";

    echo "<tr><th>Administrador: </th><td><input type='text' size='30' id='f_admin' name='f_admin' class='textbox' required></td></tr>";
    echo "<tr><th>Técnico: </th><td><input type='text' size='30' id='f_tecnico' name='f_tecnico' class='textbox' required></td></tr>";

    echo "<tbody><tr><th></th><td><input type='submit' value='Guardar' class='btn' id='f_guardar' name='f_guardar' /></td>";
 
    echo "</tbody></table></form>";
 
  
?>





</body>
</html>

