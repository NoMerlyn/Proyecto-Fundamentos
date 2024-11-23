<?php
include('../php/verificar_acceso.php');
verificarAcceso('profesor');

// Conexión a la base de datos
include('../php/cone.php');
$conn = Conexion();

// Verificar si se recibió el ID de la tarea
if (!isset($_GET['id'])) {
    echo '<div class="alert alert-danger">No se especificó la tarea</div>';
    exit;
}

$tareaId = $_GET['id'];

// Obtener información de la tarea
$stmt = $conn->prepare("SELECT t.descripcion, t.fecha_entrega, m.nombre AS materia_nombre, cl.nombre AS curso_nombre, c.tema AS clase_nombre
                        FROM tareas t
                        JOIN clases c ON t.clase_id = c.id
                        JOIN materias m ON c.materia_id = m.id
                        JOIN cursos cl ON m.curso_id = cl.id
                        WHERE t.id = :tareaId");
$stmt->bindValue(':tareaId', $tareaId);
$stmt->execute();
$tarea = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$tarea) {
    echo '<div class="alert alert-danger">La tarea no existe</div>';
    exit;
}

// Obtener estudiantes asignados a la clase
$stmt = $conn->prepare("SELECT 
        u.nombre AS estudiante_nombre, 
        e.id AS estudiante_id, 
        COALESCE(et.estado, 'Sin entregar') AS estado_tarea, 
        COALESCE(ca.calificacion, 0) AS calificacion
    FROM estudiantes e
    JOIN usuarios u ON e.usuario_id = u.id
    JOIN inscripciones i ON e.id = i.estudiante_id
    JOIN cursos c ON i.curso_id = c.id
    JOIN materias m ON c.id = m.curso_id
    JOIN clases cl ON m.id = cl.materia_id
    JOIN tareas t ON cl.id = t.clase_id
    LEFT JOIN estudiantes_tareas et ON e.id = et.estudiante_id AND et.tarea_id = :tareaId
    LEFT JOIN calificaciones ca ON e.id = ca.estudiante_id AND ca.tarea_id = :tareaId
    WHERE t.id = :tareaId");

$stmt->bindValue(':tareaId', $tareaId);
$stmt->execute();
$estudiantes = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Calificar Tarea | FISEI</title>
    <link href="../css/bootstrap.css" rel="stylesheet">
</head>
<body class="bg-body-tertiary">
<div class="container shadow-lg rounded p-4 mt-3">
    <h2>Calificar Tarea: <?= htmlspecialchars($tarea['descripcion']) ?></h2>
    <p><strong>Materia:</strong> <?= htmlspecialchars($tarea['materia_nombre']) ?> | <strong>Clase:</strong> <?= htmlspecialchars($tarea['clase_nombre']) ?> | <strong>Fecha de Entrega:</strong> <?= htmlspecialchars($tarea['fecha_entrega']) ?></p>

    <?php if (count($estudiantes) > 0): ?>
        <table class="table table-bordered mt-3">
            <thead>
                <tr>
                    <th>Nombre del Estudiante</th>
                    <th>Estado</th>
                    <th>Calificación</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($estudiantes as $estudiante): ?>
                    <tr>
                        <td><?= htmlspecialchars($estudiante['estudiante_nombre']) ?></td>
                        <td><?= $estudiante['estado_tarea'] ?>
                        </td>
                        <td><?= htmlspecialchars($estudiante['calificacion']) ?></td>
                        <td>
                            <a href="calificar_estudiante.php?estudiante_id=<?= $estudiante['estudiante_id'] ?>&tarea_id=<?= $tareaId ?>" class="btn btn-primary btn-sm">Calificar</a>
                            <a href="ver_archivos.php?estudiante_id=<?= $estudiante['estudiante_id'] ?>&tarea_id=<?= $tareaId ?>" class="btn btn-info btn-sm">Ver Archivos</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p class="mt-3">No hay estudiantes asignados a esta clase</p>
    <?php endif; ?>
</div>
<script src="../js/bootstrap.js"></script>
</body>
</html>
   
