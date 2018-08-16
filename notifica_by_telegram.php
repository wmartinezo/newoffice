<?php

$info = $argv[1];

include 'include/conexion.php';

$Os_link = mysqli_connect(OsHOST,OsUSER,OsPASS,OsDATB) or die("Error: " . mysqli_error($Os_link));
$Os_link_CEN = mysqli_connect(OsHOST_CEN,OsUSER_CEN,OsPASS_CEN,OsDATB_CEN) or die("Error: " . mysqli_error($Os_link_CEN));

$Os_mysql= "SELECT * FROM NewOff_Grupos WHERE id like '%' ORDER by id LIMIT 50;";
$Os_query = $Os_mysql or die("Error al consultar la base de datos" . mysqli_error($Os_link));
$Os_result = $Os_link->query($Os_query);


while($Os_row = mysqli_fetch_array($Os_result)) {

    	$Os_id=$Os_row['id'];
        $Os_BOT=$Os_row['grp_bot'];
        $Os_integrantes=$Os_row['grp_integrantes'];


	$personas = explode("; ", $Os_integrantes);
        	foreach($personas as $key => $val) {
			$llama = exec("echo -e 'msg $val $info' | nc -w 2 172.16.100.101 1313");


        	}





}


//$llama = exec("echo -e 'msg Walter_Martinez $info' | nc -w 2 172.16.100.101 1314");
//$llama = exec("echo -e 'msg Alejandro_Carrasco $info' | nc -w 2 172.16.100.101 1314");
//$llama = exec("echo -e 'msg Adrian_Gutierrez $info' | nc -w 2 172.16.100.101 1314");

?>
