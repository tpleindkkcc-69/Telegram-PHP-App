<?php

ini_set('error_reporting', E_ALL);

$botToken = "1526063655:AAE-i4rZKL_99ZuBLZ01h58e2KWF8GIlOoA";
$website = "https://api.telegram.org/bot".$botToken;

$update = file_get_contents('php://input');
$update = json_decode($update, TRUE);

$chatId = $update["message"]["chat"]["id"];
$username = $update["message"]["from"]["username"];
$message = $update["message"]["text"]; 
$message_id = $update["message"]["message_id"];

if (strpos($message, "/start") === 0){
sendMessage($chatId, 
"🦇 HEYYY ! 🦇 
TYPE /cmds TO KNOW ALL MY COMMANDS 
BOT FOR CC MADE BY => 🦇 @tplein_dkk_cc 🦇 ", $message_id);
}

//////////=========[Cmds Command]=========//////////

elseif (strpos($message, "/cmds") === 0){
sendMessage($chatId, 
"🦇 COMMANDS 🦇
/b3 => braintreeChecker
/st => stripeChecker
/bin => binInfo", $message_id);
}


/*elseif (strpos($message, "/b3") === 0){
sendMessage($chatId, 
            "🦇 HEY ! 🦇
 this COMMANDS is currently in maintenance
               COME BACK LATER ", $message_id);
}

elseif (strpos($message, "/st") === 0){
sendMessage($chatId, 
            "🦇 HEY ! 🦇
 this COMMANDS is currently in maintenance
               COME BACK LATER ", $message_id);
}*/


elseif (strpos($message, "/bin") === 0){
$bin = substr($message, 5);
function GetStr($string, $start, $end){
$str = explode($start, $string);
$str = explode($end, $str[1]);  
return $str[0];
};
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, 'https://lookup.binlist.net/'.$bin.'');
curl_setopt($ch, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
'Host: lookup.binlist.net',
'Cookie: _ga=GA1.2.549903363.1545240628; _gid=GA1.2.82939664.1545240628',
'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,image/apng,*/*;q=0.8'));
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, '');
$fim = curl_exec($ch);
$bank = GetStr($fim, '"bank":{"name":"', '"');
$name = GetStr($fim, '"name":"', '"');
$brand = GetStr($fim, '"brand":"', '"');
$country = GetStr($fim, '"country":{"name":"', '"');
$scheme = GetStr($fim, '"scheme":"', '"');
$type = GetStr($fim, '"type":"', '"');
if(strpos($fim, '"type":"credit"') !== false){
$bin = 'Credit';
}else{
$bin = 'Debit';
};
sendMessage($chatId, '
╭╴ 🦇 VALID BIN 🦇 
|BANK => '.$bank.'  
|COUNTRY => '.$name.' 
|BRAND => '.$brand.'
|CARD => '.$scheme.'
|TYPE => '.$type.'
└BOT MADE by => 🦇 @tplein_dkk_cc 🦇', $message_id);
}

///////======[1REQ STRIPE FOR BOT]======///////

elseif (strpos($message, "/chk") === 0){
$lista = substr($message, 6);
$i     = explode("|", $lista);
$cc    = $i[0];
$mon    = $i[1];
$year  = $i[2];
$cvv   = $i[3];

error_reporting(0);
date_default_timezone_set('Asia/Jakarta');

if ($_SERVER['REQUEST_METHOD'] == "POST"){
extract($_POST);
}
elseif ($_SERVER['REQUEST_METHOD'] == "GET"){
extract($_GET);
}

function GetStr($string, $start, $end){
$str = explode($start, $string);
$str = explode($end, $str[1]);
return $str[0];
};

///////////////////////////////////////////////////////////////////////////////////////////////////////////////

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, 'https://lookup.binlist.net/'.$cc.'');
curl_setopt($ch, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
'Host: lookup.binlist.net',
'Cookie: _ga=GA1.2.549903363.1545240628; _gid=GA1.2.82939664.1545240628',
'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,image/apng,*/*;q=0.8'));
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, '');
$fim = curl_exec($ch);
$bank = GetStr($fim, '"bank":{"name":"', '"');
$name = GetStr($fim, '"name":"', '"');
$brand = GetStr($fim, '"brand":"', '"');
$country = GetStr($fim, '"country":{"name":"', '"');
$scheme = GetStr($fim, '"scheme":"', '"');
$type = GetStr($fim, '"type":"', '"');
if(strpos($fim, '"type":"credit"') !== false){
$bin = 'Credit';
}else{
$bin = 'Debit';
};

