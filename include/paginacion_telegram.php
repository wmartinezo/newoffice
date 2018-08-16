<?php
//////////////////////////////////// PAGINACION ALTA /////////////////////////////////////////////////

//Registros por 

$noRegistros = 20; // cantidad de registros 
$pagina = 1; // pána actual
$paginacion=""; // menu
$next_p="";

//$condicion="id like '%' "; // condicion de MySQL
	$paginacion .= "<table class='round_table_container' style='width:100%'><tr><td class='round_table' style='width:400px'>";
//Si hay pána por ?pagina=valor, lo asigna
if(isset($_GET["pagina"])){
    $pagina = $_GET["pagina"];
	$paginacion .= "<font class='font-titulo'> &nbsp; Pagina: ".$pagina."</font><br>";
}

$Os_mysql= "SELECT count(*) FROM $tabla WHERE $condicion";
$Os_query = $Os_mysql or die("Error al consultar la base de datos" . mysqli_error($Os_link));
$Os_result = $Os_link->query($Os_query);

$Os_row_p = mysqli_fetch_array($Os_result);
$totalRegistros = $Os_row_p["count(*)"];
$pagtotceil="";

$noPaginas = ceil($totalRegistros/$noRegistros); 
$back_p="";

if ($noPaginas>5){
	$p_final=$pagina+5;
}else{
	$p_final=$pagina+$noPaginas;
}

if ($pagina>5){
	$p_inicio=$pagina-5;
}else{
	$p_inicio=1;
}



if ($noPaginas>5 AND $pagina+5<$noPaginas){
$next_p="<a href='?pagina=$noPaginas&$g_nombre&$g_apellido&$g_telefono&$g_alias&$g_grupos&$g_ultimavez&$g_online&$g_estado'><img src='images_sys/next.png' style='border:0; vertical-align:middle'></a>";
}

if ($p_inicio>1){
	$back_p="<a href='?pagina=1&$g_nombre&$g_apellido&$g_telefono&$g_alias&$g_grupos&$g_ultimavez&$g_online&$g_estado'><img src='images_sys/back.png' style='border:0; vertical-align:middle'></a>";
}

if ($p_final>$noPaginas){
$p_final=$noPaginas;
}

$paginacion .=  "<font class='font-titulo'>&nbsp;&nbsp;&nbsp; Total: ".$totalRegistros.", Pagina: $back_p</font> ";


for($i=$p_inicio; $i<=$p_final; $i++) { //Imprimo las pánas

    if($i == $pagina){
        $paginacion .=  "<font class='font-titulo' style='color:#FF0000'><b>$i</b> </font>"; // pagina actual sin link
    }else{
		$paginacion .= "<font class='font-titulo' color=black><a href=\"?pagina=".$i."&$g_nombre&$g_apellido&$g_telefono&$g_alias&$g_grupos&$g_ultimavez&$g_online&$g_estado\">".$i." </a></font>";
	}
	
	if ($i==$pagtotceil){break;}

}
$paginacion .= "$next_p";
$paginacion .= "</td>  <td class='round_table' style='width:400px'>$boton</td> <td class='round_table' style='width:100px'>$agregar_boton</td> </tr></table> ";

echo $paginacion;
//////////////////////////////////// FIN PAGINACION ALTA /////////////////////////////////////////////////
?>

