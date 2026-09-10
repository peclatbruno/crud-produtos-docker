<?php
// index.php - Lista todos os produtos cadastrados (operação "Read" do CRUD)
require 'db.php';

// Busca todos os registros ordenados pelo mais recente primeiro
$stmt = $pdo->query("SELECT * FROM produtos ORDER BY id DESC");
$produtos = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>CRUD de Produtos</title>
    <style>
        body { font-family: Arial, sans-serif; max-width: 900px; margin: 40px auto; padding: 0 20px; }
        h1 { color: #2c3e50; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 10px; text-align: left; }
        th { background: #2c3e50; color: #fff; }
        tr:nth-child(even) { background: #f7f7f7; }
        a.btn { padding: 5px 10px; border-radius: 4px; text-decoration: none; color: #fff; font-size: 13px; }
        a.edit { background: #f39c12; }
        a.delete { background: #e74c3c; }
        a.new { display: inline-block; margin-top: 15px; background: #27ae60; padding: 8px 14px; border-radius: 4px; color: #fff; text-decoration: none; }
    </style>
</head>
<body>
    <h1>Produtos cadastrados</h1>
    <a class="new" href="create.php">+ Novo produto</a>

    <table>
        <tr>
            <th>ID</th>
            <th>Nome</th>
            <th>Descrição</th>
            <th>Preço</th>
            <th>Data de cadastro</th>
            <th>Ações</th>
        </tr>
        <?php if (empty($produtos)): ?>
            <tr><td colspan="6">Nenhum produto cadastrado ainda.</td></tr>
        <?php endif; ?>
        <?php foreach ($produtos as $p): ?>
            <tr>
                <td><?= htmlspecialchars($p['id']) ?></td>
                <td><?= htmlspecialchars($p['nome']) ?></td>
                <td><?= htmlspecialchars($p['descricao']) ?></td>
                <td>R$ <?= number_format($p['preco'], 2, ',', '.') ?></td>
                <td><?= htmlspecialchars($p['data_cadastro']) ?></td>
                <td>
                    <a class="btn edit" href="edit.php?id=<?= $p['id'] ?>">Editar</a>
                    <a class="btn delete" href="delete.php?id=<?= $p['id'] ?>" onclick="return confirm('Tem certeza que deseja excluir este produto?')">Excluir</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>
