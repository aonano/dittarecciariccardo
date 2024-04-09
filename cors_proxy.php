<?php
// Imposta gli header CORS per consentire le chiamate da qualsiasi dominio
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

// Verifica il metodo della richiesta
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    // Risponde con successo alle richieste di pre-flight (OPTIONS)
    http_response_code(200);
    exit();
}

// Verifica se è stata fornita una cartella di immagini nella query string
if (isset($_GET['image_folder'])) {
    // Ottieni la cartella delle immagini dalla query string
    $imageFolder = $_GET['image_folder'];

    // Costruisci il percorso completo della cartella delle immagini
    $imageFolderPath = __DIR__ . '/' . $imageFolder;

    // Verifica se la cartella delle immagini esiste e può essere letta
    if (is_dir($imageFolderPath)) {
        // Crea un array per memorizzare gli URL delle immagini
        $imageUrls = array();

        // Scansiona la cartella delle immagini per ottenere i nomi dei file
        $files = scandir($imageFolderPath);
        foreach ($files as $file) {
            // Ignora le voci corrispondenti ai file nascosti (inizia con '.')
            if ($file[0] !== '.') {
                // Costruisci l'URL relativo dell'immagine
                $imageUrl = $imageFolder . '/' . $file;
                // Aggiungi l'URL dell'immagine all'array
                $imageUrls[] = $imageUrl;
            }
        }

        // Invia l'array degli URL delle immagini come risposta
        echo json_encode($imageUrls);
        exit();
    }
}

// Se si arriva qui, restituisci un errore 400 (Bad Request)
http_response_code(400);
echo "Errore: Cartella immagini non valida.";
?>
