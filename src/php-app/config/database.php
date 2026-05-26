<?php
// ================================================
// CONEXIÓN A POSTGRESQL
// ================================================

function getConexion() {
    $host = getenv('DB_HOST') ?: 'postgres';
    $port = getenv('DB_PORT') ?: '5432';
    $dbname = getenv('DB_NAME') ?: 'sgd_reportes';
    $user = getenv('DB_USER') ?: 'admin';
    $password = getenv('DB_PASSWORD') ?: 'Admin1234!';

    try {
        $dsn = "pgsql:host=$host;port=$port;dbname=$dbname";
        $pdo = new PDO($dsn, $user, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $pdo;
    } catch (PDOException $e) {
        die(json_encode([
            'error' => 'Error de conexión: ' . $e->getMessage()
        ]));
    }
} 