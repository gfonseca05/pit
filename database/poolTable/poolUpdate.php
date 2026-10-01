<?php
include_once("../config.php");
exigirLogin('user', '../../Login/login.php');

$row = buscarConta($conn, 'user', $_SESSION['email']);

$nextClean = $_POST['prox'] ?? '';
$lastClean = $_POST['ult'] ?? '';
$user = $row['user_id'];
$pool = $_POST['variavel'] ?? '';

$stmt = $conn->prepare("UPDATE piscina SET proximaLimpeza = ?, ultimaLimpeza = ? WHERE fk_user_id = ? AND nome = ?");
$stmt->bind_param("ssis", $nextClean, $lastClean, $user, $pool);
$result = $stmt->execute();
if ($result == true) {
    alertaERedireciona('Data Alterada!', '../../Hub/Profile/profile.php');
} else {
    print "<script>alert('ERRO: Não foi possível alterar a piscina!');</script>";
}
?>
