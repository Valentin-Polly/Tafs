<?php
session_start();

// Verificar si se recibieron los datos del espectáculo
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener los datos del espectáculo
    $id_espectaculo = $_POST['id_espectaculo'];
    $nombre = $_POST['nombre'];
    $precio = $_POST['precio'];
    $fecha = $_POST['fecha'];
    $hora = $_POST['hora'];

    // Conexión a la base de datos para obtener imagen
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "tafs";

    $conn = new mysqli($servername, $username, $password, $dbname);

    // Obtener la imagen del espectáculo
    $stmt = $conn->prepare("SELECT img FROM espectaculos WHERE id_espectaculo = ?");
    $stmt->bind_param("i", $id_espectaculo);
    $stmt->execute();
    $result = $stmt->get_result();
    $imagen = '';
    
    if ($row = $result->fetch_assoc()) {
        $imagen = !empty($row['img']) ? 'data:image/jpg;base64,'.base64_encode($row['img']) : '';
    }
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pago - <?php echo htmlspecialchars($nombre); ?></title>
    <link rel="stylesheet" href="css/estilos.css">
    <style>

        .descripcion-expositor{
            display: flex;
            max-width: 500px;
            margin-left: 181px;
            background-color: #fff;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            border-radius: 10px;
            overflow: hidden;

        }

        .producto-expositor {
            display: flex;
            max-width: 1000px;
            margin: 20px auto;
            background-color: #fff;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            border-radius: 10px;
            overflow: hidden;
        }

        .producto-imagen {
            width: 50%;
            max-height: 500px;
        }

        .producto-imagen img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .producto-detalles {
            width: 50%;
            padding: 20px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .producto-info {
            margin-bottom: 20px;
        }

        .producto-info h1 {
            margin-bottom: 10px;
            color: #333;
        }

        .producto-precio {
            font-size: 2em;
            color: #3483fa;
            margin-bottom: 20px;
        }

        .metodos-pago {
        display: flex;
        justify-content: center; /* Centra horizontalmente */
        align-items: center; /* Alinea verticalmente */
        gap: 20px; /* Espacio entre las imágenes */
        margin-top: 20px;
    }

    .metodos-pago form {
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .metodos-pago img {
        width: 100px; /* Tamaño fijo para las imágenes */
        height: 100px; /* Tamaño fijo para las imágenes */
        object-fit: contain; /* Mantiene la proporción de la imagen */
        border-radius: 10px;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        box-shadow: 0 4px 6px rgba(0,0,0,0.1);
    }

    .metodos-pago img:hover {
        transform: scale(1.1);
        box-shadow: 0 6px 8px rgba(0,0,0,0.2);
    }
</style>
    </style>
</head>
<body>
    <div class="producto-expositor">
        <div class="producto-imagen">
            <?php if(!empty($imagen)): ?>
                <img src="<?php echo $imagen; ?>" alt="<?php echo htmlspecialchars($nombre); ?>">
            <?php else: ?>
                <img src="img/placeholder.jpg" alt="Imagen no disponible">
            <?php endif; ?>
        </div>
        <div class="producto-detalles">
            <div class="producto-info">
                <h1><?php echo htmlspecialchars($nombre); ?></h1>
                <p><strong>Fecha:</strong> <?php echo htmlspecialchars($fecha); ?></p>
                <p><strong>Hora:</strong> <?php echo htmlspecialchars($hora); ?></p>
            </div>
            <div class="producto-precio">
                $<?php echo number_format($precio, 2); ?>
            </div>
            
            <h2>Seleccione el método de pago</h2>
            <div class="metodos-pago">
    <!-- Transferencia Bancaria -->
    <form action="metodospago/TransferenciaBancaria.php" method="POST">
        <input type="hidden" name="id_espectaculo" value="<?php echo htmlspecialchars($id_espectaculo); ?>">
        <input type="hidden" name="nombre" value="<?php echo htmlspecialchars($nombre); ?>">
        <input type="hidden" name="precio" value="<?php echo htmlspecialchars($precio); ?>">
        <input type="hidden" name="fecha" value="<?php echo htmlspecialchars($fecha); ?>">
        <input type="hidden" name="hora" value="<?php echo htmlspecialchars($hora); ?>">
        <input type="image" src="img/TransferenciaBancaria.png" width="150px" alt="TransferenciaBancaria">
    </form>

    <!-- Mercado Pago -->
    <form action="metodospago/mercadopago.php" method="POST">
        <input type="hidden" name="id_espectaculo" value="<?php echo htmlspecialchars($id_espectaculo); ?>">
        <input type="hidden" name="nombre" value="<?php echo htmlspecialchars($nombre); ?>">
        <input type="hidden" name="precio" value="<?php echo htmlspecialchars($precio); ?>">
        <input type="hidden" name="fecha" value="<?php echo htmlspecialchars($fecha); ?>">
        <input type="hidden" name="hora" value="<?php echo htmlspecialchars($hora); ?>">
        <input type="image" src="img/mercadopago.webp" width="150px" alt="MercadoPago">
    </form>

    <!-- Cuenta DNI -->
    <form action="metodospago/cuentadni.php" method="POST">
        <input type="hidden" name="id_espectaculo" value="<?php echo htmlspecialchars($id_espectaculo); ?>">
        <input type="hidden" name="nombre" value="<?php echo htmlspecialchars($nombre); ?>">
        <input type="hidden" name="precio" value="<?php echo htmlspecialchars($precio); ?>">
        <input type="hidden" name="fecha" value="<?php echo htmlspecialchars($fecha); ?>">
        <input type="hidden" name="hora" value="<?php echo htmlspecialchars($hora); ?>">
        <input type="image" src="img/CuentaDNI.jpeg" width="150px" alt="CuentaDNI">
    </form>
</div>
        </div>
    </div>
<div class="descripcion-expositor">
    Descripcion
    <input type="hidden" name="hora" value="<?php echo htmlspecialchars($descripcion); ?>">
</div>
</body>
</html>

<?php
} else {
    // Si no se recibieron datos por POST, redirigir a la página principal
    header('Location: index.php');
    exit();
}
?>