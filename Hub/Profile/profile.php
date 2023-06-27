<?php
include('../../database/config.php');
session_start();

$query = "SELECT * FROM user WHERE email = '{$_SESSION['email']}'";

$result = mysqli_query($conn, $query);

if (!$result) {
    echo "Erro na consulta: " . mysqli_error($conn);
    exit();
}

$row = mysqli_fetch_assoc($result);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src="https://cdn.tailwindcss.com"></script>

    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,400,0,0" />
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,400,0,0" />
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,400,0,0" />
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,400,0,0" />
</head>

<body class="flex">
    <div
        class="profile container flex flex-col items-center text-2xl p-5 md:w-1/5 md:h-screen md:shadow-2xl md:shadow-black md:z-10 md:bg-slate-700 md:text-white">
        <div class="avatar rounded-full h-1/3 md:h-auto bg-black mb-8 "><img
                class="rounded-full min-h-40 max-h-40 min-w-40 max-w-40 w-40 h-40"
                src="data:image/jpeg;base64,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"
                alt="">
        </div>
        <div class="data w-full grid grid-rows-6 grid-cols-2 gap-3 md:grid-rows-8 h-fit">
            <div class="name flex w-full col-span-2">
                <span class="material-symbols-outlined mt-1 text-sky-600 ">
                    person
                </span>
                <p class="text-left ml-3" id="user">
                    <?php echo $row['nome'] ?>
                </p>
            </div>
            <div class="mail flex w-full col-span-2">
                <span class="material-symbols-outlined mt-1 text-sky-600 ">
                    mail
                </span>
                <p class="text-left ml-3" id="email">
                    <?php echo $row['email'] ?>
                </p>
            </div>
            <div class="phone flex w-full col-span-2">
                <span class="material-symbols-outlined mt-1 text-sky-600 ">
                    call
                </span>
                <p class="text-left ml-3" id="phone">
                    <?php
                    if ($row['telefone'] != '')
                        echo $row['telefone'];
                    else
                        echo 'Você não cadastrou esses dados';
                    ?>
                </p>
            </div>
            <div class="address flex w-full col-span-2">
                <span class="material-symbols-outlined mt-1 text-sky-600 ">
                    home
                </span>
                <p class="text-left ml-3" id="address">
                    <?php
                    if ($row['endereco'] != '')
                        echo $row['endereco'];
                    else
                        echo 'Você não cadastrou esses dados';
                    ?>
                </p>
            </div>
            <a href="update.php"
                class="edit rounded-lg bg-sky-500 transition duration-700 ease-in-out hover:bg-sky-400 w-full row-span-2 md:col-span-2 md:bg-sky-800 md:hover:bg-violet-700 flex items-center justify-center h-2/3 self-center">Editar
                Perfil</a>
            <a href="../../database/password.php"
                class="changePsw rounded-lg bg-blue-500 transition duration-700 ease-in-out hover:bg-blue-600 w-full row-span-2 flex items-center justify-center md:row-start-7 md:row-span-2 md:col-span-2 md:h-full md:bg-blue-800 md:hover:bg-indigo-700">
                Alterar
                Senha</a>
        </div>
    </div>
    <div
        class="pools hidden md:visible md:w-4/5 md:h-screen bg-blue-50 md:z-0 md:grid md:grid-cols-3 md:grid-rows-3 md:gap-x-24 md:gap-y-20 md:p-20">
        <a href="../Pool\CriarPiscina/pool.php" class="bg-white/[0.4] shadow-2xl shadow-slate-400/50 h-full w-full rounded-xl cursor-pointer p-5">Clique aqui para adicionar uma piscina </a>
        <div class="bg-white/[0.4] shadow-2xl shadow-slate-400/50 h-full w-full rounded-xl cursor-pointer"></div>
        <div class="bg-white/[0.4] shadow-2xl shadow-slate-400/50 h-full w-full rounded-xl cursor-pointer"></div>
        <div
            class="bg-yellow-200 shadow-2xl shadow-slate-400/50 h-full w-full rounded-xl flex items-center justify-center text-center text-4xl cursor-pointer">
            Para adicionar mais piscinas, adquira a versão premium</div>

    </div>

    <script src="script.js"></script>
</body>

</html>