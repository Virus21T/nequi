<?php

$dbserver = 'mysql:dbname=dragonbl_hoteles_nequi;host=127.0.0.1';
$user = 'dragonbl_h_nequi';
$password = 'dragonbltodos';

try {
    // Crear la conexi贸n con PDO y configurar el modo de error
    $dbh = new PDO($dbserver, $user, $password);
    
    // Configurar el modo de error de PDO para que lance excepciones
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    // Si ocurre un error en la conexi贸n, muestra el mensaje de error
    echo 'La conexi贸n ha fallado: ' . $e->getMessage();
}

?>