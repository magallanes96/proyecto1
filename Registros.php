<?php
 //Configuración de la conexión a la base de datos
$serverName = "tcp:memo96.database.windows.net,1433";
$connectionOptions = array(
    "Database" => "SafePass",
   "Uid" => "memo96",
    "PWD" => "Hmcrgl09",
    "Encrypt" => true,
    "TrustServerCertificate" => false
);

// Conectar a la base de datos
$conn = sqlsrv_connect($serverName, $connectionOptions);
if (!$conn) {
    die(json_encode(array("error" => "Error en la conexión a la base de datos.")));
}


// Procesar solicitud POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Leer datos enviados por el ESP32
    $input = json_decode(file_get_contents("php://input"), true);
    //$rfid = $input['rfid'] ?? null;
    $fecha_hora = $input['fecha_hora'] ?? null; 
    $temperatura = $input['temperatura'] ?? null;
    $estado = $input['estado'] ?? null;
    $id_empleado = $input['id_empleado'] ?? null;

    if ($fecha_hora && $temperatura && $estado && $id_empleado) {
        // Consulta para insertar datos en la base
       
        $sql = "INSERT INTO registro (fecha_hora,temperatura,estado,id_empleado) VALUES (?,?,?,? )";
        $params = array($fecha_hora,$temperatura, $estado, $id_empleado);
        $stmt = sqlsrv_query($conn, $sql, $params);

        if ($stmt === false) {
            die(json_encode(array("error" => "Error al insertar datos.")));
        } else {
            echo json_encode(array("mensaje" => "Datos registrados correctamente."));
        }
    } else {
        echo json_encode(array("error" => "Datos incompletos."));
    }
} else {
    echo json_encode(array("error" => "Método no permitido."));
}

// Cerrar conexión
sqlsrv_close($conn);
?>
