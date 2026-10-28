<?php
use App\Database\Conexao;

require_once __DIR__ . '/../../autoload.php';

$id = (int) ($_GET['id'] ?? 0);

if ($id <= 0) {
    http_response_code(400);
    exit('ID inválido.');
}

$pdo = Conexao::get();

$stmt = $pdo->prepare('DELETE FROM produtos WHERE id = :id');
$stmt->execute([':id' => $id]);

header('Location: index.php');
exit;
