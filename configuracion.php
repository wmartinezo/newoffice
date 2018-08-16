<?php

include 'include/inicio_session.php';

?>
<html>
<head>
<link href="css/menu.css" rel="stylesheet" />


<meta charset=iso-8859-1 />
<link rel="icon" href="favicon.ico" type="image/x-icon">
<link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
<title>NewOffice - Configuracion</title>

<link href="css/style.css" rel="stylesheet" type="text/css" />
<link href="css/font-awesome.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" href="css/jquery.lightbox.css"  />

<script type="text/javascript" src="js/jquery.min.js"></script>

<script type="text/javascript" src="js/jquery.lightbox.js"></script>
<script type="text/javascript">
    jQuery(document).ready(function(){
      jQuery('.lightbox').lightbox();
    });
</script>
</head>
<?php flush(); ?>
<body>
		  
<?php

include 'include/conexion.php';
include 'include/session.php';
include 'include/menu.php';




   echo "<br><center><div class='tablelogin'><table border=1><thead><tr><th><font style='font-size:19px;'>Estado del Servidor</font></th></tr></thead><tr><td><table border=0><tbody>";

   $Os_mysql_user= "SELECT * FROM NewOff_Clientes WHERE cli_nombre like '%' ORDER by id LIMIT 5;";
   $Os_query_user = $Os_mysql_user or die("Error al consultar la base de datos" . mysqli_error($Os_link));
   $Os_result_user = $Os_link->query($Os_query_user);

$nombres_clientes="";

while($Os_row_user = mysqli_fetch_array($Os_result_user)) {
 
    $cli_nombres = $Os_row_user['cli_nombre'];
    $nombres_clientes.="$cli_nombres <br>";
 
}


$estado_server="Normal";
$release_server=exec("cat /etc/*release | head -n 1");
$kernel_server=exec("uname -rs");
$ip_server=exec("hostname -I");
$up_dias=exec("awk '{print int($1/86400)}' /proc/uptime");
$up_horas=exec("awk '{print int($1%86400/3600)}' /proc/uptime");
$up_minutos=exec("awk '{print int(($1%3600)/60)}' /proc/uptime");
$up_segundos=exec("awk '{print int($1%60)}' /proc/uptime");
$uptime_server="Equipo encendido hace $up_dias dias, $up_horas hora(s), $up_minutos minutos y $up_segundos segundos.";


    echo "<tr><th width='200px'>Estado del Servidor:</th><td align='left'>$estado_server</td></tr>";
    echo "<tr><th width='200px'>Server Release:</th><td align='left'>$release_server</td></tr>";
    echo "<tr><th width='200px'>Kernel:</th><td align='left'>$kernel_server</td></tr>";
    echo "<tr><th width='200px'>IP:</th><td align='left'>$ip_server</td></tr>";
    echo "<tr><th width='200px'>Uptime:</th><td align='left'>$uptime_server</td></tr>";
    echo "<tr><th width='200px'>Servicios:</th><td align='left'>Centreon: $centeron_server</td></tr>";

    echo "</tbody>";
    echo "</table>\n";




   $Os_mysql_user= "SELECT * FROM NewOff_Impresoras WHERE imp_nombre like '%' order by imp_contador_historico LIMIT 5;";
   $Os_query_user = $Os_mysql_user or die("Error al consultar la base de datos" . mysqli_error($Os_link));
   $Os_result_user = $Os_link->query($Os_query_user);

$nombres_clientes="";

while($Os_row_user = mysqli_fetch_array($Os_result_user)) {
 
    $imp_hostname = $Os_row_user['imp_hostname'];
    $imp_puerto = $Os_row_user['imp_puerto'];
    $imp_contador = $Os_row_user['imp_contador_historico'];


    $resumen_impresoras="";
 
}   
    

mysqli_close($Os_link);

?>

</body>
</html>

