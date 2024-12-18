<?php
header("Content-Type: application/json"); 
try {
    $conn = new PDO("sqlsrv:server = tcp:memo96.database.windows.net,1433; Database = SafePass", "memo96", "Hmcrgl09");
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    echo "Conexión exitosa a Azure SQL Database.<br>";

    // Ejecuta una consulta de prueba
   $sql = "SELECT id, fecha, hora, temperatura, estado, id_empleado FROM tu_tabla";
    $stmt = $conn->query($sql);

    // Obtener resultados como un array
    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Devolver los datos como JSON
    echo json_encode($data);
} catch (Exception $e) {
    // En caso de error, devolver un mensaje JSON
    echo json_encode(["error" => $e->getMessage()]);
}
?>
   

