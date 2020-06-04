<?php

namespace App;

use Illuminate\Http\Request;
use App\MyLog;
use App\Ocr;
use App\Location;
use App\Staffgauge;
use App\LineMessagingAPI;

use Google\Cloud\Vision\V1\ImageAnnotatorClient;
use Google\Cloud\Vision\VisionClient;

use Intervention\Image\ImageManagerStatic as Image;
use Illuminate\Support\Facades\DB;

//use Illuminate\Database\Eloquent\Model;

class GoogleCloudVision //extends Model
{
    public function detectText($path)
    {
        //https://onlinelearningportal.website/google-vision-api-implementation-with-laravel-5-8/
        
        //CALL GOOGLE VISION OBJECT AND DO TEXT DETECTION
        $key_path = storage_path('../public/CKartisan-c6f07fc70d07.json');
        $vision = new VisionClient(['keyFile' => json_decode(file_get_contents($key_path), true)]);         
        $image = $vision->image(file_get_contents($path), [ 'TEXT_DETECTION' ] );        
        $result = $vision->annotate($image);
        //print_r($result); exit;
        $texts = $result->text();

        //FIND OUT WATER LEVEL
        $title = "-";
        $description=[];
        $numbers=[];
        $first = true;
        if($texts){
            foreach($texts as $key=>$text)
            {
                if($first) {$first = false; continue;}
                $description[]=$text->description();
                //GET CLEAN DATA 
                $temp = $this->cleanNumber($text->description());
                //ถ้าได้ตัวเลขน้อยกว่าเดิม ให้บันทึก
                if($temp){
                    /*
                    if($title){
                        if($temp < $title){
                            $title = $temp;
                        }
                    }else{
                        $title = $temp;
                    }
                    */
                    $title = $temp;
                    $numbers[] = $temp;
                }
            }
        }
        return [
            "title" => $title,
            "content" => json_encode($description, JSON_UNESCAPED_UNICODE ),
            "numbers" => json_encode($numbers, JSON_UNESCAPED_UNICODE ),
        ];
        // fetch text from image //
        //print_r($description);    

    }

    public function cleanNumber($text)
    {
        //REMOVE E
        $text = str_replace("E","",$text);
        //REMOVE .
        $text = str_replace(".","",$text);
        //REMOVE SPACEBAR
        $text = str_replace(" ","",$text);
        //CONVERT to float
        $number = floatval($text);
        if($number){
            return $number;
            //CONVERT to int
            $number = intval($number);
            if($number){
                //divisible with 10 but not 0
                if($number % 10 == 0){
                    return $number;
                }
            }            
        }        
        return false;
    }
}
