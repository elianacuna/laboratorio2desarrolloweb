<?php
// Incluir el archivo de configuración con las credenciales
require_once 'config.php';

// Función para conectarse a la base de datos
function conectarDB() {
    // Crear la conexión usando las constantes definidas en config.php
    $conexion = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME, DB_PORT);

    // Verificar si la conexión fue exitosa
    if ($conexion->connect_error) {
        die("Error de conexión: " . $conexion->connect_error);
    }

    // Devolver la conexión
    return $conexion;
}

// Establecer la conexión
$conexion = conectarDB();
?>
