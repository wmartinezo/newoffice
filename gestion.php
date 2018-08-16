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
include 'include/menu.php';




   echo "<br><center><div class='tablelogin'>
		<table border=1><thead><tr><th colspan=2><font style='font-size:19px;'>Desempeño de impresiones</font></th></tr></thead>
					<tr><td colspan=3><table border=1><tbody>
					<tr><th colspan=7>";


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

	echo "<select id='impresora' name='impresora' class='textbox'>";
	echo "<option value=''>-</option>";

	$selected_ly="";

		while($Os_row = mysqli_fetch_array($Os_result)) {

		$Os_id=$Os_row['id'];
		$Os_ly_orden=$Os_row['imp_nombre'];
		$Os_ly_nombre=$Os_row['imp_hostname'];
		
		if($impresora_buscada==$Os_ly_nombre)
		{
			$selected_ly="selected";
		}else{
			$selected_ly="";
		}
		
		$existeLY=true;

		echo "		<option value='$Os_ly_nombre' $selected_ly>$Os_ly_orden</option>";

	}
		echo "</select>";


$meses=array(1=>"Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");



if (isset($_GET['mes'])){
        $mes_buscado=$_GET['mes'];
}else{
        $mes_buscado="";
}

//if($mes_buscado<9){$mes_buscado="0".$mes_buscado;}

        echo "<select id='mes' name='mes' class='textbox'>";
        echo "<option value=''>-</option>";

        $selected_ly="";


                for($f=1;$f<=12;$f++) {
                if($mes_buscado==$f)
                {
                        $selected_ly="selected";
                }else{
                        $selected_ly="";
                }

		if($f<9){$numero="0".$f;}else{$numero=$f;}

                echo "          <option value='$numero' $selected_ly>".$meses[$f]."</option>";

        	}
                echo "</select>";

	$anio_actual=date("Y");

if (isset($_GET['anio'])){
        $year=$_GET['anio'];
}else{
        $year=date("Y");
}


        echo "<select id='anio' name='anio' class='textbox'>";
        echo "<option value='-'>-</option>";

for($yr=2015; $yr<=2025; $yr++) {

	if ($year==$yr){
	        echo "<option value='$yr' selected>$yr</option>";
	}else{
        	echo "<option value='$yr'>$yr</option>";
	}

}

	echo "</select>";






if (isset($_GET['mes'])){
	$month=$_GET['mes'];
}else{
	$month=date("n");
}

$month=intval($month);



//$year=date("Y");
$diaActual=date("j");
 
# Obtenemos el dia de la semana del primer dia
# Devuelve 0 para domingo, 6 para sabado
$diaSemana=date("w",mktime(0,0,0,$month,1,$year))+7;
# Obtenemos el ultimo dia del mes
$ultimoDiaMes=date("d",(mktime(0,0,0,$month+1,1,$year)-1));
 

echo "<table border=1 id='calendar'>";
echo "	<caption> ".$meses[$month]." ".$year."</caption>";
echo "	<tr>";
echo "		<th>Lun</th><th>Mar</th><th>Mie</th><th>Jue</th>";
echo "		<th>Vie</th><th>Sab</th><th>Dom</th>";
echo "	</tr>";
echo "	<tr bgcolor='silver'>";

		$last_cell=$diaSemana+$ultimoDiaMes;
		// hacemos un bucle hasta 42, que es el máximo de valores que puede
		// haber... 6 columnas de 7 dias

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
				echo "<td>&nbsp;</td>";
			}else{
				// mostramos el dia

if(strlen($day)==1){
	$busqueda_fecha="%0$day/%$month/$year%";
}else{
        $busqueda_fecha="%$day/%$month/$year%";
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
				if($day==$diaActual)
					echo "<td class='hoy'><font style='font-size:19px'><b>$day</b></font> - Hojas: <b>$his_hojas</b><br>Hojas x día: $differencia</td>";
				else
				echo "<td><font style='font-size:19px'><b>$day</b></font> - Hojas: <b>$his_hojas</b><br>Hojas x día: $differencia</td>";
				
				$day++;
				$his_hojas;
			}
			// cuando llega al final de la semana, iniciamos una columna nueva
			if($i%7==0)
			{
				echo "</tr><tr>\n";
			}
		}




