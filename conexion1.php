<?php
// PHP Data Objects(PDO) Sample Code:
try {
    $conn = new PDO("sqlsrv:server = tcp:memo96.database.windows.net,1433; Database = SafePass", "memo96", "Hmcrgl09");
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}
catch (PDOException $e) {
    print("Error connecting to SQL Server.");
    die(print_r($e));
}

// SQL Server Extension Sample Code:
$connectionInfo = array("UID" => "memo96", "pwd" => "Hmcrgl09", "Database" => "SafePass", "LoginTimeout" => 30, "Encrypt" => 1, "TrustServerCertificate" => 0);
$serverName = "tcp:memo96.database.windows.net,1433";
$conn = sqlsrv_connect($serverName, $connectionInfo);
?>
