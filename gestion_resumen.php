<?php

include 'include/inicio_session.php';

?>
<html>
<head>
<link href="css/menu.css" rel="stylesheet" />

	<style>
		#calendar .hoy {
			background-color:#CCCCCC;
		}


.chartContainer {
  background-color: #EEEEEE;
  padding: 20px;
}

	</style>

<meta charset=iso-8859-1 />
<link rel="icon" href="favicon.ico" type="image/x-icon">
<link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
<title>NewOffice - Gestion</title>

<link href="css/style.css" rel="stylesheet" type="text/css" />
<link href="css/font-awesome.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" href="css/jquery.lightbox.css"  />

<script type="text/javascript" src="js/jquery.min.js"></script>

<script type="text/javascript" src="js/jquery.lightbox.js"></script>
<script type="text/javascript" src="js/chart.min.js"></script>

<script type="text/javascript">
    jQuery(document).ready(function(){
      jQuery('.lightbox').lightbox();
    });


$(document).ready(function(){
	$("#impresora").change(function(){
		varImpr=$('select[id=impresora]').val();
		window.open('gestion.php?impresora=' + varImpr, '_top');
	});

	$("#mes").change(function(){
		varImpr=$('select[id=impresora]').val();
		varMes=$('select[id=mes]').val();
		window.open('gestion.php?impresora=' + varImpr + '&mes=' + varMes, '_top');
	});
        $("#anio").change(function(){
                varImpr=$('select[id=impresora]').val();
                varMes=$('select[id=mes]').val();
                varAnio=$('select[id=anio]').val();
                window.open('gestion.php?impresora=' + varImpr + '&mes=' + varMes + '&anio=' + varAnio, '_top');
        });

});


</script>
</head>
<body onload="drawCharts()">
		  
<?php

include 'include/conexion.php';
include 'include/session.php';
//include 'include/menu.php';


$meses=array(1=>"Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");



if (isset($_GET['mes'])){
        $mes_buscado=$_GET['mes'];
}else{
        $mes_buscado="";
}

if (isset($_GET['impresora'])){
        $impresora_buscada=$_GET['impresora'];
}else{
        $impresora_buscada="";
}

if (isset($_GET['mes'])){
        $month=$_GET['mes'];
}else{
        $month=date("n");
}

$month=intval($month);

        $anio_actual=date("Y");

if (isset($_GET['anio'])){
        $year=$_GET['anio'];
}else{
        $year=date("Y");
}

$total_hojas_mes=0; 
$total_costohojas_mes=0;

   $Os_mysql_user= "SELECT * FROM NewOff_Impresoras WHERE imp_hostname like '$impresora_buscada%' order by imp_contador_historico LIMIT 1;";
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

   $Os_mysql_vph= "SELECT * FROM NewOff_Clientes WHERE cli_impresoras like '%$impres_name%' ORDER by id DESC LIMIT 1;";
   $Os_query_vph = $Os_mysql_vph or die("Error al consultar la base de datos" . mysqli_error($Os_link));
   $Os_result_vph = $Os_link->query($Os_query_vph);


while($Os_row_vph = mysqli_fetch_array($Os_result_vph)) {
    $his_hojas="";
    $valor_hoja = $Os_row_vph['cli_costo_hoja'];

}



    $resumen_impresoras.="<img src='images/impresora.png' style='width:32px;height:32px;vertical-align:middle'> <b>$impres_name</b> (<font style='background-color:#CCCCCC'>$imp_hostname</font>)<br> Valor por Hoja: $$valor_hoja";

}

if($month<=9){
$mes = "0"."$month";
}



   $Os_mysql_mes= "SELECT * FROM NewOff_HistoricoHojas WHERE his_fecha like '%/$mes/%' AND his_impresora like '$impresora_buscada%' ORDER by id DESC LIMIT 1;";
   $Os_query_mes = $Os_mysql_mes or die("Error al consultar la base de datos" . mysqli_error($Os_link));
   $Os_result_mes = $Os_link->query($Os_query_mes);

   $his_hojas="";

