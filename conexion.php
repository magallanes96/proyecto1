<?php

try {
    $conn = new PDO("sqlsrv:server = tcp:memo96.database.windows.net,1433; Database = SafePass", "memo96", "Hmcrgl09");
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

   

    // Ejecuta una consulta de prueba
  if (isset($_POST['Nombre'], $_POST['Telefono'], $_POST['Clave'], $_POST['Correo'])) {
        // Recoger datos del formulario
        $nombre = $_POST['Nombre'];
        $telefono = $_POST['Telefono'];
        $clave = $_POST['Clave];
        $correo = $_POST['Correo'];

        // Consulta SQL para insertar los datos
        $sql = "INSERT INTO empleados (nombre, telefono, clave, correo) VALUES (:nombre, :telefono, :clave, :correo)";
        $stmt = $conn->prepare($sql);

        // Ejecutar la consulta con parámetros
        $stmt->execute([
            ':nombre' => $nombre,
            ':telefono' => $telefono,
            ':clave' => $clave,
            ':correo' => $correo,
        ]);

        echo "¡Usuario agregado correctamente!";
    } else {
        echo "Por favor, completa todos los campos del formulario.";
    }
} catch (PDOException $e) {
    echo "Error al conectar o insertar en la base de datos: " . $e->getMessage();
}

// Cerrar la conexión
$conn = null;
?>

