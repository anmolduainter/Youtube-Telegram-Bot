<?php

require('simple_html_dom.php');

function authenticate(){
	$webToken="302517024:AAGgrgOiESarNaMM8LoS6Ct-goVmJ3ircmc";
    $url="https://api.telegram.org/bot".$webToken;
	return $url;
}
function getMessage_id(){
	
	$url_a=authenticate();
	 $update=file_get_contents($url_a."/getupdates");
	 $updateArray=json_decode($update,TRUE);
	 $chat_id=$updateArray["result"][0]["message"]["chat"]["id"];
	 return $chat_id;
}
function getMessage_text(){
	
	 $url_a=authenticate();
	 $update=file_get_contents($url_a."/getupdates");
	 $updateArray=json_decode($update,TRUE);
	 $num=(sizeof($updateArray["result"]))-1;
	 $chat_text=$updateArray["result"][$num]["message"]["text"];
	 return $chat_text;
}

function getMessage_textDownload(){
	
	 $url_a=authenticate();
	 $update=file_get_contents($url_a."/getupdates");
	 $updateArray=json_decode($update,TRUE);
	 $num=(sizeof($updateArray["result"]))-2;
	 $chat_text=$updateArray["result"][$num]["message"]["text"];
	 return $chat_text;
}


function getUrl(){
	$chat_text_url=getMessage_text();
	$html=file_get_html('https://www.youtube.com/results?search_query='.str_replace(' ','+',$chat_text_url));
	return $html;
}

function getUrlDownload(){
	$chat_text_url=getMessage_textDownload();
	$html=file_get_html('https://www.youtube.com/results?search_query='.str_replace(' ','+',$chat_text_url));
	return $html;
}


function getVideoUrl(){
	$ol=getUrl()->find('h3.yt-lockup-title',0);
	$a=$ol->find('a.yt-uix-tile-link',0);
	$video_url=$a->href;
	$video_youtube='https://youtube.com'.$video_url;
	return $video_youtube;
}


function getVideoUrlDownload(){
	$ol=getUrlDownload()->find('h3.yt-lockup-title',0);
	$a=$ol->find('a.yt-uix-tile-link',0);
	$video_url=$a->href;
	$video_youtube='https://www.youtube.com'.$video_url;
	return $video_youtube;
}

function sendMessage(){
	
	if (getMessage_text()=='Hi'){
		 file_get_contents(authenticate()."/sendmessage?chat_id=".getMessage_id()."&text=Hi Sir Search For songs.....");
	}
	
	else if(getMessage_text()=='Y'){
		 file_get_contents(authenticate()."/sendmessage?chat_id=".getMessage_id()."&text=Getting url for download.....");
		 file_get_contents(authenticate()."/sendmessage?chat_id=".getMessage_id()."&text=".download());
	}
	else if(getMessage_text()=='N'){
		 file_get_contents(authenticate()."/sendmessage?chat_id=".getMessage_id()."&text=Okay Sir ...");
	}
	else{
    file_get_contents(authenticate()."/sendmessage?chat_id=".getMessage_id()."&text=".getVideoUrl());
	file_get_contents(authenticate()."/sendmessage?chat_id=".getMessage_id()."&text=Want to download (Y/N)");	
	}
	
	
}
function download(){
	$url="http://keepvid.com/?url=".getVideoUrlDownload();
	return $url;
}

sendMessage();

?>