<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styleCrud.css">
    <link rel="preload" href="styleCrud.css" as="style">
    <title>Agregar Usuarios</title>
    
</head>
<body>
    <header>
    <nav class="navegacion-principal">
        <button><span><a href="inicio.html">Inicio</a></span></button>
        <button><span><a href="agregar.php">Agregar accesos</a></span></button>
        
        <button><span><a href="entradas.php">accesos</a></span></button>
      </nav>
    </header>
    

<?php
try {
    // Crear una instancia de conexión
    $conn = new PDO("sqlsrv:server = tcp:memo96.database.windows.net,1433; Database = SafePass", "memo96", "Hmcrgl09");
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // Consulta SQL
    $sql = "SELECT id_registro, fecha_hora, temperatura, estado FROM registros";
    $stmt = $conn->query($sql);
    //$stmt->execute();

    // Crear tabla HTML
    echo "<table border='1'>
            <tr>
                <th>ID</th>
                <th>Fecha y hora</th>
                <th>Temperatura</th>
                <th>Estado</th>
            </tr>";

    // Mostrar los resultados en la tabla
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        echo "<tr>
                <td>" . htmlspecialchars($row['id_registro']) . "</td>
                <td>" . htmlspecialchars($row['fecha_hora']) . "</td>
                <td>" . htmlspecialchars($row['temperatura']) . "</td>
            
                <td>" . htmlspecialchars($row['estado']) . "</td>
               
              </tr>";
    }
    echo "</table>";

    // Cerrar la conexión
    $conn = null;
} catch (PDOException $exp) {
    echo "Error al consultar la base de datos: " . $exp->getMessage();
}
?>
</div>
</body>

</html>
