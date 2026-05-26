<?php
// ================================================
// PÁGINA DE DOCUMENTOS
// ================================================
require_once 'config/database.php';

$pdo = getConexion();

// Búsqueda
$busqueda = isset($_GET['buscar']) ? $_GET['buscar'] : '';
if ($busqueda) {
    $stmt = $pdo->prepare("SELECT * FROM documentos_vigentes WHERE titulo ILIKE :busqueda ORDER BY fecha_aprobacion DESC");
    $stmt->execute(['busqueda' => "%$busqueda%"]);
} else {
    $stmt = $pdo->query("SELECT * FROM documentos_vigentes ORDER BY fecha_aprobacion DESC");
}
$documentos = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Documentos - SGD</title>
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
        <div class="card">
            <h2>🔍 Buscar Documentos</h2>
            <form method="GET" action="documentos.php">
                <div class="form-group">
                    <label>Título del documento:</label>
                    <input type="text" name="buscar" value="<?= htmlspecialchars($busqueda) ?>" placeholder="Escribe para buscar...">
                </div>
                <button type="submit" class="btn btn-primary">Buscar</button>
                <?php if ($busqueda): ?>
                    <a href="documentos.php" class="btn btn-primary" style="margin-left:10px;">Limpiar</a>
                <?php endif; ?>
            </form>
        </div>
        <div class="card">
            <h2>📁 Lista de Documentos 
                <?php if ($busqueda): ?>
                    <small style="font-size:14px; color:#666;">- Resultados para: "<?= htmlspecialchars($busqueda) ?>"</small>
                <?php endif; ?>
            </h2>
            <?php if (count($documentos) === 0): ?>
                <p style="color:#666; text-align:center; padding:20px;">No se encontraron documentos.</p>
            <?php else: ?>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Título</th>
                        <th>Tipo</th>
                        <th>Estado</th>
                        <th>Versión</th>
                        <th>Fecha Aprobación</th>
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
                        <td><?= date('d/m/Y', strtotime($doc['fecha_aprobacion'])) ?></td>
                        <td><?= htmlspecialchars($doc['aprobado_por']) ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>