<?php

require_once '../config/config.php';
require_once '../controllers/functions.php';
require_once '../controllers/authController.php';


// Session prüfen
if (empty($_SESSION['id'])) {
    echo json_encode(['success' => false, 'error' => 'Nicht eingeloggt']);
    exit;
}



// ajax/save_batch.php
$input = json_decode(file_get_contents('php://input'), true);

if (isset($input['updates']) && is_array($input['updates'])) {

    $stmt = $pdo->prepare("
                SELECT short_name, id 
                FROM experiments 
            ");
    $stmt->execute();
    // First column becomes the key, second column becomes the value
    $experimentIDs = $stmt->fetchAll(PDO::FETCH_KEY_PAIR);

    foreach ($input['updates'] as $update) {
        $userID = $update['userID'];
        $date   = $update['date'];
        $value  = $update['value'];

        // Insert / Update
        $stmt = $pdo->prepare("
                    INSERT INTO calendar (user_id, date, experiments_id)
                    VALUES (:user_id, :date, :experiments_id)
                    ON DUPLICATE KEY UPDATE experiments_id = VALUES(experiments_id)
                ");

        $success = $stmt->execute([
            ':user_id'        => $userID,
            ':date'           => $date,
            ':experiments_id' => $experimentIDs[$value]
        ]);
    }
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'error' => 'No data']);
}










