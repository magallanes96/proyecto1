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
        <button><span><a href="services.html">eliminar accesos</a></span></button>
        <button><span><a href="contact.html">Dar acceso</a></span></button>
      </nav>
    </header>
    <div class="form-container">
        <h3>Agregara Nuevos Usuarios</h3>
        <h2>Llena todos los campos</h2>
        <form class="form" action="conexion1.php" method="POST">
            <div class="input-group">
                <label for="Nombre">Nombre completo</label>
                <input type="text" name="Nombre" id="Nombre" placeholder="">
            </div>
            <div class="input-group">
                <label for="Edad">Edad</label>
                <input type="text" name="Edad" id="Edad" placeholder="">
            </div>
            <div class="input-group">
                <label for="Telefono">Telefono</label>
                <input type="text" name="Telefono" id="Telefono" placeholder="">
            </div>
            <div class="input-group">
                <label for="Correo">N.Tarjeta</label>
                <input type="text" name="Correo" id="Correo" placeholder="">
            </div>
            <button>Agregar </button>


            </div>
            </form>
            </div>
            
            <div>
                
<?php

include_once 'conexion.php';

try {
    // Crear una instancia de conexión
    $conexion = conexion::ConexionBD();

    // Consulta SQL
    $sql = "SELECT id, username, password FROM usuarios";
    $stmt = $conexion->prepare($sql);
    $stmt->execute();

    // Crear tabla HTML
    echo "<table border='1'>
            <tr>
                <th>ID</th>
                <th>username</th>
                <th>password</th>
               // <th>Teléfono</th>
            </tr>";

    // Mostrar los resultados en la tabla
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        echo "<tr>
                <td>" . htmlspecialchars($row['id']) . "</td>
                <td>" . htmlspecialchars($row['username']) . "</td>
                <td>" . htmlspecialchars($row['password']) . "</td>
               
              </tr>";
    }
    echo "</table>";

    // Cerrar la conexión
    $conexion = null;
} catch (PDOException $exp) {
    echo "Error al consultar la base de datos: " . $exp->getMessage();
}
?>
</div>
</body>

</html>