while($Os_row_mes = mysqli_fetch_array($Os_result_mes)) {
    $his_impresora = $Os_row_mes['his_impresora'];
    $his_cliente = $Os_row_mes['his_cliente'];
    $his_fecha = $Os_row_mes['his_fecha'];
    $his_hojas = $Os_row_mes['his_hojas'];
    $his_toner = $Os_row_mes['his_toner'];
    $his_estado = $Os_row_mes['his_estado'];
    $his_anote = $Os_row_mes['his_anote'];
}

    echo "<table border=1 id='customers'><tr>";
    echo "</td></tr><tr><th width=150>Impresora: </th><td>$resumen_impresoras</td></tr>";
    echo "</td></tr><tr><th width=150>Impresiones históricas: </th><td> Total de hojas impresas: $his_hojas</td></tr>";

   $Os_mysql_mes= "SELECT * FROM NewOff_HistoricoHojas WHERE his_fecha like '%/$mes/%' AND his_impresora like '$impresora_buscada%' AND his_toner <> '' AND (his_toner like '___' OR his_toner like '__') ORDER by id DESC LIMIT 1;";
   $Os_query_mes = $Os_mysql_mes or die("Error al consultar la base de datos" . mysqli_error($Os_link));
   $Os_result_mes = $Os_link->query($Os_query_mes);

   $his_hojas="";

while($Os_row_mes = mysqli_fetch_array($Os_result_mes)) {
    $his_impresora = $Os_row_mes['his_impresora'];
    $his_cliente = $Os_row_mes['his_cliente'];
    $his_fecha = $Os_row_mes['his_fecha'];
    $his_hojas = $Os_row_mes['his_hojas'];
    $his_toner = $Os_row_mes['his_toner'];
    $his_estado = $Os_row_mes['his_estado'];
    $his_anote = $Os_row_mes['his_anote'];

}



   echo "<br><center><table id='customers' border=1>";
echo "<thead><tr><th>Impresora</th> <th>Dia</th> <th>Mes</th> <th>Año</th> <th>Hojas Impresas</th> <th>Historico</th> <th>Costo</th> </tr></thead>";

   $Os_mysql_user= "SELECT * FROM NewOff_HistoricoHojas WHERE his_impresora like '%' ORDER by id LIMIT 5;";
   $Os_query_user = $Os_mysql_user or die("Error al consultar la base de datos" . mysqli_error($Os_link));
   $Os_result_user = $Os_link->query($Os_query_user);

while($Os_row_user = mysqli_fetch_array($Os_result_user)) {
 
    $his_impresora = $Os_row_user['his_impresora'];
    $his_cliente = $Os_row_user['his_cliente']; 
    $his_fecha = $Os_row_user['his_fecha'];
    $his_hojas = $Os_row_user['his_hojas'];
    $his_toner = $Os_row_user['his_toner'];
    $his_estado = $Os_row_user['his_estado'];
    $his_anote = $Os_row_user['his_anote'];

}





if (isset($_GET['impresora'])){

        $impresora_buscada=$_GET['impresora'];

}else{

        $impresora_buscada="";

}


	$Os_mysql= "SELECT * FROM NewOff_Impresoras ORDER BY id ASC"; 
	$Os_query = $Os_mysql or die("Error al consultar la base de datos" . mysqli_error($Os_link));
	$Os_result = $Os_link->query($Os_query);

	$existeLY=false;




//$year=date("Y");
$diaActual=date("j");
 
# Obtenemos el dia de la semana del primer dia
# Devuelve 0 para domingo, 6 para sabado
$diaSemana=date("w",mktime(0,0,0,$month,1,$year))+7;
# Obtenemos el ultimo dia del mes
$ultimoDiaMes=date("d",(mktime(0,0,0,$month+1,1,$year)-1));



		$last_cell=$diaSemana+$ultimoDiaMes;

