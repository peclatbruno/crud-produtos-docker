<?php
// db.php - Responsável por abrir a conexão com o banco de dados
// e garantir que a tabela "produtos" exista antes de qualquer operação.

// As credenciais vêm das variáveis de ambiente definidas no docker-compose.yml
// (seção "environment" do serviço "app"). Não usamos arquivo .env.
$host = getenv('DB_HOST');
$user = getenv('DB_USER');
$pass = getenv('DB_PASSWORD');
$dbname = getenv('DB_NAME');

try {
    // Conecta usando PDO (mais seguro que mysqli puro, evita SQL Injection com prepared statements)
    $pdo = new PDO(
        "mysql:host=$host;dbname=$dbname;charset=utf8mb4",
        $user,
        $pass,
        [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION] // Faz o PDO lançar exceções em caso de erro
    );
} catch (PDOException $e) {
    die("Erro ao conectar ao banco de dados: " . $e->getMessage());
}

// Cria a tabela "produtos" automaticamente, caso ela ainda não exista.
// Isso evita a necessidade de rodar um script SQL manual: basta subir os containers.
$pdo->exec("
    CREATE TABLE IF NOT EXISTS produtos (
        id INT AUTO_INCREMENT PRIMARY KEY,
        nome VARCHAR(150) NOT NULL,
        descricao TEXT,
        preco DECIMAL(10,2) NOT NULL DEFAULT 0,
        data_cadastro DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
    )
");
