<?php

require_once __DIR__ . '/vendor/autoload.php';

$bot = new \TelegramBot\Api\BotApi('316747810:AAFhNhL5dhAkDHmj0b7fkCl6zxiTe2hj6hU');

$response = file_get_contents('php://input');
$update = json_decode($response, true);

$chatId = $update["message"]["chat"]["id"];

$text = $update["message"]["text"];

if (preg_match('/\/start/', $text)) {
    $bot->setWebhook('https://ecb11ae0.ngrok.io');
    $message = 'Hi! What do I have to count? Please write your expression and press ENTER. For example "3+5"';
    $bot->sendMessage($chatId, $message);
    return;
}

if (preg_match('/[a-zA-Zа-яА-Я\[\]\{\}]+/', $text)) {
    $message = 'Enter the expression correctly. For example "3+5"';
    $bot->sendMessage($chatId, $message);
    return;
}

$text = preg_replace('/[\s!?:…_=]+/', '', $text);
eval('$result = '.$text.';');

$bot->sendMessage($chatId, $result);

//$keyboard = new \TelegramBot\Api\Types\ReplyKeyboardMarkup(
//    [
//        ['7', '8', '9', '+'],
//        ['4', '5', '6', '-'],
//        ['1', '2', '3', '*'],
//        ['0', '.', '=', '/'],
//    ],
//    true,
//    true
//);

//$bot->sendMessage($chatId, $h, false, null, null, $keyboard, true);