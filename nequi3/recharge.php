<?php
session_start();
require_once('config/conex.php');

if (!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $monto = floatval($_POST['monto']);
    $user_id = $_SESSION['id'];

    $stmt = $conexion->prepare("UPDATE users SET saldo = saldo + ? WHERE id = ?");
    $stmt->bind_param("di", $monto, $user_id);
    $stmt->execute();
    
    $_SESSION['saldo'] += $monto;

    header("Location: dashboard.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recargar Saldo - Nequi</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="container">
        <h2>Recargar Saldo</h2>
        <form method="POST">
            <input type="number" name="monto" step="0.01" placeholder="Monto a recargar" required>
            <button type="submit">Recargar</button>
        </form>
        <div class="menu">
            <a href="dashboard.php">Volver al Inicio</a>
        </div>
    </div>
</body>
</html>
