<?php
$token = ('6274297006:AAGi3PEF-HOTcrnLmT0omKySMlx16P6mBqk');

function sendMessage($chat_id, $text, $reply_markup = NULL) {
    $url = API_URL . "sendMessage?chat_id=" . $chat_id . "&text=" . urlencode($text);
    if ($reply_markup) {
        $url .= "&reply_markup=" . json_encode($reply_markup);
    }
    file_get_contents($url);
}

function mainMenu($chat_id) {
    $keyboard = [
        'keyboard' => [
            [['text' => 'اکانت عمومی']],
            [['text' => 'اکانت خصوصی']]
        ],
        'resize_keyboard' => true,
        'one_time_keyboard' => true
    ];
    sendMessage($chat_id, "لطفاً گزینه‌ای را انتخاب کنید:", $keyboard);
}

function publicAccountMenu($chat_id) {
    $keyboard = [
        'keyboard' => [
            [['text' => 'یکماهه حجم نامحدود']],
            [['text' => 'بازگشت به منوی اصلی']]
        ],
        'resize_keyboard' => true,
        'one_time_keyboard' => true
    ];
    sendMessage($chat_id, "گزینه‌های اکانت عمومی:", $keyboard);
}

function privateAccountMenu($chat_id) {
    $keyboard = [
        'keyboard' => [
            [['text' => 'یک ماهه حجم نامحدود']],
            [['text' => 'سه ماهه حجم نامحدود 10% تخفیف']],
            [['text' => 'شش ماهه حجم نامحدود 12% تخفیف']],
            [['text' => 'یکساله حجم نامحدود 15% تخفیف']],
            [['text' => 'بازگشت به منوی اصلی']]
        ],
        'resize_keyboard' => true,
        'one_time_keyboard' => true
    ];
    sendMessage($chat_id, "گزینه‌های اکانت خصوصی:", $keyboard);
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
        mainMenu($chat_id);
        break;
    case 'اکانت عمومی':
        publicAccountMenu($chat_id);
        break;
    case 'اکانت خصوصی':
        privateAccountMenu($chat_id);
        break;
    case 'یکماهه حجم نامحدود':
    case 'یک ماهه حجم نامحدود':
    case 'سه ماهه حجم نامحدود 10% تخفیف':
    case 'شش ماهه حجم نامحدود 12% تخفیف':
    case 'یکساله حجم نامحدود 15% تخفیف':
        sendMessage($chat_id, "شماره کارت: [شماره کارت]\nمبلغ: [مبلغ مورد نظر]");
        break;
    case 'بازگشت به منوی اصلی':
        mainMenu($chat_id);
        break;
    // اضافه کردن سایر کیس‌ها و پاسخ‌های مربوطه
}

?>
