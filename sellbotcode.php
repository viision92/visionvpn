<?php
$botToken = "6900629278:AAFWe7X6N5gWRyTHnnTnMrKBLOF0DOTng_g";
$website = "https://api.telegram.org/bot" . $botToken;

// Function to send messages
function sendMessage($chatId, $message) {
    global $website;
    $url = $website . "/sendMessage?chat_id=" . $chatId . "&text=" . urlencode($message);
    file_get_contents($url);
}

// Function to handle callbacks
function handleCallback($callbackQuery) {
    $chatId = $callbackQuery['message']['chat']['id'];
    $data = $callbackQuery['data'];

    switch($data) {
        case '1-1':
            sendMessage($chatId, "Please send the payment to this card number: XXXX-XXXX-XXXX-XXXX. Amount: YY");
            break;
        // Add more cases for other menu options
    }
}

$content = file_get_contents("php://input");
$update = json_decode($content, true);

if(isset($update["message"])) {
    $message = $update["message"];
    $chatId = $message["chat"]["id"];

    // Check if the message has text
    if(isset($message["text"])) {
        $text = $message["text"];

        // Implement your menu logic here
        switch($text) {
            case "/start":
                sendMessage($chatId, "Welcome to the VPN Sales Bot!");
                // Add more code to display initial menu
                break;
            // Add more cases for other commands
        }
    }
} elseif(isset($update["callback_query"])) {
    handleCallback($update["callback_query"]);
}
?>
