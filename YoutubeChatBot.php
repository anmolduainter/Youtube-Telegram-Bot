<?php

     require('simple_html_dom.php');
    
	$loading=TRUE;
    $i=0;    
	$webToken="302517024:AAGgrgOiESarNaMM8LoS6Ct-goVmJ3ircmc";
     $url="https://api.telegram.org/bot".$webToken;
	// while(true){

	
     $update=file_get_contents($url."/getupdates");
	 $updateArray=json_decode($update,TRUE);
	 $chat_id=$updateArray["result"][0]["message"]["chat"]["id"];
	 $num=(sizeof($updateArray["result"]))-1;
	 $chat_text=$updateArray["result"][$num]["message"]["text"];
	 
	 
	 $html = file_get_html('https://www.youtube.com/results?search_query='.str_replace(' ','+',$chat_text));
 
   // creating an array of elements
   $videos = [];
 
   // Find top ten videos
   $i = 1;
   $ol=$html->find('ol.item-section',0);
   foreach ($ol->find('li') as $video) {
        if ($i > 2) {
                break;
        }
 
        // Find item link element 
        $videoDetails = $video->find('a.yt-uix-tile-link', 0);
 
        // get title attribute
      //  $videoTitle = $videoDetails->title;
 
        // get href attribute
        $videoUrl = 'https://youtube.com' . $videoDetails->href;
 
        // push to a list of videos
        $videos[] = [
        //        'title' => $videoTitle,
                'url' => $videoUrl
        ];
 
        $i++;
   }
	 
	file_get_contents($url."/sendmessage?chat_id=".$chat_id."&text=".implode("",$videos[0]));

    file_get_contents($url."/sendmessage?chat_id=".$chat_id."&text=".implode("",$videos[1]));
	 
	

    // print_r($chat_text);
//	 print_r(sizeof($updateArray["result"]));
	// print_r($updateArray);
	var_dump($videos);
	// }

?>
