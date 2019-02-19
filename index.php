<?php
date_default_timezone_set('Europe/Madrid');
define("BOT_ID", "");
include("functions.php");
$result = file_get_contents("php://input");
if ($result){
	$update = json_decode($result, true);
	if (!empty($update)){
		if ($update["message"]["chat"]["type"]=="group"){ //GROUP
			$group_id = $update["message"]["chat"]["id"];
			$message_id = $update["message"]["message_id"];
			$text = $update["message"]["text"];
			checkMessage($text,$group_id,$message_id);
		}else if ($update["message"]["chat"]["type"]=="supergroup"){ //SUPERGROUP/CHANNEL
			$group_id = $update["message"]["chat"]["id"];
			$message_id = $update["message"]["message_id"];
			$text = $update["message"]["text"];
			checkMessage($text,$group_id,$message_id);
		}else if ($update["message"]["chat"]["type"]=="private"){ //CHAT
			$now = strtotime("now");
			$chat_id = $update["message"]["chat"]["id"];
			$message_id = $update["message"]["message_id"];
			$text = $update["message"]["text"];
			sendMessage("Este bot sirve para borrar los mensajes (EN GRUPOS, requiere permisos de borrado de texto) que se generan automáticamente al compartir algún vídeo o foto desde Whatsapp",$chat_id);
		}else if ($update["channel_post"]){ //CHANNEL
				$channel_id = $update["channel_post"]["chat"]["id"];
				leaveChat($channel_id);
		}
	}
}
?>