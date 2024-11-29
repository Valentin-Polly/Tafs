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

// Consulta para obtener todos los productos cargados
$sql = "SELECT * FROM espectaculos";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    ?>
    <html>
    <head>
        <title>Dar de baja productos</title>
    </head>
    <body>
        <h1>Dar de baja productos</h1>
        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
            <table>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Descripción</th>
                    <th>Precio Unitario</th>
                    <th>Acción</th>
                </tr>
                <?php
                while($row = $result->fetch_assoc()) {
                    ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row["id_espectaculo"]); ?></td>
                        <td><?php echo htmlspecialchars($row["nombre"]); ?></td>
                        <td><?php echo htmlspecialchars($row["descripcion"]); ?></td>
                        <td><?php echo htmlspecialchars($row["precio"]); ?></td>
                        <td>
                            <input type="checkbox" name="espectaculos[]" value="<?php echo htmlspecialchars($row["id_espectaculo"]); ?>" class="checkbox">
                            Dar de baja
                        </td>
                    </tr>
                    <?php
                }
                ?>
            </table>
            <input type="submit" value="Dar de baja seleccionados" class="btn">

    </body>
    </html>
    <?php
} else {
    echo "No hay productos cargados.";
}

// Procesar formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["espectaculos"]) && !empty($_POST["espectaculos"])) {
        $Espectaculos = $_POST["espectaculos"];
        foreach ($Espectaculos as $id) {
            if (!empty($id)) { // Verificar que $id no esté vacío
                $stmt = $conn->prepare("DELETE FROM espectaculos WHERE id_espectaculo = ?");
                $stmt->bind_param("s", $id); 
                $stmt->execute();
                
                echo "Producto con ID $id dado de baja correctamente.<br>";
            } else {
                
                echo "Error: No se puede eliminar un producto con ID vacío.";
            }
        }
    } else {
        echo "No se han seleccionado productos para dar de baja.";
    }
}

$conn->close();
?>
        </form>