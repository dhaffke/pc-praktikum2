<?php
ob_start();
// ===================== INIT =====================
require_once 'config/config.php';
require_once 'controllers/functions.php';
require_once 'controllers/emailController.php';
require_once 'controllers/authController.php';

// ===================== PASSWORD RESET =====================
if (!empty($_GET['password-token'])) {
    $passwordToken = trim($_GET['password-token']);
    resetPassword($passwordToken);
}

?>
<!DOCTYPE html>
<html lang="de">

<?php include 'includes/header.inc.php'; ?>

<body class="d-flex flex-column min-vh-100">

<div id="logout-warning">
    Automatischer Logout in <span id="countdown">60</span> Sekunden
</div>

<script>
    (function () {

        const logoutTime = 20 * 60 * 1000; // 20 Minuten
        const warningDuration = 60; // letzte 60 Sekunden sichtbar
        const logoutUrl = "<?= $homeLink ?>?logout";

        let inactivityTimer;
        let countdownTimer;
        let remainingSeconds;

        const warningBox = document.getElementById("logout-warning");
        const countdownEl = document.getElementById("countdown");

        function resetTimer() {
            clearTimeout(inactivityTimer);
            clearInterval(countdownTimer);

            warningBox.style.display = "none";

            inactivityTimer = setTimeout(startCountdown, logoutTime - (warningDuration * 1000));
        }

        function startCountdown() {
            remainingSeconds = warningDuration;
            warningBox.style.display = "block";
            countdownEl.textContent = remainingSeconds;

            countdownTimer = setInterval(() => {
                remainingSeconds--;
                countdownEl.textContent = remainingSeconds;

                if (remainingSeconds <= 0) {
                    clearInterval(countdownTimer);
                    logoutUser();
                }
            }, 1000);
        }

        function logoutUser() {
            window.location.href = logoutUrl;
        }

        const events = [
            "load",
            "mousemove",
            "mousedown",
            "touchstart",
            "click",
            "keypress",
            "scroll"
        ];

        events.forEach(event => {
            window.addEventListener(event, resetTimer, true);
        });

    })();
</script>


<!-- ===================== MAIN CONTENT ===================== -->
<main class="flex-fill">

    <?php

    // 2. Pfad aus der URL holen
    $REQUEST_URI = $_SERVER['REQUEST_URI'];
    $PHP_URL_PATH = parse_url($REQUEST_URI, PHP_URL_PATH);

    $adminPage = in_array("admin", explode('/', $PHP_URL_PATH) );

    $get = $_GET ?? [];

    // ===================== ROUTING =====================

    if ($adminPage) {
        if (!empty($_SESSION['id'])) {

            if (isset($get['users'])) {
                include 'pages/admin/users.php';

            } elseif (isset($get['mass_entry_users'])) {
                include 'pages/admin/mass_entry_users.php';

            } elseif (isset($get['study_programs'])) {
                include 'pages/admin/study_programs.php';

            } elseif (isset($get['experiments'])) {
                include 'pages/admin/experiments.php';

            } elseif (isset($get['settings'])) {
                include 'pages/admin/settings.php';

            } else {
                include 'pages/plan.php';
            }

        } else {
            if (isset($get['forgot_password'])) {
                include 'pages/admin/controllers/forgot_password.php';

            } elseif (isset($get['message'])) {
                include 'pages/admin/controllers/message.php';

            } elseif (isset($get['reset_password'])) {
                include 'pages/admin/controllers/reset_password.php';

            } else {
                include 'pages/admin/controllers/login.php';
            }
        }
    }else{
        if (!empty($_SESSION['logged_in'])) {

                include 'pages/plan.php';

            } else {

                include 'pages/login.php';
            }
    }

    ?>

</main>

<!-- Snackbar -->
<div id="snackbar"></div>

<?php include 'includes/footer.inc.php'; ?>

</body>
</html>