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
       
        <button><span><a href="entradas.php">acceso</a></span></button>
      </nav>
    </header>
    <div class="form-container">
        <h3>Agregar Nuevos Usuarios</h3>
        <h2>Llena todos los campos</h2>
        <form class="form" action="conexion.php" method="POST">
            <div class="input-group">
                <label for="Nombre">Nombre completo</label>
                <input type="text" name="Nombre" id="Nombre" placeholder="">
            </div>
            <div class="input-group">
                <label for="Telefono">Telefono</label>
                <input type="text" name="Telefono" id="Telefono" placeholder="">
            </div> 
            <div class="input-group">
                <label for="Clave">N. Tarjeta</label>
                <input type="text" name="Clave" id="Clave" placeholder="">
            </div>
            <div class="input-group">
                <label for="Correo">Correo</label>
                <input type="text" name="Correo" id="Correo" placeholder="">
            </div>
            <button type="submit">Agregar </button>


            </div>
            </form>
            </div>
            
            <div>
                
<?php



try {
    // Crear una instancia de conexión
    $conn = new PDO("sqlsrv:server = tcp:memo96.database.windows.net,1433; Database = SafePass", "memo96", "Hmcrgl09");
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // Consulta SQL
    $sql = "SELECT id_empleado, nombre, telefono, clave, correo FROM empleados";
    $stmt = $conn->query($sql);
    //$stmt->execute();

    // Crear tabla HTML
    echo "<table border='1'>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Telefono</th>
                <th>CLave</th>
                <th>Correo</th>
            </tr>";

    // Mostrar los resultados en la tabla
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        echo "<tr>
                <td>" . htmlspecialchars($row['id_empleado']) . "</td>
                <td>" . htmlspecialchars($row['nombre']) . "</td>
                <td>" . htmlspecialchars($row['telefono']) . "</td>
                <td>" . htmlspecialchars($row['clave']) . "</td>
                <td>" . htmlspecialchars($row['correo']) . "</td>
               
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
