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
 
    $f_nombre=$_POST['f_nombre'];
    $f_apellido=$_POST['f_apellido'];
    $f_telefono=$_POST['f_telefono'];
    $f_pass=$_POST['f_pass'];
    $f_pass2=$_POST['f_pass2'];
    $f_alias=$f_nombre."_".$f_apellido;
    $f_activo="1";

$Os_mysql_ly= "SELECT * FROM NewOff_Usuarios WHERE usr_fono='$f_telefono' LIMIT 1"; 
$Os_query_ly = $Os_mysql_ly or die("Error al consultar la base de datos" . mysqli_error($Os_link));
$Os_result_ly = $Os_link->query($Os_query_ly);

	while($Os_row_ly = mysqli_fetch_array($Os_result_ly)) {

    $Os_id_ly=$Os_row_ly['id'];

		if($Os_id_ly>="0"){
			echo "<br><table class='round_table_container' style='width: 400px; height: 25; background-color: #CC0000; display: table-cell; vertical-align: middle; text-align: center'>
<tr><td><div><font style='color:#FFFFFF;font-family: Verdana'>El Telefono Ya Existe.</font></div></td></tr></table><br>";	
		
			die();
		}
	
	}

	$ahora=time();
	if($f_pass==$f_pass2){
		$f_pass=md5("Os1r1s"."$f_pass");
		$sql_insertar="INSERT INTO NewOff_Usuarios (usr_fono, usr_nombre, usr_apellido, usr_alias, usr_activo, usr_password) VALUES";
        	$sql_insertar.="('$f_telefono', '$f_nombre', '$f_apellido', '$f_alias', '$f_activo', '$f_pass');";
			
    		$Os_query_insertar = $sql_insertar or die("Error al escribir en la base de datos" . mysqli_error($Os_link));
    		$Os_result_insertar = $Os_link->query($sql_insertar);       


	}else{

		echo "<br><table class='round_table_container' style='width: 400px; height: 25; background-color: #CC0000; display: table-cell; vertical-align: middle; text-align: center'>
<tr><td><div><font style='color:#FFFFFF;font-family: Verdana'>Password no coincide.</font></div></td></tr></table><br>";


	}



if ($Os_link->affected_rows==1){
    echo "<br><table class='round_table_container' style='width: 400px; height: 25; background-color: #31B404; display: table-cell; vertical-align: middle; text-align: center'><tr><td><div><font style='color:#FFFFFF;font-family: Verdana'>Guardado con éxito</font></div></td></tr></table><br>";	


exec("echo -e 'add_contact $f_telefono $f_nombre $f_apellido' | nc -w 1 172.16.100.101 1313");

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
 
 
 
    echo "<font class='font-titulo'>Nuevo Contacto</font><br><br>";
    echo "<form id='nuevo_contacto' method='post' action='#'><table border='1' id='customers' width='50%'><thead>";

    echo "<tr><th>*Nombre: </th><td><input type='text' size='20' id='f_nombre' name='f_nombre' class='textbox' required></td></tr>";
    echo "<tr><th>*Apellido: </th><td><input type='text' size='20' id='f_apellido' name='f_apellido' class='textbox' required></td></tr>";
    echo "<tr><th>*Telefono: </th><td><input type='text' size='30' id='f_telefono' name='f_telefono' class='textbox' pattern='[0-9]{11}' required></td></tr>";

    echo "<tr><th>*Password: </th><td><input type='password' size='30' id='f_pass' name='f_pass' class='textbox' required></td></tr>";
    echo "<tr><th>*Password: </th><td><input type='password' size='30' id='f_pass2' name='f_pass2' class='textbox' required></td></tr>";
	
    echo "<tbody><tr><th></th><td><input type='submit' value='Guardar' class='btn' id='f_guardar' name='f_guardar' /></td>";
 
    echo "</tbody></table></form>";
 
  
?>





</body>
</html>

