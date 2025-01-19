<?php
// Configuración de la conexión a la base de datos
$serverName = "tcp:memo96.database.windows.net,1433";
$connectionOptions = array(
    "Database" => "SafePass",
    "Uid" => "memo96",
    "PWD" => "Hmcrgl09",
    "Encrypt" => true,
    "TrustServerCertificate" => false
);
// Crear la conexión
$conn = sqlsrv_connect($serverName, $connectionOptions);

if (!$conn) {
    die("Conexión fallida: " . print_r(sqlsrv_errors(), true));
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Leer datos enviados por el ESP32
    $input = json_decode(file_get_contents("php://input"), true);
    //$rfid = $input['rfid'] ?? null;
    $temperatura = $input['temperatura'] ?? null; 
    $estado= $input['estado'] ?? null;
    $clave = $input['clave'] ?? null;
   // $id_empleado = $input['id_empleado'] ?? null;
    

    // Verificar si la clave RFID existe en la base de datos
    $sqlCheckRFID = "SELECT id_empleado FROM empleados WHERE clave = ?";
    $paramsCheckRFID = array($clave);
    $stmtCheckRFID = sqlsrv_query($conn, $sqlCheckRFID, $paramsCheckRFID);

    if ($stmtCheckRFID === false) {
        echo json_encode(array("error" => "Error en la consulta RFID.", "detalles" => sqlsrv_errors()));
        exit;
    }

    if (!sqlsrv_has_rows($stmtCheckRFID)) {
        echo json_encode(array("error" => "Tarjeta RFID no registrada."));
        exit;
    }

    // Recuperar el id_empleado
    $row = sqlsrv_fetch_array($stmtCheckRFID, SQLSRV_FETCH_ASSOC);
    $id_empleado = $row['id_empleado'];

    if (!$temperatura || !$estado) {
        echo json_encode(array("error" => "Datos incompletos para el registro de temperatura."));
        exit;
    }

    // Insertar datos en la tabla registro
    $sqlInsert = "INSERT INTO registro (fecha_hora, temperatura, estado, id_empleado) VALUES (GETDATE(), ?, ?, ?)";
    $paramsInsert = array($temperatura, $estado, $id_empleado);
    $stmtInsert = sqlsrv_query($conn, $sqlInsert, $paramsInsert);

    if ($stmtInsert === false) {
        echo json_encode(array("error" => "Error al insertar datos.", "detalles" => sqlsrv_errors()));
        exit;
    }

    // Responder con éxito
    echo json_encode(array(
        "mensaje" => "Datos registrados correctamente.",
        "id_empleado" => $id_empleado
    ));

} else {
    echo json_encode(array("error" => "Método no permitido."));
}

// Cerrar conexión
sqlsrv_close($conn);
?>
