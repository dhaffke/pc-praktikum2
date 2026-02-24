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

$data = json_decode(file_get_contents("php://input"), true);

$programId = $data['program_id'];
$date   = $data['date'];
$action = $data['action'];

if ($action === 'add') {
    $stmt = $pdo->prepare("INSERT IGNORE INTO calendar_holidays_programs (program_id, date) VALUES (:program_id, :date)");
    $stmt->execute([
        'program_id' => $programId,
        'date' => $date
    ]);
}

if ($action === 'remove') {
    $stmt = $pdo->prepare("DELETE FROM calendar_holidays_programs WHERE program_id = :program_id AND date = :date");
    $stmt->execute([
        'program_id' => $programId,
        'date' => $date
    ]);
}

echo json_encode(['success' => true]);