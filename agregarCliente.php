<?php
require_once("./persistencia/ClienteDAO.php");
require_once("./logica/Cliente.php");

$clienteDAO = new ClienteDAO();
$mensaje = '';

// Manejo de la lógica para agregar, actualizar y eliminar
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Insertar o actualizar cliente
    if (isset($_POST["id_cliente"]) && $_POST["id_cliente"] !== "") {
        // Actualizar cliente
        $cliente = new Cliente($_POST["id_cliente"], $_POST["nombre"], $_POST["email"], $_POST["telefono"]);
        $clienteDAO->actualizarCliente($cliente);
        $mensaje = "Cliente actualizado exitosamente.";
    } else {
        // Insertar nuevo cliente
        $cliente = new Cliente(null, $_POST["nombre"], $_POST["email"], $_POST["telefono"]);
        $clienteDAO->insertarCliente($cliente);
        $mensaje = "Cliente agregado exitosamente.";
    }
} elseif (isset($_GET["eliminar_id"])) {
    // Eliminar cliente
    $clienteDAO->eliminarCliente($_GET["eliminar_id"]);
    $mensaje = "Cliente eliminado exitosamente.";
} elseif (isset($_GET["editar_id"])) {
    // Obtener cliente a editar
    $clienteEditando = $clienteDAO->obtenerClientePorId($_GET["editar_id"]);
}

// Obtener todos los clientes para mostrar en la tabla
$clientes = $clienteDAO->obtenerTodosLosClientes();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Gestión de Clientes</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<?php include ("encabezado.php");?>
<div class="container mt-5">
    <h1 class="text-center">Gestión de Clientes</h1>
    <p class="text-success"><?php echo $mensaje; ?></p>

    <!-- Formulario para agregar/editar cliente -->
    <form method="POST" action="agregarCliente.php" class="mb-4">
        <input type="hidden" name="id_cliente" value="<?php echo isset($clienteEditando) ? $clienteEditando->getIdCliente() : ''; ?>">
        
        <div class="mb-3">
            <label for="nombre" class="form-label">Nombre:</label>
            <input type="text" name="nombre" class="form-control" required value="<?php echo isset($clienteEditando) ? $clienteEditando->getNombre() : ''; ?>">
        </div>
        
        <div class="mb-3">
            <label for="email" class="form-label">Email:</label>
            <input type="email" name="email" class="form-control" value="<?php echo isset($clienteEditando) ? $clienteEditando->getEmail() : ''; ?>">
        </div>
        
        <div class="mb-3">
            <label for="telefono" class="form-label">Teléfono:</label>
            <input type="text" name="telefono" class="form-control" value="<?php echo isset($clienteEditando) ? $clienteEditando->getTelefono() : ''; ?>">
        </div>
        
        <button type="submit" class="btn btn-primary"><?php echo isset($clienteEditando) ? 'Actualizar Cliente' : 'Agregar Cliente'; ?></button>
    </form>

    <!-- Tabla para mostrar clientes -->
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Email</th>
                <th>Teléfono</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($clientes as $cliente): ?>
                <tr>
                    <td><?php echo $cliente->getIdCliente(); ?></td>
                    <td><?php echo $cliente->getNombre(); ?></td>
                    <td><?php echo $cliente->getEmail(); ?></td>
                    <td><?php echo $cliente->getTelefono(); ?></td>
                    <td>
                        <a href="agregarCliente.php?editar_id=<?php echo $cliente->getIdCliente(); ?>" class="btn btn-warning btn-sm">Editar</a>
                        <a href="agregarCliente.php?eliminar_id=<?php echo $cliente->getIdCliente(); ?>" class="btn btn-danger btn-sm" onclick="return confirm('¿Estás seguro de eliminar este cliente?');">Eliminar</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
</body>
</html>
