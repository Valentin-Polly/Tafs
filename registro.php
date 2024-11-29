<?php
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "tafs";

    $conn = mysqli_connect($servername, $username, $password, $dbname);

    if (!$conn) {
        die("Conexión fallida: " . mysqli_connect_error());
    }

// Inicia la sesión
session_start();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/estilos.css">
    <title>registro</title>
</head>
<body>
<div class="container">
    <form action="" method="POST" class="formulario">
        <h2 class="titulo">REGISTRAR</h2>
<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
    <label for="nombre">Nombre:</label>
    <input type="text" id="nombre" name="nombre" class="form-control"><br><br>
    <label for="apellido">Apellido:</label>
    <input type="text" id="apellido" name="apellido" class="form-control"><br><br>
    <label for="dni">DNI:</label>
    <input type="text" id="dni" name="dni" class="form-control"><br><br>
    <label for="email">Email:</label>
    <input type="email" id="email" name="email" class="form-control"><br><br>
    <label for="contraseña">Contraseña:</label>
    <input type="password" id="contraseña" name="contraseña" class="form-control"><br><br>
    <label for="telefono">Telefono:</label>
    <input type="telefono" id="telefono" name="telefono" class="form-control"><br><br>
    <input type="submit" value="Registrarse" class="boton-primario">
</form>
</div>
<?php
if (!$conn) {
    die("Error de conexión: " . mysqli_connect_error());
}
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (empty($_POST["nombre"]) or empty($_POST["apellido"]) or empty($_POST["dni"]) or empty($_POST["email"]) or empty($_POST["contraseña"]) or empty($_POST["telefono"])) {
        $_SESSION['error'] = "Uno de los campos esta vacio";
        header('Location: registro.php'); 
        exit;
    } else {
        $nombre = $_POST['nombre'];
        $apellido = $_POST['apellido'];
        $dni = $_POST['dni'];
        $email = $_POST['email'];
        $contraseña = $_POST['contraseña'];
        $telefono = $_POST['telefono'];

        $stmt = $conn->prepare("INSERT INTO usuarios (nombre, apellido, dni, email, contraseña, telefono) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssss", $nombre, $apellido, $dni, $email, $contraseña, $telefono);
        $stmt->execute();

        if ($stmt->affected_rows == 1) {
            echo "<script>alert('Registro exitoso!')</script>"; 
        } else {
            echo "Error al registrar: " . $stmt->error;
        }
        $stmt->close();
    }
}
?>
</body>
</html>