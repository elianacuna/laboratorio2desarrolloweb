<?php
// Conexion a la base de datos
include_once '../../includes/conexion.php';

if (isset($_GET['codigo'])) {
    $codigo = $_GET['codigo'];

    // Consulta para eliminar el producto
    $sql = "DELETE FROM Producto WHERE codigo = ?";
    $stmt = mysqli_prepare($conexion, $sql);
    mysqli_stmt_bind_param($stmt, 'i', $codigo);
    
    if (mysqli_stmt_execute($stmt)) {
        echo '<script>alert("producto eliminado correctamente."); window.location.href = "../../index.php";</script>';
    } else {
        echo "<script>alert('Error al eliminar producto');</script>";
    }

    mysqli_stmt_close($stmt);
}

mysqli_close($conexion);

header("Location: ../../producto.php");
exit();
?>
