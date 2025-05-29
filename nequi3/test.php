<?php
require_once('config/conex.php');
if ($conn) {
    echo "Conexión exitosa a la base de datos";
} else {
    echo "Error de conexión";
}
?> 