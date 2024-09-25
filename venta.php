<?php
//Conexion a la base de datos
include_once 'includes/conexion.php';

//traer el menu
include_once 'index.php';

// Realizar la consulta a la base de datos
$sql = "SELECT f.codigo, f.cliente, f.fecha, f.monto, df.producto, df.cantidad, df.subtotal FROM factura f 
INNER JOIN detalle_factura df ON f.codigo = df.factura;";
$resultado = mysqli_query($conexion, $sql); 

?>

<!doctype html>
<html lang="es">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Lista de Clientes</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="assets/css/cliente.css">

  </head>
  <body>
  
    <div class="cardview container mt-5" style="margin-top: 20px;">
        <h2 class="text-center mb-4">Lista de Ventas</h2>
        <a type="button" href="modules/ventas/agregar_venta.php" class="btn btn-outline-secondary">Agregar Venta</a>

        
        <table class="table table-striped table-bordered">
            <thead class="table-primary">
                <tr>
                    <th>Código</th>
                    <th>Cliente</th>
                    <th>fecha</th>
                    <th>monto</th>
                    <th>producto</th>
                    <th>cantidad</th>
                    <th>subtotal</th>
                    <th>Factura</th>
                    <th>Acciones</th>

                </tr>
            </thead>
            <tbody>
                <?php
                if (mysqli_num_rows($resultado) > 0) {
                    while ($fila = mysqli_fetch_assoc($resultado)) {
                        echo "<tr>";
                        echo "<td>" . $fila['codigo'] . "</td>";
                        echo "<td>" . $fila['cliente'] . "</td>";
                        echo "<td>" . $fila['fecha'] . "</td>";
                        echo "<td>" . $fila['monto'] . "</td>";
                        echo "<td>" . $fila['producto'] . "</td>";
                        echo "<td>" . $fila['cantidad'] . "</td>";
                        echo "<td>" . $fila['subtotal'] . "</td>";
                        echo "<td>";
                        ?>
                        <div class="dropdown">
                            <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton<?php echo $fila['codigo']; ?>" data-bs-toggle="dropdown" aria-expanded="false">
                                Acciones
                            </button>
                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton<?php echo $fila['codigo']; ?>">
                                <li><a class="dropdown-item" href="modules/ventas/editar_ventas.php?codigo=<?php echo $fila['codigo']; ?>">Editar</a></li>
                                <li><a class="dropdown-item" href="modules/ventas/eliminar_ventas.php?codigo=<?php echo $fila['codigo']; ?>" onclick="return confirm('¿Estás seguro que deseas eliminar esta venta?');">Eliminar</a></li>
                            </ul>
                        </div>
                        <?php
                        echo "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='9' class='text-center'>No hay datos disponibles</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
  </body>
</html>

<?php
// Cerrar la conexión
mysqli_close($conexion);
?>

