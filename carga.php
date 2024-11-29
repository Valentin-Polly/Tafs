<?php
// Conexión a la base de datos
$hostname = 'localhost';
$username = 'root';
$password = '';
$database = 'tafs';

$conn = new mysqli($hostname, $username, $password, $database);

// Verificar conexión
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

// Crear el formulario
?>
<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" enctype="multipart/form-data">
  <label for="nombre">Nombre del producto: </label>
  <input type="text" id="nombre" name="nombre"><br><br>
  <label for="precio">Precio unitario del producto: </label>
  <input type="number" id="precio" name="precio"><br><br>
  <label for="descripcion">Descripción del producto: </label>
  <textarea id="descripcion" name="descripcion"></textarea><br><br>
  <label for="fecha">Fecha: </label>
  <input type="date" id="fecha" name="fecha"><br><br>
  <label for="hora">Hora: </label>
  <input type="time" id="hora" name="hora"><br><br>
  <label for="duracion">Duracion: </label>
  <input type="text" id="duracion" name="duracion"><br><br>
  <label for="img">Imagen del producto: </label>
  <input type="file" id="img" name="img"><br><br>
  <label for="categoria">Categoria: </label>
  <select name="categoria" id="categoria">
    <option value="nulo"> - </option>
    <option value="precioNormal">Precio Normal</option>
    <option value="oferta">Oferta</option>
  </select>
  
  <input type="submit" value="Cargar producto">
</form>

<?php
// Procesar el formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $nombre = $_POST["nombre"];
  $precio = $_POST["precio"];
  $duracion = $_POST["duracion"];
  $descripcion = $_POST["descripcion"];
  $fecha = $_POST["fecha"];
  $hora = $_POST["hora"];
  $duracion = $_POST["duracion"];
  $categoria = $_POST["categoria"];

  // Procesar la imagen
  $img = addslashes(file_get_contents($_FILES['img']['tmp_name']));

  // Insertar el producto en la base de datos
  $sql = "INSERT INTO espectaculos (nombre, precio, duracion, descripcion, fecha, hora, categoria, img) VALUES ('$nombre', '$precio', '$duracion', '$descripcion', '$fecha', '$hora', '$categoria', '$img')";
  if ($conn->query($sql) === TRUE) {
    echo "Producto cargado con éxito!";
  } else {
    echo "Error al cargar el producto: " . $conn->error;
  }
}

// Cerrar la conexión
$conn->close();
?>
