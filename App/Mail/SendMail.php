<?php

namespace App\Mail;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require '../../vendor/autoload.php';

class SendMail
{
    public $destination;
    public $message;


    public function __construct($destination, $message)
    {
        $this->destination = $destination;
        $this->message = $message;

    }

    public function send(){
        $mail = new PHPMailer(true);

        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->SMTPSecure = 'tls';
        $mail->Username = 'your_mail@gmail.com';
        $mail->Password = 'your_password';
        $mail->Port = 587;
        $mail->CharSet = "UTF-8";
        $mail->setFrom($this->getDestination());
        $mail->addAddress($this->getDestination());
        $mail->Subject = 'Envio de email automático';
        $mail->Body    = $this->getMessage();
        $mail->send();
    }

    public function getDestination()
    {
        return $this->destination;
    }

    public function getMessage()
    {
        return $this->message;
    }

}