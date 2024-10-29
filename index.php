<?php

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema de Boletas</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <?php include ("encabezado.php"); ?>

    <div class="container text-center">
        <div class="header-circle"></div>
        <h1 class="mt-4">Bienvenido al Sistema de Boletas</h1>
        <div class="mt-4">
            <h2>Administrar</h2>
            <ul class="list-group mt-3">
                <li class="list-group-item"><a href="agregarProveedor.php">Agregar Proveedor</a></li>
                <li class="list-group-item"><a href="agregarCliente.php">Agregar Cliente</a></li>
                <li class="list-group-item"><a href="agregarEvento.php">Agregar Evento</a></li>
                <li class="list-group-item"><a href="comprarBoleta.php">Vender Boleta</a></li>
                <li class="list-group-item"><a href="verFacturas.php">Ver Facturas</a></li>
            </ul>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
