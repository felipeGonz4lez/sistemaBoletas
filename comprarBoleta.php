<?php
require_once("./persistencia/BoletaDAO.php");
require_once("./persistencia/ClienteDAO.php");
require_once("./persistencia/EventoDAO.php");

// Crear instancias de DAO
$boletaDAO = new BoletaDAO();
$clienteDAO = new ClienteDAO();
$eventoDAO = new EventoDAO();

$mensaje = '';

// Manejo de la lógica para comprar boletos
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Verificar si se está comprando una boleta
    if (isset($_POST["nombre_usuario"]) && isset($_POST["id_cliente"]) && isset($_POST["id_evento"])) {
        // Insertar nueva boleta
        $boleta = new Boleta(null, $_POST["nombre_usuario"], $_POST["id_cliente"], $_POST["id_evento"]);
        $idBoleta = $boletaDAO->insertarBoleta($boleta);
        $mensaje = "Boleta comprada exitosamente con ID: $idBoleta.";
    }
    
    // Verificar si se está eliminando una boleta
    if (isset($_POST["id_boleta"])) {
        $boletaDAO->eliminarBoleta($_POST["id_boleta"]);
        $mensaje = "Boleta eliminada exitosamente.";
    }
}

// Obtener todos los clientes y eventos para llenar los select
$clientes = $clienteDAO->obtenerTodosLosClientes();
$eventos = $eventoDAO->obtenerTodosLosEventos();
$boletasVendidas = $boletaDAO->obtenerTodasLasBoletas();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Venta de Boletas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<?php include ("encabezado.php");?>
<div class="container mt-5">
    <h1 class="text-center">Venta de Boletas</h1>
    <p class="text-success"><?php echo $mensaje; ?></p>

    <!-- Formulario para comprar boleta -->
    <form method="POST" action="comprarBoleta.php" class="mb-4">
        <div class="mb-3">
            <label for="nombre_usuario" class="form-label">Nombre del Usuario:</label>
            <input type="text" name="nombre_usuario" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="id_cliente" class="form-label">Seleccione Cliente:</label>
            <select name="id_cliente" class="form-select" required>
                <option value="">Seleccione un cliente</option>
                <?php foreach ($clientes as $cliente): ?>
                    <option value="<?php echo $cliente->getIdCliente(); ?>">
                        <?php echo $cliente->getIdCliente() . ' - ' . $cliente->getNombre(); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="mb-3">
            <label for="id_evento" class="form-label">Seleccione Evento:</label>
            <select name="id_evento" class="form-select" required>
                <option value="">Seleccione un Evento</option>
                <?php foreach ($eventos as $evento): ?>
                    <option value="<?php echo $evento->getIdEvento(); ?>"><?php echo $evento->getNombre(); ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Vender Boleta</button>
    </form>

    <!-- Tabla de Boletas Vendidas -->
    <h2>Boletas Vendidas</h2>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>ID Boleta</th>
                <th>Nombre Usuario</th>
                <th>ID Cliente</th>
                <th>ID Evento</th>
                <th>Precio</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php if (count($boletasVendidas) > 0): ?>
                <?php foreach ($boletasVendidas as $boleta): ?>
                <tr>
                    <td><?php echo $boleta->getIdBoleta(); ?></td>
                    <td><?php echo $boleta->getNombreUsuario(); ?></td>
                    <td><?php echo $boleta->getIdCliente(); ?></td>
                    <td><?php echo $boleta->getIdEvento(); ?></td>
                    
                    <?php 
                        // Obtener el evento correspondiente para obtener el precio
                        $evento = $eventoDAO->obtenerEventoPorId($boleta->getIdEvento()); 
                    ?>
                    <td><?php echo $evento ? $evento->getPrecio() : 'N/A'; ?></td> <!-- Mostrar Precio del Evento -->
                    
                    <td>
                        
                        <form method="POST" action="comprarBoleta.php" class="d-inline">
                            <input type="hidden" name="id_boleta" value="<?php echo $boleta->getIdBoleta(); ?>">
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('¿Está seguro de que desea eliminar esta boleta?');">Eliminar</button>
                        </form>
                    </td>
                </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="5" class="text-center">No hay boletas vendidas disponibles.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>
</body>
</html>

