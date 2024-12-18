<?php

try {
    $conn = new PDO("sqlsrv:server = tcp:memo96.database.windows.net,1433; Database = SafePass", "memo96", "Hmcrgl09");
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

   

    // Ejecuta una consulta de prueba
  if (isset($_POST['Nombre'], $_POST['Edad'], $_POST['Telefono'], $_POST['Correo'])) {
        // Recoger datos del formulario
        $nombre = $_POST['Nombre'];
        $edad = $_POST['Edad'];
        $telefono = $_POST['Telefono'];
        $correo = $_POST['Correo'];

        // Consulta SQL para insertar los datos
        $sql = "INSERT INTO usuarios (nombre, edad, telefono, correo) VALUES (:nombre, :edad, :telefono, :correo)";
        $stmt = $conn->prepare($sql);

        // Ejecutar la consulta con parámetros
        $stmt->execute([
            ':nombre' => $nombre,
            ':edad' => $edad,
            ':telefono' => $telefono,
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

