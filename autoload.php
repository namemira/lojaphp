
<?php

spl_autoload_register(function (string $classe) {
    $mapa = [
        'App\\Database\\Conexao' => __DIR__ . '/src/database/Conexao.php',
    ];

    if (isset($mapa[$classe]) && file_exists($mapa[$classe])) {
        require_once $mapa[$classe];
    }
});
