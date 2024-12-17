<?php
try {
    $conn = new PDO("sqlsrv:server = tcp:memo96.database.windows.net,1433; Database = SafePass", "memo96", "Hmcrgl09");
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    echo "Conexión exitosa a Azure SQL Database.<br>";

    // Ejecuta una consulta de prueba
   // $query = "SELECT* FROM Empleados"; // Reemplaza 'TuTabla' con una tabla real
   // $stmt = $conn->query($query);

   /* foreach ($stmt as $row) {
        print_r($row); // Muestra los resultados
        echo "<br>";*/
        $user = $_POST['username'];
   $pass = $_POST['password'];
    // Consulta para verificar las credenciales
    $stmt = $conn->prepare("SELECT id FROM usuarios WHERE usuario =:username AND password =:password");
    $stmt->bindParam(':username', $user);
    $stmt->bindParam(':password', $pass);
    $stmt->execute();
    $res=$stmt->fetch(PDO::FETCH_ASSOC);
   /*$res=$conn->query("SELECT id FROM usuarios where username = :username AND password = :password");
    $res->bindParam(':username', $user);
    $res->bindParam(':password', $pass);*/
  
    if ($res) {
        echo "Inicio de sesión exitoso.";
        header("Location: inicio.html");
        exit();
    } else {
        //echo "Usuario o contraseña incorrectos.";
      //echo "<p class='error'>¡Se ha producido un error! Por favor, inténtalo de nuevo.</p>";
      echo "<script>alert('¡Error! Por favor, inténtalo de nuevo.');</script>";
      exit();
    }
   
} catch (PDOException $e) {
    echo "Error de conexión: " . $e->getMessage();
}
?>