echo "	</tr>";
echo "</table>";



echo "<div class='chartContainer'>";
echo "<canvas id='lineChartBlueGreen' width='400px' height='200px'></canvas>";
echo "  </div>";



?>


<script>

var results = [



<?php


for($i=1; $i <= count($di); $i++) {


        echo "{ date: \"dia $i\", paginas: ".$di[$i]."},";

}


?>

  {
    date: "",
    visits: 0
  }
];

//this is the function to create the line chart
function drawLineChart(div_id, results, yColumn, yLabel, xAxes, firstColour, secondColour, thirdColour, fourthColour) {
  var ctx = document.getElementById(div_id).getContext("2d");
  var width = window.innerWidth || document.body.clientWidth;
  var gradientStroke = ctx.createLinearGradient(0, 0, width, 0);
  gradientStroke.addColorStop(0, firstColour);
  gradientStroke.addColorStop(0.3, secondColour);
  gradientStroke.addColorStop(0.6, thirdColour);
  gradientStroke.addColorStop(1, fourthColour);

  var labels = results.map(function(item) {
    return item[xAxes];
  });
  var data = results.map(function(item) {
    return item[yColumn];
  });

  var myChart = new Chart(ctx, {
    type: "line",
    data: {
      labels: labels,
      datasets: [
        {
          label: yLabel,
          borderColor: gradientStroke,
          pointBorderColor: gradientStroke,
          pointBackgroundColor: gradientStroke,
          pointHoverBackgroundColor: gradientStroke,
          pointHoverBorderColor: gradientStroke,
          pointBorderWidth: 8,
          pointHoverRadius: 8,
          pointHoverBorderWidth: 1,
          pointRadius: 3,
          fill: false,
          borderWidth: 4,
          data: data
        }
      ]
    },
    options: {
      responsive: true,
      maintainAspectRatio: false,
      legend: {
        position: "none"
      },
      scales: {
        yAxes: [
          {
            ticks: {
              fontFamily: "Roboto Mono",
              fontColor: "#556F7B",
              fontStyle: "bold",
              beginAtZero: true,
              maxTicksLimit: 5,
              padding: 20
            },
            gridLines: {
              drawTicks: false,
              display: false,
              drawBorder: false
            }
          }
        ],
        xAxes: [
          {
            gridLines: {
              zeroLineColor: "transparent"
            },
            ticks: {
              padding: 20,
              fontColor: "#556F7B",
              fontStyle: "bold",
              fontFamily: "Roboto Mono"
            },
            gridLines: {
              drawTicks: false,
              display: false,
              drawBorder: false
            }
          }
        ]
      }
    }
  });
}


//this is to initialise the charts
function drawCharts() {
  drawLineChart(
    "lineChartBlueGreen",
    results,
    "paginas",
    "Hojas",
    "date",
    "#088A29",
    "#04B45F",
    "#088A29",
    "#088A29"
  );
}

</script>



<?php




// Resumen de Impresora



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

if($month<=9){
$mes = "0"."$month";
}


    $resumen_impresoras.="<a href='gestion_resumen.php?impresora=$impresora_buscada&mes=$mes&anio=$year'><img src='images/impresora.png' style='width:32px;height:32px;vertical-align:middle'></a> <b>$impres_name</b> (<font style='background-color:#CCCCCC'>$imp_hostname</font>) - Hojas Impresas: $imp_contador - Estado: $impres_output<br>";

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

    echo "</td></tr><tr><th width=150>Impresora: </th><td>$resumen_impresoras</td></tr>";
    echo "</td></tr><tr><th width=150>Impresiones del Mes: </th><td> Hojas impresas en el mes: $his_hojas</td></tr>";




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


    echo "</td></tr><tr><th width=150>Consumo Toner: </th><td> Cantidad de toner: $his_toner</td></tr>";
    echo "<tr><th></th><td align='right'></td></tr></tbody></table>\n";
    echo "</td></tr></table></div></center>";




   mysqli_close($Os_link); 









?>

</body>
</html>

