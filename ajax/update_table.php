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

// =============================
// Hilfsfunktionen
// =============================

function post($key, $default = "")
{
    return isset($_POST[$key]) ? trim(strip_tags($_POST[$key])) : $default;
}

function jsonResponse($success, $error = null)
{
    echo json_encode([
        'success' => $success,
        'error'   => $error
    ]);
    exit;
}

function executeUpdate($pdo, $sql, $params)
{
    $stmt = $pdo->prepare($sql);

    foreach ($params as $key => $value) {
        $stmt->bindValue($key, $value);
    }

    if ($stmt->execute()) {
        jsonResponse(true);
    } else {
        jsonResponse(false, $stmt->errorInfo());
    }
}

// =============================
// Session prüfen
// =============================

if (empty($_SESSION['id'])) {
    jsonResponse(false, 'Nicht eingeloggt');
}

$request = post("request");

// =============================
// Router
// =============================

switch ($request) {

    // =========================================================
    case "study_programs":

        executeUpdate($pdo,
            "UPDATE study_programs 
             SET name = :name, active = :active, attempt_count = :attempt_count
             WHERE id = :id LIMIT 1",
            [
                ':name'   => post("name"),
                ':attempt_count' => (int)($_POST["attempt_count"] ?? 0),
                ':active' => (int)($_POST["active"] ?? 0),
                ':id'     => (int)post("entryID")
            ]
        );

        break;


    // =========================================================
    case "users":

        executeUpdate($pdo,
            "UPDATE users 
             SET name = :name,
                 active = :active,
                 study_program_id = :study_program_id
             WHERE id = :id LIMIT 1",
            [
                ':name'             => post("name"),
                ':active'           => (int)($_POST["active"] ?? 0),
                ':study_program_id' => (int)post("study_program_id"),
                ':id'               => (int)post("entryID")
            ]
        );

        break;


    // =========================================================
    case "experiments":

        executeUpdate($pdo,
            "UPDATE experiments 
             SET name = :name,
                 short_name = :short_name,
                 repetition = :repetition,
                 active = :active
             WHERE id = :id LIMIT 1",
            [
                ':name'       => post("name"),
                ':short_name' => post("short_name"),
                ':repetition' => (int)($_POST["repetition"] ?? 0),
                ':active'     => (int)($_POST["active"] ?? 0),
                ':id'         => (int)post("entryID")
            ]
        );

        break;


    // =========================================================
    case "settings":

        executeUpdate($pdo,
            "UPDATE settings 
             SET days        = :days,
                 start       = :start,
                 end         = :end,
                 free_start  = :free_start,
                 free_end    = :free_end,
                 free_active = :active,
                 password    = :password
             LIMIT 1",
            [
                ':days'       => post('days'),
                ':start'      => post('start'),
                ':end'        => post('end'),
                ':free_start' => $_POST['free_start'] ?? '0000-00-00',
                ':free_end'   => $_POST['free_end'] ?? '0000-00-00',
                ':active'     => (int)($_POST['active'] ?? 0),
                ':password'   => $_POST['password'] ?? ''
            ]
        );

        break;


    // =========================================================
    default:
        jsonResponse(false, "Ungültiger Request");
}