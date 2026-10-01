<?php
    include_once("../config.php");
    exigirLogin('user', '../../Login/login.php');

    $row = buscarConta($conn, 'user', $_SESSION['email']);

    $nome = trim($_POST["poolName"] ?? "");
    $largura = (float) ($_POST["width"] ?? 0);
    $profundidade = (float) ($_POST["height"] ?? 0);
    $comprimento = (float) ($_POST["depth"] ?? 0);
    $cod_user = $row['user_id'];
    if(($_POST["nextClean"] ?? "") == "") {
        $proxLimpeza = '0000/00/00';
    }
    else {
        $proxLimpeza = $_POST["nextClean"];
    }
    if(($_POST["lastClean"] ?? "") == "") {
        $ultLimpeza = '0000/00/00';
    }
    else {
        $ultLimpeza = $_POST["lastClean"];
    }

    $stmt = $conn->prepare("INSERT INTO piscina (nome, largura, altura, comprimento, proximaLimpeza, ultimaLimpeza, fk_user_id) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sdddssi", $nome, $largura, $profundidade, $comprimento, $proxLimpeza, $ultLimpeza, $cod_user);
    $result = $stmt->execute();
    if($result==true){
        alertaERedireciona('Cadastro concluído!', '../../Hub/Profile/profile.php');
    }else{
        print "<script>alert('ERRO: Não foi possível cadastrar a piscina!');</script>";
    }
?>
