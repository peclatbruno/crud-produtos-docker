<?php
// delete.php - Exclui um produto do banco (operação "Delete" do CRUD)
// A confirmação é feita antes, via JavaScript (confirm()) no link da listagem.
require 'db.php';

$id = $_GET['id'] ?? null;
if ($id) {
    $stmt = $pdo->prepare("DELETE FROM produtos WHERE id = ?");
    $stmt->execute([$id]);
}

header("Location: index.php");
exit;
