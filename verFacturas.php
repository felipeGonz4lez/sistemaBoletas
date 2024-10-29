<?php
require_once("./persistencia/FacturaDAO.php");
require_once("./persistencia/ClienteDAO.php");

// Crear instancias de DAO
$facturaDAO = new FacturaDAO();
$clienteDAO = new ClienteDAO();

// Obtener todas las facturas
$facturas = $facturaDAO->obtenerTodasLasFacturas();
$clientes = $clienteDAO->obtenerTodosLosClientes();

// Manejo de la eliminación de factura
if (isset($_GET['eliminar'])) {
    $facturaDAO->eliminarFactura($_GET['eliminar']);
    header("Location: verFacturas.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Ver Facturas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h1 class="text-center">Listado de Facturas</h1>

    <?php if (empty($facturas)): ?>
        <p class="text-danger">No hay facturas disponibles.</p>
    <?php else: ?>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID Factura</th>
                    <th>Fecha</th>
                    <th>Total</th>
                    <th>ID Cliente</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($facturas as $factura): ?>
                    <tr>
                        <td><?php echo $factura->getIdFactura(); ?></td>
                        <td><?php echo $factura->getFecha(); ?></td>
                        <td><?php echo $factura->getTotal(); ?></td>
                        <td><?php echo $factura->getIdCliente(); ?></td>
                        <td>
                            <a href="verFacturas.php?id=<?php echo $factura->getIdFactura(); ?>" class="btn btn-info btn-sm">Ver</a>
                            <a href="verFacturas.php?eliminar=<?php echo $factura->getIdFactura(); ?>" class="btn btn-danger btn-sm" onclick="return confirm('¿Está seguro de que desea eliminar esta factura?');">Eliminar</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</div>
</body>
</html>
