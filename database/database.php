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
                $nome = $_POST["nome"];
                $email = $_POST["email"];
                $senha = md5($_POST["senha"]);
                $data_nasc = $_POST["data"];


                $sql = "UPDATE usuarios SET nome='{$nome}',
                                            email='{$email}',
                                            senha='{$senha}',
                                            data_nasc='{$data_nasc}'
                                        WHERE
                                            id =".$_REQUEST['id'];
                $result = $conf->query($sql);

                if($result==true){
                    print "<script>alert('Edição concluída!');</script>";
                    print "<script>location.href='?page=listar';</script>";
                }else{
                    print "<script>alert('ERRO: Não foi possível concluir a edição!');</script>";
                    print "<script>location.href='?page=default';</script>";
                }
                break;
                case 'excluir':
                    $sql = "DELETE FROM usuarios WHERE id=".$_REQUEST['id'];
                    $result = $conf->query($sql);

                    if($result==true){
                        print "<script>alert('Exclusão concluída!');</script>";
                        print "<script>location.href='?page=listar';</script>";
                    }else{
                        print "<script>alert('ERRO: Não foi possível excluir o registro!');</script>";
                        print "<script>location.href='?page=default';</script>";
                    }
                    break;
                case 'esquecisenha':
                    $senha = md5($_POST["senha"]);

                    $sql = "UPDATE user SET senha='{$senha}' WHERE id =".$_REQUEST['id'];
                    $result = $conf->query($sql);
    
                    if($result==true){
                        print "<script>alert('Edição concluída!');</script>";
                        print "<script>location.href='?page=listar';</script>";
                    }else{
                        print "<script>alert('ERRO: Não foi possível concluir a edição!');</script>";
                        print "<script>location.href='?page=default';</script>";
                    }
                    break;
    }
?>