<?php
include_once("../config.php");
exigirLogin('user', '../../Login/login.php');

$row = buscarConta($conn, 'user', $_SESSION['email']);

$poolName = null;
switch($_REQUEST['delete'] ?? '') {
    case '1':
        $poolName = $_SESSION['poolNameOne'] ?? null;
        break;
    case '2':
        $poolName = $_SESSION['poolNameTwo'] ?? null;
        break;
    case '3':
        $poolName = $_SESSION['poolNameThree'] ?? null;
}
if ($poolName === null) {
    alertaERedireciona('ERRO: Piscina não encontrada!', '../../Hub/Profile/profile.php');
}

$stmt = $conn->prepare("DELETE FROM piscina WHERE fk_user_id = ? AND nome = ?");
$stmt->bind_param("is", $row['user_id'], $poolName);
$result = $stmt->execute();
if($result==true){
    alertaERedireciona('Piscina Deletada!', '../../Hub/Profile/profile.php');
}else{
    print "<script>alert('ERRO: Não foi possível deletar a piscina!');</script>";
}
?>
