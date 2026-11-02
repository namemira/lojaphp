
<?php
require_once __DIR__ . '/../autoload.php';

use App\Database\Conexao;

if (isset($_GET['id'])) {

    $id = filter_var($_GET['id'], FILTER_VALIDATE_INT);

    if ($id !== false && $id > 0) {

        $stmt = Conexao::get()->prepare(
            'DELETE FROM produtos WHERE id = :id'
        );

        $stmt->execute([
            ':id' => $id
        ]);
    }
}

header('Location: index.php');
exit;