$ultima_cuenta_hojas=0;
$di=array();

		for($i=1;$i<=42;$i++)
		{
			if($i==$diaSemana)
			{
				// determinamos en que dia empieza
				$day=1;
			}
			if($i<$diaSemana || $i>=$last_cell)
			{
				// celca vacia
//				echo "<td>&nbsp;</td>";
			}else{
				// mostramos el dia
if(strlen($day)==1){
	$busqueda_fecha="%0$day/%$month/$year%";
}else{
        $busqueda_fecha="%$day/%$month/$year%";
}








   $Os_mysql_vph= "SELECT * FROM NewOff_Clientes WHERE cli_impresoras like '%$impres_name%' ORDER by id DESC LIMIT 1;";
   $Os_query_vph = $Os_mysql_vph or die("Error al consultar la base de datos" . mysqli_error($Os_link));
   $Os_result_vph = $Os_link->query($Os_query_vph);


while($Os_row_vph = mysqli_fetch_array($Os_result_vph)) {
    $his_hojas="";
    $valor_hoja = $Os_row_vph['cli_costo_hoja'];

}








   $Os_mysql_user= "SELECT * FROM NewOff_HistoricoHojas WHERE his_fecha like '$busqueda_fecha' AND his_impresora like '$impresora_buscada' ORDER by id DESC LIMIT 1;";
   $Os_query_user = $Os_mysql_user or die("Error al consultar la base de datos" . mysqli_error($Os_link));
   $Os_result_user = $Os_link->query($Os_query_user);

//echo "$Os_mysql_user<br><br>";

if(isset($ultima_cuenta_hojas)){
$his_hojas=$ultima_cuenta_hojas;
}else{
$his_hojas=0;
}

while($Os_row_user = mysqli_fetch_array($Os_result_user)) {
    $his_hojas="";
    $his_impresora = $Os_row_user['his_impresora'];
    $his_cliente = $Os_row_user['his_cliente'];
    $his_fecha = $Os_row_user['his_fecha'];
    $his_hojas = $Os_row_user['his_hojas'];
    $his_toner = $Os_row_user['his_toner'];
    $his_estado = $Os_row_user['his_estado'];
    $his_anote = $Os_row_user['his_anote'];

}

if($ultima_cuenta_hojas==0){
	$ultima_cuenta_hojas=$his_hojas;
}

if($his_hojas==0){
        $differencia=0;
}



if($ultima_cuenta_hojas<=$his_hojas){
	$differencia=$his_hojas-$ultima_cuenta_hojas;
}

$ultima_cuenta_hojas=$his_hojas;

$di[$day]=$differencia;

if($his_hojas==0){
$his_hojas=$ultima_cuenta_hojas;
}

$costo_hojas=$valor_hoja*$differencia;

				if($day==$diaActual){
				//	echo "<td class='hoy'><font style='font-size:19px'><b>$day</b></font> - Hojas: <b>$his_hojas</b><br>Hojas x día: $differencia</td>";
					echo "<tr><td>$impres_name ($impresora_buscada)</td> <td>$day</td> <td>$month</td> <td>$year</td> <td>$differencia</td> <td>$his_hojas</td> <td>$$costo_hojas</td></tr>";
				}else{
				//echo "<td><font style='font-size:19px'><b>$day</b></font> - Hojas: <b>$his_hojas</b><br>Hojas x día: $differencia</td>";
					echo "<tr><td>$impres_name ($impresora_buscada)</td> <td>$day</td> <td>$month</td> <td>$year</td> <td>$differencia</td> <td>$his_hojas</td> <td>$$costo_hojas</td></tr>";
				}

$total_hojas_mes=$total_hojas_mes+$differencia;
$total_costohojas_mes=$total_costohojas_mes+$costo_hojas;

	
				$day++;
				$his_hojas;
			}
			// cuando llega al final de la semana, iniciamos una columna nueva
			if($i%7==0)
			{
				//echo "</tr><tr>\n";
			}
		}


 echo "<tr><th>$impres_name ($impresora_buscada) Total Hojas Impresas / Valor mensual</th> <th></th> <th>$month</th> <th>$year</th> <th>$total_hojas_mes</th> <th>$his_hojas</th> <th>$$total_costohojas_mes</th></tr>";



//echo "	</tr>";
echo "</table>";






   mysqli_close($Os_link); 









?>

</body>
</html>

