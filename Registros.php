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
    //$rfid = $input['rfid'] ?? null;
    $fecha_hora = $input['fecha_hora'] ?? null; 
    $temperatura = $input['temperatura'] ?? null;
    $estado = $input['estado'] ?? null;
    $id_empleado = $input['id_empleado'] ?? null;
   var_dump($input);
    if ($fecha_hora && $temperatura && $estado && $id_empleado) {
        // Consulta para insertar datos en la base
       
        $sql = "INSERT INTO registro (fecha_hora,temperatura,estado,id_empleado) VALUES (?,?,?,? )";
        $params = array($fecha_hora,$temperatura, $estado, $id_empleado);
        $stmt = sqlsrv_query($conn, $sql, $params);

        if ($stmt === false) {
            die(json_encode(array("error" => "Error al insertar datos.")));
          echo json_encode(array($params));
        } else {
            echo json_encode(array("mensaje" => "Datos registrados correctamente."));
        }
    } else {
        echo json_encode(array("error" => "Datos incompletos."));
      print_r($params);
    }
} else {
    echo json_encode(array("error" => "Método no permitido."));
  echo json_encode(array($params));
}

if ($stmt === false) {
    $errors = sqlsrv_errors();
    $errorMsg = "";
    foreach ($errors as $error) {
        $errorMsg .= "SQLSTATE: " . $error['SQLSTATE'] . " - " . $error['message'] . "<br />";
    }
    die(json_encode(array("error" => "Error al insertar datos: " . $errorMsg)));
}

// Cerrar conexión
sqlsrv_close($conn);
?>
