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
</nav>

<div class = "boxcontactos">
<h2>Redes TAFS</h2>
        <div class="redes">
            <span class="redes">Facebook</span>
            <a href="https://www.facebook.com/teatro.tafs/" class="fa fa-facebook"></a><br>
            <span>X</span>
            <a href="https://x.com/teatrotafs" class="fa fa-twitter"></a><br>
            <span>Instagram</span>
            <a href="https://www.instagram.com/teatrotafs/?igsh=dGx6azByMTd4M2pq" class="fa fa-instagram"></a><br>
        </div>
<h2>Telefono</h2>
  <p class="redes">02475 40-4487</p>
<h2>E-Mail</h2>
  <p class="redes">tafs@gmail.com</p>
</div>
<footer>
    <div>
        <p>Teatro TAFS &reg; 2024</p>
    </div>
</footer>
</body>
</html>