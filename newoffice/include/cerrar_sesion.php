<?php

session_start();

session_destroy();

header('Content-Type: text/html; charset=ISO-8859-1'); 
header("Location: ../index.php");

exit;
?>
