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


        for($i = 2; $i < 256; $i++)
        {
            $InsertButaca = "INSERT INTO `butaca` (`ID_Butaca`) VALUES ($i);";
            $resultadoObra = $conexion->query($InsertButaca);
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