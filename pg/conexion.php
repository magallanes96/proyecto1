<?php
class conexion {
    private static $host = 'localhost';
    private static $dbname = 'sistema';
    private static $username = 'sa';
    private static $password = '1234';
    private static $puerto = 1433;

    public static function ConexionBD() {
        try {
            $conn = new PDO(
                "sqlsrv:Server=" . self::$host . "," . self::$puerto . ";Database=" . self::$dbname,
                self::$username,
                self::$password
            );
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $conn;
        } catch (PDOException $exp) {
            die("No se logró conectar correctamente con la base de datos " . self::$dbname . ", error: " . $exp->getMessage());
        }
    }
}
?>
