<style>
    body {
        background-image: url('bbblurry.svg');
        background-size: cover; /* Hace que la imagen ocupe todo el fondo */
    background-position: center;
        font-family: Arial, sans-serif;
        background-color: rgba(144, 156, 244, 0.411);
        padding: 20px;
        display: flex;
        justify-content: center;
        align-items: center;
        min-height: 100vh;
    }
    
    table {
        width: 80%;
        border-collapse: collapse;
        margin: 20px auto;
        background-color: #fff;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        border-radius: 8px;
        overflow: hidden;
    }

    th, td {
        padding: 15px;
        text-align: left;
        border-bottom: 1px solid #ddd;
    }

    th {
        background-color: #4CAF50;
        color: white;
        text-transform: uppercase;
        font-size: 14px;
    }

    tr:nth-child(even) {
        background-color: #f9f9f9;
    }

    tr:hover {
        background-color: #f1f1f1;
    }

    td {
        font-size: 14px;
        color: #333;
    }
</style>

<?php
// Incluir la clase de conexión
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
