<?php
session_start();

require "../config/conexao.php";

if(!isset($_SESSION['id_user'])){
    header("Location: ../auth/login.php");
    exit;
}

if(!isset($_GET['id'])){
    header("Location: ../index.php");
    exit;
}

$id_user = $_SESSION['id_user'];
$id_projeto = $_GET['id'];
$erro = "";

$sql = "SELECT * FROM projetos
WHERE id_projeto = ?
AND id_user = ?";

$stmt = $pdo->prepare($sql);
$stmt->execute([$id_projeto, $id_user]);

$projeto = $stmt->fetch(PDO::FETCH_ASSOC);

if(!$projeto){
    header("Location: ../index.php");
    exit;
}

if(isset($_POST["publicar"])){

    $legenda = trim($_POST["legenda"]);
    $categoria = $_POST["categoria"];

    if(empty($legenda)){
        $erro = "Digite uma legenda.";
    }

    if(empty($_FILES["arquivo"]["name"])){
        $erro = "Selecione um arquivo.";
    }

    if(empty($erro)){

        $arquivo = $_FILES["arquivo"];

        $nomeOriginal = $arquivo["name"];
        $tmp = $arquivo["tmp_name"];

        $extensao = strtolower(pathinfo($nomeOriginal, PATHINFO_EXTENSION));

        $tipo = "outro";

        if(in_array($extensao, ["jpg","jpeg","png","webp","gif"])){
            $tipo = "imagem";
        }

        elseif(in_array($extensao, ["mp4","webm","mov"])){
            $tipo = "video";
        }

        elseif(in_array($extensao, ["mp3","wav","ogg"])){
            $tipo = "audio";
        }

        elseif($extensao == "pdf"){
            $tipo = "pdf";
        }

        try{

            $sql = "INSERT INTO post
            (id_user,id_projeto,id_categoria,arquivo,legenda,tipo)
            VALUES(?,?,?,?,?,?)";

            $stmt = $pdo->prepare($sql);

            $stmt->execute([
                $id_user,
                $id_projeto,
                $categoria,
                "",
                $legenda,
                $tipo
            ]);

            $id_post = $pdo->lastInsertId();

            $pastaProjeto = "../uploads/projetos/user_".$id_user."/proj_".$id_projeto;

            $pastaPosts = $pastaProjeto."/posts";

            if(!is_dir($pastaPosts)){
                mkdir($pastaPosts,0777,true);
            }

            $pastaPost = $pastaPosts."/post_".$id_post;

            if(!is_dir($pastaPost)){
                mkdir($pastaPost,0777,true);
            }

            $nomeArquivo = "arquivo.".$extensao;

            $caminho = $pastaPost."/".$nomeArquivo;

            move_uploaded_file($tmp,$caminho);

            $caminhoBanco = "uploads/projetos/user_".$id_user."/proj_".$id_projeto."/posts/post_".$id_post."/".$nomeArquivo;

            $sql = "UPDATE post
            SET arquivo = ?
            WHERE id_post = ?";

            $stmt = $pdo->prepare($sql);

            $stmt->execute([
                $caminhoBanco,
                $id_post
            ]);

            header("Location: ../projetos/visualizar.php?id=".$id_projeto);
            exit;

        }catch(PDOException $e){

            $erro = "Erro ao criar post.";

        }

    }

}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Novo Post — Treefolio</title>

<?php include "../includes/header.php"; ?>

</head>

<body>

<nav class="navbar">

<a class="navbar__logo" href="../index.php">

<img src="../Static/img/logo.svg" alt="Treefolio">

<span class="navbar__logo-text">
tree<span>folio</span>
</span>

</a>

</nav>

<div class="auth-page">

<div class="card auth-card card--elevated">

<div class="auth-header">

<img class="auth-header__logo" src="../Static/img/logo.svg" alt="Treefolio">

<h1 class="heading-lg">
Novo Post
</h1>

<p class="text-muted mt-1">
Adicione um novo conteúdo ao projeto
</p>

</div>

<?php if(!empty($erro)): ?>

<div class="alert alert--error mb-2">

<?= htmlspecialchars($erro) ?>

</div>

<?php endif; ?>

<form method="POST" enctype="multipart/form-data">

<div class="form-group">

<label class="form-label">
Arquivo
</label>

<input
class="form-input"
type="file"
name="arquivo"
required>

</div>

<div class="form-group">

<label class="form-label">
Categoria
</label>

<select
class="form-input"
name="categoria"
required>

<option value="">Selecione</option>

<?php

$sql = "SELECT * FROM categorias ORDER BY categoria";

$stmt = $pdo->prepare($sql);

$stmt->execute();

while($categoria = $stmt->fetch(PDO::FETCH_ASSOC)){

?>

<option value="<?= $categoria['id_categoria'] ?>">

<?= htmlspecialchars($categoria['categoria']) ?>

</option>

<?php } ?>

</select>

</div>

<div class="form-group">

<label class="form-label">
Legenda
</label>

<textarea
class="form-input"
name="legenda"
rows="5"
placeholder="Conte um pouco sobre este post..."
required></textarea>

</div>

<button
type="submit"
name="publicar"
class="btn btn--primary btn--full btn--lg mt-2">

Publicar Post

</button>

</form>

</div>

</div>

<?php include "../includes/footer.php"; ?>

</body>
</html>