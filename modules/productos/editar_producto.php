<?php
// Conexion a la base de datos
include_once '../../includes/conexion.php'; 

// variables para los datos del producto
$codigo = "";
$desc = "";
$obse = "";
$precio = "";

if (isset($_GET['codigo'])) {
    $codigo = $_GET['codigo'];

    // Consulta para obtener los datos del producto
    $sql = "SELECT descripcion, observaciones, precio FROM Producto WHERE codigo = ?";
    $stmt = mysqli_prepare($conexion, $sql);
    mysqli_stmt_bind_param($stmt, 'i', $codigo);
    
    if (mysqli_stmt_execute($stmt)) {
        mysqli_stmt_bind_result($stmt, $desc, $obse, $precio);
        mysqli_stmt_fetch($stmt);  
    } else {
        echo "<script>alert('Error al obtener los datos del producto');</script>";
    }

    mysqli_stmt_close($stmt);
}

?>

<!doctype html>
<html lang="es">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>lab2</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  </head>
  <body>
  
    <div class="container mt-5">
        <h2 class="text-center mb-4">Editar Cliente</h2>
        
        <form action="" method="POST" novalidate>
            <div class="mb-3">
                <label for="observacion" class="form-label">Observacion</label>
                <input type="text" class="form-control" id="observacion" name="observacion" value="<?php echo htmlspecialchars($obse); ?>" required>
            </div>
            <div class="mb-3">
                <label for="precio" class="form-label">Precio</label>
                <input type="text" class="form-control" id="precio" name="precio" value="<?php echo htmlspecialchars($precio); ?>" required>
            </div>
            <div class="mb-3">
                <label for="descripcion" class="form-label">Descripcion</label>
                <input type="text" class="form-control" id="descripcion" name="descripcion" value="<?php echo htmlspecialchars($desc); ?>" required>
            </div>
            
            <input type="hidden" name="codigo" value="<?php echo $codigo; ?>">

            <button type="submit" class="btn btn-primary">Actualizar Prodcuto</button>
            <a href="../../producto.php" class="btn btn-secondary">Cancelar</a>
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
    $desc = $_POST['descripcion'];
    $obse = $_POST['observacion'];
    $precio = $_POST['precio'];

    // Consulta para actualizar los datos del producto
    $sql = "UPDATE Producto SET descripcion = ?, precio = ?, observaciones = ? WHERE codigo = ?";
    $stmt = mysqli_prepare($conexion, $sql);
    mysqli_stmt_bind_param($stmt, 'sssi', $desc, $precio, $obse, $codigo);
    
    if (mysqli_stmt_execute($stmt)) {
        echo "<script>alert('Productp actualizado correctamente');</script>";

        header("Location: ../../producto.php");
        exit();
    } else {
        echo "<script>alert('Error al actualizar el producto');</script>";
    }

    mysqli_stmt_close($stmt);
}

mysqli_close($conexion);
