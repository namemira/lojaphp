<?php
namespace App\Database;

use PDO;

class Conexao {
    private static ?PDO $pdo = null;

    public static function get(): PDO {
        if (self::$pdo === null) {
            self::$pdo = new PDO(
                'mysql:host=db;dbname=loja;charset=utf8mb4',
                'root',
                'root',
                [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                ]
            );
        }

        return self::$pdo;
    }
}

/* $pdo = Conexao::get();

$id = $_GET['id'] ?? null;

$sql = "UPDATE produtos
        SET nome = :nome, preco = :preco
        WHERE id = :id";

echo "<pre>SQL executado: $sql</pre>";

$stmt = $pdo->prepare($sql);

$stmt->execute([
    'nome' => 'Notebook Gamer',
    'preco' => 4500.00,
    'id' => $id
]);

echo "Produto atualizado com sucesso!"; */