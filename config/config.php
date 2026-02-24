<?php
/**
 * A complete login script with registration and members area.
 *
 * @author: Nils Reimers / http://www.php-einfach.de/experte/php-codebeispiele/loginscript/
 * @license: GNU GPLv3
 */
 
//Tragt hier eure Verbindungsdaten zur Datenbank ein
$db_host = 'localhost';

$environment = ($_SERVER['HTTP_HOST'] === 'localhost') ? 'local' : 'cserver';

$config = [
    'local' => [
        'db_name'     => 'pc',
        'db_user'     => 'pc-praktikum',
        'db_password' => '-psE-SalN[K4n21o',
        'url'         => 'http://localhost/pc/'
    ],
    'cserver' => [
        'db_name'     => 'pc-praktikum',
        'db_user'     => 'pc-praktikum',
        'db_password' => 'So32Z(BbPzJ-2o3]',
        'url'         => 'https://cstorage.synology.me/pc/'
    ]
];

if (!isset($config[$environment])) {
    die('Invalid environment configuration');
}

$db_name     = $config[$environment]['db_name'];
$db_user     = $config[$environment]['db_user'];
$db_password = $config[$environment]['db_password'];
$URL         = $config[$environment]['url'];


/* ===========================
 * PDO (empfohlen)
 * =========================== */
//$pdo = new PDO("mysql:host=$db_host;dbname=$db_name", $db_user, $db_password);
try {
    $pdo = new PDO(
        "mysql:host={$db_host};dbname={$db_name};charset=utf8mb4",
        $db_user,
        $db_password
    );
} catch (PDOException $e) {
    die('Database connection failed (PDO)');
}