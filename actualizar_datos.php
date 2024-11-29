
<?php
session_start();
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "tafs";


$conn = new mysqli(hostname: $servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_SESSION['email']; // Asumiendo que guardaste el email del usuario en la sesión

    $fields = ['nombre', 'apellido', 'dni', 'email', 'contraseña', 'telefono'];
    $updates = [];

    foreach ($fields as $field) {
        if (isset($_POST[$field]) && !empty($_POST[$field])) {
            $value = $conn->real_escape_string($_POST[$field]);
            $updates[] = "$field = '$value'";
        }
    }

    if (!empty($updates)) {
        $sql = "UPDATE usuarios SET " . implode(", ", $updates) . " WHERE email = '$email'";

        if ($conn->query($sql) === TRUE) {
            echo "Datos actualizados correctamente";
            // Si el email fue actualizado, actualiza también la sesión
            if (isset($_POST['email'])) {
                $_SESSION['email'] = $_POST['email'];
            }
        } else {
            echo "Error al actualizar datos: " . $conn->error;
        }
    } else {
        echo "No se recibieron datos para actualizar";
    }
}

$conn->close();

// Redirigir de vuelta a la página de mi cuenta
header("Location: miCuenta.php");
exit();
?>