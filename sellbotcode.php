<?php
$botToken = "6900629278:AAFWe7X6N5gWRyTHnnTnMrKBLOF0DOTng_g";
$website = "https://api.telegram.org/bot" . $botToken;

// Function to send messages
function sendMessage($chatId, $message) {
    global $website;
    $url = $website . "/sendMessage?chat_id=" . $chatId . "&text=" . urlencode($message);
    file_get_contents($url);
}

// Function to handle main menu
function mainMenu($chatId) {
    sendMessage($chatId, "لطفا یک گزینه را انتخاب کنید:\n1- اکانت عمومی\n2- اکانت خصوصی");
}

// Function to handle submenu and actions
function handleMenu($chatId, $text) {
    switch($text) {
        case "/start":
            mainMenu($chatId);
            break;
        case "1- اکانت عمومی":
            sendMessage($chatId, "اکانت عمومی:\n1-1 یکماهه حجم نامحدود\n1-2 بازگشت");
            break;
        case "1-1":
            sendMessage($chatId, "لطفا مبلغ را به شماره کارت XXXX-XXXX-XXXX-XXXX واریز کنید. مبلغ: YY");
            break;
        case "1-2":
        case "2-1-2":
        case "2-2-2":
        case "2-3-2":
        case "2-4-2":
            mainMenu($chatId);
            break;
        case "2- اکانت خصوصی":
            sendMessage($chatId, "اکانت خصوصی:\n2-1 یک ماهه حجم نامحدود\n2-2 سه ماهه حجم نامحدود 10% تخفیف\n2-3 شش ماهه حجم نامحدود 12% تخفیف\n2-4 یکماهه حجم نامحدود 15% تخفیف");
            break;
        // Add more cases for other options
    }
}

$content = file_get_contents("php://input");
$update = json_decode($content, true);

if(isset($update["message"])) {
    $message = $update["message"];
    $chatId = $message["chat"]["id"];

    if(isset($message["text"])) {
        $text = $message["text"];
        handleMenu($chatId, $text);
    }
}
?>
