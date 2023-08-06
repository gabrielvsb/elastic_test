<?php

namespace App\Log;

use App\Database\Database;

class LogMail
{
    public $message;
    public $email;

    public function __construct($message, $email)
    {
        $this->message = $message;
        $this->email = $email;
    }

    public function saveLog(){
        try {
            $message = $this->getMessage();
            $email = $this->getEmail();

            $database = new Database();
            $conn = $database->getConnection();

            $sql = "INSERT INTO log (message, email) VALUES (:message, :email)";

            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':message', $message);
            $stmt->bindParam(':email', $email);

            $stmt->execute();
        }catch (\Exception $exception){
            return $exception->getMessage();
        }
    }

    public function getMessage()
    {
        return $this->message;
    }

    public function getEmail()
    {
        return $this->email;
    }


}