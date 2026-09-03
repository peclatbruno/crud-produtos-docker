<?php
// edit.php - Formulário de edição de um produto existente (operação "Update" do CRUD)
require 'db.php';

$id = $_GET['id'] ?? null;
if (!$id) {
    header("Location: index.php");
    exit;
}

// Se o formulário foi enviado, atualiza o registro no banco
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = trim($_POST['nome']);
    $descricao = trim($_POST['descricao']);
    $preco = str_replace(',', '.', $_POST['preco']);

    $stmt = $pdo->prepare("UPDATE produtos SET nome = ?, descricao = ?, preco = ? WHERE id = ?");
    $stmt->execute([$nome, $descricao, $preco, $id]);

    header("Location: index.php");
    exit;
}

// Busca os dados atuais do produto para pré-carregar o formulário
$stmt = $pdo->prepare("SELECT * FROM produtos WHERE id = ?");
$stmt->execute([$id]);
$produto = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$produto) {
    die("Produto não encontrado.");
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Editar Produto</title>
    <style>
        body { font-family: Arial, sans-serif; max-width: 500px; margin: 40px auto; padding: 0 20px; }
        label { display: block; margin-top: 12px; font-weight: bold; }
        input, textarea { width: 100%; padding: 8px; margin-top: 4px; box-sizing: border-box; }
        button { margin-top: 20px; padding: 10px 20px; background: #f39c12; color: #fff; border: none; border-radius: 4px; cursor: pointer; }
        a { display: inline-block; margin-top: 15px; }
    </style>
</head>
<body>
    <h1>Editar produto #<?= htmlspecialchars($produto['id']) ?></h1>
    <form method="POST">
        <label for="nome">Nome</label>
        <input type="text" id="nome" name="nome" value="<?= htmlspecialchars($produto['nome']) ?>" required>

        <label for="descricao">Descrição</label>
        <textarea id="descricao" name="descricao" rows="4"><?= htmlspecialchars($produto['descricao']) ?></textarea>

        <label for="preco">Preço</label>
        <input type="text" id="preco" name="preco" value="<?= htmlspecialchars($produto['preco']) ?>" required>

        <button type="submit">Atualizar</button>
    </form>
    <a href="index.php">&larr; Voltar para a listagem</a>
</body>
</html>
