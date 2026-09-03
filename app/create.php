<?php
// create.php - Formulário de cadastro de um novo produto (operação "Create" do CRUD)
require 'db.php';

// Se o formulário foi enviado (POST), insere o novo registro no banco
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = trim($_POST['nome']);
    $descricao = trim($_POST['descricao']);
    $preco = str_replace(',', '.', $_POST['preco']); // aceita vírgula como separador decimal

    // Prepared statement: evita SQL Injection
    $stmt = $pdo->prepare("INSERT INTO produtos (nome, descricao, preco) VALUES (?, ?, ?)");
    $stmt->execute([$nome, $descricao, $preco]);

    header("Location: index.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Novo Produto</title>
    <style>
        body { font-family: Arial, sans-serif; max-width: 500px; margin: 40px auto; padding: 0 20px; }
        label { display: block; margin-top: 12px; font-weight: bold; }
        input, textarea { width: 100%; padding: 8px; margin-top: 4px; box-sizing: border-box; }
        button { margin-top: 20px; padding: 10px 20px; background: #27ae60; color: #fff; border: none; border-radius: 4px; cursor: pointer; }
        a { display: inline-block; margin-top: 15px; }
    </style>
</head>
<body>
    <h1>Cadastrar novo produto</h1>
    <form method="POST">
        <label for="nome">Nome</label>
        <input type="text" id="nome" name="nome" required>

        <label for="descricao">Descrição</label>
        <textarea id="descricao" name="descricao" rows="4"></textarea>

        <label for="preco">Preço</label>
        <input type="text" id="preco" name="preco" placeholder="Ex: 19,90" required>

        <button type="submit">Salvar</button>
    </form>
    <a href="index.php">&larr; Voltar para a listagem</a>
</body>
</html>
