<?php
function sendSMS($to, $message, $from = 'FireText', $schedule = '', $reference = '')
{
    $apiKey = 'yourApiKey';
    $url = "https://www.firetext.co.uk/api/sendsms?apiKey=$apiKey&message=" . urlencode($message) .
        "&from=" . urlencode($from) .
        "&to=" . urlencode($to);

    if ($schedule)
        $url .= "&schedule=" . urlencode($schedule);
    if ($reference)
        $url .= "&reference=" . urlencode($reference);

    return file_get_contents($url);
}

// example:

require 'send_text.php';
sendSMS('07123456789,447712345678', 'This is the text message', 'FireText', '2010-05-22 17:00', '1234567'); // just call the function

//this is a function that does this: https://www.firetext.co.uk/api/sendsms?apiKey=myApiKey&message=This+is+a+test+message&from=FireText&to=07123456789,447712345678&schedule=2010-05-22%2017:00&reference=1234567

// or use an api call

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_GET['api'])) {
    try {
        $to = $_POST['to'];
        $message = $_POST['message'];
        $from = $_POST['from'] ?? 'Coinadrink HQ';
        $schedule = $_POST['schedule'] ?? null;
        $reference = $_POST['reference'] ?? null;

        if (!$to) {
            echo json_encode(['status' => 'error', 'error' => 'Missing recepient parameters']);
            exit;
        }

        if (!$message) {
            echo json_encode(['status' => 'error', 'error' => 'Missing message parameters']);
            exit;
        }

        $result = sendSMS($to, $message, $from, $schedule, $reference);
        echo json_encode(['status' => 'success', 'result' => $result]);
        exit;

    } catch (Exception $error) {
        echo 'Caught exception: ', $error->getMessage(), "\n";
    }
    header('Content-Type: application/json');
}



//////////////////////////
function callSendTextApi($to, $message, $from = 'Coinadrink HQ') {
    $url = 'howeveryoucallanapifromfileinphpidk';

    $data = [
        'to' => $to,
        'message' => $message,
        'from' => $from
    ];

    $options = [
        'http' => [
            'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
            'method'  => 'POST',
            'content' => http_build_query($data),
        ],
    ];
    $context  = stream_context_create($options);
    $result = file_get_contents($url, false, $context);

    return $result; // JSON response from API
}

callSendTextApi('07123456789', 'Hello from PHP!');