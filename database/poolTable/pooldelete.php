<?php
include_once("../config.php");
include_once("../databaase.php");
session_start();
$query = "SELECT * FROM user WHERE email = '{$_SESSION['email']}'";
$result = mysqli_query($conn, $query);
$row = mysqli_fetch_assoc($result);

$sql = "DELETE FROM piscina WHERE fk_user_id = '{$row['user_id']}' AND nome = '' ";
$result = $conn->query($sql);
if($result==true){
    print "<script>alert('Piscina Deletada!');</script>";
    print "<script>location.href='../../Hub/Profile/profile.php';</script>";
}else{
    print "<script>alert('ERRO: Não foi possível deletar a piscina!');</script>";
}
?>