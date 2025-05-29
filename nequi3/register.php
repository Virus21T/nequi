<?php
session_start();
require_once('config/conex.php');

try {
    // Verificar si la tabla existe
    $check_table = $conexion->query("SHOW TABLES LIKE 'utilisateurs'");
    if ($check_table->num_rows == 0) {
        // Crear la tabla si no existe
        $create_table = "CREATE TABLE IF NOT EXISTS utilisateurs (
            id_utilisateur INT AUTO_INCREMENT PRIMARY KEY,
            nom_complet VARCHAR(100) NOT NULL,
            numero_telephone VARCHAR(20) NOT NULL UNIQUE,
            mot_de_passe VARCHAR(255) NOT NULL,
            solde_compte DECIMAL(10,2) DEFAULT 0.00,
            date_inscription TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        )";
        $conexion->query($create_table);

        // Crear la tabla de transacciones
        $create_transactions = "CREATE TABLE IF NOT EXISTS transactions (
            id_transaction INT AUTO_INCREMENT PRIMARY KEY,
            id_expediteur INT NOT NULL,
            id_destinataire INT NOT NULL,
            montant DECIMAL(10,2) NOT NULL,
            type_transaction ENUM('envoi', 'reception', 'retrait') NOT NULL,
            date_transaction TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            statut ENUM('en_cours', 'completee', 'annulee') DEFAULT 'en_cours',
            FOREIGN KEY (id_expediteur) REFERENCES utilisateurs(id_utilisateur),
            FOREIGN KEY (id_destinataire) REFERENCES utilisateurs(id_utilisateur)
        )";
        $conexion->query($create_transactions);
    }

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $nombre = trim($_POST['nombre']);
        $telefono = trim($_POST['telefono']);
        $pass = password_hash($_POST['password'], PASSWORD_DEFAULT);

        if (empty($nombre) || empty($telefono) || empty($_POST['password'])) {
            throw new Exception("Todos los campos son obligatorios.");
        }

        // Primero verificamos si el teléfono ya existe
        $check_phone = $conexion->prepare("SELECT id_utilisateur FROM utilisateurs WHERE numero_telephone = ?");
        $check_phone->bind_param("s", $telefono);
        $check_phone->execute();
        $result = $check_phone->get_result();

        if ($result->num_rows > 0) {
            $error = "Este número de teléfono ya está registrado. Por favor, use otro número o inicie sesión.";
        } else {
            $stmt = $conexion->prepare("INSERT INTO utilisateurs (nom_complet, numero_telephone, mot_de_passe) VALUES (?, ?, ?)");
            $stmt->bind_param("sss", $nombre, $telefono, $pass);
            if ($stmt->execute()) {
                $success = "Registro exitoso. <a href='login.php'>Inicia sesión</a>";
            } else {
                throw new Exception("Error al registrar: " . $conexion->error);
            }
        }
    }
} catch (Exception $e) {
    $error = $e->getMessage();
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
        <img src="img/nequi-logo.png" alt="Nequi Logo" class="logo">
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