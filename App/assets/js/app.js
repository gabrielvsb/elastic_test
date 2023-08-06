const startButton = document.getElementById('btnStart');
const stopButton = document.getElementById('btnStop');
const emailButton = document.getElementById('btnSendMail');
const msg = document.getElementById('message');
let mediaRecorder;
let audioChunks = [];

startButton.addEventListener('click', startRecording);
stopButton.addEventListener('click', stopRecording);
emailButton.addEventListener('click', sendMail);

function startRecording() {
    msg.innerText = '';
    navigator.mediaDevices.getUserMedia({ audio: true })
        .then(stream => {
            mediaRecorder = new MediaRecorder(stream);

            mediaRecorder.ondataavailable = event => {
                if (event.data.size > 0) {
                    audioChunks.push(event.data);
                }
            };

            mediaRecorder.onstop = () => {
                const audioBlob = new Blob(audioChunks, { type: 'audio/wav' });
                saveAudio(audioBlob);
            };

            mediaRecorder.start();
            startButton.disabled = true;
            stopButton.disabled = false;
            emailButton.disabled = true;
        })
        .catch(error => {
            console.error('Erro ao gravar mensagem:', error);
        });
}

function stopRecording() {
    mediaRecorder.stop();
    startButton.disabled = false;
    stopButton.disabled = true;
}

function saveAudio(audioBlob) {
    const formData = new FormData();
    formData.append('audio', audioBlob, 'audio.wav');
    msg.innerText = 'Transcrevendo audio...';
    fetch('http://localhost/elastic_test/api/googleapi/save_audio.php', {
        method: 'POST',
        body: formData
    })
        .then(response => response.json())
        .then(result => {
            console.log('Server response:', result.msg);
            sendAudioToGoogleAPI(result.file_path)
        })
        .catch(error => {
            console.error('Error sending audio to server:', error);
        });
}

function sendAudioToGoogleAPI(audioFile){
    const formData = new FormData();
    formData.append('audio', audioFile);

    fetch('http://localhost/elastic_test/api/googleapi/speech_to_text.php', {
        method: 'POST',
        body: formData
    })
        .then(response => response.json())
        .then(result => {
            msg.innerText = result;
            emailButton.disabled = false;
        })
        .catch(error => {
            console.error('Error sending audio to server:', error);
        });
}

function sendMail(){
    const message = document.getElementById('message').textContent;

    const formData = new FormData();
    formData.append('message', message);

    msg.innerText = 'Enviando email...'

    fetch('http://localhost/elastic_test/api/emailapi/send_mail.php', {
        method: 'POST',
        body: formData
    })
        .then(response => response.text())
        .then(result => {
            msg.innerText = "";
            alert(result);
        })
        .catch(error => {
            console.error('Error sending mail:', error);
        });
}