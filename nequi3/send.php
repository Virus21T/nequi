<?php
session_start();
require_once('config/conex.php');

if (!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $telefono = $_POST['telefono'];
    $monto = floatval($_POST['monto']);
    $from = $_SESSION['id'];

    $dest = $conexion->prepare("SELECT id FROM users WHERE telefono = ?");
    $dest->bind_param("s", $telefono);
    $dest->execute();
    $result = $dest->get_result();

    if ($result->num_rows === 1) {
        $to = $result->fetch_assoc()['id'];

        $conexion->begin_transaction();
        
        // Actualizar saldo del remitente
        $update_from = $conexion->prepare("UPDATE users SET saldo = saldo - ? WHERE id = ? AND saldo >= ?");
        $update_from->bind_param("did", $monto, $from, $monto);
        $update_from->execute();
        
        // Actualizar saldo del destinatario
        $update_to = $conexion->prepare("UPDATE users SET saldo = saldo + ? WHERE id = ?");
        $update_to->bind_param("di", $monto, $to);
        $update_to->execute();
        
        // Registrar la transacción
        $insert_trans = $conexion->prepare("INSERT INTO transactions (origen_id, destino_id, monto) VALUES (?, ?, ?)");
        $insert_trans->bind_param("iid", $from, $to, $monto);
        $insert_trans->execute();
        
        $conexion->commit();

        $_SESSION['saldo'] -= $monto;
        $mensaje = "Transferencia exitosa.";
    } else {
        $mensaje = "Número de destino no encontrado.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Enviar Dinero - Nequi</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="container">
        <h2>Enviar Dinero</h2>
        <?php if (isset($mensaje)) echo "<p class='mensaje'>$mensaje</p>"; ?>
        <form method="POST">
            <input type="text" name="telefono" placeholder="Número del destinatario" required>
            <input type="number" name="monto" step="0.01" placeholder="Monto a enviar" required>
            <button type="submit">Enviar</button>
        </form>
        <p><a href="dashboard.php">Volver al Inicio</a></p>
    </div>
</body>
</html>
