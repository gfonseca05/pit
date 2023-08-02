<?php
include_once("../config.php");
session_start();
$query = "SELECT * FROM user WHERE email = '{$_SESSION['email']}'";
$result = mysqli_query($conn, $query);
$row = mysqli_fetch_assoc($result);

$poolName;
switch($_REQUEST['delete']) {
    case '1':
        $poolName = $_SESSION['poolNameOne'];
        break;
    case '2':
        $poolName = $_SESSION['poolNameTwo'];
        break;
    case '3':
        $poolName = $_SESSION['poolNameThree'];
}
$sql = "DELETE FROM piscina WHERE fk_user_id = '{$row['user_id']}' AND nome = '{$poolName}' ";
$result = $conn->query($sql);
if($result==true){
    print "<script>alert('Piscina Deletada!');</script>";
    print "<script>location.href='../../Hub/Profile/profile.php';</script>";
}else{
    print "<script>alert('ERRO: Não foi possível deletar a piscina!');</script>";
}
?>