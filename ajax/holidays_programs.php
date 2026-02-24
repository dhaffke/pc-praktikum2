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

$programId  = $_POST['programId']  ?? null;
$request = $_POST['request'] ?? null;

if (empty($programID) || empty($request)) {
    echo json_encode(['success' => false, 'error' => 'Ungueltige Parameter']);
    exit;
}

try {

    switch ($request) {

        case 'getDates':

            $stmt = $pdo->prepare("
            SELECT date 
            FROM holidays_program_dates
            WHERE program_id = ?
            ORDER BY date ASC
        ");

            $stmt->execute([$programId]);

            $dates = [];

            while ($row = $stmt->fetch()) {
                $dates[] = $row['date']; // Format: YYYY-MM-DD
            }

            echo json_encode([
                'success' => true,
                'dates' => $dates
            ]);
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