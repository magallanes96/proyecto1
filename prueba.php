<?php
// Configuración de la conexión a la base de datos
$serverName = "tcp:memo96.database.windows.net,1433"; // Cambia esto si es necesario
$connectionOptions = array(
    "Database" => "SafePass", // Cambia esto si es necesario
    "Uid" => "memo96", // Cambia esto si es necesario
    "PWD" => "Hmcrgl09", // Cambia esto si es necesario
    "Encrypt" => true,
    "TrustServerCertificate" => false
);

// Conectar a la base de datos
$conn = sqlsrv_connect($serverName, $connectionOptions);
if (!$conn) {
    // Imprimir detalles del error
    $errors = sqlsrv_errors();
    foreach ($errors as $error) {
        echo "SQLSTATE: " . $error['SQLSTATE'] . "<br />";
        echo "Código de error: " . $error['code'] . "<br />";
        echo "Mensaje: " . $error['message'] . "<br />";
    }
} else {
    echo "Conexión exitosa a la base de datos.";
    // Aquí puedes cerrar la conexión si solo estás probando
    sqlsrv_close($conn);
}
?>
