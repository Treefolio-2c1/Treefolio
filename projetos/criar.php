<?php
session_start();

require "../config/conexao.php";

if(!isset($_SESSION['id_user'])){
    header("Location: ../login.php");
    exit;
}

$id_user = $_SESSION['id_user'];
$erro = "";

if(isset($_POST['criar'])){

    $titulo = $_POST['titulo'];
    $descricao = $_POST['descricao'];
    $categoria = $_POST['categoria'];
    $capa = $_FILES['capa'];

    try{

        $sql = "INSERT INTO projetos 
        (id_user, titulo, descricao, categoria)
        VALUES (?, ?, ?, ?)";

        $stmt = $pdo->prepare($sql);

        $stmt->execute([
            $id_user,
            $titulo,
            $descricao,
            $categoria
        ]);

        $id_projeto = $pdo->lastInsertId();

        $nome_pasta = "proj_".$id_projeto."_".str_replace(
            " ",
            "_",
            strtolower($titulo)
        );

        $pasta = "../uploads/usuarios/user_".$id_user."/projetos/".$nome_pasta."/";

        mkdir($pasta."posts", 0777, true);
        mkdir($pasta."arquivos", 0777, true);

        $extensao = pathinfo($capa['name'], PATHINFO_EXTENSION);

        $nome_capa = "capa.".$extensao;

        move_uploaded_file(
            $capa['tmp_name'],
            $pasta.$nome_capa
        );

        $caminho_capa = "uploads/usuarios/user_".$id_user.
        "/projetos/".$nome_pasta."/".$nome_capa;

        $sql = "UPDATE projetos 
        SET capa = ?
        WHERE id_projeto = ?";

        $stmt = $pdo->prepare($sql);

        $stmt->execute([
            $caminho_capa,
            $id_projeto
        ]);

        header("Location: index.php");
        exit;

    }catch(PDOException $e){

        $erro = "Erro ao criar projeto: ".$e->getMessage();

    }

}
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Criar projeto — Treefolio</title>

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
        Criar projeto
      </h1>
    </div>

    <?php if (!empty($erro)): ?>
      <div class="alert alert--error mb-2">
        ⚠️ <?= htmlspecialchars($erro) ?>
      </div>
    <?php endif; ?>

    <form method="POST" action="" enctype="multipart/form-data">
      <div class="form-group">
        <label class="form-label" for="titulo">Título do projeto</label>
        <input class="form-input" type="text" id="titulo" name="titulo" placeholder="Ex: Casa Moderna 2026" required>
      </div>
      <div class="form-group">
        <label class="form-label" for="descricao">Descrição</label>
        <textarea class="form-input" id="descricao" name="descricao" placeholder="Descreva seu projeto..." rows="5" required></textarea>
      </div>
      <div class="form-group">
        <label class="form-label" for="categoria"> Categoria do projeto</label>
        <input class="form-input" type="text" id="categoria" name="categoria" placeholder="Arquitetura, Programação, Arte..."required>
      </div>
      <div class="form-group">
        <label class="form-label" for="capa">Capa do projeto</label>
        <input class="form-input" type="file" id="capa" name="capa" accept="image/*" required>
      </div>
      <button type="submit" name="criar" class="btn btn--primary btn--full btn--lg mt-2">Criar Projeto</button>
    </form>
  </div>
</div>

<?php include "../includes/footer.php"; ?>

</body>
</html>