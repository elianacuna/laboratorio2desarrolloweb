<?php
// Conexion a la base de datos
include_once '../../includes/conexion.php'; 

// variables para los datos del cliente
$codigo = "";
$nombre = "";
$telefono = "";
$correo = "";

if (isset($_GET['codigo'])) {
    $codigo = $_GET['codigo'];

    // Consulta para obtener los datos del cliente
    $sql = "SELECT nombre, telefono, correo FROM clientes WHERE codigo = ?";
    $stmt = mysqli_prepare($conexion, $sql);
    mysqli_stmt_bind_param($stmt, 'i', $codigo);
    
    if (mysqli_stmt_execute($stmt)) {
        mysqli_stmt_bind_result($stmt, $nombre, $telefono, $correo);
        mysqli_stmt_fetch($stmt);  
    } else {
        echo "<script>alert('Error al obtener los datos del cliente');</script>";
    }

    mysqli_stmt_close($stmt);
}

?>

<!doctype html>
<html lang="es">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Editar Cliente</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  </head>
  <body>
  
    <div class="container mt-5">
        <h2 class="text-center mb-4">Editar Cliente</h2>
        
        <form action="" method="POST" novalidate>
            <div class="mb-3">
                <label for="nombre" class="form-label">Nombre</label>
                <input type="text" class="form-control" id="nombre" name="nombre" value="<?php echo htmlspecialchars($nombre); ?>" required>
            </div>
            <div class="mb-3">
                <label for="telefono" class="form-label">Teléfono</label>
                <input type="text" class="form-control" id="telefono" name="telefono" value="<?php echo htmlspecialchars($telefono); ?>" required>
            </div>
            <div class="mb-3">
                <label for="correo" class="form-label">Correo electrónico</label>
                <input type="email" class="form-control" id="correo" name="correo" value="<?php echo htmlspecialchars($correo); ?>" required>
            </div>
            
            <input type="hidden" name="codigo" value="<?php echo $codigo; ?>">

            <button type="submit" class="btn btn-primary">Actualizar Cliente</button>
            <a href="../../cliente.php" class="btn btn-secondary">Cancelar</a>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
  </body>
</html>

<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    actualizarCliente();
}

function actualizarCliente(){
    global $conexion;

    $codigo = $_POST['codigo'];
    $nombre = $_POST['nombre'];
    $telefono = $_POST['telefono'];
    $correo = $_POST['correo'];

    // Consulta para actualizar los datos del cliente
    $sql = "UPDATE clientes SET nombre = ?, telefono = ?, correo = ? WHERE codigo = ?";
    $stmt = mysqli_prepare($conexion, $sql);
    mysqli_stmt_bind_param($stmt, 'sssi', $nombre, $telefono, $correo, $codigo);
    
    if (mysqli_stmt_execute($stmt)) {
        echo "<script>alert('Cliente actualizado correctamente');</script>";

        header("Location: ../../cliente.php");
        exit();
    } else {
        echo "<script>alert('Error al actualizar el cliente');</script>";
    }

    mysqli_stmt_close($stmt);
}

mysqli_close($conexion);
