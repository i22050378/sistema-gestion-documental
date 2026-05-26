<?php
// ================================================
// PÁGINA PRINCIPAL - PORTAL DE CONSULTA
// ================================================
require_once 'config/database.php';

$pdo = getConexion();
$documentos = $pdo->query("SELECT * FROM documentos_vigentes ORDER BY fecha_aprobacion DESC")->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema de Gestión Documental</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="header">
        <h1>📄 Sistema de Gestión Documental</h1>
        <p>Portal de Consulta Pública - Módulo PHP</p>
    </div>
    <div class="nav">
        <a href="index.php">🏠 Inicio</a>
        <a href="documentos.php">📁 Documentos</a>
        <a href="reportes.php">📊 Reportes</a>
    </div>
    <div class="container">
        <div class="stats">
            <div class="stat-card">
                <h3><?= count($documentos) ?></h3>
                <p>Documentos Vigentes</p>
            </div>
            <div class="stat-card">
                <h3>3</h3>
                <p>Bases de Datos Activas</p>
            </div>
            <div class="stat-card">
                <h3>PHP 8</h3>
                <p>Módulo Activo</p>
            </div>
        </div>
        <div class="card">
            <h2>📋 Documentos Vigentes</h2>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Título</th>
                        <th>Tipo</th>
                        <th>Estado</th>
                        <th>Versión</th>
                        <th>Aprobado por</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($documentos as $doc): ?>
                    <tr>
                        <td><?= $doc['id'] ?></td>
                        <td><?= htmlspecialchars($doc['titulo']) ?></td>
                        <td><?= $doc['tipo_archivo'] ?></td>
                        <td><span class="badge badge-aprobado"><?= $doc['estado'] ?></span></td>
                        <td>v<?= $doc['version'] ?></td>
                        <td><?= htmlspecialchars($doc['aprobado_por']) ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>