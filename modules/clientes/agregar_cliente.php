<!doctype html>
<html lang="en">
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
      <div class="card mx-auto rounded" style="max-width: 600px;">
          <div class="card-header text-center bg-primary text-white rounded-top">
              Agregar Cliente
          </div>
          <form action="" method="POST" novalidate>
            <div class="card-body">

              <div class="col-md">
                <label for="nombres" class="form-label">Nombre</label>
                <input type="text" class="form-control" name="nombres"  required>
              </div>
    
              <!-- Correo y telefono -->
              <div class="row mb-3" style="margin-top: 10px;">
                <div class="col-md-6">
                    <label for="correo" class="form-label">Correo electronico</label>
                    <input type="email" class="form-control" name="correo"required>
                </div>
                <div class="col-md-6">
                    <label for="tel" class="form-label">Número de telefono</label>
                    <input type="number" class="form-control" name="telefono"  required>
                </div>
            </div>
    
            <button type="submit" class="btn btn-primary w-100">Agregar cliente</button>
    
    
              </div>

          </form>
      </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
  </body>
</html>