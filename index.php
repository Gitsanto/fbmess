<?php
// parameters
$hubVerifyToken = 'TOKEN123456abcd';
$accessToken = "EAAQzbPp4H1kBAK5Xxgtvfa3TL73v1MdnLuMEn3ePeVuhIBuNxUebXTGZC3z6E9cIjVzE7Tu6VncSG8YUxux8lJyzGbbffCY8wo0o1mOByGhqJ77ZAnWiOM2lx6FVWeJ0W69tz1Il1LT418MkleqiQcGiWTiVLgsiZBkrIXiHgZDZD";

// check token at setup
if ($_REQUEST['hub_verify_token'] === $hubVerifyToken) {
  echo $_REQUEST['hub_challenge'];
  exit;
}

// handle bot's anwser
$input = json_decode(file_get_contents('php://input'), true);

$senderId = $input['entry'][0]['messaging'][0]['sender']['id'];
$messageText = $input['entry'][0]['messaging'][0]['message']['text'];


$answer = "I don't understand. Ask me 'hi'.";
if($messageText == "hi") {
    $answer = "Hello";
}

$response = [
    'recipient' => [ 'id' => $senderId ],
    'message' => [ 'text' => $answer ]
];
$ch = curl_init('https://graph.facebook.com/v2.6/me/messages?access_token='.$accessToken);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($response));
curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
curl_exec($ch);
curl_close($ch);

//based on http://stackoverflow.com/questions/36803518
