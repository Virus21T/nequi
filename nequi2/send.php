<?php
session_start();
include('config/conex.php');

if (!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $telefono = $_POST['telefono'];
    $monto = floatval($_POST['monto']);
    $from = $_SESSION['id'];

    $dest = $conn->prepare("SELECT id FROM usuarios WHERE telefono = ?");
    $dest->bind_param("s", $telefono);
    $dest->execute();
    $result = $dest->get_result();

    if ($result->num_rows === 1) {
        $to = $result->fetch_assoc()['id'];

        $conn->begin_transaction();
        $conn->query("UPDATE usuarios SET saldo = saldo - $monto WHERE id = $from AND saldo >= $monto");
        $conn->query("UPDATE usuarios SET saldo = saldo + $monto WHERE id = $to");
        $conn->query("INSERT INTO transacciones (origen_id, destino_id, monto) VALUES ($from, $to, $monto)");
        $conn->commit();

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
        <p><a href="dashboard.php">Volver al Dashboard</a></p>
    </div>
</body>
</html>
