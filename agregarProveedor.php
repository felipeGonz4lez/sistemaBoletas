<?php
require_once("./persistencia/ProveedorDAO.php");
require_once("./logica/Proveedor.php");

$proveedorDAO = new ProveedorDAO();
$mensaje = '';

// Manejo de la lógica para agregar, actualizar y eliminar
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Insertar o actualizar proveedor
    if (isset($_POST["id_proveedor"]) && $_POST["id_proveedor"] !== "") {
        // Actualizar proveedor
        $proveedor = new Proveedor($_POST["id_proveedor"], $_POST["nombre"], $_POST["email"], $_POST["telefono"]);
        $proveedorDAO->actualizarProveedor($proveedor);
        $mensaje = "Proveedor actualizado exitosamente.";
    } else {
        // Insertar nuevo proveedor
        $proveedor = new Proveedor(null, $_POST["nombre"], $_POST["email"], $_POST["telefono"]);
        $proveedorDAO->insertarProveedor($proveedor);
        $mensaje = "Proveedor agregado exitosamente.";
    }
} elseif (isset($_GET["eliminar_id"])) {
    // Eliminar proveedor
    $proveedorDAO->eliminarProveedor($_GET["eliminar_id"]);
    $mensaje = "Proveedor eliminado exitosamente.";
} elseif (isset($_GET["editar_id"])) {
    // Obtener proveedor a editar
    $proveedorEditando = $proveedorDAO->obtenerProveedorPorId($_GET["editar_id"]);
}

// Obtener todos los proveedores para mostrar en la tabla
$proveedores = $proveedorDAO->obtenerTodosLosProveedores();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Gestión de Proveedores</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<?php include ("encabezado.php");?>
<div class="container mt-5">
    <h1 class="text-center">Gestión de Proveedores</h1>
    <p class="text-success"><?php echo $mensaje; ?></p>

    <!-- Formulario para agregar/editar proveedor -->
    <form method="POST" action="agregarProveedor.php" class="mb-4">
        <input type="hidden" name="id_proveedor" value="<?php echo isset($proveedorEditando) ? $proveedorEditando->getIdProveedor() : ''; ?>">
        
        <div class="mb-3">
            <label for="nombre" class="form-label">Nombre:</label>
            <input type="text" name="nombre" class="form-control" required value="<?php echo isset($proveedorEditando) ? $proveedorEditando->getNombre() : ''; ?>">
        </div>
        
        <div class="mb-3">
            <label for="email" class="form-label">Email:</label>
            <input type="email" name="email" class="form-control" value="<?php echo isset($proveedorEditando) ? $proveedorEditando->getEmail() : ''; ?>">
        </div>
        
        <div class="mb-3">
            <label for="telefono" class="form-label">Teléfono:</label>
            <input type="text" name="telefono" class="form-control" value="<?php echo isset($proveedorEditando) ? $proveedorEditando->getTelefono() : ''; ?>">
        </div>
        
        <button type="submit" class="btn btn-primary"><?php echo isset($proveedorEditando) ? 'Actualizar Proveedor' : 'Agregar Proveedor'; ?></button>
    </form>

    <!-- Tabla para mostrar proveedores -->
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
            <?php foreach ($proveedores as $proveedor): ?>
                <tr>
                    <td><?php echo $proveedor->getIdProveedor(); ?></td>
                    <td><?php echo $proveedor->getNombre(); ?></td>
                    <td><?php echo $proveedor->getEmail(); ?></td>
                    <td><?php echo $proveedor->getTelefono(); ?></td>
                    <td>
                        <a href="agregarProveedor.php?editar_id=<?php echo $proveedor->getIdProveedor(); ?>" class="btn btn-warning btn-sm">Editar</a>
                        <a href="agregarProveedor.php?eliminar_id=<?php echo $proveedor->getIdProveedor(); ?>" class="btn btn-danger btn-sm" onclick="return confirm('¿Estás seguro de eliminar este proveedor?');">Eliminar</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
</body>
</html>
