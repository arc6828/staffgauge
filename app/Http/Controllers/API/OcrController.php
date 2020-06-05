<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\MyLog;
use App\Ocr;
use App\Location;
use App\Profile;
use App\Staffgauge;
//use App\Weather;
use App\LineMessagingAPI;
use App\GoogleCloudVision;

//use Google\Cloud\Vision\V1\ImageAnnotatorClient;
//use Google\Cloud\Vision\VisionClient;

use Intervention\Image\ImageManagerStatic as Image;
use Illuminate\Support\Facades\DB;


class OcrController extends Controller
{
        
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {        
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //SAVE LOG
        $requestData = $request->all();
        $data = [
            "title" => "Line : api/ocr",
            "content" => json_encode($requestData, JSON_UNESCAPED_UNICODE),
        ];
        MyLog::create($data);        
        
        //GET ONLY FIRST EVENT
        $event = $requestData["events"][0];
        //FIRST OR CREATE 
        if(isset($event["source"]["userId"] ))
        {
            $profile = Profile::firstOrCreate(
                [ 'lineid' => $event["source"]["userId"] ],
                [ 
                    'role'=>'guest', 
                    //'user_id'=>'', 
                    //'photo'=>'', 
                    //'newsletter'=>'no', 
                ]
            );
        }
        
        switch($event["type"]){
            case "message" : 
                $this->messageHandler($event);
                break;
            case "postback" : 
                $this->postbackHandler($event);
                break;
        }
    }

    public function messageHandler($event)
    {
        switch($event["message"]["type"]){
            case "image" :                 
                $this->imageHandler($event);
                break;
            case "location" :                 
                $this->locationHandler($event);
                break;
            case "text" :                 
                $this->textHandler($event);
                break;
        }   

    }

    public function textHandler($event)
    {
        
        $line = new LineMessagingAPI();
        switch( strtolower($event["message"]["text"]) )
        {     
            case "line quick reply" :            
                $line->replyToUser(null, $event, "quickReply");
                break;
            case "line newsletter" :        
                $profile = Profile::where('lineid',$event['source']['userId'])->first();         
                $data = ($profile->newsletter=="yes")? "เปิดการรับข่าวสาร" : "ไม่รับข่าวสาร" ;
                $line->replyToUser($data, $event, "newsletter");
                break;
            /*
            case "line weather now" :    
                $weather = Weather::orderBy('created_at', 'desc')->first();
                $data = "Weather Now : ".$weather->weather_bangkok. " อ้างอิงจาก http://weather.bangkok.go.th/radar/RadarAnimation.aspx";
                $line->replyToUser($data, $event, "text");
                break;
            */

            
        }   
    }


    public function imageHandler($event)
    {
        //LOAD REMOTE IMAGE AND SAVE TO LOCAL
        $line = new LineMessagingAPI();         
        $binary_data  = $line->getImageFromLine($event["message"]["id"]);                
        $filename = $this->random_string(50).".png";
        $new_path = storage_path('app/public/uploads/ocr/'.$filename);
        Image::make($binary_data)->save($new_path);
                        
        //ANALYSE IMAGE WITH GOOGLE VISION API
        $vision = new GoogleCloudVision();
        $detected_text = $vision->detectText($new_path);
        
        //CREATE OCR
        $data = [
            "title" => $detected_text['title'],
            "content" => $detected_text['content'],
            "numbers" => $detected_text['numbers'],
            "photo" => "uploads/ocr/".$filename,
            "user_id" => "1",  //ASSUME
            "lineid" => $event["source"]["userId"],
            //"staffgaugeid" => "1",
            //"locationid" => "1",
            "msgocrid" => $event["message"]["id"],
        ];
        $location = Location::where('lineid',$data['lineid'])
            ->whereDate('created_at', DB::raw('CURDATE()') )
            ->orderBy('created_at','desc')
            ->first();
        if($location)
        {
            //UPDATE STAFFGAUGE
            $data["staffgaugeid"] = $location->staffgaugeid;
            $data["locationid"] = $location->id;
            $ocr = Ocr::create($data);     
            //FINALLY REPLY TO USER      
            $line = new LineMessagingAPI();               
            $line->replyToUser($ocr, $event,"flex-image");
        }
        else
        {
            //NO UPDATE STAFFGAUGE 
            $ocr = Ocr::create($data);    
            
            //REQUEST FOR LOCATION
            $line = new LineMessagingAPI();             
            $line->replyToUser(null, $event, "quickReply-only-location");
        }     

    }

    public function random_string($length) {
        $key = '';
        $keys = array_merge(range(0, 9), range('a', 'z'));
    
        for ($i = 0; $i < $length; $i++) {
            $key .= $keys[array_rand($keys)];
        }
    
        return $key;
    }

