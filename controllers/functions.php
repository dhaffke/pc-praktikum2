<?php

/**
 * Ermittle Feiertage, Arbeitstage und Wochenenden von einem Datum
 *
 * @param $datum als String im Format Y-m-d oder als Timestamp
 * @param string $bundesland<br>
 * 	BW = Baden-Württemberg<br>
 * 	BY = Bayern<br>
 * 	BE = Berlin<br>
 * 	BB = Brandenburg<br>
 * 	HB = Bremen<br>
 * 	HH = Hamburg<br>
 * 	HE = Hessen<br>
 * 	MV = Mecklenburg-Vorpommern<br>
 * 	NI = Niedersachsen<br>
 * 	NW = Nordrhein-Westfalen<br>
 * 	RP = Rheinland-Pfalz<br>
 * 	SL = Saarland<br>
 * 	SN = Sachsen<br>
 * 	ST = Sachsen-Anhalt<br>
 * 	SH = Schleswig-Holstein<br>
 * 	TH = Thüringen
 * @return 'Arbeitstag', 'Wochenende' oder Name des Feiertags als String
 */
function feiertag($datum, $bundesland = '')
{
    $bundesland = strtoupper($bundesland);

    if (!$datum instanceof DateTime) {
        try {
            $datum = new DateTime($datum);
        } catch (Exception $e) {
            return false;
        }
    }

    $md   = $datum->format('md');
    $jahr = (int)$datum->format('Y');
    $wday = (int)$datum->format('w');

    $status = ($wday === 0 || $wday === 6) ? 'Wochenende' : 'Arbeitstag';

    // Osterdatum
    $ostern = new DateTime('@' . easter_date($jahr));
    $ostern->setTimezone(new DateTimeZone(date_default_timezone_get()));

    $beweglich = [
        'Karfreitag'        => (clone $ostern)->modify('-2 days')->format('md'),
        'Ostersonntag'      => $ostern->format('md'),
        'Ostermontag'       => (clone $ostern)->modify('+1 day')->format('md'),
        'Weiberfastnacht '  => (clone $ostern)->modify('-52 day')->format('md'),
        'Christi Himmelf.'  => (clone $ostern)->modify('+39 days')->format('md'),
        'Pfingstsonntag'    => (clone $ostern)->modify('+49 days')->format('md'),
        'Pfingstmontag'     => (clone $ostern)->modify('+50 days')->format('md'),
        'Fronleichnam'      => (clone $ostern)->modify('+60 days')->format('md'),
    ];

    $fix = [
        '0101' => 'Neujahr',
        '0501' => 'Tag der Arbeit',
        '1003' => 'Tag der deutschen Einheit',
        '1225' => '1. Weihnachtsfeiertag',
        '1226' => '2. Weihnachtsfeiertag',
        '1224' => 'Heiliger Abend (Bankfeiertag)',
        '1231' => 'Silvester (Bankfeiertag)',
    ];

    $laender = [
        'Heilige Drei Könige' => ['BW','BY','ST'],
        'Fronleichnam'       => ['BW','BY','HE','NW','RP','SL','SN','TH'],
        'Mariä Himmelfahrt'  => ['BY','SL'],
        'Reformationstag'   => ['BB','MV','SN','ST','TH'],
        'Allerheiligen'     => ['BW','BY','NW','RP','SL'],
        'Weiberfastnacht' => ['NW','RP','BW','BY'],
    ];

    // Feste Feiertage
    if (isset($fix[$md])) {
        return $fix[$md];
    }

    // Bewegliche Feiertage
    foreach ($beweglich as $name => $tag) {
        if ($md === $tag) {
            if (!isset($laender[$name]) || in_array($bundesland, $laender[$name])) {
                return $name;
            }
        }
    }

    // Buß- und Bettag (SN)
    if ($bundesland === 'SN') {
        $busstag = new DateTime("last wednesday of november $jahr");
        if ($datum->format('md') === $busstag->format('md')) {
            return 'Buß- und Bettag';
        }
    }

    return $status;
}







//##########################################################################################################################
//##############################################################################################################
function sqlBackup(PDO $pdo): bool
{
    try {
        $backupDir = dirname(__DIR__) . '/backups/' . date('Y-m-d_H-i-s');

        if (!is_dir($backupDir) && !mkdir($backupDir, 0755, true)) {
            throw new RuntimeException("Backup directory could not be created.");
        }

        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $tables = $pdo->query("SHOW TABLES")->fetchAll(PDO::FETCH_COLUMN);

        foreach ($tables as $table) {

            $filename = $backupDir . "/{$table}.sql";
            $handle = fopen($filename, 'w');

            if (!$handle) {
                throw new RuntimeException("Could not write file: {$filename}");
            }

            fwrite($handle, "-- Backup of table `{$table}`\n");
            fwrite($handle, "-- Generated: " . date('Y-m-d H:i:s') . "\n\n");

            // Struktur
            $createStmt = $pdo->query("SHOW CREATE TABLE `{$table}`")
                ->fetch(PDO::FETCH_ASSOC);

            fwrite($handle, "DROP TABLE IF EXISTS `{$table}`;\n");
            fwrite($handle, $createStmt['Create Table'] . ";\n\n");

            // Daten
            $stmt = $pdo->query("SELECT * FROM `{$table}`", PDO::FETCH_ASSOC);

            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {

                $columns = array_map(
                    fn($col) => "`{$col}`",
                    array_keys($row)
                );

                $values = array_map(
                    fn($val) => $val === null ? "NULL" : $pdo->quote($val),
                    array_values($row)
                );

                $sql = "INSERT INTO `{$table}` (" .
                    implode(',', $columns) .
                    ") VALUES (" .
                    implode(',', $values) .
                    ");\n";

                fwrite($handle, $sql);
            }

            fclose($handle);
        }

        return true;

    } catch (Throwable $e) {
        error_log("SQL Backup Error: " . $e->getMessage());
        return false;
    }
}

