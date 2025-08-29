<?php
function sendSMS($to, $message, $from = 'FireText', $schedule = '', $reference = '') {
    $apiKey = 'yourApiKey';
    $url = "https://www.firetext.co.uk/api/sendsms?apiKey=$apiKey&message=" . urlencode($message) .
           "&from=" . urlencode($from) .
           "&to=" . urlencode($to);

    if ($schedule) $url .= "&schedule=" . urlencode($schedule);
    if ($reference) $url .= "&reference=" . urlencode($reference);

    return file_get_contents($url);
}

// example:

require 'send_text.php';
sendSMS('07123456789,447712345678', 'This is the text message', 'FireText', '2010-05-22 17:00', '1234567'); // just call the function

//this is a function that does this: https://www.firetext.co.uk/api/sendsms?apiKey=myApiKey&message=This+is+a+test+message&from=FireText&to=07123456789,447712345678&schedule=2010-05-22%2017:00&reference=1234567

?>