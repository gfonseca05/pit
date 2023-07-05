<?php
include_once("../../../database/config.php");
session_start();

$poolName = $_GET['value'];
$sql = "SELECT proximaLimpeza FROM piscina WHERE fk_user_id = {$_SESSION['user_id']} AND nome = '{$poolName}'";

$resultado = $conn->query($sql);
if ($resultado->num_rows > 0) {
    $row = $resultado->fetch_assoc();
    $data = $row["proximaLimpeza"];
    if ($data === null || $data === '0000-00-00') {
        $dataFormatada = '0000-00-00';
    } else {
        $dataFormatada = date("Y-m-d", strtotime($data));
        if ($dataFormatada === false) {
            $data = '0000-00-00';
        }
    }
} else {
    echo "Nenhum resultado encontrado.";
}


$query = "SELECT ultimaLimpeza FROM piscina WHERE fk_user_id = {$_SESSION['user_id']} AND nome = '{$poolName}'";

$result = $conn->query($query);
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $data2 = $row["ultimaLimpeza"];
    if ($data2 === null || $data2 === '0000-00-00') {
        $dataFormatada2 = '0000-00-00';
    } else {
        $dataFormatada2 = date("Y-m-d", strtotime($data2));
        if ($dataFormatada2 === false) {
            $data2 = '0000-00-00';
        }
    }
} else {
    echo "Nenhum resultado encontrado.";
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <!-- <link href="../../../dist/output.css" rel="stylesheet"> -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
</head>
<style>
    .material-symbols-outlined {
        font-variation-settings:
            'FILL' 100,
            'wght' 600,
            'GRAD' 50,
            'opsz' 48
    }
</style>

<body>
    <div class="min-h-screen w-full flex items-center justify-center bg-gray-50">
        <form action="../../../database/poolTable/poolUpdate.php" method="POST">
            <input type="hidden" name="variavel" value="<?php echo $poolName; ?>">
            <h1 class="mb-1 font-bold text-3xl flex gap-1 items-baseline font-mono">Datas de Limpeza<span
                    class="text-sm text-blue-500">atualize as datas</sm>
            </h1>
            <div class="grid max-w-3xl gap-2 py-10 px-8 sm:grid-cols-2 bg-white rounded-md border-t-4 border-blue-400">
                <div class="grid">
                    <div
                        class="bg-white flex min-h-[60px] flex-col-reverse justify-center rounded-md border border-gray-300 px-3 py-2 shadow-sm focus-within:shadow-inner">
                        <input type="text" id="nextClean" oninput="formatDate(this)" name="prox"
                            class="peer block w-full border-0 p-0 text-base text-gray-900 placeholder-gray-400 focus:ring-0"
                            placeholder="AAAA/MM/DD" value="<?php echo $dataFormatada ?>" />
                        <label
                            class="block transform text-xs font-bold uppercase text-gray-400 transition-opacity, duration-200 peer-placeholder-shown:h-0 peer-placeholder-shown:-translate-y-full peer-placeholder-shown:opacity-0">Próxima
                            Limpeza
                        </label>
                    </div>
                </div>
                <div class="switch my-2 md:my-0">
                    <span onclick="alterDate()"
                        class="material-symbols-outlined rotate-90 scale-150 h-full self-center hover:text-blue-500 cursor-pointer transition duration-700 ease-in-out">
                        multiple_stop
                    </span>
                </div>
                <div class="grid">
                    <div
                        class="bg-white first:flex min-h-[60px] flex-col-reverse justify-center rounded-md border border-gray-300 px-3 py-2 shadow-sm focus-within:shadow-inner">
                        <input type="text" id="lastClean" oninput="formatDate(this)" name="ult"
                            class="peer block w-full border-0 p-0 text-base text-gray-900 placeholder-gray-400 focus:ring-0"
                            placeholder="AAAA/MM/DD" value="<?php echo $dataFormatada2 ?>" />
                        <label
                            class="block transform text-xs font-bold uppercase text-gray-400 transition-opacity, duration-200 peer-placeholder-shown:h-0 peer-placeholder-shown:-translate-y-full peer-placeholder-shown:opacity-0">Última
                            Limpeza
                        </label>
                    </div>
                </div>

                <input type="submit" class="mt-4 bg-blue-500 text-white py-2 px-6 rounded-md hover:bg-blue-600 ">
                </input>
            </div>
        </form>
    </div>
    <script src="update.js"></script>
</body>

</html>