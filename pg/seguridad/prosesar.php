<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre = $_POST['nombre'];
    $usuario = $_POST['usuario'];
    $password = $_POST['password'];

    try {
        // Conexión a la base de datos
        $dsn = 'mysql:host=localhost;dbname=Empleados;charset=utf8';
        $username = 'tu_usuario_mysql'; // Cambiar por el usuario de tu base de datos
        $password_db = 'tu_contraseña_mysql'; // Cambiar por la contraseña de tu base de datos

        $pdo = new PDO($dsn, $username, $password_db);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Hash de la contraseña
        $password_hash = password_hash($password, PASSWORD_BCRYPT);

        // Inserción segura usando prepared statements
        $sql = "INSERT INTO Accesos (Nombre, Usuario, Password) VALUES (:nombre, :usuario, :password)";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':nombre', $nombre);
        $stmt->bindParam(':usuario', $usuario);
        $stmt->bindParam(':password', $password_hash);
        $stmt->execute();

        echo "Registro exitoso.";
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>
