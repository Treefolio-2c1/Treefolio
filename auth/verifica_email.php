<?php
session_start();

if(!isset($_GET['token'])){
    echo "Token não enviado";
    exit;
}

if(!isset($_SESSION['token']) || !isset($_SESSION['expira'])){
    echo "Link inválido";
    exit;
}

if(time() > $_SESSION['expira']){
    echo "Link expirado";
    exit;
}

if($_GET['token'] === $_SESSION['token']){
    unset($_SESSION['token']);
    unset($_SESSION['expira']);
    unset($_SESSION['email_enviado']);

    echo "Email verificado com sucesso<br>";
    echo '<a href="login.php">Ir para login</a>';
    exit;
} else {
    echo "Token inválido";
    exit;
}