<?php
    include_once("../config.php");
    include_once("../databaase.php");
    session_start();

    $query = "SELECT * FROM user WHERE email = '{$_SESSION['email']}'";
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($result);

    $nome = $_POST["poolName"];
    $largura = $_POST["width"];
    $profundidade = $_POST["height"];
    $comprimento = $_POST["depth"];
    $proxLimpeza = $_POST["nextClean"];
    $ultLimpeza = $_POST["lastClean"];
    $cod_user = $row['user_id'];
        
    $sql = "INSERT INTO piscina (nome, largura, altura, comprimento, proximaLimpeza, ultimaLimpeza, fk_user_id) VALUES ('{$nome}', '{$largura}', '{$profundidade}', '{$comprimento}', '{$proxLimpeza}', '{$ultLimpeza}', '{$cod_user}')";
    $result = $conn->query($sql);
    if($result==true){
        print "<script>alert('Cadastro concluído!');</script>";
        print "<script>location.href='../../Hub/Profile/profile.php';</script>";
    }else{
        print "<script>alert('ERRO: Não foi possível cadastrar a piscina!');</script>";
    }
?>