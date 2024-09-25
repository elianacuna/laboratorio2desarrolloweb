<?php
// Incluir el archivo de configuración
require_once 'config.php';

// Función para conectarse a la base de datos
function conectarDB() {
    // Crear la conexión usando los valores definidos en config.php
    $conexion = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

    // Comprobar si la conexión fue exitosa
    if ($conexion->connect_error) {
        die("Error de conexión: " . $conexion->connect_error);
    }

    // Devolver la conexión
    return $conexion;
}

// Llamada a la función para verificar si funciona correctamente
$conexion = conectarDB();

// Puedes comprobar si la conexión fue exitosa
if ($conexion) {
    //echo "Conexión exitosa a la base de datos " . DB_NAME;
} else {
    echo "Error de conexión.";
}
?>
