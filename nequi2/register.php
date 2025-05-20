<?php
require_once('config/conex.php');

// Verificar la conexión
if (!$conn) {
    die("Error de conexión: No se pudo conectar a la base de datos");
}

// Verificar si la tabla existe
$check_table = $conn->query("SHOW TABLES LIKE 'usuarios'");
if ($check_table->num_rows == 0) {
    die("Error: La tabla 'usuarios' no existe en la base de datos");
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre = $_POST['nombre'];
    $telefono = $_POST['telefono'];
    $pass = password_hash($_POST['password'], PASSWORD_DEFAULT);

    // Primero verificamos si el teléfono ya existe
    $check_phone = $conn->prepare("SELECT id FROM usuarios WHERE telefono = ?");
    $check_phone->bind_param("s", $telefono);
    $check_phone->execute();
    $result = $check_phone->get_result();

    if ($result->num_rows > 0) {
        $error = "Este número de teléfono ya está registrado. Por favor, use otro número o inicie sesión.";
    } else {
        $stmt = $conn->prepare("INSERT INTO usuarios (nombre, telefono, password) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $nombre, $telefono, $pass);
        if ($stmt->execute()) {
            $success = "Registro exitoso. <a href='login.php'>Inicia sesión</a>";
        } else {
            $error = "Error al registrar: " . $conn->error;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro - Nequi</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="container">
        <h2>Registro</h2>
        <?php
        if (isset($success)) echo "<p class='success'>$success</p>";
        if (isset($error)) echo "<p class='error'>$error</p>";
        ?>
        <form method="POST">
            <input type="text" name="nombre" placeholder="Nombre completo" required>
            <input type="text" name="telefono" placeholder="Número de teléfono" required>
            <input type="password" name="password" placeholder="Contraseña" required>
            <button type="submit">Registrarse</button>
        </form>
        <p>¿Ya tienes cuenta? <a href="login.php">Inicia sesión</a></p>
    </div>
</body>
</html>