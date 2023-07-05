<?php
include_once("../config.php");
session_start();
$query = "SELECT * FROM user WHERE email = '{$_SESSION['email']}'";
$result = mysqli_query($conn, $query);
$row = mysqli_fetch_assoc($result);

$nextClean = $_POST['prox'];
$lastClean = $_POST['ult'];
$user = $row['user_id'];
$pool = $_POST['variavel'];

$sql = "UPDATE piscina SET proximaLimpeza = '{$nextClean}', ultimaLimpeza = '{$lastClean}' WHERE fk_user_id = {$user} AND nome = '{$pool}'";
$result = $conn->query($sql);
if ($result == true) {
    print "<script>alert('Data Alterada!');</script>";
    print "<script>location.href='../../Hub/Profile/profile.php';</script>";
} else {
    print "<script>alert('ERRO: Não foi possível alterar a piscina!');</script>";
}
?>