<?php
session_start();
include('config/conex.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $telefono = $_POST['telefono'];
    $pass = $_POST['password'];

    $stmt = $conn->prepare("SELECT * FROM usuarios WHERE telefono = ?");
    $stmt->bind_param("s", $telefono);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();
        if (password_verify($pass, $user['password'])) {
            $_SESSION['id'] = $user['id'];
            $_SESSION['nombre'] = $user['nombre'];
            $_SESSION['saldo'] = $user['saldo'];
            header("Location: dashboard.php");
            exit();
        }
    }
    $error = "Número o clave incorrectos.";
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión - Nequi</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="container">
        <h2>Iniciar Sesión</h2>
        <?php if (isset($error)) echo "<p style='color:red;'>$error</p>"; ?>
        <form method="POST">
            <input type="text" name="telefono" placeholder="Número de teléfono" required>
            <input type="password" name="password" placeholder="Contraseña" required>
            <button type="submit">Ingresar</button>
        </form>
        <p>¿No tienes cuenta? <a href="register.php">Regístrate</a></p>
    </div>
</body>
</html>
