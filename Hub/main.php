<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="../dist/output.css" rel="stylesheet">
    <style>
        .profile-image {
            background-color: blue; /* Marcação para a posição da foto de perfil */
            width: 40px;
            height: 40px;
            border-radius: 50%;
        }

        .dropdown-content {
            right: 0;
            top: 100%;
        }
    </style>
</head>

<body class="bg-gray-100">
    <?php
    print "<h2>Olá, ". $email ."</h2>";
    ?>
    <div class="flex justify-end items-center p-4 relative">
        <div class="relative z-10">
            <div class="profile-image"></div>
            <div class="absolute right-0 mt-2 w-48 bg-white border border-gray-200 rounded-lg shadow-md hidden dropdown-content">
                <ul class="py-2">
                    <li><a href="#" class="block px-4 py-2 text-gray-800 hover:bg-blue-500">Perfil</a></li>
                    <li><a href="#" class="block px-4 py-2 text-gray-800 hover:bg-gray-200">Log Off</a></li>
                </ul>
            </div>
        </div>
    </div>

    <div class="container mx-auto px-4">
        <div class="max-w-sm mx-auto bg-white shadow-md rounded-lg overflow-hidden">
            <div class="p-4">
                <h2 class="text-xl font-semibold text-gray-800">Card da Piscina</h2>
                <p class="text-gray-600 mt-2">Clique no card para ir para a página da piscina.</p>
            </div>
            <div class="p-4">
                <a href="./Pool/CriarPiscina/pool.html" class="block bg-blue-500 hover:bg-blue-600 text-white text-center font-semibold py-2 px-4 rounded">Adicionar Piscina</a>
            </div>
        </div>
    </div>
    <script src="script.js"></script>
</body>

</html>
