<?php
include("./config.php");
iniciarSessao();

switch ($_REQUEST['acao'] ?? '') {
    case 'cadastrar':
        $email = trim($_POST["email"] ?? "");
        $user = trim($_POST["user"] ?? "");
        $password = $_POST["psw"] ?? "";

        if ($email === "" || $user === "" || $password === "") {
            alertaERedireciona('ERRO: Preencha todos os campos!', '../Cadastro/cadastro.php');
        }
        if (emailEmUso($conn, $email)) {
            alertaERedireciona('ERRO: Este email já está cadastrado!', '../Cadastro/cadastro.php');
        }

        $hash = password_hash($password, PASSWORD_DEFAULT);
        $code = gerarCodigo();

        $stmt = $conn->prepare("INSERT INTO user (nome, email, senha, verify_cod) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $user, $email, $hash, $code);
        $result = $stmt->execute();

        if ($result == true) {
            alertaERedireciona('Cadastro concluído!', '../Login/login.php');
        } else {
            print "<script>alert('ERRO: Não foi possível concluir o cadastro!');</script>";
        }
        break;
    case 'cadastrar-pro':
        $email = trim($_POST["email"] ?? "");
        $user = trim($_POST["user"] ?? "");
        $password = $_POST["psw"] ?? "";
        $tel = trim($_POST["tel"] ?? "");

        if ($email === "" || $user === "" || $password === "") {
            alertaERedireciona('ERRO: Preencha todos os campos!', '../Cadastro/cadastro-profissional.php');
        }
        if (emailEmUso($conn, $email)) {
            alertaERedireciona('ERRO: Este email já está cadastrado!', '../Cadastro/cadastro-profissional.php');
        }

        $hash = password_hash($password, PASSWORD_DEFAULT);
        $code = gerarCodigo();

        $stmt = $conn->prepare("INSERT INTO profissional (nome, email, senha, telefone, verify_cod) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssss", $user, $email, $hash, $tel, $code);
        $result = $stmt->execute();

        if ($result == true) {
            alertaERedireciona('Cadastro concluído!', '../Login/login.php');
        } else {
            print "<script>alert('ERRO: Não foi possível concluir o cadastro!');</script>";
        }
        break;
    case 'editar':
        exigirLogin('user', '../Login/login.php');
        $row = buscarConta($conn, 'user', $_SESSION['email']);

        $nome = trim($_POST["name"] ?? "");
        $email = trim($_POST["email"] ?? "");
        $telefone = trim($_POST["phone"] ?? "");
        $endereco = trim($_POST["address"] ?? "");

        //Impede trocar para um email que já pertence a outra conta
        if ($email !== $row['email'] && emailEmUso($conn, $email)) {
            alertaERedireciona('ERRO: Este email já está cadastrado!', '../Hub/Profile/profile.php');
        }

        $stmt = $conn->prepare("UPDATE user SET nome = ?, email = ?, telefone = ?, endereco = ? WHERE user_id = ?");
        $stmt->bind_param("ssssi", $nome, $email, $telefone, $endereco, $row['user_id']);
        $result = $stmt->execute();

        if ($result == true) {
            $_SESSION['email'] = $email;
            alertaERedireciona('Edição concluída!', '../Hub/Profile/profile.php');
        } else {
            alertaERedireciona('ERRO: Não foi possível concluir a edição!', '../Hub/Profile/profile.php');
        }
        break;
    case 'editar-pro':
        exigirLogin('profissional', '../Login/login.php');
        $row = buscarConta($conn, 'profissional', $_SESSION['email']);

        $nome = trim($_POST["name"] ?? "");
        $email = trim($_POST["email"] ?? "");
        $telefone = trim($_POST["phone"] ?? "");

        if ($email !== $row['email'] && emailEmUso($conn, $email)) {
            alertaERedireciona('ERRO: Este email já está cadastrado!', '../Hub/Profile/profile-profissional.php');
        }

        $stmt = $conn->prepare("UPDATE profissional SET nome = ?, email = ?, telefone = ? WHERE profissional_id = ?");
        $stmt->bind_param("sssi", $nome, $email, $telefone, $row['profissional_id']);
        $result = $stmt->execute();

        if ($result == true) {
            $_SESSION['email'] = $email;
            alertaERedireciona('Edição concluída!', '../Hub/Profile/profile-profissional.php');
        } else {
            alertaERedireciona('ERRO: Não foi possível concluir a edição!', '../Hub/Profile/profile-profissional.php');
        }
        break;
    case 'esquecisenha':
        exigirLogin('user', '../Login/login.php');
        $row = buscarConta($conn, 'user', $_SESSION['email']);

        $code = trim($_POST["code"] ?? "");
        $newpass = $_POST["psw"] ?? "";

        //O código precisa ser o da conta logada
        if ($newpass === "" || !hash_equals((string) $row['verify_cod'], $code)) {
            alertaERedireciona('ERRO: Código inválido!', '../Hub/password.php');
        }

        //Troca a senha e gera um novo código, para que o antigo não possa ser reutilizado
        $hash = password_hash($newpass, PASSWORD_DEFAULT);
        $novoCodigo = gerarCodigo();
        $stmt = $conn->prepare("UPDATE user SET senha = ?, verify_cod = ? WHERE user_id = ?");
        $stmt->bind_param("ssi", $hash, $novoCodigo, $row['user_id']);
        $result = $stmt->execute();

        if ($result == true) {
            alertaERedireciona('Edição concluída!', '../Hub/Profile/profile.php');
        } else {
            alertaERedireciona('ERRO: Não foi possível concluir a edição!', '../Hub/Profile/profile.php');
        }
        break;
    case 'Excluir Perfil':
        exigirLogin('user', '../Login/login.php');
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            alertaERedireciona('ERRO: Requisição inválida!', '../Hub/Profile/profile.php');
        }
        $row = buscarConta($conn, 'user', $_SESSION['email']);

        //As piscinas são removidas junto pelo ON DELETE CASCADE, mas apagamos antes por garantia
        $stmt = $conn->prepare("DELETE FROM piscina WHERE fk_user_id = ?");
        $stmt->bind_param("i", $row['user_id']);
        $teste = $stmt->execute();

        $stmt = $conn->prepare("DELETE FROM user WHERE user_id = ?");
        $stmt->bind_param("i", $row['user_id']);
        $result = $stmt->execute();

        if ($result == true && $teste == true) {
            session_destroy();
            alertaERedireciona('Exclusão concluída!', '../index.html');
        } else {
            alertaERedireciona('ERRO: Não foi possível concluir a exclusao!', '../Hub/Profile/profile.php');
        }
        break;
    case 'Excluir Conta':
        exigirLogin('profissional', '../Login/login.php');
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            alertaERedireciona('ERRO: Requisição inválida!', '../Hub/Profile/profile-profissional.php');
        }
        $stmt = $conn->prepare("DELETE FROM profissional WHERE email = ?");
        $stmt->bind_param("s", $_SESSION['email']);
        $result = $stmt->execute();

        if ($result == true) {
            session_destroy();
            alertaERedireciona('Exclusão concluída!', '../index.html');
        } else {
            alertaERedireciona('ERRO: Não foi possível concluir a exclusao!', '../Hub/Profile/profile-profissional.php');
        }
        break;
}
