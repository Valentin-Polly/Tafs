<?php
$id_espectaculo = $_POST['id_espectaculo'];
$nombre = $_POST['nombre'];
$precio = $_POST['precio'];
$fecha = $_POST['fecha'];
$hora = $_POST['hora'];

// Procesar el pago según el método seleccionado...
?>
<div class="detalles-espectaculo">
<h2>Espectáculo seleccionado:</h2>
<p><strong>Nombre:</strong> <?php echo htmlspecialchars($nombre); ?></p>
<p><strong>Precio:</strong> $<?php echo htmlspecialchars($precio); ?></p>
<p><strong>Fecha:</strong> <?php echo htmlspecialchars($fecha); ?></p>
<p><strong>Hora:</strong> <?php echo htmlspecialchars($hora); ?></p>
</div>  