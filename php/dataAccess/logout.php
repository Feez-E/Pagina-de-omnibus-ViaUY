<?php
include('../businessLogic/usuario.php');
session_start();
unset($_SESSION["userData"]);
header("Location: ../../index.php");
exit;
?>