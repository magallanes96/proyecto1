<?php
// Datos de conexión a la base de datos SQL Server
$serverName = "localhost"; // O la dirección IP del servidor SQL Server
$database = "sistema"; // Nombre de la base de datos
$username = "sa"; // Usuario de la base de datos
$password = "1234"; // Contraseña de la base de datos

try {
    // Conexión utilizando PDO con SQL Server
    $conn = new PDO("sqlsrv:server=$serverName;database=$database", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Verificar si los datos fueron enviados desde el formulario
    if (isset($_POST['username']) && isset($_POST['password'])) {
        // Obtener los datos del formulario
        $user = trim(htmlspecialchars($_POST['username']));
        $pass = trim(htmlspecialchars($_POST['password']));

        // Encriptar la contraseña (opcional, para mayor seguridad)
        $hashedPass = password_hash($pass, PASSWORD_DEFAULT); // Para cifrar la contraseña

        // Consulta SQL para insertar los datos en la base de datos
        $stmt = $conn->prepare("INSERT INTO usuarios (username, password) VALUES (:username, :password)");

        // Vincular los parámetros de la consulta
        $stmt->bindParam(':username', $user);
        $stmt->bindParam(':password', $hashedPass); // Insertamos la contraseña cifrada
        $stmt->execute();
        // Ejecutar la consulta
        if ($stmt->execute()) {
            echo "Usuario registrado exitosamente.";
        } else {
            echo "Hubo un error al registrar el usuario.";
        }
    }
} catch (PDOException $e) {
    echo "Error al conectar con la base de datos: " . $e->getMessage();
}
?>
