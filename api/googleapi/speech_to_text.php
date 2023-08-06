<?php

require '../../vendor/autoload.php';
# Imports the Google Cloud client library
use Google\Cloud\Speech\V1\SpeechClient;
use Google\Cloud\Speech\V1\RecognitionAudio;
use Google\Cloud\Speech\V1\RecognitionConfig;
use Google\Cloud\Speech\V1\RecognitionConfig\AudioEncoding;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['audio'])) {
    $responseJson = array();

    $arquivo = $_POST['audio'];


    $audio = file_get_contents($arquivo);

    $encoding = AudioEncoding::WEBM_OPUS;
    $sampleRateHertz = 48000;
    $languageCode = 'pt-BR';

    $audio = (new RecognitionAudio())
        ->setContent($audio);

    $config = (new RecognitionConfig())
        ->setEncoding($encoding)
        ->setSampleRateHertz($sampleRateHertz)
        ->setLanguageCode($languageCode);

    $client = new SpeechClient();

    $response = $client->recognize($config, $audio);

    $transcript = '';
    foreach ($response->getResults() as $result) {
        $alternatives = $result->getAlternatives();
        $mostLikely = $alternatives[0];
        $transcript = $mostLikely->getTranscript();
        $confidence = $mostLikely->getConfidence();
    }

    $client->close();

    $responseJson['msg'] = 'Audio transcript!';
    $responseJson['transcript'] = $transcript;

    unlink($arquivo);

    echo json_encode($transcript);
}


