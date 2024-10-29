<?php
require_once("./persistencia/EventoDAO.php");
require_once("./logica/Evento.php");
require_once("./persistencia/ProveedorDAO.php");

// Crear instancia de DAO
$eventoDAO = new EventoDAO();
$proveedorDAO = new ProveedorDAO();
$mensaje = '';

// Manejo de la lógica para agregar, actualizar y eliminar eventos
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Insertar o actualizar evento
    if (isset($_POST["id_evento"]) && $_POST["id_evento"] !== "") {
        // Actualizar evento
        $evento = new Evento($_POST["id_evento"], $_POST["nombre_evento"], $_POST["fecha"], $_POST["aforo"], $_POST["id_proveedor"], $_POST["precio"]);
        $eventoDAO->actualizarEvento($evento);
        $mensaje = "Evento actualizado exitosamente.";
    } else {
        // Insertar nuevo evento
        $evento = new Evento(null, $_POST["nombre_evento"], $_POST["fecha"], $_POST["aforo"], $_POST["id_proveedor"], $_POST["precio"]);
        $eventoDAO->insertarEvento($evento);
        $mensaje = "Evento agregado exitosamente.";
    }
} elseif (isset($_GET["eliminar_id"])) {
    // Eliminar evento
    $eventoDAO->eliminarEvento($_GET["eliminar_id"]);
    $mensaje = "Evento eliminado exitosamente.";
} elseif (isset($_GET["editar_id"])) {
    // Obtener evento a editar
    $eventoEditando = $eventoDAO->obtenerEventoPorId($_GET["editar_id"]);
}

// Obtener todos los eventos y proveedores
$eventos = $eventoDAO->obtenerTodosLosEventos();
$proveedores = $proveedorDAO->obtenerTodosLosProveedores();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Gestión de Eventos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<?php include ("encabezado.php");?>
<div class="container mt-5">
    <h1 class="text-center">Gestión de Eventos</h1>
    <p class="text-success"><?php echo $mensaje; ?></p>

    <!-- Formulario para agregar/editar evento -->
    <form method="POST" action="agregarEvento.php" class="mb-4">
        <input type="hidden" name="id_evento" value="<?php echo isset($eventoEditando) ? $eventoEditando->getIdEvento() : ''; ?>">
        
        <div class="mb-3">
            <label for="nombre_evento" class="form-label">Nombre del Evento:</label>
            <input type="text" name="nombre_evento" class="form-control" required value="<?php echo isset($eventoEditando) ? $eventoEditando->getNombre() : ''; ?>">
        </div>
        
        <div class="mb-3">
            <label for="fecha" class="form-label">Fecha del Evento:</label>
            <input type="date" name="fecha" class="form-control" required value="<?php echo isset($eventoEditando) ? $eventoEditando->getFecha() : ''; ?>">
        </div>
        
        <div class="mb-3">
            <label for="aforo" class="form-label">Aforo:</label>
            <input type="number" name="aforo" class="form-control" required value="<?php echo isset($eventoEditando) ? $eventoEditando->getAforo() : ''; ?>">
        </div>
        
         <div class="mb-3">
            <label for="precio" class="form-label">Precio:</label>
            <input type="number" name="precio" class="form-control" required value="<?php echo isset($eventoEditando) ? $eventoEditando->getPrecio() : ''; ?>" step="0.01">
        </div>
        
        <div class="mb-3">
            <label for="id_proveedor" class="form-label">Proveedor:</label>
            <select name="id_proveedor" class="form-select" required>
                <option value="">Seleccione un proveedor</option>
                <?php foreach ($proveedores as $proveedor): ?>
                    <option value="<?php echo $proveedor->getIdProveedor(); ?>" 
                        <?php echo isset($eventoEditando) && $eventoEditando->getIdProveedor() == $proveedor->getIdProveedor() ? 'selected' : ''; ?>>
                        <?php echo $proveedor->getIdProveedor() . ' - ' . $proveedor->getNombre(); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        
        <button type="submit" class="btn btn-primary"><?php echo isset($eventoEditando) ? 'Actualizar Evento' : 'Agregar Evento'; ?></button>
    </form>

    <!-- Tabla para mostrar eventos -->
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Fecha</th>
                <th>Aforo</th>
                <th>Precio</th>
                <th>ID Proveedor</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($eventos as $evento): ?>
                <tr>
                    <td><?php echo $evento->getIdEvento(); ?></td>
                    <td><?php echo $evento->getNombre(); ?></td>
                    <td><?php echo $evento->getFecha(); ?></td>
                    <td><?php echo $evento->getAforo(); ?></td>
                    <td><?php echo $evento->getPrecio(); ?></td>
                    <td><?php echo $evento->getIdProveedor(); ?></td>
                    <td>
                        <a href="agregarEvento.php?editar_id=<?php echo $evento->getIdEvento(); ?>" class="btn btn-warning btn-sm">Editar</a>
                        <a href="agregarEvento.php?eliminar_id=<?php echo $evento->getIdEvento(); ?>" class="btn btn-danger btn-sm" onclick="return confirm('¿Estás seguro de eliminar este evento?');">Eliminar</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
</body>
</html>