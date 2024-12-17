<?php
try {
    $conn = new PDO("sqlsrv:server = tcp:memo96.database.windows.net,1433; Database = SafePass", "memo96", "Hmcrgl09");
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    echo "Conexión exitosa a Azure SQL Database.<br>";

    // Ejecuta una consulta de prueba
    $query = "SELECT* FROM Empleados"; // Reemplaza 'TuTabla' con una tabla real
    $stmt = $conn->query($query);

    foreach ($stmt as $row) {
        print_r($row); // Muestra los resultados
        echo "<br>";
    }
} catch (PDOException $e) {
    echo "Error de conexión: " . $e->getMessage();
}
?>
