<?php
include("./config.php");
switch ($_REQUEST['acao']) {
    case 'cadastrar':
        $email = $_POST["email"];
        $user = $_POST["user"];
        $password = ($_POST["psw"]);
        $code = mt_rand(10000, 99999);

        $sql = "INSERT INTO user (nome, email, senha, verify_cod) VALUES ('{$user}', '{$email}', '{$password}', '{$code}')";
        $result = $conn->query($sql);

        if ($result == true) {
            print "<script>alert('Cadastro concluído!');</script>";
            print "<script>location.href='../Login/login.php';</script>";
        } else {
            print "<script>alert('ERRO: Não foi possível concluir o cadastro!');</script>";
        }
        break;
    case 'cadastrar-pro':
        $email = $_POST["email"];
        $user = $_POST["user"];
        $password = ($_POST["psw"]);
        $code = mt_rand(10000, 99999);
        $tel = ($_POST["tel"]);

        $sql = "INSERT INTO profissional (nome, email, senha, telefone, verify_cod) VALUES ('{$user}', '{$email}', '{$password}', '{$tel}', '{$code}')";
        $result = $conn->query($sql);

        if ($result == true) {
            print "<script>alert('Cadastro concluído!');</script>";
            print "<script>location.href='../Login/login.php';</script>";
        } else {
            print "<script>alert('ERRO: Não foi possível concluir o cadastro!');</script>";
        }
        break;
    case 'editar':
        session_start();

        $query = "SELECT user_id FROM user WHERE email = '{$_SESSION['email']}'";
        $result = mysqli_query($conn, $query);
        if (!$result) {
            echo "Erro na consulta: " . mysqli_error($conn);
            exit();
        }
        $row = mysqli_fetch_assoc($result);

        $nome = $_POST["name"];
        $email = $_POST["email"];
        $telefone = $_POST["phone"];
        $endereco = $_POST["address"];

        $sql = "UPDATE user SET nome='{$nome}',
                                            email='{$email}',
                                            telefone='{$telefone}',
                                            endereco='{$endereco}'
                                        WHERE
                                            user_id = '{$row['user_id']}'";
        $result = $conn->query($sql);

        if ($result == true) {
            $_SESSION['email'] = $email;
            print "<script>alert('Edição concluída!');</script>";
            print "<script>location.href='../Hub/Profile/profile.php';</script>";
        } else {
            print "<script>alert('ERRO: Não foi possível concluir a edição!');</script>";
            print "<script>location.href='../Hub/Profile/profile.php';</script>";
        }
        break;
    case 'editar-pro':
        session_start();

        $query = "SELECT profissional_id FROM profissional WHERE email = '{$_SESSION['email']}'";
        $result = mysqli_query($conn, $query);
        if (!$result) {
            echo "Erro na consulta: " . mysqli_error($conn);
            exit();
        }
        $row = mysqli_fetch_assoc($result);

        $nome = $_POST["name"];
        $email = $_POST["email"];
        $telefone = $_POST["phone"];

        $sql = "UPDATE profissional SET nome='{$nome}',
                                                email='{$email}',
                                                telefone='{$telefone}'
                                            WHERE
                                                profissional_id = '{$row['profissional_id']}'";
        $result = $conn->query($sql);

        if ($result == true) {
            $_SESSION['email'] = $email;
            print "<script>alert('Edição concluída!');</script>";
            print "<script>location.href='../Hub/Profile/profile-profissional.php';</script>";
        } else {
            print "<script>alert('ERRO: Não foi possível concluir a edição!');</script>";
            print "<script>location.href='../Hub/Profile/profile-profissional.php';</script>";
        }
        break;
    case 'esquecisenha':
        session_start();

        $code = $_POST["code"];
        $newpass = $_POST["psw"];

        $query = "SELECT verify_cod FROM user WHERE email = '{$_SESSION['email']}' AND verify_cod = '{$code}'";
        $result = mysqli_query($conn, $query);
        if (!$result) {
            echo "Erro na consulta: " . mysqli_error($conn);
            exit();
        }
        if ($result == true) {
            //não esta reconhecndo o $newpass
            $query = "UPDATE user SET senha= '{$newpass}' WHERE verify_cod = '{$code}'";
            $result = mysqli_query($conn, $query);
            print "<script>alert('Edição concluída!');</script>";
            print "<script>location.href='../Hub/Profile/profile.php';</script>";
        } else {
            print "<script>alert('ERRO: Não foi possível concluir a edição!');</script>";
            print "<script>location.href='../Hub/Profile/profile.php';</script>";
        }
        break;
    case 'Excluir Perfil':
        session_start();

        $query = "SELECT * FROM user WHERE email = '{$_SESSION['email']}'";
        $result = mysqli_query($conn, $query);
        $row = mysqli_fetch_assoc($result);
        if (!$result) {
            echo "Erro na consulta: " . mysqli_error($conn);
            exit();
        }

        /* $email = $_POST["email"]; */

        $sql = "DELETE FROM user WHERE email = '{$_SESSION['email']}'";
        $result = $conn->query($sql);

        $delete = "DELETE FROM piscina WHERE fk_user_id = {$row['user_id']}";
        $teste = $conn->query($delete);
        if ($result == true && $teste == true) {
            /* $_SESSION['email'] = $email; */
            print "<script>alert('Exclusão concluída!');</script>";
            print "<script>location.href='../index.html';</script>";
        } else {
            print "<script>alert('ERRO: Não foi possível concluir a exclusao!');</script>";
            print "<script>location.href='../Hub/Profile/profile.php';</script>";
        }
        break;
    case 'Excluir Conta': //Testar todo esse coódigo
        session_start();
        $sql = "DELETE FROM profissional WHERE email = '{$_SESSION['email']}'";
        $result = $conn->query($sql);
        if ($result == true) {
            print "<script>alert('Exclusão concluída!');</script>";
            print "<script>location.href='../index.html';</script>";
        } else {
            print "<script>alert('ERRO: Não foi possível concluir a exclusao!');</script>";
            print "<script>location.href='../Hub/Profile/profile-profissional.php';</script>";
        }
        break;
}