<?php
$botToken = "6274297006:AAGi3PEF-HOTcrnLmT0omKySMlx16P6mBqk";
$website = "https://api.telegram.org/bot".$botToken;
$content = file_get_contents("php://input");
$update = json_decode($content, true);
$chatId = $update["message"]["chat"]["id"];
$message = $update["message"]["text"];

switch($message) {
    case "/start":
        sendMessage($chatId, "به ویژن خوش آمدید. لطفا یک گزینه را انتخاب کنید.", $mainMenu);
        break;
    case "اکانت عمومی":
        sendMessage($chatId, "انتخاب کنید:", $publicAccountMenu);
        break;
    case "یکماهه حجم نامحدود":
        sendMessage($chatId, "قیمت: 35 هزار تومان\nلطفا پرداخت کنید و سپس شماره تراکنش را ارسال کنید.", null);
        break;
    case "اکانت خصوصی":
        sendMessage($chatId, "انتخاب کنید:", $privateAccountMenu);
        break;
    // ... ادامه کد برای دیگر گزینه‌ها
    default:
        // پردازش سایر پیام‌ها
        break;
}

function sendMessage($chatId, $message, $replyMarkup = null) {
    $url = $GLOBALS['website']."/sendMessage?chat_id=".$chatId."&text=".urlencode($message);
    if ($replyMarkup) {
        $url .= "&reply_markup=".json_encode($replyMarkup);
    }
    file_get_contents($url);
}

$mainMenu = [
    'keyboard' => [['اکانت عمومی'], ['اکانت خصوصی']],
    'resize_keyboard' => true,
    'one_time_keyboard' => false
];

$publicAccountMenu = [
    'keyboard' => [['یکماهه حجم نامحدود'], ['بازگشت']],
    'resize_keyboard' => true,
    'one_time_keyboard' => false
];

$privateAccountMenu = [
    'keyboard' => [['یک ماهه حجم نامحدود'], ['سه ماهه حجم نامحدود 10% تخفیف'], ['شش ماهه حجم نامحدود 12% تخفیف'], ['یکماهه حجم نامحدود 15% تخفیف'], ['بازگشت']],
    'resize_keyboard' => true,
    'one_time_keyboard' => false
];

// ... بقیه تعریف‌های منو

?>
