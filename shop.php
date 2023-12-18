<?php
define('API_KEY','6900629278:AAFWe7X6N5gWRyTHnnTnMrKBLOF0DOTng_g');
function makereq($method,$datas=[]){
    $url = "https://api.telegram.org/bot".API_KEY."/".$method;
    $ch = curl_init();
    curl_setopt($ch,CURLOPT_URL,$url);
    curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
    curl_setopt($ch,CURLOPT_POSTFIELDS,http_build_query($datas));
    $res = curl_exec($ch);
    if(curl_error($ch)){
        var_dump(curl_error($ch));
    }else{
        return json_decode($res);
    }
}
function apiRequest($method, $parameters) {
  if (!is_string($method)) {
    error_log("Method name must be a string\n");
    return false;
  }
  if (!$parameters) {
    $parameters = array();
  } else if (!is_array($parameters)) {
    error_log("Parameters must be an array\n");
    return false;
  }
  foreach ($parameters as $key => &$val) {
    if (!is_numeric($val) && !is_string($val)) {
      $val = json_encode($val);
    }
  }
  $url = "https://api.telegram.org/bot".API_KEY."/".$method.'?'.http_build_query($parameters);
  $handle = curl_init($url);
  curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($handle, CURLOPT_CONNECTTIMEOUT, 5);
  curl_setopt($handle, CURLOPT_TIMEOUT, 60);
  return exec_curl_request($handle);
}
$update = json_decode(file_get_contents('php://input'));
var_dump($update);
$chat_id = $update->message->chat->id;
$message_id = $update->message->message_id;
$from_id = $update->message->from->id;
$name = $update->message->from->first_name;
$username = $update->message->from->username;
$textmessage = isset($update->message->text)?$update->message->text:'';
$reply = $update->message->reply_to_message->forward_from->id;
$stickerid = $update->message->reply_to_message->sticker->file_id;
$button_back = json_encode(['keyboard'=>[
[['text'=>'بازگشت']],
],'resize_keyboard'=>true]);
$command = file_get_contents('data/admin/'.$from_id."/command.txt");
$command1 = file_get_contents('data/users/'.$from_id."/command.txt");
$message_id = $update->message->message_id;
$date = file_get_contents("https://provps.ir/td?td=date");
$time = file_get_contents("https://provps.ir/td?td=time");
$photo = $update->message->photo;
$video = $update->message->video;
$sticker = $update->message->sticker;
$file = $update->message->document;
$music = $update->message->audio;
$text = $update->message->text;
$wait = file_get_contents('data/users/'.$from_id."/wait.txt");
$coin_wait = file_get_contents('data/users/'.$wait."/coin.txt");
$voice = $update->message->voice;
$forward = $update->message->forward_from;
$admin = file_get_contents("data/adminlist.txt");
$chnnl = "Vision_freedom_FEQ";
$coin = file_get_contents("data/users/$from_id/coin.txt");
$Member = file_get_contents("data/member.txt");
//-------
function SendMessage($ChatId, $TextMsg)
{
 makereq('sendMessage',[
'chat_id'=>$ChatId,
'text'=>$TextMsg,
'parse_mode'=>"MarkDown"
]);
}
function SendSticker($ChatId, $sticker_ID)
{
 makereq('sendSticker',[
'chat_id'=>$ChatId,
'sticker'=>$sticker_ID
]);
}
function Forward($KojaShe,$AzKoja,$KodomMSG)
{
makereq('ForwardMessage',[
'chat_id'=>$KojaShe,
'from_chat_id'=>$AzKoja,
'message_id'=>$KodomMSG
]);
}
function save($filename,$TXTdata)
	{
	$myfile = fopen($filename, "w") or die("Unable to open file!");
	fwrite($myfile, "$TXTdata");
	fclose($myfile);
	}
    $step = "";
    if (file_exists("data/users/$from_id/step.txt")) {
      $step = file_get_contents("data/users/$from_id/step.txt");
    }
    if ($textmessage == "/cancel") {
        save("data/users/$from_id/command.txt","none");
var_dump(makereq('sendMessage',[
        'chat_id'=>$update->message->chat->id,
        'text'=>"`تمامی موارد کنسل شدند ✅
یکی از دکمه هارو انتخاب کنید ☝`",
        'parse_mode'=>'MarkDown',
        'reply_markup'=>json_encode([
            'keyboard'=>[
              [
                ['text'=>"محصولات 🛒"],['text'=>"خرید الماس 💎"]
              ],
       [
                ['text'=>"راهنما ⚠️"],['text'=>"الماس رایگان 🎁"]
              ],
        [
                  ['text'=>"پشتیبانی 👤"],['text'=>"اطلاعات حساب 💰"]
			  ],
		[
				  ['text'=>"کد هدیه 🏆"],['text'=>"انتقال الماس 💎"]
              ]
            ]
        ])
    ]));
	save("data/users/$from_id/step.txt","none");
 }
	elseif ($textmessage == "بازگشت") {
var_dump(makereq('sendMessage',[
        'chat_id'=>$update->message->chat->id,
        'text'=>"`با موفقیت به منوی اصلی بازگشتید
یکی از دکمه هارو انتخاب کنید ☝`",
        'parse_mode'=>'MarkDown',
        'reply_markup'=>json_encode([
            'keyboard'=>[
              [
                ['text'=>"محصولات 🛒"],['text'=>"خرید الماس 💎"]
              ],
       [
                ['text'=>"راهنما ⚠️"],['text'=>"الماس رایگان 🎁"]
              ],
        [
                  ['text'=>"پشتیبانی 👤"],['text'=>"اطلاعات حساب 💰"]
			  ],
		[
				  ['text'=>"کد هدیه 🏆"],['text'=>"انتقال الماس 💎"]
              ]
            ]
        ])
    ]));
	save("data/users/$from_id/step.txt","none");
}
elseif ($textmessage == "انتقال الماس ♻️"){
sendMessage($chat_id,"`این بخش موقتا غیر فعال میباشد`");
} 
    elseif ($step == "useCode") {
      if (file_exists("data/codes/$textmessage.txt")) {
        $price = file_get_contents("data/codes/$textmessage.txt");
        $coin = file_get_contents("data/users/".$from_id."/coin.txt");
        settype($coin,"integer");
        $newcoin = $coin + $price;
        save("data/users/".$from_id."/coin.txt",$newcoin);
        unlink("data/codes/$textmessage.txt");
        save("data/users/$from_id/step.txt","none");
var_dump(makereq('sendMessage',[
        'chat_id'=>$update->message->chat->id,
        'text'=>"الماس های شما به مقدار `$price` افزایش یافت",
        'parse_mode'=>'MarkDown',
        'reply_markup'=>json_encode([
            'keyboard'=>[
              [
                ['text'=>"محصولات 🛒"],['text'=>"خرید الماس 💎"]
              ],
       [
                ['text'=>"راهنما ⚠️"],['text'=>"الماس رایگان 🎁"]
              ],
        [
                  ['text'=>"پشتیبانی 👤"],['text'=>"اطلاعات حساب 💰"]
			  ],
	    [
		          ['text'=>"کد هدیه 🏆"],['text'=>"انتقال الماس ♻"]
              ]
            ]
        ])
    ]));
sendMessage("@$chnnl","`
کد در ساعت $time 
توسط کاربر :\n@$username\nاستفاده شد 🎁
الماس های دریافت شده از این کد: $price
`\n@$chnnl");
}
      else {
        SendMessage($chat_id,"`کد وارد شده نا معتبر است\nیا استفاده شده است .`");
      }
    }
    elseif ($step == "settitle") {
      SendMessage($chat_id,"توضیحات محصول :‌ ");
      $count = file_get_contents("data/products/count.txt");
      save("data/products/$count.txt",$textmessage."(******)");
      save("data/products/$textmessage.txt",$count);
      save("data/users/$from_id/step.txt","setabout");
    }
    elseif ($step == "setabout") {
      SendMessage($chat_id,"لینک های خرید موفق : ");
      $count = file_get_contents("data/products/count.txt");
      $last= file_get_contents("data/products/$count.txt");
      save("data/products/$count.txt",$last.$textmessage."(******)");
      save("data/users/$from_id/step.txt","successLink");
    }
    elseif ($step == "successLink") {
      SendMessage($chat_id,"قیمت محصول :‌ ");
      $count = file_get_contents("data/products/count.txt");
      $last= file_get_contents("data/products/$count.txt");
      save("data/products/$count.txt",$last.$textmessage."(******)");
      save("data/users/$from_id/step.txt","setprice");
    }
    elseif ($step == "setprice") {

      $count = file_get_contents("data/products/count.txt");
      $last = file_get_contents("data/products/$count.txt");
      save("data/products/$count.txt",$last.$textmessage."");
      save("data/users/$from_id/step.txt","none");
      settype($count,"integer");
      $newcount = $count + 1;
      save("data/products/count.txt",$newcount);
      SendMessage($chat_id,"محصول شماره $newcount ثبت شد .");
    }
    elseif ($textmessage == "محصول جدید 🛒" && $from_id == $admin) {
       sendMessage($chat_id,"عنوان محصول : ");
	        save("data/users/$from_id/step.txt","settitle");
}
    elseif ($textmessage == "محصولات 🛒") {
      $keyboard = [
	  [
		['text'=>'بازگشت']
	]
];
      $count = file_get_contents("data/products/count.txt");
      $n = 0;
      $text = "";
      while ($n <= $count ) {
        $post = file_get_contents("data/products/$n.txt");
        $arrayPost = explode('(******)',$post);
        $n = $n + 1;
        array_push($keyboard,[$arrayPost['0']]);
      }
      json_encode($keyboard);

      var_dump(makereq('sendMessage',[
           'chat_id'=>$update->message->chat->id,
           'text'=>"`تعداد الماس های شما :` $coin
`محصولات ربات فروشگاه 💰 : `",
     'parse_mode'=>'MarkDown',
           'reply_markup'=>json_encode([
               'keyboard'=>$keyboard,
               'resize_keyboard'=>true
           ])
       ]));

    }
  //============
  elseif($textmessage == 'فروارد همگانی ✅' and $from_id == $admin){
mkdir("data/admin/$from_id");
save("data/admin/".$from_id."/command.txt","s2a fwd");
	SendMessage($chat_id,"`پیام مورد نظر را فوروارد کنید ➡ :`");
	}
	elseif($command == 's2a fwd' and $from_id == $admin){
	save("data/admin/".$from_id."/command.txt","none");
	SendMessage($chat_id,"📮 پیام شما در صف ارسال قرار گرفت.");
	$all_member = fopen( "data/member.txt", 'r');
		while( !feof( $all_member)) {
 			$user = fgets( $all_member);
	Forward($user,$admin,$message_id);
		}
	}
	//===========
	//===========
	elseif($text == 'پیام همگانی 👥' and $from_id == $admin){
	save("data/admin/".$from_id."/command.txt","s2a");
	SendMessage($chat_id," پیامتون رو ارسال کنید ⚠ :");
	}
	elseif($command == 's2a' and $from_id == $admin){
	save("data/admin/".$from_id."/command.txt","none");
	SendMessage($chat_id," پیام شما در صف ارسال قرار گرفت. ✅");
	$all_member = fopen( "data/member.txt", 'r');
		while( !feof( $all_member)) {
 			$user = fgets( $all_member);
			if($sticker_id != null){
			SendSticker($user,$sticker_id);
			}
			elseif($video_id != null){
			SendVideo($user,$video_id,$caption);
			}
			elseif($voice_id != null){
			SendVoice($user,$voice_id,'',$caption);
			}
			elseif($file_id != null){
			SendDocument($user,$file_id,'',$caption);
			}
			elseif($music_id != null){
			SendAudio($user,$music_id,'',$caption);
			}
			elseif($photo2_id != null){
			SendPhoto($user,$photo2_id,'',$caption);
			}
			elseif($photo1_id != null){
			SendPhoto($user,$photo1_id,'',$caption);
			}
			elseif($photo0_id != null){
			SendPhoto($user,$photo0_id,'',$caption);
			}
			elseif($text != null){
			SendMessage($user,$text,"html","true");
			}
		}
	}
//============
elseif(strpos($textmessage,'/start') !== false) {
  $id = str_replace("/start ","",$textmessage);

  if (!file_exists("data/users/$from_id/coin.txt")) {
    mkdir("data/users/$from_id");
    save("data/users/$from_id/coin.txt","1");
    save("data/users/$from_id/step.txt","none");
    
    save("data/users/$from_id/chance.txt","0|0");
    SendMessage($chat_id,"`👤 ثبت نام با موفقیت انجام شد .`
/start
را دوباره ارسال کنید 😊");

    if ($id != "") {
      if ($id != $from_id) {
          SendMessage($id,"`یک نفر از طریق لینک شما وارد ربات شد و 1 الماس به موجودی شما اضافه شد ✅`");
          $coin = file_get_contents("data/users/$id/coin.txt");
          settype($coin,"integer");
          $newcoin = $coin + 1;
          save("data/users/$id/coin.txt",$newcoin);
      }
      else {
        SendMessage($chat_id,"شما قبلا در ربات عضو بودید !");
      }
    }
  }
var_dump(makereq('sendMessage',[
        'chat_id'=>$update->message->chat->id,
        'text'=>"`سلام کاربر عزیز 👤
▪️▪️▪️▪️▪️▪️▪️▪️▪️▪️▪️▪️▪️
 `
`لطفا روی دکمه (راهنما ⚠️) کلیک کنید .
نگران نباشید این ربات کاملا اتوماتیک عمل میکند و بعد از پرداخت محصول خود را دریافت میکنید 💰`
🆔 : @$chnnl",
        'parse_mode'=>'MarkDown',
        'reply_markup'=>json_encode([
            'keyboard'=>[
              [
                ['text'=>"محصولات 🛒"],['text'=>"خرید الماس 💎"]
              ],
       [
                ['text'=>"راهنما ⚠️"],['text'=>"الماس رایگان 🎁"]
              ],
        [
                  ['text'=>"پشتیبانی 👤"],['text'=>"اطلاعات حساب 💰"]
			  ],
		[
				  ['text'=>"کد هدیه 🏆"],['text'=>"انتقال الماس 💎"]
              ]
            ]
        ])
    ]));
}
    $txxt = file_get_contents('data/member.txt');
$pmembersid= explode("\n",$txxt);
	if (!in_array($chat_id,$pmembersid)) {
		$aaddd = file_get_contents('data/member.txt');
		$aaddd .= $chat_id."
";
    	file_put_contents('data/member.txt',$aaddd);
}
	elseif($textmessage == 'آمار 📊' && $chat_id == $admin)
	{
		$txtt = file_get_contents('data/member.txt');
		$membersidd= explode("\n",$txtt);
		$mmemcount = count($membersidd) -1;
{
sendmessage($chat_id,"`تعداد کل اعضای ربات :` $mmemcount");
}
}
elseif($textmessage == "خرید الماس 💎"){
sendMessage($chat_id,"`تا اطلاع ثانوی الماس به فروش نمیرسد` .");
}
elseif ($textmessage == "/panel" && $from_id == $admin){
var_dump(makereq('sendMessage',[
        'chat_id'=>$update->message->chat->id,
        'text'=>"`پنل مدیریت با موفقیت باز شد\nیکی از دکمه هارا انتخاب کنید :`",
        'parse_mode'=>'MarkDown',
        'reply_markup'=>json_encode([
            'keyboard'=>[
              [
                ['text'=>"ارسال الماس 💰"],['text'=>"کم کردن الماس 💎"]
              ],
			  [
			    ['text'=>"حذف محصول 🛒"],['text'=>"محصول جدید 🛒"]
			  ],
			  [
			  ['text'=>"فروارد همگانی ✅"],['text'=>"ساخت کد هدیه 🎁"]
          ],
          [
         ['text'=>"پیام همگانی 👥"],['text'=>"آمار 📊"]
			  ]
            ],
        ])
    ]));  
	}

elseif (strpos($textmessage,"/buy") !== false) {
  $id = str_replace("/buy","",$textmessage);
  if ($id == "") {
      SendMessage($chat_id,"`محصول در سیستم موجود نمیباشد ❎`");
  }
  else {
    if (file_exists("data/products/$id.txt")) {
      $product = file_get_contents("data/products/$id.txt");
      $array = explode("(******)",$product);
      $price = $array['3'];
      $coin = file_get_contents("data/users/$from_id/coin.txt");
      if ($coin >= $price) {
        $coin = file_get_contents("data/users/".$from_id."/coin.txt");
        settype($coin,"integer");
        $newcoin = $coin - $price;
        save("data/users/".$from_id."/coin.txt",$newcoin);
        SendMessage($chat_id,"محصول مورد نظر خریداری شد 💸");
        SendMessage($chat_id,"لینک دانلود محصول :
        ".$array['2']);
      }
      else {
        SendMessage($chat_id,"`شما الماس کافی ندارید ⛔\nتعداد الماس های شما :` $coin");
      }
    }
    else {
      SendMessage($chat_id,"`محصول در سیستم موجود نمیباشد ❎`");
    }
  }

}
elseif ($textmessage == "ارسال الماس 💰" && $from_id == $admin){
sendMessage($chat_id,"ادمین عزیز جهت اهدای سکه به کاربری از دستور زیر استفاده کنید
/addgem USERID COIN");
}
elseif ($textmessage == "ساخت کد هدیه 🎁" && $from_id == $admin){
sendMessage($chat_id,"برای ساخت کد هدیه از دستور زیر استفاده کنید :
/createcode CODE COIN");
}
elseif ($textmessage == "کم کردن الماس 💎" && $from_id == $admin){
sendMessage($chat_id,"ادمین عزیز جهت کم کردن سکه کاربری از دستور زیر استفاده کنید
/getcoin USERID COIN");
}
elseif ($textmessage == "حذف محصول 🛒" && $from_id == $admin){
sendMessage($chat_id,"ادمین عزیز جهت حذف یک محصول از دستور زیر استفاده کنید
/delpost PostId");
}
elseif (strpos($textmessage,"/getcoin") !== false && $from_id == $admin) {
  $text = explode(" ",$textmessage);
  if ($text['2'] != "" && $text['1'] != "") {
    $coin = file_get_contents("data/users/".$text['1']."/coin.txt");
    settype($coin,"integer");
    $newcoin = $coin - $text['2'];
    save("data/users/".$text['1']."/coin.txt",$newcoin);
    SendMessage($chat_id,"عملیات فوق با موفقیت انجام شد");
    SendMessage($text['1'],"ادمین از شما ".$text['2']." الماس کم کرد");
  }
  else {
    SendMessage($chat_id,"Syntax Error!");
  }
}
elseif (strpos($textmessage,"/delpost") !== false && $from_id == $admin) {
  $id = str_replace("/delpost ","",$textmessage);
  if (file_exists("data/products/$id.txt")) {
    $product = file_get_contents("data/products/$id.txt");
    $array = explode("(******)",$product);
    $title = $array['0'];
    unlink("data/products/$title.txt");
    unlink("data/products/$id.txt");
    SendMessage($chat_id,"محصول حذف شد");
  }
  else {
    SendMessage($chat_id,"محصول یافت نشد .");
  }
}
elseif (strpos($textmessage,"کد هدیه 🏆") !== false) {
  save("data/users/$from_id/step.txt","useCode");
var_dump(makereq('sendMessage',[
        'chat_id'=>$update->message->chat->id,
        'text'=>"`کد هدیه را ارسال کنید 💰 :`",
        'parse_mode'=>'MarkDown',
        'reply_markup'=>json_encode([
            'keyboard'=>[
              [
                ['text'=>"بازگشت"]
              ]
            ],
            'resize_keyboard'=>true
        ])
    ]));  
}
  //===============
  elseif($text == 'انتقال الماس 💎'){
  SendMessage($chat_id,"`تا اطلاع ثانوی غیر فعال میباشد .`");
  }
elseif (strpos($textmessage,"/createcode") !== false && $from_id == $admin) {
  $text = explode(" ",$textmessage);
  $code = $text['1'];
  $value = $text['2'];
  save("data/codes/$code.txt",$value);
  SendMessage("@$chnnl","
  کد جدید در ساعت $time و در تاریخ $date  ساخته شد👇
  هرکی زودتر کد زیر رو در ربات :\n@PBotShopBot\n بزنه اون برندست ☺️\nکد : $code \n تعداد الماس : $value\n@$chnnl");
}
elseif (strpos($textmessage,"/addgem") !== false && $from_id == $admin) {
  $text = explode(" ",$textmessage);
  if ($text['2'] != "" && $text['1'] != "") {
    $coin = file_get_contents("data/users/".$text['1']."/coin.txt");
    settype($coin,"integer");
    $newcoin = $coin + $text['2'];
    save("data/users/".$text['1']."/coin.txt",$newcoin);
    SendMessage($text['1'],"تعداد ".$text['2']." الماس به شما اضافه شد");
  }
  else {
    SendMessage($chat_id,"Syntax Error!");
  }
}

  //===============
  elseif($text == 'پشتیبانی 👤'){
  file_put_contents('data/users/'.$from_id."/command.txt","contact");
  SendMessage($chat_id,"`پیامتون رو در قالب یک متن ارسال کنید تا به دست پشتیبانی برسد :`
جهت لغو دستور :
/cancel
را ارسال کنید ➡");
  }
  elseif($command1 == 'contact'){
  if($text){
  file_put_contents('data/users/'.$from_id."/command.txt","none");
  SendMessage($chat_id,"پیام شما ثبت شد و بزودی جواب داده میشود ✅");
  if($from_username == null){
  $from_username = '---';
  }else{
  $from_username = "@$from_username";
  }
  SendMessage(136888679,"
کاربری با مشخصات : 
$from_id
$username
یک پیام به شما ارسال کرد ✅
متن پیام :
 $text");
  }else{
  SendMessage($chat_id,"`فقط متن میتوانید ارسال کنید ❎ .`");
  }
  }
  //===============
elseif($textmessage == "راهنما ⚠️"){
sendMessage($chat_id,"`راهنما ربات فروشگاه 💰 :\n شما با این ربات میتوانید محصولات با ارزش را هم به صورت پولی و هم به صورت رایگان دریافت کنید 💸\nشما برای خرید محصولات نیاز به الماس دارید که میتوانید با کلیک بر روی دکمه (خرید الماس 💎) الماس بخرید\nپول کافی برای خرید الماس ندارید؟\nمشکلی نیست میتوانید با کلیک بر روی دکمه (الماس رایگان 🎁) الماس را به صورت رایگان دریافت کنید ☺️`\n🆔 @$chnnl");
}
elseif($textmessage == "الماس رایگان 🎁"){
sendMessage($chat_id,"سلام 🙃\nبرای دریافت الماس رایگان ابتدا ما به شما یک لینک اختصاصی میدیم 😚\nو هر 1 نفری که با لینک شما وارد ربات شوند تعداد 1 الماس دریافت میکنید 💎\nلینک شما در پیام بعدی ارسال میشود ☺️");
}
if($textmessage == "الماس رایگان 🎁"){
sendMessage($chat_id,"`لینک شما :` [https://telegram.me/PBotShopBot?start=$from_id]️");
}
elseif($textmessage == "اطلاعات حساب 💰"){
sendMessage($chat_id,"تعداد الماس های شما 💰 : $coin");
}
else {
  if (file_exists("data/products/$textmessage.txt")) {
    $id = file_get_contents("data/products/$textmessage.txt");
    $product = file_get_contents("data/products/$id.txt");
    $array = explode("(******)",$product);

    SendMessage($chat_id,"`نام محصول 💸 :‌` ".$array['0']."

  `  توضیحات محصول 📝 :`
    ".$array['1']."

   ` قیمت :`‌ ".$array['3']." `الماس 💰`

`جهت لغو دستور` /cancel `را ارسال کنید ➡

    خرید محصول با دستور` : 🔨 /buy".$id);
  }
}unlink ("error_log");
?>
