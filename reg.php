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

// Conectar a la base de datos
$conn = sqlsrv_connect($serverName, $connectionOptions);
if (!$conn) {
    die(json_encode(array("error" => "Error en la conexión a la base de datos.", "detalles" => sqlsrv_errors())));
} else {
    echo json_encode(array("mensaje" => "Conexión exitosa a la base de datos."));
}

// Procesar solicitud POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Leer datos enviados por el ESP32
    $input = json_decode(file_get_contents("php://input"), true);
    $clave = $input['clave'] ?? null;
    $temperatura = $input['temperatura'] ?? null;
    $estado = $input['estado'] ?? null;

    if ($clave) {
        // Verificar si la clave RFID existe en la base de datos
        $sqlCheckRFID = "SELECT id_empleado FROM empleados WHERE clave = ?";
        $paramsCheckRFID = array($clave);
        $stmtCheckRFID = sqlsrv_query($conn, $sqlCheckRFID, $paramsCheckRFID);
        echo json_encode(array("id_empleado" => $id_empleado));
        if ($stmtCheckRFID === false) {
            $errors = sqlsrv_errors();
            die(json_encode(array("error" => "Error en la consulta RFID.", "detalles" => $errors)));
        }

        if (sqlsrv_has_rows($stmtCheckRFID) === false) {
            die(json_encode(array("error" => "Tarjeta RFID no registrada.")));
        }

        // Recuperar el id_empleado
        $row = sqlsrv_fetch_array($stmtCheckRFID, SQLSRV_FETCH_ASSOC);
        $id_empleado = $row['id_empleado'];

        // Verificar datos antes de la inserción
        if ($temperatura && $estado && $id_empleado) {
            // Insertar datos en la tabla registro
            $sqlInsert = "INSERT INTO registro (fecha_hora, temperatura, estado, id_empleado) VALUES (GETDATE(), ?, ?, ?)";
            $paramsInsert = array($temperatura, $estado, $id_empleado);
            $stmtInsert = sqlsrv_query($conn, $sqlInsert, $paramsInsert);

            if ($stmtInsert === false) {
                $errors = sqlsrv_errors();
                die(json_encode(array("error" => "Error al insertar datos.", "detalles" => $errors)));
            } else {
                // Responder con el id_empleado y un mensaje de éxito
                echo json_encode(array(
                    "mensaje" => "Datos registrados correctamente.",
                    "id_empleado" => $id_empleado
                ));
            }
        }else{
                echo json_encode(array("mensaje" => "Datos registrados correctamente."));
            }
        } else {
            echo json_encode(array("error" => "Datos incompletos para el registro de temperatura."));
        }
    } else {
        echo json_encode(array("error" => "Clave RFID no proporcionada."));
    }
} else {
    echo json_encode(array("error" => "Método no permitido."));
}

// Cerrar conexión
sqlsrv_close($conn);
?>
