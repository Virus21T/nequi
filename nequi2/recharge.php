<?php
session_start();
include('config/conex.php');

if (!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $monto = floatval($_POST['monto']);
    $user_id = $_SESSION['id'];

    $conn->query("UPDATE usuarios SET saldo = saldo + $monto WHERE id = $user_id");
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
        <p><a href="dashboard.php">Volver al Dashboard</a></p>
    </div>
</body>
</html>
