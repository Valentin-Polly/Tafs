<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php    
        include "fnc.php";



        $consultaObra = "SELECT * FROM obra";
        $resultadoObra = $conexion->query($consultaObra);

        while($columnaObra = $resultadoObra->fetch_assoc())
        {

            $consultaInsert = "INSERT INTO programacion " .
                "(ID_Obra, Precio_Butaca, Porcentaje_Oferta, Fecha_Funcion) VALUES (" .
                $columnaObra['ID_Obra'] . ", 100, 0, NOW())";

            $conexion->query($consultaInsert);

        }

        $consultaProgramacion = "SELECT * FROM programacion";
        $resultadoProgramacion = $conexion->query($consultaProgramacion);

        while($columnaProgramacion = $resultadoProgramacion->fetch_assoc())
        {
            $consultaButaca = "SELECT * FROM butaca";
            $resultadoButaca = $conexion->query($consultaButaca);

            while($columnaButaca = $resultadoButaca->fetch_assoc())
            {
                $consultaUbicarButaca = "INSERT INTO ubicarbutaca " . 
                "(ID_Programacion, ID_Butaca, Disponibilidad_Butaca) VALUES (" .
                $columnaProgramacion['ID_Programacion'] . ", " . $columnaButaca['ID_Butaca'] . ", 0)";

                $conexion->query($consultaUbicarButaca);
            }
            
        }

        
        
        
    ?>
</body>
</html>