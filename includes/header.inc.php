<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>PC</title>


    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <!-- CSS -->
    <link href="<?= $URL ?>lib/mystyle.css" rel="stylesheet">


    <link href="https://cdn.jsdelivr.net/npm/tom-select@2.5.1/dist/css/tom-select.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/tom-select@2.5.1/dist/js/tom-select.complete.min.js"></script>

    <!-- JS -->
    <script src="https://code.jquery.com/jquery-4.0.0.js" integrity="sha256-9fsHeVnKBvqh3FB2HYu7g2xseAZ5MlN6Kz/qnkASV8U=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="<?= $URL ?>lib/functions.js"></script>

    <link rel="apple-touch-icon" sizes="180x180" href="favicon/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="favicon/favicon-16x16.png">
    <link rel="manifest" href="favicon/site.webmanifest">
</head>

<?php if (!empty($_SESSION['logged_in'])): ?>

    <?php

    $uriPath = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    $segments = explode('/', trim($uriPath, '/'));
    $admin = in_array('admin', $segments, true); // $admin wird auch in plan.php benötigt

    $homeLink = $admin
            ? $URL . 'admin/'
            : $URL;

// Aktive Seite ermitteln
    $currentPage = array_key_first($_GET) ?? 'plan';

    $navItems = [
            'users'            => ['label' => 'Users',              'link' => $URL . 'admin/?users'],
            'mass_entry_users' => ['label' => 'Mass Entry Users',   'link' => $URL . 'admin/?mass_entry_users'],
            'study_programs'   => ['label' => 'Programs',           'link' => $URL . 'admin/?study_programs'],
            'experiments'      => ['label' => 'Experiments',        'link' => $URL . 'admin/?experiments'],
            'settings'         => ['label' => 'Settings',           'link' => $URL . 'admin/?settings'],
    ];
    ?>

    <nav class="navbar navbar-expand-lg bg-white border-bottom shadow-sm py-2">
        <div class="container-fluid position-relative align-items-center">

            <!-- Logo / Home -->
            <a class="navbar-brand fw-semibold <?= $currentPage === 'plan' ? 'text-dark' : 'text-muted' ?>"
               href="<?= $homeLink ?>">
                Plan
            </a>

            <?php if ($admin): ?>

                <!-- Mittige Navigation -->
                <div class="position-absolute top-50 start-50 translate-middle">
                    <ul class="nav gap-4">

                        <?php foreach ($navItems as $key => $item): ?>
                            <?php
                            $active = $currentPage === $key;
                            ?>
                            <li class="nav-item">
                                <a href="<?= $item['link'] ?>"
                                   class="nav-link px-2 <?= $active
                                           ? 'fw-semibold text-dark border-bottom border-2 border-dark'
                                           : 'text-muted' ?>">
                                    <?= $item['label'] ?>
                                </a>
                            </li>
                        <?php endforeach; ?>

                    </ul>
                </div>

            <?php endif; ?>

            <!-- Logout rechts -->
            <div class="ms-auto">
                <form action="<?= $homeLink ?>?logout" method="post" class="m-0">
                    <button type="submit"
                            class="btn btn-sm btn-outline-dark rounded-pill px-3">
                        Logout
                    </button>
                </form>
            </div>

        </div>
    </nav>

<?php endif; ?>


