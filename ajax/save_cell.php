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

$userID  = $_POST['userID']  ?? null;
$date    = $_POST['date']    ?? null;
$value   = $_POST['value']   ?? null;
$request = $_POST['request'] ?? null;

if (empty($userID) || empty($date) || empty($request)) {
    echo json_encode(['success' => false, 'error' => 'Ungueltige Parameter']);
    exit;
}

try {

    switch ($request) {

        /* =========================
           CALENDAR (Experiments)
        ==========================*/
        case 'calendar':

            // Experiment-ID holen
            $stmt = $pdo->prepare("
                SELECT id 
                FROM experiments 
                WHERE short_name = :short_name 
                LIMIT 1
            ");
            $stmt->execute([':short_name' => $value]);
            $experimentID = $stmt->fetchColumn();

            if ($experimentID) {

                // Insert / Update
                $stmt = $pdo->prepare("
                    INSERT INTO calendar (user_id, date, experiments_id)
                    VALUES (:user_id, :date, :experiments_id)
                    ON DUPLICATE KEY UPDATE experiments_id = VALUES(experiments_id)
                ");

                $success = $stmt->execute([
                    ':user_id'        => $userID,
                    ':date'           => $date,
                    ':experiments_id' => $experimentID
                ]);

            } else {

                // Löschen wenn kein gültiges Experiment
                $stmt = $pdo->prepare("
                    DELETE FROM calendar 
                    WHERE user_id = :user_id 
                    AND date = :date 
                    LIMIT 1
                ");

                $success = $stmt->execute([
                    ':user_id' => $userID,
                    ':date'    => $date
                ]);
            }

            echo json_encode(['success' => $success]);
            break;


        /* =========================
           CALENDAR HOLIDAYS
        ==========================*/
        case 'calendar_holidays':

            $holiday = ($value === "true" || $value == 1) ? 1 : 0;

            // Wenn Feiertag gesetzt wird → normalen Kalendereintrag löschen
            if ($holiday === 1) {
                $stmt = $pdo->prepare("
                    DELETE FROM calendar 
                    WHERE user_id = :user_id 
                    AND date = :date 
                    LIMIT 1
                ");
                $stmt->execute([
                    ':user_id' => $userID,
                    ':date'    => $date
                ]);
            }

            // Insert / Update Holiday
            $stmt = $pdo->prepare("
                INSERT INTO calendar_holidays (user_id, date, holiday)
                VALUES (:user_id, :date, :holiday)
                ON DUPLICATE KEY UPDATE holiday = VALUES(holiday)
            ");

            $success = $stmt->execute([
                ':user_id' => $userID,
                ':date'    => $date,
                ':holiday' => $holiday
            ]);

            echo json_encode(['success' => $success]);
            break;


        default:
        echo json_encode(['success' => false, 'error' => 'Ungültiger Request']);
    }

} catch (PDOException $e) {
    echo json_encode([
        'success' => false,
        'error'   => 'Datenbankfehler'
    ]);
}