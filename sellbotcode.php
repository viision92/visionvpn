<?php
define('BOT_TOKEN', '6900629278:AAFWe7X6N5gWRyTHnnTnMrKBLOF0DOTng_g');
define('API_URL', 'https://api.telegram.org/bot'.BOT_TOKEN.'/');

function sendMessage($chat_id, $text) {
    file_get_contents(API_URL . "sendMessage?chat_id=" . $chat_id . "&text=" . urlencode($text));
}

function sendMenu($chat_id) {
    $keyboard = [
        'keyboard' => [
            [['text' => 'اکانت عمومی']],
            [['text' => 'اکانت خصوصی']]
        ],
        'resize_keyboard' => true,
        'one_time_keyboard' => true
    ];
    file_get_contents(API_URL . "sendMessage?chat_id=" . $chat_id . "&text=انتخاب کنید&reply_markup=" . json_encode($keyboard));
}

$content = file_get_contents("php://input");
$update = json_decode($content, true);

if (!$update) {
    exit;
}

$message = $update['message'];
$chat_id = $message['chat']['id'];
$text = $message['text'];

switch ($text) {
    case '/start':
        sendMenu($chat_id);
        break;
    case 'اکانت عمومی':
        // اجرای عملیات مربوط به اکانت عمومی
        sendMessage($chat_id, "گزینه‌های اکانت عمومی");
        break;
    case 'اکانت خصوصی':
        // اجرای عملیات مربوط به اکانت خصوصی
        sendMessage($chat_id, "گزینه‌های اکانت خصوصی");
        break;
    // اضافه کردن کیس‌های دیگر برای دکمه‌های زیرمنو
}

?>
