<?php

use App\Support\CarrinhoSessao;

require_once __DIR__ . '/../autoload.php';

$c = new CarrinhoSessao();

if (isset($_GET['id'])) {
    $c->adicionar((int) $_GET['id']);
}
?>