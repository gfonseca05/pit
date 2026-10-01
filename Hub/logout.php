<?php
require_once("../database/seguranca.php");
iniciarSessao();
$_SESSION = [];
session_destroy();
header("Location: ../index.html");
exit();
