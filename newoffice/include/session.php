<?php

$Os_link = mysqli_connect(OsHOST,OsUSER,OsPASS,OsDATB) or die("Error: " . mysqli_error($Os_link));
$Os_link_CEN = mysqli_connect(OsHOST_CEN,OsUSER_CEN,OsPASS_CEN,OsDATB_CEN) or die("Error: " . mysqli_error($Os_link_CEN));

if ((isset($_POST['nombre_usuarioOs']) AND isset($_POST['clave_usuarioOs']))){
    $sUsuario = $_POST['nombre_usuarioOs'];	
    $sClave = $_POST['clave_usuarioOs'];
 
  $sClave = md5("Os1r1s".$_POST['clave_usuarioOs']);
 
}else{

    $sUsuario = "";
    $sClave = "";

}
 
if (isset($_SESSION['Os_useradmin'])==true){
 
    $global_userOs=$_SESSION['Os_useradmin'];
    $global_userlvl=$_SESSION['Os_useradlvl'];
    goto comienzo;  
 
}
 
$Os_mysql_user= "SELECT * FROM NewOff_Usuarios WHERE usr_alias='$sUsuario' AND usr_password='$sClave'  LIMIT 1 ";
$Os_query_user = $Os_mysql_user or die("Error al consultar la base de datos" . mysqli_error($Os_link));
$Os_result_user = $Os_link->query($Os_query_user);
 
$usrnombre="";
 
while($Os_row_user = mysqli_fetch_array($Os_result_user)) {
 
    $usrnombre = $Os_row_user['usr_alias'];
    $usrpassword = $Os_row_user['usr_password'];
 
}
 
if (isset($_SESSION['Os_failintentcastigo'])==true AND $_SESSION['Os_failintentcastigo']<>""){
 
 
 
    $tiempo_castigo=$_SESSION['Os_failintentcastigo'];
    $ahora_ya=strtotime('now');
    if ($ahora_ya>($tiempo_castigo+120)){
        $_SESSION['Os_failintentcastigo']="";
    }else{
 
        $_SESSION['Os_failintentcounter']="0";    
        echo "<br><br><center><div class='green-bar' style='width: 500; height: 25; background-color: #ed0000; display: table-cell; vertical-align: middle;'><font style='color:#FFFFFF'>Ha fallado 4 intentos de login, deberá esperar unos minutos antes de volver a intentar</font></div></center>"; 
  
        die();
    }
 
}
 
 
 
if ($usrnombre=="" AND isset($_POST['login'])){
    echo "<br><br><center><div class='green-bar' style='width: 500; height: 25; background-color: #ed0000; display: table-cell; vertical-align: middle;'><font style='color:#FFFFFF'>Fallo al iniciar sesión</font></div></center>";
 
    if (isset($_SESSION['Os_failintentcounter'])==true){
         
        $counterfails=$_SESSION['Os_failintentcounter'];
 
        if($counterfails>3){
            $_SESSION['Os_failintentcastigo']=strtotime('now');
 
 
                echo "<br><br><center><div class='green-bar' style='width: 500; height: 25; background-color: #ed0000; display: table-cell; vertical-align: middle;'><font style='color:#FFFFFF'>Ha fallado 4 intentos de login, deberá esperar unos minutos antes de volver a intentar</font></div></center>";
 
 
die();
 
        }else{
            $_SESSION['Os_failintentcounter']=$_SESSION['Os_failintentcounter']+1;
             
        }
         
    }else{
		$_SESSION['Os_failintentcounter']=0;
		$_SESSION['Os_failintentcounter']=$_SESSION['Os_failintentcounter']+1;  
    }
 
 
}


if ((isset($usrnombre) AND isset($usrpassword)) AND $usrnombre<>""){
 
    $sUsuario = $_POST['nombre_usuarioOs'];
    $sClave = $_POST['clave_usuarioOs'];
 
    $_SESSION['Os_useradmin']=$sUsuario;
    $_SESSION['Os_useradlvl']=$usrnivel;
     
    $global_userOs=$sUsuario;
    $global_userlvl=$usrnivel;
 
 
}else{
 
    echo "<br><br><br><br><center><form id='login_form_Os' method='post' action=''><div class='tablelogin' style='width:50%'><table border=1><thead><tr><th><font style='font-size:19px;'>Inicio Sesion</font><img src='images/impresora.png' style='vertical-align: middle;' align='right'></th></tr></thead><tr><td><table border=0><tbody>";
    echo "<tr><th style='width:100px'>Usuario: </th><td width=350><input class='textbox' name='nombre_usuarioOs' id='nombre_usuarioOs' size='60' type='text' value=''>";
    echo "<br/></td></tr><tr><th>Password: </th><td width=350><input class='textbox' name='clave_usuarioOs' id='clave_usuarioOs' size='60' type='password' value=''><br/></td></tr>";
    echo "<tr><th><input type='submit' name='login' value='Iniciar' class='btn_login' id='login' /></th><td align='left'>
	<a href='recover_pass.php?lightbox[iframe]=true&lightbox[width]=500&lightbox[height]=440' class='lightbox'><button class='btn'>Recupera password</button></a> &nbsp;&nbsp;&nbsp;<img src='images/logo.png' style='width:70px;vertical-align: middle'></td></tr> </form></tbody></table><br>\n";
    echo "</td></tr></table></div></center>";
    die();
 
}
 
comienzo:
 
  
?>