///////////////////////////////////////////////////////////////////////////////////////////////////////////////

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, '');
curl_setopt($ch, CURLOPT_HEADER, 0);
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
''));
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
curl_setopt($ch, CURLOPT_COOKIEFILE, getcwd().'/cookie.txt');
curl_setopt($ch, CURLOPT_COOKIEJAR, getcwd().'/cookie.txt');
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS,  '');
$result = curl_exec($ch);

//////////////////////////////////////////////////////////////////////////////////////////////////////////////

if(strpos($result, '')){ //PUT RESPONSE OF YOUR SITE FOR LIVE CC
sendMessage($chatId, "
╭╴CARD ==> $lista
|STATUS ==> ✅ LIVE CVV ✅
|RESPONSE ==> SUCCESSFULLY CHARGED 
|BANK ==> $bank
|COUNTRY ==> $country
|BRAND ==> $brand
|CARD ==> $scheme
|TYPE ==> $type
|CHECKED BY ==> @$username
└BOT DEVELOPED BY 🦇 @tplein_dkk_cc 🦇", $message_id);
}
elseif (strpos($result, "")){
sendMessage($chatId, "
╭╴CARD ==> $lista
|STATUS ==> ✅ LIVE CCN ✅
|RESPONSE ==> INCORRECT_CVC 
|BANK ==> $bank
|COUNTRY ==> $country
|BRAND ==> $brand
|CARD ==> $scheme
|TYPE ==> $type
|CHECKED BY ==> @$username
└BOT DEVELOPED BY 🦇 @tplein_dkk_cc 🦇", $message_id);
}
elseif (strpos($result, "")){
sendMessage($chatId, "
╭╴CARD ==> $lista
|STATUS ==> ❌ DECLINED ❌
|RESPONSE ==> DECLINED 
|BANK ==> $bank
|COUNTRY ==> $country
|BRAND ==> $brand
|CARD ==> $scheme
|TYPE ==> $type
|CHECKED BY ==> @$username
└BOT DEVELOPED BY 🦇 @tplein_dkk_cc 🦇", $message_id);
}
elseif (strpos($result, "")){
sendMessage($chatId, "
╭╴CARD ==> $lista
|STATUS ==> ❌ EXPIRED CARD ❌
|RESPONSE ==> EXPIRED_CARD 
|BANK ==> $bank
|COUNTRY ==> $country
|BRAND ==> $brand
|CARD ==> $scheme
|TYPE ==> $type
|CHECKED BY ==> @$username
└BOT DEVELOPED BY 🦇 @tplein_dkk_cc 🦇", $message_id);
}
elseif (strpos($result, "")){
sendMessage($chatId, "
╭╴CARD ==> $lista
|STATUS ==> ❌ DO NOT HONOR ❌
|RESPONSE ==> DO_NOT_HONOR 
|BANK ==> $bank
|COUNTRY ==> $country
|BRAND ==> $brand
|CARD ==> $scheme
|TYPE ==> $type
|CHECKED BY ==> @$username
└BOT DEVELOPED BY 🦇 @tplein_dkk_cc 🦇", $message_id);
}
elseif (strpos($result, "")){
sendMessage($chatId, "
╭╴CARD ==> $lista
|STATUS ==> ❌ INCORRECT NUMBER ❌
|RESPONSE ==> INCORRECT_NUMBER 
|BANK ==> $bank
|COUNTRY ==> $country
|BRAND ==> $brand
|CARD ==> $scheme
|TYPE ==> $type
|CHECKED BY ==> @$username
└BOT DEVELOPED BY 🦇 @tplein_dkk_cc 🦇", $message_id);
}
else{
sendMessage($chatId, "
╭╴CARD ==> $lista
|STATUS ==> ❌ ERROR ❌
|RESPONSE ==> NOT LISTED 
|BANK ==> $bank
|COUNTRY ==> $country
|BRAND ==> $brand
|CARD ==> $scheme
|TYPE ==> $type
|CHECKED BY ==> @$username
└BOT DEVELOPED BY 🦇 @tplein_dkk_cc 🦇", $message_id);
};

curl_close($ch);
}


///////======[2REQ BRAINTREE FOR BOT]======///////

elseif (strpos($message, "/b3") === 0){
$lista = substr($message, 6);
$i     = explode("|", $lista);
$cc    = $i[0];
$mon    = $i[1];
$year  = $i[2];
$cvv   = $i[3];

error_reporting(0);
date_default_timezone_set('Asia/Jakarta');

if ($_SERVER['REQUEST_METHOD'] == "POST"){
extract($_POST);
}
elseif ($_SERVER['REQUEST_METHOD'] == "GET"){
extract($_GET);
}

function GetStr($string, $start, $end){
$str = explode($start, $string);
$str = explode($end, $str[1]);
return $str[0];
};

///////////////////////////////////////////////////////////////////////////////////////////////////////////////

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, 'https://lookup.binlist.net/'.$cc.'');
curl_setopt($ch, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
'Host: lookup.binlist.net',
'Cookie: _ga=GA1.2.549903363.1545240628; _gid=GA1.2.82939664.1545240628',
'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,image/apng,*/*;q=0.8'));
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, '');
$fim = curl_exec($ch);
$bank = GetStr($fim, '"bank":{"name":"', '"');
$name = GetStr($fim, '"name":"', '"');
$brand = GetStr($fim, '"brand":"', '"');
$country = GetStr($fim, '"country":{"name":"', '"');
$scheme = GetStr($fim, '"scheme":"', '"');
$type = GetStr($fim, '"type":"', '"');
if(strpos($fim, '"type":"credit"') !== false){
$bin = 'Credit';
}else{
$bin = 'Debit';
};

///////////////////////////////////////////////////////////////////////////////////////////////////////////////
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, '');
curl_setopt($ch, CURLOPT_HEADER, 0);
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
''));
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
curl_setopt($ch, CURLOPT_COOKIEFILE, getcwd().'/cookie.txt');
curl_setopt($ch, CURLOPT_COOKIEJAR, getcwd().'/cookie.txt');
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS,  '');
$result1 = curl_exec($ch);
$token = trim(strip_tags(getStr($result1,'{"token":"','"')));

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, '');
curl_setopt($ch, CURLOPT_HEADER, 0);
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
''));
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
curl_setopt($ch, CURLOPT_COOKIEFILE, getcwd().'/cookie.txt');
curl_setopt($ch, CURLOPT_COOKIEJAR, getcwd().'/cookie.txt');
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS,  '');
$result = curl_exec($ch);

