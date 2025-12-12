<?php
require_once 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

header('Content-Type: application/json');

// Configuration
$uploadDir = __DIR__ . '/uploads/';
$maxFileSize = 10 * 1024 * 1024; // 10 MB

// Créer le dossier uploads s'il n'existe pas
if (!file_exists($uploadDir)) {
    mkdir($uploadDir, 0777, true);
}

// Nettoyer les anciens fichiers (plus de 1 heure)
cleanOldFiles($uploadDir, 3600);

try {
    // Vérifier si des fichiers ont été uploadés
    if (!isset($_FILES['files']) || !is_array($_FILES['files']['name'])) {
        throw new Exception('Aucun fichier reçu');
    }

    $files = $_FILES['files'];
    $convertedFiles = [];
    $errorMessages = [];

    // Traiter chaque fichier
    for ($i = 0; $i < count($files['name']); $i++) {
        // Vérifier les erreurs d'upload
        if ($files['error'][$i] !== UPLOAD_ERR_OK) {
            $errorMessages[] = "Erreur lors de l'upload de {$files['name'][$i]}";
            continue;
        }

        // Vérifier la taille du fichier
        if ($files['size'][$i] > $maxFileSize) {
            $errorMessages[] = "{$files['name'][$i]} est trop volumineux (max 10 MB)";
            continue;
        }

        // Vérifier l'extension
        $fileName = $files['name'][$i];
        $ext = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
        
        if ($ext !== 'xls') {
            $errorMessages[] = "{$fileName} n'est pas un fichier XLS";
            continue;
        }

        try {
            // Charger le fichier XLS
            $inputFile = $files['tmp_name'][$i];
            $spreadsheet = IOFactory::load($inputFile);

            // Générer le nom du fichier de sortie
            $baseName = pathinfo($fileName, PATHINFO_FILENAME);
            $outputFileName = $baseName . '.xlsx';
            $outputFile = $uploadDir . uniqid() . '_' . $outputFileName;

            // Sauvegarder en XLSX
            $writer = new Xlsx($spreadsheet);
            $writer->save($outputFile);

            // Ajouter à la liste des fichiers convertis
            $convertedFiles[] = [
                'name' => $outputFileName,
                'path' => 'uploads/' . basename($outputFile),
                'size' => filesize($outputFile)
            ];

            // Nettoyer la mémoire
            $spreadsheet->disconnectWorksheets();
            unset($spreadsheet);

        } catch (Exception $e) {
            $errorMessages[] = "Erreur de conversion pour {$fileName}: " . $e->getMessage();
        }
    }

    // Préparer la réponse
    if (count($convertedFiles) > 0) {
        echo json_encode([
            'success' => true,
            'converted' => count($convertedFiles),
            'files' => $convertedFiles,
            'errors' => $errorMessages
        ]);
    } else {
        throw new Exception('Aucun fichier n\'a pu être converti. ' . implode(', ', $errorMessages));
    }

} catch (Exception $e) {
    echo json_encode([
        'success' => false,
        'message' => $e->getMessage()
    ]);
}

/**
 * Nettoie les fichiers plus anciens que $maxAge secondes
 */
function cleanOldFiles($dir, $maxAge) {
    if (!is_dir($dir)) {
        return;
    }

    $now = time();
    $files = glob($dir . '*');

    foreach ($files as $file) {
        if (is_file($file)) {
            if ($now - filemtime($file) >= $maxAge) {
                @unlink($file);
            }
        }
    }
}