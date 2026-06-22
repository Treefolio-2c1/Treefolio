<?php
session_start();

// cria código (simulação)
if(!isset($_SESSION['codigo'])){
    $_SESSION['codigo'] = rand(100000, 999999);
    echo "Código gerado (simulação): " . $_SESSION['codigo'] . "<br><br>";
}

if($_SERVER["REQUEST_METHOD"] == "POST"){

    $codigoDigitado = $_POST['codigo'];

    if($codigoDigitado == $_SESSION['codigo']){
        echo "Email verificado";
        unset($_SESSION['codigo']);
    } else {
        echo "Código incorreto";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Verificar Email</title>
</head>
<body>

<h2>Verificação de Email</h2>

<form method="POST">
    <input type="text" name="codigo" placeholder="Digite o código" required>
    <br><br>
    <button type="submit">Verificar</button>
</form>

</body>
</html>