//////////////////////////////////////////////////////////////////////////////////////////////////////////////

if(strpos($result, '')){ //PUT RESPONSE OF YOUR SITE FOR LIVE CC
sendMessage($chatId, "
╭╴CARD ==> $lista
|STATUS ==> ✅ LIVE CVV ✅
|RESPONSE ==> [CVV2] : [M]
|BANK ==> $bank
|COUNTRY ==> $country
|BRAND ==> $brand
|CARD ==> $scheme
|TYPE ==> $type
|CHECKED BY ==> @$username
└BOT DEVELOPED BY 🦇 @tplein_dkk_cc 🦇", $message_id);
}
elseif (strpos($result, "")){
sendMessage($chatId, "
╭╴CARD ==> $lista
|STATUS ==> ✅ LIVE CCN ✅
|RESPONSE ==> Card Issuer Declined CVV => 2010
|BANK ==> $bank
|COUNTRY ==> $country
|BRAND ==> $brand
|CARD ==> $scheme
|TYPE ==> $type
|CHECKED BY ==> @$username
└BOT DEVELOPED BY 🦇 @tplein_dkk_cc 🦇", $message_id);
}
elseif (strpos($result, "")){
sendMessage($chatId, "
╭╴CARD ==> $lista
|STATUS ==> ❌ DECLINED ❌
|RESPONSE ==> Declined => 2046
|BANK ==> $bank
|COUNTRY ==> $country
|BRAND ==> $brand
|CARD ==> $scheme
|TYPE ==> $type
|CHECKED BY ==> @$username
└BOT DEVELOPED BY 🦇 @tplein_dkk_cc 🦇", $message_id);
}
elseif (strpos($result, "")){
sendMessage($chatId, "
╭╴CARD ==> $lista
|STATUS ==> ❌ EXPIRED CARD ❌
|RESPONSE ==> Expired Card => 2004
|BANK ==> $bank
|COUNTRY ==> $country
|BRAND ==> $brand
|CARD ==> $scheme
|TYPE ==> $type
|CHECKED BY ==> @$username
└BOT DEVELOPED BY 🦇 @tplein_dkk_cc 🦇", $message_id);
}
elseif (strpos($result, "")){
sendMessage($chatId, "
╭╴CARD ==> $lista
|STATUS ==> ❌ DO NOT HONOR ❌
|RESPONSE ==> Do Not Honor 
|BANK ==> $bank
|COUNTRY ==> $country
|BRAND ==> $brand
|CARD ==> $scheme
|TYPE ==> $type
|CHECKED BY ==> @$username
└BOT DEVELOPED BY 🦇 @tplein_dkk_cc 🦇", $message_id);
}
elseif (strpos($result, "")){
sendMessage($chatId, "
╭╴CARD ==> $lista
|STATUS ==> ❌ INCORRECT NUMBER ❌
|RESPONSE ==> Invalid Credit Card Number => 2005
|BANK ==> $bank
|COUNTRY ==> $country
|BRAND ==> $brand
|CARD ==> $scheme
|TYPE ==> $type
|CHECKED BY ==> @$username
└BOT DEVELOPED BY 🦇 @tplein_dkk_cc 🦇", $message_id);
}
elseif (strpos($result, "")){
sendMessage($chatId, "
╭╴CARD ==> $lista
|STATUS ==> ❌ TRANSACTION NOT ALLOWED ❌
|RESPONSE ==> Transaction Not Allowed => 2015
|BANK ==> $bank
|COUNTRY ==> $country
|BRAND ==> $brand
|CARD ==> $scheme
|TYPE ==> $type
|CHECKED BY ==> @$username
└BOT DEVELOPED BY 🦇 @tplein_dkk_cc 🦇", $message_id);
}
else{
sendMessage($chatId, "
╭╴CARD ==>       $lista
|STATUS ==> ❌ ERROR ❌
|RESPONSE ==> Not Listed 
|BANK ==> $bank
|COUNTRY ==> $country
|BRAND ==> $brand
|CARD ==> $scheme
|TYPE ==> $type
|CHECKED BY ==> @$username
└BOT DEVELOPED BY 🦇 @tplein_dkk_cc 🦇", $message_id);
};

curl_close($ch);
}


function sendMessage ($chatId, $message) {

	$url = $GLOBALS[website]."/sendMessage?chat_id=".$chatId."&text=".urlencode($message);
	file_get_contents($url);
}

?>
