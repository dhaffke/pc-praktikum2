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


$program_id  = $_GET['program_id'];

$stmt = $pdo->prepare("SELECT date FROM calendar_holidays_programs WHERE program_id  = :program_id");
$stmt->execute(['program_id' => $program_id]);

$dates = $stmt->fetchAll(PDO::FETCH_COLUMN);

echo json_encode(['dates' => $dates]);