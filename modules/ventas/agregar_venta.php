<?php
// Conexion a la base de datos
include_once '../../includes/conexion.php';

// Traer la lista de clientes
function traerInfoClientes() {
    global $conexion;
    $sqlCliente = "SELECT codigo, nombre FROM clientes";
    $resultado = mysqli_query($conexion, $sqlCliente);
    return $resultado;
}

// Traer la lista de productos
function traerInfoProducto() {
    global $conexion;
    $sqlProducto = "SELECT codigo, descripcion, precio FROM Producto";
    $resultado = mysqli_query($conexion, $sqlProducto);
    return $resultado;
}
?>

<!doctype html>
<html lang="es">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Ejemplo3</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="../../assets/css/venta.css">
  </head>
  <body>

    <header class="bg-primary text-white py-3 shadow-sm">
      <div class="container d-flex justify-content-between align-items-center">
          <a href="../../index.php" class="btn btn-outline-light d-flex align-items-center">
              <i class="bi bi-arrow-left-circle me-2"></i> Regresar
          </a>
      </div>
    </header>
    
    <div class="container mt-5 mb-5">
      <div id="alertError" class="alert alert-danger" style="display: none;">
        <span id="textAlert"></span>
      </div>
      
      <div class="card mx-auto rounded" style="max-width: 600px;">
          <div class="card-header text-center bg-primary text-white rounded-top">
              Agregar Venta
          </div>
          <form id="miFormulario" action="" method="POST" novalidate>
            <div class="card-body">

              <!-- Cliente -->
              <div class="col-md mb-3">
                <label for="cliente" class="form-label">Cliente</label>
                <select name="cliente" id="cliente" class="form-select" required>
                  <option value="">Seleccione un cliente</option>
                  <?php
                  $clientes = traerInfoClientes(); 
                  if ($clientes) {
                      while ($cliente = mysqli_fetch_assoc($clientes)) {
                          echo "<option value='{$cliente['codigo']}'>{$cliente['nombre']}</option>";
                      }
                  }
                  ?>
                </select>
              </div>

              <!-- Producto -->
              <div class="col-md mb-3">
                <label for="producto" class="form-label">Producto</label>
                <select name="producto" id="producto" class="form-select" required onchange="actualizarMonto()">
                    <option value="">Seleccione un producto</option>
                    <?php
                    $productos = traerInfoProducto(); 
                    if ($productos) {
                        while ($producto = mysqli_fetch_assoc($productos)) {
                            echo "<option value='{$producto['codigo']}' data-precio='{$producto['precio']}'>{$producto['descripcion']}</option>";
                        }
                    }
                    ?>
                    </select>
                </div>

              <!-- fecha y monto -->
            <div class="row mb-3" style="margin-top: 10px;">
                <div class="col-md-6">
                    <label for="fecha" class="form-label">Fecha</label>
                    <input type="date" class="form-control" name="fecha" required>
                </div>
                
                <div class="col-md-6">
                    <label for="monto" class="form-label">Monto</label>
                    <input type="number" class="form-control" name="monto" id="monto" required readonly>
                </div>
            
            </div>
   
            <!-- cantidad y subtotal -->
            <div class="row mb-3" style="margin-top: 10px;">
                <div class="col-md-6">
                    <label for="cantidad" class="form-label">Cantidad</label>
                    <input type="number" class="form-control" name="cantidad" id="cantidad" required>
                </div>
                <div class="col-md-6">
                    <label for="subtotal" class="form-label">Subtotal</label>
                    <input type="number" class="form-control" id="subtotal" name="subtotal" required>
                </div>
            </div>
            
               <button type="submit" class="btn btn-primary w-100">Agregar venta</button>
    
              </div>
          </form>
      </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script>
    
    function actualizarMonto() {
        const productoSelect = document.getElementById('producto');
        const precio = productoSelect.options[productoSelect.selectedIndex].getAttribute('data-precio');
        document.getElementById('monto').value = precio;
    }

    function calcularSubtotal() {
        
        const montoTv = document.getElementById('monto').value;
        const cantidadTv = document.getElementById('cantidad').value;

        const monto = parseFloat(montoTv);
        const cantidad = parseInt(cantidadTv);

        const subtotalTv = monto * cantidad;

        document.getElementById('subtotal').value = subtotalTv.toFixed(2);  
        
    }
        
        document.getElementById('cantidad').addEventListener('input', calcularSubtotal);

    
    function validarFormulario(event) {
        const form = document.getElementById('miFormulario');
        if (!form.checkValidity()) {
            event.preventDefault(); 
            event.stopPropagation();
            
            const alertError = document.getElementById('alertError');
            const textAlert = document.getElementById('textAlert');
            textAlert.textContent = 'Por favor, completa todos los campos.';
            alertError.style.display = 'block'; 
        } else {
            const alertError = document.getElementById('alertError');
            alertError.style.display = 'none';
        }
        form.classList.add('was-validated'); 
    }
    
    const form = document.getElementById('miFormulario');
    form.addEventListener('submit', validarFormulario);
    </script>
  </body>
</html>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    agregarVenta();
}

function agregarVenta(){
    global $conexion;

    $cliente = $_POST['cliente'] ?? '';
    $producto = $_POST['producto'] ?? '';
    $fecha = $_POST['fecha'] ?? '';
    $monto = $_POST['monto'] ?? '';
    $cantidad = $_POST['cantidad'] ?? '';
    $subtotal = $_POST['subtotal'] ?? '';

    if (empty($cliente) || empty($producto) || empty($fecha) || empty($monto) || empty($cantidad) || empty($subtotal)) {
        echo "<script>alert('Todos los campos son obligatorios');</script>";
        return;
    }

    $conexion->begin_transaction();

    try {
        $sqlFactura = "INSERT INTO Factura (cliente, fecha, monto) VALUES (?, ?, ?)";
        
        if ($stmtFactura = $conexion->prepare($sqlFactura)) {

            $stmtFactura->bind_param("isd", $cliente, $fecha, $monto);
            
            if ($stmtFactura->execute()) {

                $facturaId = $conexion->insert_id;

                $sqlDetalle = "INSERT INTO Detalle_Factura (factura, producto, cantidad, subtotal) VALUES (?, ?, ?, ?)";
                
                if ($stmtDetalle = $conexion->prepare($sqlDetalle)) {

                    $stmtDetalle->bind_param("iiid", $facturaId, $producto, $cantidad, $subtotal);

                    if ($stmtDetalle->execute()) {

                        $conexion->commit();

                        echo '<script>alert("Venta agregada correctamente."); window.location.href = "../../index.php";</script>';

                    } else {

                        throw new Exception("Error al agregar el detalle de la venta: " . $stmtDetalle->error);

                    }

                    $stmtDetalle->close();
                }
            } else {

                throw new Exception("Error al agregar la factura: " . $stmtFactura->error);

            }

            $stmtFactura->close();
        }
    } catch (Exception $e) {

        $conexion->rollback();

        echo "<script>alert('Error: " . $e->getMessage() . "');</script>";

    }

}

?>
