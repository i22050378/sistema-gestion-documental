<?php
// ================================================
// PÁGINA DE REPORTES
// ================================================
require_once 'config/database.php';

$pdo = getConexion();

// Estadísticas generales
$total = $pdo->query("SELECT COUNT(*) FROM documentos_vigentes")->fetchColumn();
$aprobados = $pdo->query("SELECT COUNT(*) FROM documentos_vigentes WHERE estado = 'Aprobado'")->fetchColumn();
$reportes = $pdo->query("SELECT * FROM reportes_cumplimiento ORDER BY fecha_generacion DESC")->fetchAll(PDO::FETCH_ASSOC);

// Generar reporte
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $titulo = $_POST['titulo'];
    $descripcion = $_POST['descripcion'];
    $stmt = $pdo->prepare("INSERT INTO reportes_cumplimiento 
        (titulo, descripcion, generado_por, total_documentos, total_aprobados, total_pendientes) 
        VALUES (:titulo, :descripcion, :generado_por, :total, :aprobados, :pendientes)");
    $stmt->execute([
        'titulo' => $titulo,
        'descripcion' => $descripcion,
        'generado_por' => 'Operario',
        'total' => $total,
        'aprobados' => $aprobados,
        'pendientes' => $total - $aprobados
    ]);
    header('Location: reportes.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reportes - SGD</title>
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
                <h3><?= $total ?></h3>
                <p>Total Documentos</p>
            </div>
            <div class="stat-card">
                <h3><?= $aprobados ?></h3>
                <p>Aprobados</p>
            </div>
            <div class="stat-card">
                <h3><?= $total - $aprobados ?></h3>
                <p>Pendientes</p>
            </div>
        </div>
        <div class="card">
            <h2>📊 Generar Nuevo Reporte</h2>
            <form method="POST" action="reportes.php">
                <div class="form-group">
                    <label>Título del reporte:</label>
                    <input type="text" name="titulo" placeholder="Ej: Reporte Mayo 2026" required>
                </div>
                <div class="form-group">
                    <label>Descripción:</label>
                    <textarea name="descripcion" rows="3" placeholder="Descripción del reporte..."></textarea>
                </div>
                <button type="submit" class="btn btn-primary">📊 Generar Reporte</button>
            </form>
        </div>
        <div class="card">
            <h2>📋 Historial de Reportes</h2>
            <?php if (count($reportes) === 0): ?>
                <p style="color:#666; text-align:center; padding:20px;">No hay reportes generados aún.</p>
            <?php else: ?>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Título</th>
                        <th>Total Docs</th>
                        <th>Aprobados</th>
                        <th>Pendientes</th>
                        <th>Generado por</th>
                        <th>Fecha</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($reportes as $rep): ?>
                    <tr>
                        <td><?= $rep['id'] ?></td>
                        <td><?= htmlspecialchars($rep['titulo']) ?></td>
                        <td><?= $rep['total_documentos'] ?></td>
                        <td><?= $rep['total_aprobados'] ?></td>
                        <td><?= $rep['total_pendientes'] ?></td>
                        <td><?= htmlspecialchars($rep['generado_por']) ?></td>
                        <td><?= date('d/m/Y H:i', strtotime($rep['fecha_generacion'])) ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>