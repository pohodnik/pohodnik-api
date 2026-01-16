<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

// Загружаем конфигурационные переменные
$SMTP_HOST = getenv('SMTP_HOST') ?: 'smtp.example.com';
$SMTP_USER = getenv('SMTP_USER') ?: '';
$SMTP_PSW = getenv('SMTP_PSW') ?: '';
$SMTP_PORT = getenv('SMTP_PORT') ?: 465;
$SMTP_DEBUG = getenv('SMTP_DEBUG') === 'true' || getenv('SMTP_DEBUG') === '1';

// Проверяем существование autoload и загружаем его
$vendorAutoload = __DIR__ . "/../vendor/autoload.php";
if (!file_exists($vendorAutoload)) {
    die("Vendor autoload not found at: $vendorAutoload. Please run 'composer install'");
}

require_once($vendorAutoload);

/**
 * Отправляет электронное письмо
 * 
 * @param array $toArray Массив получателей в формате [[email1, name1], [email2, name2], ...]
 * @param string $subject Тема письма
 * @param string $htmlBody HTML-содержимое письма
 * @param string|null $altBody Альтернативное текстовое содержимое (если null, будет сгенерировано из HTML)
 * @param string|null $fromName Имя отправителя (если null, будет использовано значение по умолчанию)
 * @return bool|string Возвращает true при успешной отправке или строку с ошибкой
 */
function sendMail(array $toArray, string $subject, string $htmlBody, ?string $altBody = null, ?string $fromName = null) {
    global $SMTP_HOST, $SMTP_USER, $SMTP_PSW, $SMTP_PORT, $SMTP_DEBUG;

    // Валидация обязательных параметров
    if (empty($SMTP_HOST) || empty($SMTP_USER) || empty($SMTP_PSW)) {
        return "SMTP configuration is incomplete";
    }

    if (empty($toArray)) {
        return "No recipients specified";
    }

    if (empty($subject)) {
        return "Email subject is required";
    }

    if (empty($htmlBody)) {
        return "Email body is required";
    }

    $mail = new PHPMailer(true);

    try {
        // Настройки сервера
        if ($SMTP_DEBUG) {
            $mail->SMTPDebug = SMTP::DEBUG_SERVER; // Включить подробный вывод отладки
        }
        
        $mail->isSMTP(); // Использовать SMTP
        $mail->CharSet = 'UTF-8';
        $mail->Host = $SMTP_HOST; // SMTP сервер
        $mail->SMTPAuth = true; // Включить аутентификацию SMTP
        $mail->Username = $SMTP_USER; // Имя пользователя SMTP
        $mail->Password = $SMTP_PSW; // Пароль SMTP
        
        // Настройка шифрования в зависимости от порта
        if ((int)$SMTP_PORT === 587) {
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        } elseif ((int)$SMTP_PORT === 465) {
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
        } else {
            $mail->SMTPSecure = false;
        }
        
        $mail->Port = (int)$SMTP_PORT; // Порт SMTP

        // Отправитель
        $defaultFromName = 'Почтовый сервис сайта Походники';
        $mail->setFrom($SMTP_USER, $fromName ?: $defaultFromName);

        // Получатели
        foreach ($toArray as $recipient) {
            if (!is_array($recipient) || empty($recipient[0])) {
                continue; // Пропускаем некорректные записи
            }
            
            $email = trim($recipient[0]);
            $name = isset($recipient[1]) ? trim($recipient[1]) : '';
            
            // Валидация email
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                continue; // Пропускаем невалидные email
            }
            
            if (!empty($name)) {
                $mail->addAddress($email, $name);
            } else {
                $mail->addAddress($email);
            }
        }

        // Проверяем, есть ли получатели
        if (count($mail->getToAddresses()) === 0) {
            return "No valid recipients found";
        }

        // Контент письма
        $mail->isHTML(true); // Формат HTML
        $mail->Subject = $subject;
        $mail->Body = $htmlBody;
        
        // Альтернативный текст
        if (!empty($altBody)) {
            $mail->AltBody = $altBody;
        } else {
            // Генерируем текстовую версию из HTML
            $textBody = strip_tags($htmlBody);
            $textBody = html_entity_decode($textBody, ENT_QUOTES | ENT_HTML5, 'UTF-8');
            $textBody = preg_replace('/\s+/', ' ', $textBody);
            $mail->AltBody = trim($textBody);
        }

        // Отправка
        $mail->send();
        return true;
        
    } catch (Exception $e) {
        // Логируем ошибку (в реальном проекте используйте логгер)
        error_log("Mail sending failed: " . $mail->ErrorInfo);
        
        // Безопасное возвращение ошибки (без внутренней информации в продакшене)
        if ($SMTP_DEBUG) {
            return "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        } else {
            return "Message could not be sent. Please try again later. {$mail->ErrorInfo}";
        }
    }
}