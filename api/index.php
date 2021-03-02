<?php
require_once 'Bot.php';

header('content-type: application/json');
$token = $_REQUEST['token'] ?? null;
$fun = $_REQUEST['fun'] ?? "sendMessage";
$message = $_REQUEST['message'] ?? '';
$photo = $_REQUEST['photo'] ?? '';
$caption = $_REQUEST['caption'] ?? '';
$parse_mode = $_REQUEST['parse_mode'] ?? '';
$disable_web_page_preview = $_REQUEST['disable_web_page_preview'] ?? False;
$disable_notification = $_REQUEST['disable_notification'] ?? False;
$reply_to_message_id = $_REQUEST['reply_to_message_id'] ?? 0;

$bot = new Bot();

if (is_null($token)) {
    echo json_encode(['code' => 422, 'message' => 'token 不能为空']);
} else {
	$chat_id = $bot->decryption($token);
	switch ($fun) {
		case "sendMessage":
			// 发送消息
			$ret = $bot->sendMessage(['text' => $message, 'parse_mode' => $parse_mode,'disable_web_page_preview' => $disable_web_page_preview,'disable_notification' => $disable_notification,'reply_to_message_id' => $reply_to_message_id,'chat_id' => $chat_id]);
			if ($ret['ok']) {
				echo json_encode(['code' => 200, 'message' => 'success']);
			} else {
				echo json_encode(['code' => 422, 'message' => $ret['description']]);
			}
			break;
		case "sendPhoto":
			//发图
			$ret = $bot->sendPhoto(['parse_mode' => $parse_mode, 'caption' => $caption, 'photo' => $photo, 'chat_id' => $chat_id]);
			if ($ret['ok']) {
				echo json_encode(['code' => 200, 'message' => 'success']);
			} else {
				echo json_encode(['code' => 422, 'message' => $ret['description']]);
			}
			break;
		}
}