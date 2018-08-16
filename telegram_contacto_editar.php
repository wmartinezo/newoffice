<?php

include 'include/inicio_session.php';

?>
<html>
<head>

<meta charset=iso-8859-1 />
<link rel="icon" href="favicon.ico" type="image/x-icon">
<link rel="shortcut icon" href="favicon.ico" type="image/x-icon">

<title>Osiris - Editar Contacto</title>

<link href="css/style.css" rel="stylesheet" type="text/css" />
<link href="css/font-awesome.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" href="css/switch.css"  />

<script type="text/javascript" src="js/jquery.min.js"></script>
<script type="text/javascript" src="js/switch.js"></script>

<script type="text/javascript">
$(document).ready(function(e) {
	$('input').lc_switch();
});
</script>

</head>
<body>

<?php

include 'include/conexion.php';
include 'include/session.php';


if (isset($_POST['f_guardar'])==true){

	$f_id=$_POST['f_id']; 
	$f_nombre=$_POST['f_nombre'];
	$f_apellido=$_POST['f_apellido'];
	$f_telefono=$_POST['f_telefono'];
	$f_alias=$f_nombre."_".$f_apellido;
        $f_alias_old=$_POST['f_alias_old'];

	if (isset($_POST['f_estado'])==true){
		$f_estado=$_POST['f_estado'];
	}else{
		$f_estado="0";
	}

    $sql_insertar="UPDATE NewOff_Usuarios SET usr_fono='$f_telefono', usr_nombre='$f_nombre', usr_apellido='$f_apellido', usr_alias='$f_alias', usr_activo='$f_estado'  WHERE id = '$f_id';";

    $Os_query_insertar = $sql_insertar or die("Error al escribir en la base de datos" . mysqli_error($Os_link));
    $Os_result_insertar = $Os_link->query($sql_insertar);       

	if ($Os_link->affected_rows==1){

		exec("echo -e 'rename_contact $f_alias_old $f_nombre $f_apellido' | nc -w 172.16.100.101 1313");


    		echo "<br><table class='round_table_container' style='width: 400px; height: 25; background-color: #31B404; display: table-cell; vertical-align: middle; text-align: center'>";
		echo "<tr><td><div><font style='color:#FFFFFF;font-family: Verdana'>Guardado con éxito <br> Su nuevo nombre de usuario es: <b>$f_alias</b> el cual se debe utilizar para el inicio de sesión.</font></div></td></tr></table><br>";	

		$ip_host=$_SERVER['REMOTE_ADDR'];
		$fecha_act=date("d-m-Y");
		$hora_act=date("H:i:s");
		$tipo_act="actualizacion de contacto Telegram";
		$nuevo_log=str_replace("'","",$sql_insertar);
		$times = time();
	
		$Os_mysql_hy= "INSERT INTO hy_table (hy_usuario,hy_fecha,hy_hora,hy_ip,hy_tipo,hy_log,hy_timestamp) VALUES ('$global_userOs', '$fecha_act', '$hora_act', '$ip_host', '$tipo_act', '$nuevo_log', '$times');";
		$Os_query_hy = $Os_mysql_hy or die("Error al consultar la base de datos" . mysqli_error($Os_link));
		$Os_result_hy = $Os_link->query($Os_query_hy);

		die();
	}else{
		echo "<br><table class='round_table_container' style='width: 400px; height: 25; background-color: #CC0000; display: table-cell; vertical-align: middle; text-align: center'><tr><td><div><font style='color:#FFFFFF;font-family: Verdana'>No se ha guardado, comprueba que el Layout no exista.</font></div></td></tr></table><br>";	
		salir:
		echo "<br><table class='round_table_container' style='width: 400px; height: 25; background-color: #CC0000; display: table-cell; vertical-align: middle; text-align: center'><tr><td><div><font style='color:#FFFFFF;font-family: Verdana'>No se ha guardado, comprueba que el Nombre que pusiste es válido.</font></div></td></tr></table><br>";	
		die();
	}
}



if (isset($_GET['id'])==true){
	if ($_GET['id']==""){die();}
	$f_id=$_GET['id'];
}else{
    echo "<br><table class='round_table_container' style='width: 400px; height: 25; background-color: #CC0000; display: table-cell; vertical-align: middle; text-align: center'><tr><td><div><font style='color:#FFFFFF;font-family: Verdana'>No se puede editar el Escenario seleccionado.</font></div></td></tr></table><br>";	
	die();
}
 
 
$Os_mysql= "SELECT * FROM NewOff_Usuarios WHERE id='$f_id';";
$Os_query = $Os_mysql or die("Error al consultar la base de datos" . mysqli_error($Os_link));
$Os_result = $Os_link->query($Os_query);

 while($Os_row = mysqli_fetch_array($Os_result)) {

    $Os_id=$Os_row['id'];
    $Os_telefono=$Os_row['usr_fono'];
    $Os_first_name=$Os_row['usr_nombre'];
    $Os_last_name=$Os_row['usr_apellido'];
    $Os_print_name=$Os_row['usr_alias'];
    $Os_grupos=$Os_row['usr_grupos'];
    $Os_ultimavez=$Os_row['usr_ultimaconexion'];
    $Os_online=$Os_row['usr_online'];
    $Os_estado=$Os_row['usr_activo'];
	

 }
 	if ($Os_estado==1){
		$check='checked';
	}else{
		$check='';
	}
	
    echo "<font class='font-titulo'>Editando el Contacto: $f_id</font><br><br>";
    echo "<form id='editar_contacto' method='post' action='#'><table border='1' id='customers' width='50%'><thead>";
    echo "<tr><th>Estado: </th><td><input type='checkbox' name='f_estado' id='f_estado' value='1' class='lcs_check lcs_tt1' $check autocomplete='off' /> </td></tr>";
    echo "<tr><th>*Nombre: </th><td><input type='hidden' id='f_id' name='f_id' value='$f_id'><input type='text' size='20' class='textbox' id='f_nombre' name='f_nombre' value='$Os_first_name' required></td></tr>";

    echo "<tr><th>*Apellido: </th><td><input type='text' size='20' id='f_apellido' name='f_apellido' value='$Os_last_name' class='textbox'></td></tr>";
    echo "<tr><th>*Telefono: </th><td><input type='text' size='20' id='f_telefono' name='f_telefono'  value='$Os_telefono' pattern='[0-9]{11}' class='textbox'><input type='hidden' id='f_alias_old' name='f_alias_old' value='$Os_print_name'> Ejemplo: 569XXXXXXXX</td></tr>";
	
    echo "<tbody><tr><th></th><td><input type='submit' value='Guardar' class='btn' id='f_guardar' name='f_guardar' /></td>";
 
    echo "</tbody></table></form>";
 
  
?>




</body>
</html>

