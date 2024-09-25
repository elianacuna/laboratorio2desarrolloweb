<?php
include('../includes/conexion.php');

// Verificar si el parámetro 'codigo' está presente en la URL
if (isset($_GET['codigo'])) {
    $codigoFactura = $_GET['codigo'];

    // Consulta para obtener los detalles de la factura y su cliente
    $consulta_factura = $conexion->query("SELECT f.codigo, f.cliente, f.fecha, f.monto, c.nombre AS nombre_cliente 
                                          FROM factura f 
                                          INNER JOIN clientes c ON f.cliente = c.codigo
                                          WHERE f.codigo = $codigoFactura");

    // Obtener detalles del cliente y la factura
    if ($consulta_factura->num_rows > 0) {
        $factura = $consulta_factura->fetch_object();
        
        // Consulta para obtener los productos asociados a la factura
        $consulta_detalles = $conexion->query("SELECT p.descripcion, df.cantidad, df.subtotal 
                                               FROM detalle_factura df 
                                               INNER JOIN producto p ON df.producto = p.codigo 
                                               WHERE df.factura = $codigoFactura");
    } else {
        echo "No se encontraron detalles para la factura.";
        exit;
    }
} else {
    echo "No se ha especificado un código de factura.";
    exit;
}
?>

<!doctype html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Factura #<?php echo $factura->codigo; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .invoice-title {
            margin-top: 20px;
            font-size: 32px;
            font-weight: bold;
        }
        .invoice {
            margin-top: 40px;
        }
        .table-invoice th {
            background-color: #f5f5f5;
        }
        .table-total {
            width: 100%;
            margin-top: 20px;
        }
        .table-total th, .table-total td {
            font-size: 18px;
        }
        .footer {
            margin-top: 50px;
            text-align: center;
            font-size: 14px;
            color: #777;
        }
    </style>
</head>
<body>

<div class="container invoice">
    <div class="row">
        <div class="col-12">
            <div class="invoice-title">
                Factura #<?php echo $factura->codigo; ?>
            </div>
            <hr>
            <div class="row">
                <div class="col-6">
                    <address>
                        <strong>Cliente:</strong><br>
                        <?php echo $factura->nombre_cliente; ?><br>
                    </address>
                </div>
                <div class="col-6 text-end">
                    <address>
                        <strong>Fecha de emisión:</strong><br>
                        <?php echo date("d/m/Y", strtotime($factura->fecha)); ?><br>
                    </address>
                </div>
            </div>
        </div>
    </div>

    <!-- Detalles de los productos -->
    <div class="row">
        <div class="col-12">
            <h3>Detalles de la factura</h3>
            <table class="table table-bordered table-invoice">
                <thead>
                    <tr>
                        <th>Producto</th>
                        <th>Cantidad</th>
                        <th>Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    while ($detalle = $consulta_detalles->fetch_object()) {
                        echo "<tr>";
                        echo "<td>" . $detalle->descripcion . "</td>";
                        echo "<td class='text-center'>" . $detalle->cantidad . "</td>";
                        echo "<td class='text-end'>Q " . number_format($detalle->subtotal, 2) . "</td>";
                        echo "</tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Totales -->
    <div class="row">
        <div class="col-12">
            <table class="table-total text-end">
                <tr>
                    <th class="text-end">Monto Total:</th>
                    <td class="text-end">Q <?php echo number_format($factura->monto, 2); ?></td>
                </tr>
            </table>
        </div>
    </div>

    <!-- Footer -->
    <div class="footer">
        <p>Gracias por su compra.</p>
    </div>
</div>

</body>
</html>
