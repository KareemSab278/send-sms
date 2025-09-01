<?php

// function sendSMS($to, $message, $from = 'FireText', $schedule = '', $reference = '')
// {
//     $apiKey = 'yourApiKey';
//     $url = "https://www.firetext.co.uk/api/sendsms?apiKey=$apiKey&message=" . urlencode($message) .
//         "&from=" . urlencode($from) .
//         "&to=" . urlencode($to);

//     if ($schedule)
//         $url .= "&schedule=" . urlencode($schedule);
//     if ($reference)
//         $url .= "&reference=" . urlencode($reference);

//     return file_get_contents($url);
// }

// // example:
// // require 'send_text.php';
// sendSMS('07123456789,447712345678', 'This is the text message', 'FireText', '2010-05-22 17:00', '1234567'); // just call the function

//this is a function that does this: https://www.firetext.co.uk/api/sendsms?apiKey=myApiKey&message=This+is+a+test+message&from=FireText&to=07123456789,447712345678&schedule=2010-05-22%2017:00&reference=1234567

// or use an api call

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['api'])) {
    header('Content-Type: application/json');
    try {
        $auth_user = $_SESSION['user-id'] ?? null;
        $to = $_POST['to'];
        $message = $_POST['message'];
        $from = $_POST['from'] ?? 'Coinadrink HQ'; // defaults to Coinadrink HQ if not provided - i could use $_SESSION['user-id']
        $schedule = $_POST['schedule'] ?? null; // not required
        $reference = $_POST['reference'] ?? null; // not required

        if (!preg_match('/^[0-9,+]+$/', $to)) { // check if phone numbers are valid with regex
            // can accept 07123456789
            // can accept 447712345678
            // can accept 07123456789,447712345678
            // can accept +447712345678
            // can accept +447712345678,+447712345679
            http_response_code(400);
            echo json_encode(['status' => 'error', 'error' => 'Invalid phone number format!']);
            exit;
        }

        if (!$auth_user) { // should i include authorization for some security measure????????? ASK C/J.
            http_response_code(401);
            echo json_encode(['status' => 'error', 'error' => 'Unauthorized user']);
            exit;
        }

        if (!$to || !$message) { // check params filled
            http_response_code(400);
            echo json_encode(['status' => 'error', 'error' => 'Missing recipient or message parameters']);
            exit;
        }

        echo json_encode(['status' => 'success', 'result' => $result]);
        exit;

    } catch (Exception $error) {
        http_response_code(500); // server err
        echo json_encode(['status' => 'error', 'error' => $error->getMessage()]); // jsonify and display error

    }
    header('Content-Type: application/json');
}



//////////////////////////
function callSendTextApi($to, $message, $from = 'Coinadrink HQ')
{
    $apiKey = getenv('FIRETEXT_API_KEY');
    $url = "https://www.firetext.co.uk/api/sendsms?apiKey=$apiKey&message=" . urlencode($message) . "&from=" . urlencode($from) . "&to=" . urlencode($to);

    $data = [
        'apiKey' => $apiKey,
        'to' => $to,
        'message' => $message,
        'from' => $from
    ];

    $options = [
        'http' => [
            'header' => "Content-type: application/x-www-form-urlencoded\r\n",
            'method' => 'POST',
            'content' => http_build_query($data),
        ],
    ];
    $context = stream_context_create($options);
    $result = file_get_contents($url, false, $context);

    return $result; // JSON response from API
}

callSendTextApi('07123456789', 'Hello from PHP!');

// i think the api is internal prod ready