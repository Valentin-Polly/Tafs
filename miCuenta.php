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
    <li><a href="#">Ofertas</a></li>
    <li><a href="#">Contactanos</a></li>
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
<?php
// Verifica si la sesión está iniciada
if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] == true) {
    // Muestra el contenido de la página de usuario
    // ...
} else {
    // Redirige al usuario a la página de login
    header('Location: login.php');
    exit;
}
?>
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
function toggleEdit(field) {
    var span = document.getElementById(field);
    var input = document.getElementsByName(field)[0];
    var button = document.getElementById('submitButton');
    
    if (input.style.display === "none") {
        span.style.display = "none";
        input.style.display = "inline";
        button.style.display = "block";
    } else {
        span.style.display = "inline";
        input.style.display = "none";
    }
}
</script>
<?php
// Obtener el email del usuario de la sesión
$email = $_SESSION['email'];

// Preparar la consulta SQL para obtener solo los datos del usuario actual
$sql = "SELECT * FROM usuarios WHERE email = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 1) {
    $row = $result->fetch_assoc();
    ?>
    <h2>Mis Datos</h2>
    <form action="actualizar_datos.php" method="POST">
        <div>
            Nombre: <span id="nombre"><?php echo htmlspecialchars($row['nombre']); ?></span>
            <input type="text" name="nombre" value="<?php echo htmlspecialchars($row['nombre']); ?>" style="display:none;">
            <button type="button" onclick="toggleEdit('nombre')">Editar</button>
        </div>
        <div>
            Apellido: <span id="apellido"><?php echo htmlspecialchars($row['apellido']); ?></span>
            <input type="text" name="apellido" value="<?php echo htmlspecialchars($row['apellido']); ?>" style="display:none;">
            <button type="button" onclick="toggleEdit('apellido')">Editar</button>
        </div>
        <div>
            DNI: <span id="dni"><?php echo htmlspecialchars($row['dni']); ?></span>
            <input type="text" name="dni" value="<?php echo htmlspecialchars($row['dni']); ?>" style="display:none;">
            <button type="button" onclick="toggleEdit('dni')">Editar</button>
        </div>
        <div>
            Email: <span id="email"><?php echo htmlspecialchars($row['email']); ?></span>
            <input type="email" name="email" value="<?php echo htmlspecialchars($row['email']); ?>" style="display:none;">
            <button type="button" onclick="toggleEdit('email')">Editar</button>
        </div>
        <div>
            Contraseña: <span id="contraseña">********</span>
            <input type="password" name="contraseña" value="" style="display:none;">
            <button type="button" onclick="toggleEdit('contraseña')">Editar</button>
        </div>
        <div>
            Teléfono: <span id="telefono"><?php echo htmlspecialchars($row['telefono']); ?></span>
            <input type="tel" name="telefono" value="<?php echo htmlspecialchars($row['telefono']); ?>" style="display:none;">
            <button type="button" onclick="toggleEdit('telefono')">Editar</button>
        </div>
        <input type="submit" value="Guardar cambios" style="display:none;" id="submitButton">
    </form>
    <?php
} else {
    echo "No se encontraron datos del usuario.";
}


$stmt->close();
$conn->close();
?>
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