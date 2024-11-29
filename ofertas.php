<!--
==============================================================================================================================================================================
Conexion con Base de Datos
==============================================================================================================================================================================
-->
<?php
// Conexión a la base de datos
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "tafs"; // Se cambió el nombre de la base de datos para evitar espacios

$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

// Inicia la sesión
session_start();

// Verifica si el usuario ha iniciado sesión
if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] == true) {
    echo "Bienvenido, " . $_SESSION['email'];
    $boton = '<li><a href="cerrar_sesion.php">Cerrar sesión</a></li>';
} else {
    $mensaje = "";
    $boton = '<li><a href="login.php">Login</a></li>';
    $boton .= '<li><a href="registro.php">Registro</a></li>';
}

$fecha_filtro = isset($_GET['fecha']) ? $_GET['fecha'] : null;
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Teatro - Reserva de Entradas</title>
    <link rel="stylesheet" href="css/estilos.css">
    <script src="https://kit.fontawesome.com/2bec4d7b4a.js" crossorigin="anonymous"></script>
</head>
<body>

<!--
==============================================================================================================================================================================
Menú de Navegación
==============================================================================================================================================================================
-->
    <nav>
    <ul>
    <li><a href="index.php"><img width="50px" src="img/IMG-20241010-WA0006.png" alt="Logo" id="logo"><span style="font-size: 30px; vertical-align: 20px; color: #f9f9f9;  margin-left: 10px;">TAFS  | </span></a></li>
    <li><a href="ofertas.php">Ofertas</a></li>
    <li><a href="contactos.php">Contactanos</a></li>
    <li>
      <a href="#">Usuario</a>
      <ul>
        <?php echo $boton; ?>
        <li><a href="miCuenta.php">Mi Cuenta</a></li>
        <li><a href="puntosTafs.php">Puntos Tafs</a></li>
      </ul>
    </li>
    <li><input type="date" id="calendar" onchange="filtrarPorFecha()" /></li>
  </ul>
</nav>
<script>
function filtrarPorFecha() {
    var fecha = document.getElementById('calendar').value;
    window.location.href = 'index.php?fecha=' + fecha;
}

window.onload = function() {
    var urlParams = new URLSearchParams(window.location.search);
    var fecha = urlParams.get('fecha');
    if (fecha) {
        document.getElementById('calendar').value = fecha;
    }
}

function toggleDescription(id) {
    var desc = document.getElementById(id);
    if (desc.style.display === "none") {
        desc.style.display = "block";
    } else {
        desc.style.display = "none";
    }
}

</script>
<!--
==============================================================================================================================================================================
Carousel (sin terminar)
==============================================================================================================================================================================

<section class="carousel">
    <div class="carousel-inner">
        <?php
        $sql = "SELECT img, nombre FROM espectaculos ORDER BY RAND() LIMIT 1";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                ?>
                <div class="carousel-item">
                    <div class="NombreProducto"><?php echo $row['nombre']; ?></div>
                    <img src="data:image/jpg;base64,<?php echo base64_encode($row['img']); ?>" />
                </div>
                <?php
            }
        }
        ?>
    </div>
    <div class="carousel-controls">
    <button class="carousel-control prev" onclick="moveCarousel(-1)">&#10094;</button>
    <button class="carousel-control next" onclick="moveCarousel(1)">&#10095;</button>
    </div>
</section>
-->
    <!--
==============================================================================================================================================================================
Mostrar productos
==============================================================================================================================================================================
 -->

 <section class="products">
    <?php
    $sql = "SELECT * FROM espectaculos WHERE categoria= 'oferta' ";
    $result = $conn->query($sql);

    if ($result === false) {
        echo "Error en la consulta: " . $conn->error;
    } else {
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                ?>
                <div class="product">
                    <div class="NombreProducto"><?php echo htmlspecialchars($row['nombre']); ?></div>
                    <?php if(!empty($row['img'])) { ?>
                        <img src="data:image/jpg;base64,<?php echo base64_encode($row['img']); ?>" alt="<?php echo htmlspecialchars($row['nombre']); ?>"/>
                    <?php } ?>
                    <div class="price">$<?php echo htmlspecialchars($row['precio']); ?></div>
                    <div class="fecha">
                        Fecha: <?php echo htmlspecialchars($row['fecha']); ?> | 
                        Hora: <?php echo htmlspecialchars($row['hora']); ?>
                    </div>
                    <div class="duracion">Duración: <?php echo htmlspecialchars($row['duracion']); ?></div>
                    <div class="button-container">
                        <button>Agregar</button>
                        <button onclick="toggleDescription('desc_<?php echo htmlspecialchars($row['nombre']); ?>')">Detalles</button>
                        <div id="desc_<?php echo htmlspecialchars($row['nombre']); ?>" class="description" style="display:none;">
                            <?php echo htmlspecialchars($row['descripcion']); ?>
                        </div>
                    </div>
                </div>
                <?php
            }
        } else {
            echo "<p>No hay espectáculos disponibles para la fecha seleccionada.</p>";
        }
    }
    ?>
</section>
</body>
<footer>
    <div>
        <h2>Redes TAFS</h2>
        <div class="redes-sociales">
            <a href="https://www.facebook.com/teatro.tafs/" class="fa fa-facebook"></a>
            <span>|</span>
            <a href="https://x.com/teatrotafs" class="fa fa-twitter"></a>
            <span>|</span>
            <a href="https://www.instagram.com/teatrotafs/?igsh=dGx6azByMTd4M2pq" class="fa fa-instagram"></a>
        </div>
        <p>Teatro TAFS &reg; 2024</p>
    </div>
</footer>
</html>