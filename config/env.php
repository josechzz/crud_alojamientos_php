<?php

function loadEnv($path) {
    if (!file_exists($path)) {
        throw new Exception(".env file not found at: $path");
    }

    $lines = file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        // Ignorar líneas vacías y comentarios
        if (trim($line) === '' || strpos(trim($line), '#') === 0) {
            continue;
        }

        // Separar clave y valor
        $keyValue = explode('=', $line, 2);
        if (count($keyValue) !== 2) {
            continue; // Ignorar líneas mal formateadas
        }

        $key = trim($keyValue[0]);
        $value = trim($keyValue[1]);

        // Eliminar comillas alrededor del valor (si existen)
        $value = trim($value, '"');

        // Guardar la variable de entorno
        putenv("$key=$value");
        $_ENV[$key] = $value;
        $_SERVER[$key] = $value;
    }
}
