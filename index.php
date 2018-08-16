<?php

include 'include/inicio_session.php';

?>
<html>
<head>
<link href="css/menu.css" rel="stylesheet" />


<meta charset=iso-8859-1 />
<link rel="icon" href="favicon.ico" type="image/x-icon">
<link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
<title>NewOffice - Principal</title>

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




   echo "<br><center><div class='tablelogin'><table border=1><thead><tr><th><font style='font-size:19px;'>Clientes</font></th></tr></thead><tr><td><table border=0><tbody>";
//    echo "<tr><th>Paso 1: Crear el escenario</th><td width=350><a href='layout_nuevo.php?lightbox[iframe]=true&lightbox[width]=500&lightbox[height]=640' class='lightbox'><button class='btn'><img src='images_sys/agregar.gif' style='vertical-align: middle;'> Agregar</button></a>";
//	echo "<br><br><a href='layout_import_excel.php?lightbox[iframe]=true&lightbox[width]=350&lightbox[height]=200' class='lightbox'><button class='btn'><img src='images_sys/importar_excel.png' style='vertical-align: middle;'> Importar</button></a> ";
//	echo "<a href='layout_export_excel.php?lightbox[iframe]=true&lightbox[width]=350&lightbox[height]=200' class='lightbox'><button class='btn'><img src='images_sys/exportar_excel.png' style='vertical-align: middle;'> Exportar</button></a>";

   $Os_mysql_user= "SELECT * FROM NewOff_Clientes WHERE cli_nombre like '%' ORDER by id LIMIT 5;";
   $Os_query_user = $Os_mysql_user or die("Error al consultar la base de datos" . mysqli_error($Os_link));
   $Os_result_user = $Os_link->query($Os_query_user);

$nombres_clientes="";

while($Os_row_user = mysqli_fetch_array($Os_result_user)) {
 
    $cli_nombres = $Os_row_user['cli_nombre'];
    $nombres_clientes.="$cli_nombres <br>";
 
}


    echo "<tr><th width=150>Clientes:</th><td>$nombres_clientes</td></tr>";

    echo "<tr><th></th><td align='right'></td></tr></tbody></table>\n";
    echo "</td></tr></table></div></center>";




   $Os_mysql_user= "SELECT * FROM NewOff_Impresoras WHERE imp_nombre like '%' order by imp_contador_historico LIMIT 5;";
   $Os_query_user = $Os_mysql_user or die("Error al consultar la base de datos" . mysqli_error($Os_link));
   $Os_result_user = $Os_link->query($Os_query_user);

$nombres_clientes="";

while($Os_row_user = mysqli_fetch_array($Os_result_user)) {
 
    $imp_hostname = $Os_row_user['imp_hostname'];
    $imp_puerto = $Os_row_user['imp_puerto'];
    $imp_contador = $Os_row_user['imp_contador_historico'];

   $Os_mysql_impres= "SELECT * FROM hosts WHERE address='$imp_hostname' LIMIT 1;";
   $Os_query_impres = $Os_mysql_impres or die("Error al consultar la base de datos" . mysqli_error($Os_link_CEN));
   $Os_result_impres = $Os_link_CEN->query($Os_query_impres);

   $impres_name="";

   while($Os_row_impres = mysqli_fetch_array($Os_result_impres)) {
      $impres_name = $Os_row_impres['name'];
      $impres_output = $Os_row_impres['output'];
   }


    $resumen_impresoras.="<img src='images/impresora.png' style='width:32px;height:32px;vertical-align:middle'> <b>$impres_name</b> (<font style='background-color:#CCCCCC'>$imp_hostname</font>) - Hojas Impresas: $imp_contador - Estado: $impres_output<br>";
 
}   
    


   echo "<br><center><div class='tablelogin'><table border=1><thead><tr><th><font style='font-size:19px;'>Impresoras</font></th></tr></thead><tr><td><table border=0><tbody>";


    echo "<tr><th width=150><b>Impresoras:</b></th><td><font color='#777777'> $resumen_impresoras</font></td></tr>";



    echo "<tr><th></th><td align='right'></td></tr></tbody></table>\n";
    echo "</td></tr></table></div></center>";

mysqli_close($Os_link);

?>

</body>
</html>

