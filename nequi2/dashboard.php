<?php
session_start();
if (!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Nequi</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <!-- Burbujas decorativas -->
    <div class="bubble"></div>
    <div class="bubble"></div>
    <div class="bubble"></div>
    <div class="bubble"></div>

    <div class="container">
        <h2>Bienvenido, <?php echo htmlspecialchars($_SESSION['nombre']); ?></h2>
        
        <div class="saldo">
            <strong>Saldo:</strong> $<?php echo number_format($_SESSION['saldo'], 2); ?>
        </div>

        <div class="menu">
            <a href="recharge.php">Recargar</a>
            <a href="send.php">Enviar dinero</a>
            <a href="transactions.php">Ver transacciones</a>
            <a href="logout.php">Cerrar sesión</a>
        </div>
    </div>
</body>
</html>
