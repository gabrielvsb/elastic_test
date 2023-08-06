<?php
require '../../vendor/autoload.php';

use App\Log\LogMail;
use App\Mail\SendMail;


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['message'])) {
    $message = $_POST['message'];
    $destination = "destination@gmail.com";

    $sendMail = new SendMail($destination, $message);

    try {
        $sendMail->send();

        $log = new LogMail($message, $destination);
        $log->saveLog();

        echo 'Email enviado!';

    }catch (Exception $exception){
        echo $exception->getMessage();
    }
}
