<?php
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_FILES['file']) && $_FILES['file']['error'] == 0) {
        $uploadDir = 'uploads/';
        $uploadFile = $uploadDir . basename($_FILES['file']['name']);

        if (!file_exists($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        if (move_uploaded_file($_FILES['file']['tmp_name'], $uploadFile)) {
            echo json_encode(['status' => 'success', 'filePath' => '/' . $uploadFile]);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Erreur lors du téléchargement']);
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Aucun fichier reçu ou une erreur s’est produite']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Méthode non autorisée']);
}
?>