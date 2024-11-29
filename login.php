<?php
// Conexión a la base de datos
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "tafs";

$conn = mysqli_connect($servername, $username, $password, $dbname);

if (!$conn) {
    die("Conexión fallida: " . mysqli_connect_error());
}

// Verifica si se ha enviado el formulario
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['email']) && isset($_POST['contraseña'])) {
        $email = $_POST['email'];
        $password = $_POST['contraseña'];

        // Prepara la consulta para verificar los datos
        $sql = "SELECT * FROM usuarios WHERE email = '$email' AND contraseña = '$password'";

        // Ejecuta la consulta
        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) > 0) {
            // Inicia la sesión
            session_start();
            $_SESSION['email'] = $email;
            $_SESSION['logged_in'] = true;

            // Redirige al usuario a la página de inicio
            header('Location: index.php');
            exit;
        } else {
            // Si no hay resultados, significa que los datos no son correctos
            $error = "Error: Los datos no son correctos";
        }
    } else {
        $error = "Error: Los campos de email y contraseña son requeridos.";
    }
}
mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="estilos.css">
    <title>Document</title>
</head>
<body>
    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" class="formulario">
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" value="<?php if (isset($_POST['email'])) { echo $_POST['email']; } ?>" class="form-control"><br><br>
        <label for="contraseña">Contraseña:</label>
        <input type="password" id="contraseña" name="contraseña" value="<?php if (isset($_POST['contraseña'])) { echo $_POST['contraseña']; } ?>" class="form-control"><br><br>
        <input type="submit" value="Iniciar sesión" class="boton-primario">
        <?php if (isset($error)) { echo $error; } ?>
    </form>
</body>
</html>