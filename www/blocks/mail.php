<?php

    require_once("err.php");
    require_once("config.php");




    $SMTP_HOST = getConf('SMTP_HOST');
    $SMTP_USER = getConf('SMTP_USER');
    $SMTP_PSW = getConf('SMTP_PSW');
    $SMTP_PORT = getConf('SMTP_PORT');


    function sendMail($toArray, $subject, $htmlBody, $altBody, $fromName) {

  
        global $SMTP_HOST;
        global $SMTP_USER;
        global $SMTP_PSW;
        global $SMTP_PORT;

        require_once(__DIR__."/../vendor/phpmailer/phpmailer/src/Exception.php");
        require_once(__DIR__."/../vendor/phpmailer/phpmailer/src/PHPMailer.php");
        require_once(__DIR__."/../vendor/phpmailer/phpmailer/src/SMTP.php");
        $mail = new PHPMailer\PHPMailer\PHPMailer(true);

        try {
            //Server settings
            $mail->SMTPDebug = PHPMailer\PHPMailer\SMTP::DEBUG_SERVER;                      //Enable verbose debug output
            $mail->isSMTP();                                            //Send using SMTP
            $mail->CharSet = 'UTF-8';
            $mail->Host       = $SMTP_HOST;                     //Set the SMTP server to send through
            $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
            $mail->Username   = $SMTP_USER;                     //SMTP username
            $mail->Password   = $SMTP_PSW;                               //SMTP password
            $mail->SMTPSecure = PHPMailer\PHPMailer\PHPMailer::ENCRYPTION_STARTTLS;            //Enable implicit TLS encryption
            $mail->Port       = $SMTP_PORT;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
        
            //Recipients
            $mail->setFrom($SMTP_USER, !empty($fromName) ? $fromName : 'Почтовый сервис сайта Походники');
            foreach ($toArray as list($email, $name)) {

                if (!empty($name)) {
                    $mail->addAddress($email, $name); 
                } else {
                    $mail->addAddress($email);
                }
            }
            // $mail->addReplyTo('info@example.com', 'Information');
            // $mail->addCC('cc@example.com');
            // $mail->addBCC('bcc@example.com');
        
            //Attachments
            // $mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
            // $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name
        
            //Content
            $mail->isHTML(true);                                  //Set email format to HTML
            $mail->Subject = $subject;
            $mail->Body    = $htmlBody;
            $mail->AltBody =!empty($altBody) ? $altBody : strip_tags($htmlBody);
        
            $mail->send();
            return true;
        } catch (Exception $e) {
            return "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
    }
  