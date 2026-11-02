
<?php
require_once __DIR__ . '/../autoload.php';

use App\Database\Conexao;

$id = filter_var($_GET['id'] ?? null, FILTER_VALIDATE_INT);

if (!$id || $id <= 0) {
    header('Location: index.php');
    exit;
}

$stmt = Conexao::get()->prepare(
    'SELECT * FROM produtos WHERE id = :id'
);

$stmt->execute([':id' => $id]);

$produto = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$produto) {
    header('Location: index.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $nome = trim($_POST['nome'] ?? '');
    $preco = (float) ($_POST['preco'] ?? -1);
    $estoque = filter_var(
        $_POST['estoque'] ?? null,
        FILTER_VALIDATE_INT
    );

    if ($nome !== '' && $preco >= 0 && $estoque !== false && $estoque !== null && $estoque >= 0) {

        $stmt = Conexao::get()->prepare(
            'UPDATE produtos
             SET nome = :nome, preco = :preco, estoque = :estoque
             WHERE id = :id'
        );

        $stmt->execute([
            ':nome' => $nome,
            ':preco' => $preco,
            ':estoque' => $estoque,
            ':id' => $id
        ]);

        header('Location: index.php');
        exit;
    }

    $erro = 'Preencha os dados corretamente.';
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Editar produto</title>

    <style>
        body {
            font-family: Arial;
            background: #f2f2f2;
            padding: 30px;
        }

        form {
            background: white;
            padding: 20px;
            max-width: 350px;
            border-radius: 8px;
        }

        label {
            display: block;
            margin-top: 12px;
        }

        input {
            width: 100%;
            padding: 8px;
            margin-top: 5px;
            box-sizing: border-box;
        }

        button, a {
            display: inline-block;
            margin-top: 15px;
        }
    </style>
</head>

<body>

<h1>Editar produto</h1>

<?php if (isset($erro)): ?>
    <p><?= htmlspecialchars($erro, ENT_QUOTES, 'UTF-8') ?></p>
<?php endif; ?>

<form method="post">

    <label for="nome">Nome:</label>
    <input
        type="text"
        id="nome"
        name="nome"
        value="<?= htmlspecialchars($produto['nome'], ENT_QUOTES, 'UTF-8') ?>"
        required
    >

    <label for="preco">Preço (R$):</label>
    <input
        type="number"
        id="preco"
        name="preco"
        min="0"
        step="0.01"
        value="<?= htmlspecialchars((string) $produto['preco'], ENT_QUOTES, 'UTF-8') ?>"
        required
    >

    <label for="estoque">Estoque:</label>
    <input
        type="number"
        id="estoque"
        name="estoque"
        min="0"
        step="1"
        value="<?= (int) $produto['estoque'] ?>"
        required
    >

    <button type="submit">Salvar alterações</button>

</form>

<p><a href="index.php">Voltar aos produtos</a></p>

</body>
</html>
