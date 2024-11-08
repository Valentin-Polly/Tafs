<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="estilos/estilos.css">
    <title>Document</title>
</head>
<body>

    <?php

        include "fnc.php";
        // Cantidad de asientos: En total son 249 (15 filas de 8 butacas) por lado (izquierdo y derecho)
        // Entidad en el DER: Asientos
        // Campos: 
        //       Obra: Obra para la que esta preparado el asiento.
        //        Disponibilidad: Muestra si el asiento esta disponible. -->

        // Muestra opciones de las obras que estan programadas y si el usuario desea ver una de ellas, aparecen las butacas, las posiciones de las mismas y la posibilidad de reservarlas en caso de que esten disponibles
        $consulta = "SELECT * FROM Obra";
        $resultado = $conexion->query($consulta);
        
        echo "<form id='formularioOpciones' method=post>";
            echo "<select name='opcion' label='Obras Disponibles'>";
                echo "<optgroup for='Obras Disponibles'>";
                    while($columna = $resultado->fetch_assoc())
                    {
                        echo "<option value=" . $columna['ID_Obra'] . ">" . $columna['Nombre_Obra'] . "</option>";
                    }
                    echo "<input type='submit'>";
                echo "</optgroup>";
                
            echo "</select>";
        echo "</form>";

        $opcion = 1;

        // Toma la opcion seleccionada y dibuja las butacas en la pantalla
        if(isset($_POST["opcion"])) 
        {
            // Si se selecciono una opcion, se muestran todos sus butacas
            $opcion = $_POST["opcion"];
            echo "Seleccionaste la opcion: " . $_POST["opcion"];
        }

        $consultaID_Obra = "SELECT ID_Programacion FROM programacion WHERE ID_Obra = $opcion";
        $resultadoID_Programacion = $conexion->query($consultaID_Obra);
        $ID_Programacion = $resultadoID_Programacion->fetch_assoc()['ID_Programacion'];

        $consulta = "SELECT * FROM ubicarbutaca WHERE ID_Programacion = $ID_Programacion";
        $resultado = $conexion->query($consulta);

        // Lado izquierdo
        echo "<div class='izq-container'>";
            echo "<div class='fila-container'>";
            while($columna = $resultado->fetch_assoc())
            {
                
                $estilo = "style='background-color: green;'";
                if($columna['Disponibilidad_Butaca'] == 1)
                {
                    $estilo = "style='background-color: red;'";
                }

                echo "<form action='' method='POST'>";
                echo "<input type='hidden' name='disponibilidadValue' value=" . $columna['Disponibilidad_Butaca'] . ">";
                echo "<input type='hidden' name='indValue' value=" . $columna['ID_Butaca'] . ">";
                echo "<input type='submit' name='numButaca' " . $estilo . " value=" . $columna['ID_Butaca'] . ">";
                echo "</form>";

                if(($columna['ID_Butaca'] % 8 == 0 && $columna['ID_Butaca'] < 248) or $columna['ID_Butaca'] == 248)
                {
                    echo "</div>";

                    if($columna['ID_Butaca'] == 120)
                    {
                        echo "</div'>";
                        echo "</div class='der-container'>";
                    }

                    echo "<div class='fila-container'>";
                }

            }

            echo "</div>";
        echo "</div>";

        if(isset($_POST["indValue"]))
        {
            // Cambiar el campo de disponibilidad_butaca
            $consulta = "UPDATE ubicarbutaca SET Disponibilidad_Butaca = 1 WHERE ID_Butaca = " . $_POST["indValue"] . " AND ID_Programacion = " . $ID_Programacion;
            $conexion->query($consulta);
            
            
        }

    ?>

    <!-- <a href="llenarTAblas.php">asdadw</a> -->
</body>
</html>