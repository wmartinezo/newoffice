<?php

include 'conexion.php';

$Os_link = mysqli_connect(OsHOST,OsUSER,OsPASS,OsDATB) or die("Error: " . mysqli_error($Os_link));

$Os_mysql_user= "SELECT * FROM NewOff_Usuarios WHERE id='0' LIMIT 1 ";
$Os_query_user = $Os_mysql_user or die("Error al consultar la base de datos" . mysqli_error($Os_link));
$Os_result_user = $Os_link->query($Os_query_user);


$usrnombre="";
$usrpassword="";
 
while($Os_row_user = mysqli_fetch_array($Os_result_user)) {
 
    $usrnombre = $Os_row_user['usr_alias'];
    $usrpassword = $Os_row_user['usr_password'];
 
}

if ($usrnombre=="admin"){

  $admin_default="admin";
  $pass_default=md5("Os1r1s"."admin");

  $sql_insertar="UPDATE NewOff_Usuarios SET usr_alias='$admin_default', usr_password='$pass_default' WHERE id = '0' LIMIT 1;";
  $Os_query_insertar = $sql_insertar or die("Error al escribir en la base de datos" . mysqli_error($Os_link));
  $Os_result_insertar = $Os_link->query($sql_insertar);

echo "Datos actualizados satisfactoriamente Usuario: admin - Password: admin";

}

?>

