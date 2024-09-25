<?php
//agregando la conexion a la base de datos
include_once '../../includes/conexion.php';
?>

<!doctype html>
<html lang="es">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Ejemplo3</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="../../assets/css/cliente.css">
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
              Agregar Cliente
          </div>
          <form id="miFormulario" action="" method="POST" novalidate>
            <div class="card-body">

              <!-- Descripcion -->
              <div class="col-md">
                <label for="descripcion" class="form-label">Descripcion</label>
                <input type="text" class="form-control" name="descripcion" required>
              </div>
    
              <!-- Observaciones y Precio -->
              <div class="row mb-3" style="margin-top: 10px;">
                <div class="col-md-6">
                    <label for="observacion" class="form-label">Observaciones</label>
                    <input type="text" class="form-control" name="observacion" required>
                </div>
                <div class="col-md-6">
                    <label for="precio" class="form-label">Precio</label>
                    <input type="number" class="form-control" name="precio" required>
                </div>
            </div>
    
            <button type="submit" class="btn btn-primary w-100">Agregar Producto</button>
    
              </div>
          </form>
      </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script>
    
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
  agregarUsuario();
}

function agregarUsuario(){
  global $conexion;

  // Obtener los datos del formulario
  $desc = $_POST['descripcion'] ?? '';
  $obser = $_POST['observacion'] ?? '';
  $precio = $_POST['precio'] ?? '';

  if (empty($desc) || empty($obser) || empty($precio)) {
      echo "<script>alert('Todos los campos son obligatorios');</script>";
      return;
  }else{

    //Preparar la consulta para agregarlo a SQL
    $sql = "INSERT INTO Producto (descripcion, observaciones, precio) VALUES (?, ?, ?)";

    if ($stmt = $conexion->prepare($sql)) {

      $stmt->bind_param("sss", $desc, $obser, $precio);

      if ($stmt->execute()) {
        echo '<script>alert("Producto agregado correctamente."); window.location.href = "../../index.php";</script>';
      } else {
          echo "Error al agregar el producto: " . $stmt->error;
      }

      $stmt->close();
  }

  }

}

?>
