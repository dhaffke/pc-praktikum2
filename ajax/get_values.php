<?php

require_once '../config/config.php';
require_once '../controllers/functions.php';
require_once '../controllers/authController.php';

header('Content-Type: application/json');

// Session prüfen
if (empty($_SESSION['id'])) {
    echo json_encode(['success' => false, 'error' => 'Nicht eingeloggt']);
    exit;
}

try {

    $stmt = $pdo->prepare("
        SELECT short_name, repetition
        FROM experiments
        WHERE active = 1
        ORDER BY short_name ASC
    ");
    $stmt->execute();

    $allowedValues = [];
    $maxPerValue   = [];

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $shortName = $row['short_name'];

        $allowedValues[] = $shortName;
        $maxPerValue[$shortName] = (int)$row['repetition'];
    }

    echo json_encode([
        'success'       => true,
        'allowedValues' => $allowedValues,
        'maxPerValue'   => $maxPerValue
    ]);

} catch (PDOException $e) {

    echo json_encode([
        'success' => false,
        'error'   => 'Datenbankfehler'
    ]);
}