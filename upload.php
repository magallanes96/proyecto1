<?php
require 'vendor/autoload.php';
use MicrosoftAzure\Storage\Blob\BlobRestProxy;

$connectionString = "DefaultEndpointsProtocol=https;AccountName=TU_CUENTA;AccountKey=TU_LLAVE;EndpointSuffix=core.windows.net";
$blobClient = BlobRestProxy::createBlobService($connectionString);

$containerName = "imagenes";

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['imagen'])) {
    $imagen = $_FILES['imagen']['tmp_name'];
    $nombre = $_FILES['imagen']['name'];
    $contenido = fopen($imagen, "r");

    try {
        $blobClient->createBlockBlob($containerName, $nombre, $contenido);
        echo json_encode(["status" => "ok", "url" => "https://TU_CUENTA.blob.core.windows.net/$containerName/$nombre"]);
    } catch (Exception $e) {
        echo json_encode(["status" => "error", "mensaje" => $e->getMessage()]);
    }
} else {
    echo json_encode(["status" => "error", "mensaje" => "No se recibió archivo"]);
}
