<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['audio'])) {
    $audio = $_FILES['audio'];

    $dir = '../temp/';

    $nameFile = uniqid('audio_') . '.wav';

    $path = $dir . $nameFile;

    if (move_uploaded_file($audio['tmp_name'], $path)) {
        $response['msg'] = "Audio salvo com sucesso!";
        $response["file_path"] = $path;
        echo json_encode($response);
    } else {
        $response['msg'] = "Audio salvo com sucesso!";
        echo json_encode($response);
    }
}