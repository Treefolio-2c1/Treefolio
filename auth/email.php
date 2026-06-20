<?php
session_start();

if(!isset($_SESSION['email'])){
    echo "Acesso inválido";
    exit;
}

if(!isset($_SESSION['token'])){
    $_SESSION['token'] = bin2hex(random_bytes(16));
    $_SESSION['expira'] = time() + 600;
}

$link = "http://localhost/Treefolio/auth/verifica_email.php?token=" . $_SESSION['token'];

if(isset($_POST['enviar'])){
    $_SESSION['email_enviado'] = true;
}

if(isset($_POST['reenviar'])){
    $_SESSION['token'] = bin2hex(random_bytes(16));
    $_SESSION['expira'] = time() + 600;
    $_SESSION['email_enviado'] = true;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Verificar Email</title>
</head>
<body>

<h2>Verifique seu email</h2>

<?php if(!isset($_SESSION['email_enviado'])): ?>

<form method="POST">
    <button type="submit" name="enviar">Enviar Email</button>
</form>

<?php else: ?>

<p>Email enviado!</p>

<a href="<?php echo $link; ?>" style="padding:10px 20px;background:#3b82f6;color:white;text-decoration:none;border-radius:5px;">
    Simular clique do email
</a>

<br><br>

<form method="POST">
    <button type="submit" name="reenviar">Reenviar Email</button>
</form>

<?php endif; ?>

</body>
</html>