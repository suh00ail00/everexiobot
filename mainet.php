<?php

$botToken = "539071427:AAEfOiV9qsACwXciK2MpPOSPaO8De3BMrGk";
$website = "https://api.telegram.org/bot".$botToken;

$update = file_get_contents('php://input');
$update = json_decode($update, TRUE);

//CHAT DETAILS
$chatId = $update["message"]["chat"]["id"];
$from = $update["message"]["from"]["id"];
$message = $update["message"]["text"];

$askid = substr($message, 1);
$askcase = "/".$askid;

//FAQ'S LIST UPDATE
$data = file_get_contents('faqs.txt');
$faqs = json_decode($data, TRUE);
$faqlist = "";

foreach ($faqs['faqs'] as $faq) {
  $faqid = $faq['id'];
  $question = $faq['question'];
  $answer = $faq['answer'];

  $faqlist = $faqlist."/".$faqid." ".$question."\n";

  if ($faqid == $askid) {
    $faqanswer = "<b>".$question."</b>\n".$answer;
  }
}

switch($message) {
        case "/start":
        case "/start@everexiobot":
                sendMessage($chatId, "Get /faq");
                break;
        case "/faq":
        case "/faq@everexiobot":
                sendMessage($chatId, "<b>FAQ's List</b>\n".$faqlist);
                break;
        case $askcase:
                sendMessage($chatId, "\n".$faqanswer);
                break;
}

function sendMessage ($chatId, $message) {

        $url = $GLOBALS[website]."/sendMessage?chat_id=".$chatId."&parse_mode=html&text=".urlencode($message);
        file_get_contents($url);

}
