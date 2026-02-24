<?php
function multi_attach_mail(string $from, string $to, string $subject, string $message, array $files = []): bool
{
    global $URL;

    // Message für HTML aufbereiten
    $message = nl2br($message, false);
    $mainTitle = 'PC Praktikum';

    // HTML Template
    $emailTemplate = <<<HTML
<!DOCTYPE html>
<html lang="de">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<style>
body { margin:0; padding:0; font-family:Arial; font-size:14px; }
a { color:#000; text-decoration:none; }
a:hover { color:#2eca6a; }
.header { background:#343a40; color:#fff; padding:15px; }
.footer { background:#f5f5f5; padding:15px; text-align:center; color:#555; }
.content { padding:15px; color:#555; }
</style>
</head>
<body>

<div class="header">
    <a href="$URL" style="color:#fff;font-size:18px;">
        $mainTitle
    </a>
</div>

<div class="content">
    <strong>{{SUBJECT}}</strong><br><br>
    {{MESSAGE}}
</div>

<div class="footer">
    $mainTitle
</div>

</body>
</html>
HTML;

    // Platzhalter ersetzen
    $emailTemplate = str_replace(
        ['{{SUBJECT}}', '{{MESSAGE}}'],
        [$subject, $message],
        $emailTemplate
    );

    // Header Basis
    $senderName = $mainTitle;
    $headers  = "From: {$senderName} <{$from}>\r\n";
    $headers .= "Reply-To: {$from}\r\n";
    $headers .= "MIME-Version: 1.0\r\n";

    $returnPath   = "-f{$from}";
    $totalSize    = 0;

    // === MIT ANHÄNGEN ===
    if (!empty($files)) {
        $boundary = md5(uniqid((string)time(), true));
        $headers .= "Content-Type: multipart/mixed; boundary=\"{$boundary}\"";

        $body  = "--{$boundary}\r\n";
        $body .= "Content-Type: text/html; charset=UTF-8\r\n";
        $body .= "Content-Transfer-Encoding: 8bit\r\n\r\n";
        $body .= $emailTemplate . "\r\n";

        foreach ($files as $file) {
            if (!is_file($file)) {
                continue;
            }

            $fileName = basename($file);
            $fileSize = filesize($file);
            $totalSize += $fileSize;

            $body .= "--{$boundary}\r\n";
            $body .= "Content-Type: application/octet-stream; name=\"{$fileName}\"\r\n";
            $body .= "Content-Disposition: attachment; filename=\"{$fileName}\"\r\n";
            $body .= "Content-Transfer-Encoding: base64\r\n\r\n";
            $body .= chunk_split(base64_encode(file_get_contents($file))) . "\r\n";
        }

        $body .= "--{$boundary}--";

        // === OHNE ANHÄNGE ===
    } else {
        $headers .= "Content-Type: text/html; charset=UTF-8\r\n";
        $body = $emailTemplate;
    }

    $subject_encoded = mb_encode_mimeheader($subject, "UTF-8", "Q");
    // Versand (zentral)
    return mailer($to, $subject_encoded, $body, $headers, $returnPath, $totalSize);
}
//############################################################################ END ##########################################################################################
//########################################################################### BEGIN #########################################################################################
function mailer( string $to, string $subject, string $message, string $headers, string $additionalParams = '', int $fileSizeAll = 0) {
    // Maximal 9 MB über Mail-Gateway
    $maxSize = 9 * 1024 * 1024;

    // === FALL: große Anhänge → normales mail() ===
    if ($fileSizeAll >= $maxSize) {
        return mail($to, $subject, $message, $headers, $additionalParams);
    }

    // === Mail-Gateway ===
    $url = 'https://www.kim23.wwwdns.kim.uni-konstanz.de/mail/mail.php';
    $key = 'fwzfbviivjko3429ebdue';

    $postData = http_build_query([
        'key'               => $key,
        'to'                => $to,
        'subject'           => $subject,
        'message'           => $message,
        'headers'           => $headers,
        'additional_params' => $additionalParams
    ]);

    $context = stream_context_create([
        'http' => [
            'method'  => 'POST',
            'header'  =>
                "Content-Type: application/x-www-form-urlencoded\r\n" .
                "Content-Length: " . strlen($postData) . "\r\n",
            'content' => $postData,
            'timeout' => 5
        ]
    ]);

    $response = file_get_contents($url, false, $context);

    return $response === "1";
}
//############################################################################ END ##########################################################################################
//########################################################################### BEGIN #########################################################################################
function sendPasswordResetLink(string $userEmail): bool
{
    global $pdo, $URL;

    // Secure token
    $resetToken = bin2hex(random_bytes(32));
    $resetTime  = time();

    // Update user
    $stmt = $pdo->prepare("
        UPDATE admins
        SET reset_token = :token,
            reset_time  = :time
        WHERE email = :email
        LIMIT 1
    ");

    if (!$stmt->execute([
        'token' => $resetToken,
        'time'  => $resetTime,
        'email' => $userEmail
    ])) {
        return false;
    }

    // Do not reveal if email exists
    if ($stmt->rowCount() === 0) {
        return true;
    }

    $resetLink = $URL . 'admin?password-token=' . urlencode($resetToken);

    $subject = 'Reset your password';
    $message = '
        <p>You requested a password reset.</p>
        <p>Click the link below to choose a new password:</p>
        <p><a href="' . htmlspecialchars($resetLink, ENT_QUOTES, 'UTF-8') . '">
            Reset your password
        </a></p>
        <p>If you did not request this, you can safely ignore this email.</p>
    ';

    return multi_attach_mail(
        'no-reply@uni-konstanz.de',
        $userEmail,
        $subject,
        $message
    );
}
//############################################################################ END ##########################################################################################
