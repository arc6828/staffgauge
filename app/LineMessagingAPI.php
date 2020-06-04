<?php

namespace App;

//use Illuminate\Database\Eloquent\Model;

use Illuminate\Http\Request;
use App\MyLog;
use App\Ocr;
use App\Location;
use App\Staffgauge;
//use App\Weather;

use Google\Cloud\Vision\V1\ImageAnnotatorClient;
use Google\Cloud\Vision\VisionClient;

use Intervention\Image\ImageManagerStatic as Image;
use Illuminate\Support\Facades\DB;

class LineMessagingAPI //extends Model
{
    public $channel_access_token = "UZmfH2bLSKTKIAWNcQ+MJiIjtwiMyCCletK/OGjy0Ybe0EUOor2lN6CZcDKknPwaD4DX93T2MeI+ocBP6+tNcU/ORteuPvaORZIvKGg5x/1ZtpY5yyjH+xyAbqSe+5BUZbuUi+KSZ3WDC283ilfCfgdB04t89/1O/w1cDnyilFU=";
    
    public function replyToUser($data, $event, $message_type)
    {
        
        switch($message_type)
        {
            case "flex-image": 
                
                $ocr = $data;
                //$template_path = storage_path('../public/json/flexbubble-test.json');  
                $template_path = storage_path('../public/json/flexbubble-reply.json'); 
                //$template_path = storage_path('../public/json/text-reply.json');       
                $string_json = file_get_contents($template_path);
                $image_url = url('/storage')."/".$ocr->photo;

                //1
                $string_json = str_replace("<image>",$image_url,$string_json);
                //2
                $string_json = str_replace("<message_id>",$event["message"]["id"],$string_json);
                
                //3
                $string_json = str_replace("<content>","-",$string_json);
                
                //4
                $numbers = join(",",json_decode($ocr->numbers));
                if(empty($numbers)){ $numbers = "-";}
                $string_json = str_replace("<numbers>",$numbers,$string_json); 
                
                $string_json = str_replace("<title>",$ocr->title,$string_json); 
                    
                //5
                $n = $ocr->title;        
                if(is_numeric($n)){            
                    $levels = [$n-10,$n-5,$n+5,$n+10,$n-2,$n-4,$n-6,$n-8];
                }else{
                    $levels = ["-","-","-","-","-","-","-","-"];
                }
                $string_json = str_replace("<min0>",$levels[0],$string_json);
                $string_json = str_replace("<min1>",$levels[1],$string_json);
                $string_json = str_replace("<min2>",$levels[2],$string_json);
                $string_json = str_replace("<min3>",$levels[3],$string_json);
                $string_json = str_replace("<min4>",$levels[4],$string_json);
                $string_json = str_replace("<min5>",$levels[5],$string_json);
                $string_json = str_replace("<min6>",$levels[6],$string_json);
                $string_json = str_replace("<min7>",$levels[7],$string_json);
                
                //6
                $string_json = str_replace("<lineid>",$event["source"]["userId"],$string_json);
                //7
                $string_json = str_replace("<login>",$image_url,$string_json);
                //8
                $string_json = str_replace("<user_manual>",$image_url,$string_json);
                //9
                $string_json = str_replace("<msgocrid>",$event["message"]["id"],$string_json);
                //10
                $string_json = str_replace("<staffgauge_name>",$ocr->staffgauge->addressgauge." [{$ocr->staffgauge->id}]" ,$string_json);
                
                $messages = [ json_decode($string_json, true) ]; 
                break;
            case "flex-location": 
                $location = $data;
                $template_path = storage_path('../public/json/flexbubble-location-reply.json');   
                $string_json = file_get_contents($template_path);                
                //1
                $string_json = str_replace("<message_id>",$event["message"]["id"],$string_json);
                //2
                $string_json = str_replace("<address>",$location->address,$string_json);
                //3
                $string_json = str_replace("<latitude>",$location->latitude,$string_json);
                //4
                $string_json = str_replace("<longitude>",$location->longitude,$string_json);
                //5
                $string_json = str_replace("<staffgauge_name>",$location->staffgauge->addressgauge." [{$location->staffgauge->id}]" ,$string_json);
                //6
                $string_json = str_replace("<created_at>",$location->created_at,$string_json);
                $messages = [ json_decode($string_json, true) ]; 
                break;
            case "quickReply": 
                $template_path = storage_path('../public/json/quick-reply.json');   
                $string_json = file_get_contents($template_path);
                $messages = [ json_decode($string_json, true) ]; 
                break;
            case "quickReply-only-location": 
                $template_path = storage_path('../public/json/quick-reply-only-location.json');   
                $string_json = file_get_contents($template_path);
                $messages = [ json_decode($string_json, true) ]; 
                break;
                
            case "newsletter": 
                $template_path = storage_path('../public/json/flexbubble-newsletter.json');   
                $string_json = file_get_contents($template_path);
                $string_json = str_replace("<newsletter>",$data,$string_json);
                $messages = [ json_decode($string_json, true) ]; 
                break;
            case "text": 
                $template_path = storage_path('../public/json/text-reply.json');   
                $string_json = file_get_contents($template_path);
                $string_json = str_replace("<text>",$data,$string_json);
                $messages = [ json_decode($string_json, true) ]; 
                break;
        }        

        $body = [
            "replyToken" => $event["replyToken"],
            "messages" => $messages,
        ];

        $opts = [
            'http' =>[
                'method'  => 'POST',
                'header'  => "Content-Type: application/json \r\n".
                            'Authorization: Bearer '.$this->channel_access_token,
                'content' => json_encode($body, JSON_UNESCAPED_UNICODE),
                //'timeout' => 60
            ]
        ];
                            
        $context  = stream_context_create($opts);
        //https://api-data.line.me/v2/bot/message/11914912908139/content
        $url = "https://api.line.me/v2/bot/message/reply";
        $result = file_get_contents($url, false, $context);

        //SAVE LOG
        $data = [
            "title" => "https://api.line.me/v2/bot/message/reply",
            "content" => json_encode($result, JSON_UNESCAPED_UNICODE),
        ];
        MyLog::create($data);
        return $result;

    }

