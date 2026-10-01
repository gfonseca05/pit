<?php
// Funções auxiliares de segurança usadas em todo o projeto

// Escapa um valor antes de exibir no HTML (evita XSS)
function e($valor)
{
    return htmlspecialchars((string) ($valor ?? ''), ENT_QUOTES, 'UTF-8');
}

function iniciarSessao()
{
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
}

// Redireciona para o login se não houver sessão do tipo esperado ('user' ou 'profissional')
function exigirLogin($tipo, $urlLogin)
{
    iniciarSessao();
    if (!isset($_SESSION['email'], $_SESSION['tipo']) || $_SESSION['tipo'] !== $tipo) {
        header("Location: {$urlLogin}");
        exit();
    }
}

// Mostra um alerta e redireciona (mesmo padrão já usado no projeto)
function alertaERedireciona($mensagem, $url)
{
    print "<script>alert(" . json_encode($mensagem) . ");</script>";
    print "<script>location.href=" . json_encode($url) . ";</script>";
    exit();
}

// Busca uma conta pelo email. $tabela é sempre um valor fixo do código, nunca do usuário.
function buscarConta($conn, $tabela, $email)
{
    $tabelas = ['user', 'profissional'];
    if (!in_array($tabela, $tabelas, true)) {
        return null;
    }
    $stmt = $conn->prepare("SELECT * FROM {$tabela} WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $conta = $stmt->get_result()->fetch_assoc();
    $stmt->close();
    return $conta ?: null;
}

// Verifica se o email já pertence a alguma conta (cliente ou profissional)
function emailEmUso($conn, $email)
{
    return buscarConta($conn, 'user', $email) !== null
        || buscarConta($conn, 'profissional', $email) !== null;
}

// Confere a senha digitada. Contas antigas, com senha salva em texto puro,
// são aceitas uma última vez e convertidas para hash automaticamente.
function verificarSenha($conn, $tabela, $conta, $senhaDigitada)
{
    $senhaSalva = $conta['senha'];
    $idColuna = $tabela === 'user' ? 'user_id' : 'profissional_id';

    if (password_verify($senhaDigitada, $senhaSalva)) {
        if (password_needs_rehash($senhaSalva, PASSWORD_DEFAULT)) {
            atualizarSenha($conn, $tabela, $idColuna, $conta[$idColuna], $senhaDigitada);
        }
        return true;
    }

    $info = password_get_info($senhaSalva);
    if ($info['algo'] === null && hash_equals($senhaSalva, $senhaDigitada)) {
        atualizarSenha($conn, $tabela, $idColuna, $conta[$idColuna], $senhaDigitada);
        return true;
    }

    return false;
}

function atualizarSenha($conn, $tabela, $idColuna, $id, $novaSenha)
{
    $hash = password_hash($novaSenha, PASSWORD_DEFAULT);
    $stmt = $conn->prepare("UPDATE {$tabela} SET senha = ? WHERE {$idColuna} = ?");
    $stmt->bind_param("si", $hash, $id);
    $ok = $stmt->execute();
    $stmt->close();
    return $ok;
}

// Código de verificação de 5 dígitos gerado de forma criptograficamente segura
function gerarCodigo()
{
    return (string) random_int(10000, 99999);
}

// Faz o login procurando o email nas tabelas indicadas. Retorna a URL de destino ou null.
function fazerLogin($conn, $email, $senha, $tabelas = ['user', 'profissional'])
{
    $destinos = [
        'user' => '../Hub/Profile/profile.php',
        'profissional' => '../Hub/Profile/profile-profissional.php',
    ];

    foreach ($tabelas as $tabela) {
        $conta = buscarConta($conn, $tabela, $email);
        if ($conta === null) {
            continue;
        }
        if (!verificarSenha($conn, $tabela, $conta, $senha)) {
            return null;
        }
        iniciarSessao();
        session_regenerate_id(true);
        $_SESSION['email'] = $conta['email'];
        $_SESSION['tipo'] = $tabela;
        return $destinos[$tabela];
    }
    return null;
}
