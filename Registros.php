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
} else {
    // Si deseas ver un mensaje de éxito al conectarte
    echo json_encode(array("mensaje" => "Conexión exitosa a la base de datos."));
}



// Procesar solicitud POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Leer datos enviados por el ESP32
    $input = json_decode(file_get_contents("php://input"), true);
    $rfid = $input['rfid'] ?? null;
   // $fecha_hora = $input['fecha_hora'] ?? null; 
    $temperatura = $input['temperatura'] ?? null;
    $estado = $input['estado'] ?? null;
    $id_empleado = $input['id_empleado'] ?? null;
   var_dump($input);


 if ($rfid) {
        // Verificar si la clave RFID existe en la base de datos
        $sqlCheckRFID = "SELECT id_empleado FROM empleados WHERE rfid = ?";
        $paramsCheckRFID = array($rfid);
        $stmtCheckRFID = sqlsrv_query($conn, $sqlCheckRFID, $paramsCheckRFID);

        if ($stmtCheckRFID === false || sqlsrv_has_rows($stmtCheckRFID) === false) {
            die(json_encode(array("error" => "Tarjeta RFID no registrada.")));
        }

        // Recuperar el id_empleado
        $row = sqlsrv_fetch_array($stmtCheckRFID, SQLSRV_FETCH_ASSOC);
        $id_empleado = $row['id_empleado'];
 }

  
    if ($temperatura && $estado && $id_empleado) {
        // Consulta para insertar datos en la base
   
        $sql = "INSERT INTO registro (fecha_hora,temperatura,estado,id_empleado) VALUES (GATEDATE(),?,?,? )";
        $params = array($temperatura, $estado, $id_empleado);
        $stmt = sqlsrv_query($conn, $sql, $params);

        if ($stmtInsert === false) {
                $errors = sqlsrv_errors();
                die(json_encode(array("error" => "Error al insertar datos.", "detalles" => $errors)));
            } else {
                echo json_encode(array("mensaje" => "Datos registrados correctamente."));
            }
        } else {
            echo json_encode(array("error" => "Datos incompletos para el registro de temperatura."));
        }
    } else {
        echo json_encode(array("error" => "Clave RFID no proporcionada."));
    } else {
    echo json_encode(array("error" => "Método no permitido."));
}



// Cerrar conexión
sqlsrv_close($conn);
?>
