<?php

$pathSessions =  realpath($_SERVER["DOCUMENT_ROOT"]).'/pc/sessions';
session_save_path("$pathSessions");
session_start();

$timeout = 20 * 60; // 20 Minuten Inaktivität
//$timeout = 10; // 15 Minuten Inaktivität
// ---------------------- AUTO-LOGOUT ----------------------
if (isset($_SESSION['last_activity'])) {
    if (time() - $_SESSION['last_activity'] > $timeout) {
        session_unset();
        session_destroy();
        header('Location: ' . $URL);
        exit;
    }
    // Letzte Aktivität aktualisieren
    $_SESSION['last_activity'] = time();
}




// Helpers//
// Helpers//
function setFlash(string $message, string $class): void
{
    $_SESSION['message'] = $message;
    $_SESSION['alert-class'] = $class;
}

function redirect(string $url): void
{
    header('Location: ' . $url);
    exit;
}

//#####################################################################################################################
//#####################################################################################################################
//#####################################################################################################################
//if admin clicks on the the login button
if (isset($_POST['login-admin-btn'])) {

    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    // ---------------- Validation ----------------
    if ($username === '') {
        $errors['username'] = 'Username is required';
    }

    if ($password === '') {
        $errors['password'] = 'Password is required';
    }

    // ---------------- Login ----------------
    if (empty($errors)) {

        $stmt = $pdo->prepare("
            SELECT id, name, email, password, active
            FROM admins
            WHERE name = :login OR email = :login
            LIMIT 1
        ");
        $stmt->bindValue(':login', $username);
        $stmt->execute();

        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$user || !password_verify($password, $user['password'])) {
            $errors['login_fail'] = 'Wrong username/email or password';
        } else {

            // ---------------- Session ----------------
            $_SESSION['id']       = $user['id'];
            $_SESSION['name'] = $user['name'];
            $_SESSION['email']    = $user['email'];
            $_SESSION['active'] = (bool) $user['active'];
            $_SESSION['logged_in'] = true;
            $_SESSION['last_activity'] = time();

            header('Location: ' . $URL .'admin/');
            exit;
        }
    }
}
//#####################################################################################################################
//#####################################################################################################################
//#####################################################################################################################
//if user clicks on the the login button
if (isset($_POST['login-user-btn'])) {

    $password = $_POST['password'] ?? '';

    if ($password === '') {
        $errors['password'] = 'Password is required';
    }

    // ---------------- Login ----------------
    if (empty($errors)) {

        /* ---------- LOAD ENTRY ---------- */
        $stmt = $pdo->prepare("SELECT password FROM settings LIMIT 1");
        $stmt->execute();
        $entry = $stmt->fetch(PDO::FETCH_ASSOC) ?: [];

        if (!$entry || $password !== $entry['password'] ) {
            $errors['login_fail'] = 'Wrong password';
        } else {

            // ---------------- Session ----------------
            $_SESSION['logged_in'] = true;
            $_SESSION['last_activity'] = time();

            header('Location: ' . $URL );
            exit;
        }
    }
}

//#####################################################################################################################
//#####################################################################################################################
//#####################################################################################################################
// logout user
if (isset($_GET['logout'])) {
    $homeLink = !empty($_SESSION['id'])
        ? $URL . 'admin'
        : $URL;

    // Session vollständig leeren
    $_SESSION = [];

    // Session-Cookie löschen (wichtig!)
    if (ini_get('session.use_cookies')) {
        $params = session_get_cookie_params();
        setcookie(
            session_name(),
            '',
            time() - 42000,
            $params['path'],
            $params['domain'],
            $params['secure'],
            $params['httponly']
        );
    }

    // Session zerstören
    session_destroy();

    header('Location: ' . $homeLink);
    exit;
}


//#####################################################################################################################
//#####################################################################################################################
//#####################################################################################################################
// if admin clicks on the forgot password button
// ===================== Forgot Password =====================
if (isset($_POST['forgot-password-btn'])) {

    $email = trim($_POST['email'] ?? '');

    // ---------- Validation ----------
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = 'Email address is invalid';
    }

    if (!empty($errors)) {
        return;
    }

    // ---------- User lookup ----------
    $stmt = $pdo->prepare(
        "SELECT id, email
         FROM admins
         WHERE email = :email
         LIMIT 1"
    );
    $stmt->bindValue(':email', $email);
    $stmt->execute();

    if (!$stmt->fetch()) {
        // bewusst gleiche Meldung → kein User-Enumeration-Leak
        setFlash(
            'If the email exists, a password reset link has been sent.',
            'alert-success'
        );
        redirect($URL . 'admin/?message');
    }

    // ---------- Send reset link ----------
    if (!sendPasswordResetLink($email)) {
        $errors['email'] = 'Failed to send password reset email. Please try again later.';
        return;
    }

    // ---------- Success ----------
    setFlash(
        'If the email exists, a password reset link has been sent.',
        'alert-success'
    );
    redirect($URL . 'admin/?message');
}

//#####################################################################################################################
//#####################################################################################################################
//#####################################################################################################################
// if admin clicked on the reset password button
if (isset($_POST['reset-password-btn'])) {

    $password     = $_POST['password'] ?? '';
    $passwordConf = $_POST['passwordConf'] ?? '';

    // validation
    if ($password === '') {
        $errors['password'] = 'Password is required';
    } elseif (strlen($password) < 8) {
        $errors['password'] = 'Password must be at least 8 characters long';
    } elseif ($password !== $passwordConf) {
        $errors['password'] = 'Passwords do not match';
    }

    // update password
    if (empty($errors) && !empty($_SESSION['email'])) {

        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        $stmt = $pdo->prepare(
            "UPDATE admins 
             SET password = :password,
                 reset_token = NULL,
                 reset_time = NULL
             WHERE email = :email
             LIMIT 1"
        );

        $stmt->bindValue(':password', $hashedPassword);
        $stmt->bindValue(':email', $_SESSION['email']);

        if ($stmt->execute()) {
            unset($_SESSION['email']);

            $_SESSION['message'] = 'Your password has been reset successfully.';
            $_SESSION['alert-class'] = 'alert-success';

            header("Location: {$URL}admin/");
            exit;
        }
    }
}

// index.php get reset_token
function resetPassword(string $resetToken): void
{
    global $pdo, $URL;

    $stmt = $pdo->prepare(
        "SELECT email, reset_time 
         FROM admins 
         WHERE reset_token = :token 
         LIMIT 1"
    );
    $stmt->bindValue(':token', $resetToken);
    $stmt->execute();

    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$user) {
        $_SESSION['message'] = 'The link is invalid. Please make sure you used the correct URL.';
        $_SESSION['alert-class'] = 'alert-danger';
        header("Location: {$URL}admin/?message");
        exit;
    }

    // Token abgelaufen (24h)
    if (time() > ((int)$user['reset_time'] + 86400)) {
        $_SESSION['message'] =
            'Your link has expired. Please request a new one via 
            <a href="'.$URL.'admin?forgot_password">password recovery</a>.';
        $_SESSION['alert-class'] = 'alert-danger';
        header("Location: {$URL}admin/?message");
        exit;
    }

    // gültiger Token
    $_SESSION['email'] = $user['email'];
    header("Location: {$URL}admin/?reset_password");
    exit;
}