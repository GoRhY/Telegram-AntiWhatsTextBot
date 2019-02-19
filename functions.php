<?php
$included_files = get_included_files();
if (count($included_files)==1){
	header('Content-Type: text/html; charset=UTF-8');
}
date_default_timezone_set('Europe/Madrid');

function send($url){
	echo $url;
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
	$output = curl_exec($ch);
	curl_close($ch);
	return $output;
}

function sendMessage($text,$chat_id,$options=array("")){
	$defaults = ['parse_mode' => 'html'];
	$params = array_merge($defaults, $options);
	$url = 'https://api.telegram.org/bot' . BOT_ID. '/sendMessage?text='.urlencode($text).'&chat_id='.$chat_id.'&'.http_build_query($params);
	return send($url);
}

function deleteMessage($chat_id,$message_id,$options=array("")){
	$defaults = ['parse_mode' => 'html'];
	$params = array_merge($defaults, $options);
	$url = 'https://api.telegram.org/bot' . BOT_ID. '/deleteMessage?&chat_id='.$chat_id.'&message_id='.$message_id.'&'.http_build_query($params);
	return send($url);
}

function checkMessage($text,$chat_id,$message_id){
	if ((substr($text,0,8)=="Video de")||(substr($text,0,7)=="Foto de")||(substr($text,0,10)=="Photo from")||(substr($text,0,10)=="Video from")||(substr($text,0,12)=="Screenshot (")){
		deleteMessage($chat_id,$message_id);
	}
}

function leaveChat($chat_id){
	$url = 'https://api.telegram.org/bot' . BOT_ID . '/leaveChat?chat_id='.$chat_id;
	return send($url);
}
?>