    public function locationHandler($event)
    {
        //PREPARE DATA
        $data = [
            "address" => $event['message']['address'],
            "latitude" => $event['message']['latitude'],
            "longitude" => $event['message']['longitude'],
            "typegroup" => $event['source']['type'],
            "lineid" => $event['source']['userId'],
            "staffgaugeid" => 1, //ASSUME
            "user_id" => 1,     //ASSUME
            "msglocid" => $event['message']['id'],
        ];
        $data["staffgaugeid"] = $this->findNearestStaffgauge($data);
        //CREATE LOCATION        
        $location = Location::create($data);       

        //FINALLY REPLY TO USER                

        //CHECK ว่ามี OCR ของวันนี้ยังไม่ได้ใส่ Location / Staffgauge หรือไม่
        $ocrs = Ocr::where('lineid',$data['lineid'])
            ->whereDate('created_at', DB::raw('CURDATE()') )
            ->whereNull('staffgaugeid')            
            ->orderBy('created_at','desc')
            ->get();

        if(count( $ocrs ) == 0)
        {
            //NO NULL OCR    
            $line = new LineMessagingAPI();   
            $line->replyToUser($location,$event,"flex-location");
        }
        else
        {
            //OTHERWISE, THERE ARE SOME RECORD IS NULL AT STAFFGAUGE
            $newdata["staffgaugeid"] = $location->staffgaugeid;
            $newdata["locationid"] = $location->id;

            Ocr::where('lineid',$data['lineid'])
                ->whereDate('created_at', DB::raw('CURDATE()') )
                ->whereNull('staffgaugeid')            
                ->orderBy('created_at','desc')
                ->update($newdata);  
            $ocr = Ocr::where('lineid',$data['lineid'])
                ->whereDate('created_at', DB::raw('CURDATE()') )     
                ->orderBy('created_at','desc')
                ->first(); 
            //FINALLY REPLY TO USER          
            $line = new LineMessagingAPI();     
            $event['message']['id'] = $ocr->msgocrid;    
            $line->replyToUser($ocr,$event,"flex-image");
        }       
    }

    public function findNearestStaffgauge($data)
    {
        $staffgauges = Staffgauge::get();

        $nearest_staffgauge_id = null;
        $min_distance = null;

        foreach($staffgauges as $item)
        {
            $dLat = $item->latitudegauge - $data["latitude"];
            //echo "<br> dLat : {$dLat} , {$item->latitudegauge} , {$data["latitude"]}";
            $dLon = $item->longitudegauge - $data["longitude"];
            //echo "<br> dLat : {$dLon} , {$item->longitudegauge} , {$data["longitude"]}";
            $d = sqrt($dLat*$dLat + $dLon*$dLon);

            if($min_distance == null)
            {
                $nearest_staffgauge_id = $item->id;
                $min_distance = $d;
            }
            else if($d < $min_distance )
            {
                $nearest_staffgauge_id = $item->id;
                $min_distance = $d;
            }
            //echo "<br>Best : [{$nearest_staffgauge_id} , {$min_distance}] , Current : [{$item->id} , {$d}] ";
        }
        return $nearest_staffgauge_id;
    }

    

    

    public function postbackHandler($event)
    {
        
        $queryString = $event['postback']['data'];
        parse_str($queryString, $new_data);

        $new_data['type'] = isset($new_data['type']) ? $new_data['type'] : "";

        switch($new_data['type'])
        {
            case "newsletter" : 
                $this->newsletterUpdateHandler($event);
                break;
            default :
                $this->ocrUpdateHandler($event);
            
        }
    }   
    
    public function ocrUpdateHandler($event)
    {
        $queryString = $event['postback']['data'];
        parse_str($queryString, $new_data);

        // update title in ocr
        
        $ocr = Ocr::where('lineid', $new_data['lineid'])
                ->where('msgocrid', $new_data['msgocrid'])
                ->first();

        $ocr->title = $new_data['title'];        
        $ocr->save();        
        
        //REPLY
        //CREATE OCR
        $data = [
            "title" => $ocr->title,
            "content" => $ocr->content,
            "numbers" => $ocr->numbers,
            "photo" => $ocr->photo,
        ];
        //Ocr::create($data);

        //FINALLY REPLY TO USER         
        $event['message'] = ['id' => ''.$new_data['msgocrid'] ];
        $line = new LineMessagingAPI();   
        $line->replyToUser($ocr,$event, "flex-image");


    }

    public function newsletterUpdateHandler($event)
    {
        $queryString = $event['postback']['data'];
        parse_str($queryString, $new_data);

        // update newsletter in profile
        
        $profile = Profile::where('lineid', $event['source']['userId'])->first();

        $profile->newsletter = $new_data['value'];        
        $profile->save();        
        
        //REPLY
        //CREATE OCR
        $data = "";
        switch($new_data['value'])
        {
            case "yes" : 
                $data = "เริ่มต้นรับข่าวสาร ... ";
                /*
                $weather = Weather::orderBy('created_at', 'desc')->first();
                $data = "เริ่มต้นรับข่าวสาร ... ".$weather->weather_bangkok;
                */
                break;
            case "no" : 
                $data = "ยกเลิกการรับแจ้งข่าวสารเรียบร้อย";
                break;
        }
        //Ocr::create($data);

        //FINALLY REPLY TO USER         
        $line = new LineMessagingAPI();   
        $line->replyToUser($data,$event, "text");

    }




    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}