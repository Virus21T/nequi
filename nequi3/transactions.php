<?php
session_start();
require_once('config/conex.php');

if (!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit();
}

$id = $_SESSION['id'];
$query = "
    SELECT u1.telefono AS destino, t.monto, t.fecha
    FROM transactions t
    JOIN users u1 ON t.destino_id = u1.id
    WHERE t.origen_id = ?
    ORDER BY t.fecha DESC
";

$stmt = $conexion->prepare($query);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transacciones - Nequi</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="container">
        <h2>Transacciones Realizadas</h2>
        <div class="transactions-list">
            <?php while ($row = $result->fetch_assoc()) : ?>
                <div class="transaction-item">
                    <p>Enviado a <strong><?= htmlspecialchars($row['destino']) ?></strong></p>
                    <p>$<?= number_format($row['monto'], 2) ?></p>
                    <p class="fecha"><?= $row['fecha'] ?></p>
                </div>
            <?php endwhile; ?>
        </div>
        <p><a href="dashboard.php" class="btn">Volver al Inicio</a></p>
    </div>
</body> 
</html>
