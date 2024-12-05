<?php
var_dump($_POST);
// Datos de conexión a la base de datos SQL Server
$serverName = "localhost"; // O la dirección IP del servidor SQL Server
$database = "sistema"; // Nombre de la base de datos
$username = "sa"; // Usuario de la base de datos
$password = "1234"; // Contraseña de la base de datos
try {
    // Conexión
    $conn = new PDO("sqlsrv:server=$serverName;database=$database", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    
    // Obtener los datos enviados desde el formulario

    $user = $_POST['username'];
   $pass = $_POST['password'];

    

    // Consulta para verificar las credenciales
    $stmt = $conn->prepare("SELECT id FROM usuarios WHERE username =:username AND password =:password");
    $stmt->bindParam(':username', $user);
    $stmt->bindParam(':password', $pass);
    $stmt->execute();
    $res=$stmt->fetch(PDO::FETCH_ASSOC);
   /*$res=$conn->query("SELECT id FROM usuarios where username = :username AND password = :password");
    $res->bindParam(':username', $user);
    $res->bindParam(':password', $pass);*/
  

    

    if ($res) {
        echo "Inicio de sesión exitoso.";
        header("Location: consultaa.php");
        exit();
    } else {
        echo "Usuario o contraseña incorrectos.";
      
    }

} catch (PDOException $e) 
{
    echo "Error al conectar con la base de datos: " . $e->getMessage();
}
?>