    public function pushToUser($data,$lineids, $message_type)
    {
        
        switch($message_type)
        {
            
            case "text": 
                $template_path = storage_path('../public/json/text-reply.json');   
                $string_json = file_get_contents($template_path);
                $string_json = str_replace("<text>",$data,$string_json);
                $messages = [ json_decode($string_json, true) ]; 
                break;
        }        

        $body = [
            "to" => $lineids,
            "messages" => $messages,
        ];

        $opts = [
            'http' =>[
                'method'  => 'POST',
                'header'  => "Content-Type: application/json \r\n".
                            'Authorization: Bearer '.$this->channel_access_token,
                'content' => json_encode($body, JSON_UNESCAPED_UNICODE),
                //'timeout' => 60
            ]
        ];
                            
        $context  = stream_context_create($opts);
        $url = "https://api.line.me/v2/bot/message/multicast";
        $result = file_get_contents($url, false, $context);

        //SAVE LOG
        $data = [
            "title" => "https://api.line.me/v2/bot/message/multicast",
            "content" => json_encode($result, JSON_UNESCAPED_UNICODE),
        ];
        MyLog::create($data);
        return $result;

    }

    public function getImageFromLine($id){
        $opts = array('http' =>[
                'method'  => 'GET',
                //'header'  => "Content-Type: text/xml\r\n".
                'header' => 'Authorization: Bearer '.$this->channel_access_token,
                //'content' => $body,
                //'timeout' => 60
            ]
        );
                            
        $context  = stream_context_create($opts);
        //https://api-data.line.me/v2/bot/message/11914912908139/content
        $url = "https://api-data.line.me/v2/bot/message/{$id}/content";
        $result = file_get_contents($url, false, $context);
        return $result;
    }

    
}
