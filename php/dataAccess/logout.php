<?php
include_once ($_SERVER['DOCUMENT_ROOT'].'/Proyecto Final/dirs.php');
include(BUSINESS_PATH.'usuario.php');
session_start();
unset($_SESSION["userData"]);
header("Location: /Proyecto Final/index.php");
exit;
?>