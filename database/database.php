<?php
    include("./config.php");
    switch($_REQUEST['acao']){
        case 'cadastrar':
            $email = $_POST["email"];
            $user = $_POST["user"];
            $password = ($_POST["psw"]);
            $code = mt_rand(10000, 99999);
            
            $sql = "INSERT INTO user (nome, email, senha, verify_cod) VALUES ('{$user}', '{$email}', '{$password}', '{$code}')";
            $result = $conn->query($sql);
            
            if($result==true){
                print "<script>alert('Cadastro concluído!');</script>";
                print "<script>location.href='../Login/login.php';</script>";
            }else{
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

                if($result==true){
                    $_SESSION['email'] = $email;
                    print "<script>alert('Edição concluída!');</script>";
                    print "<script>location.href='../Hub/Profile/profile.php';</script>";
                }else{
                    print "<script>alert('ERRO: Não foi possível concluir a edição!');</script>";
                    print "<script>location.href='../Hub/Profile/profile.php';</script>";
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
                    if($result==true){
                        //não esta reconhecndo o $newpass
                        $query = "UPDATE user SET senha='{$newpass}' WHERE verify_cod = '{$code}'";
                        $result = mysqli_query($conn, $query);
                        print "<script>alert('Edição concluída!');</script>";
                        print "<script>location.href='../Hub/Profile/profile.php';</script>";
                    }else{
                        print "<script>alert('ERRO: Não foi possível concluir a edição!');</script>";
                        print "<script>location.href='../Hub/Profile/profile.php';</script>";
                    }
                    break;
    }
