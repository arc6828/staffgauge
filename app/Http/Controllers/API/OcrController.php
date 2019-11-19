<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Ocr;

class OcrController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $requestData = $request->all();        
        $text = json_encode( $requestData, JSON_UNESCAPED_UNICODE );
        Ocr::create(["content"=>$text,"user_id"=>1]);
        return  "{'status':'success'}";

        $requestData = $request->all();
        if ($request->hasFile('photo')) {
            $requestData['photo'] = $request->file('photo')
                ->store('uploads/ocr', 'public');

            //FOR OCR 

            $path = storage_path('app/public/'.$requestData['photo']);
            //echo $path;
            $detected_text = $this->detect_text($path);

            $requestData['title'] = $detected_text['title'];
            $requestData['content'] = $detected_text['content'];
            $requestData['user_id'] = Auth::user()->id;

        }
        Ocr::create($requestData);

        return redirect('ocr')->with('flash_message', 'Ocr added!');
    }


    /*public function store2(Request $request)
    {
        $requestData = $request->all();        
        $text = jsonjson_encode( $requestData, JSON_UNESCAPED_UNICODE );
        Ocr::create(["content"=>$text,"user_id"=>1]);
        //return "{'status':'success'}";
        //return redirect('ocr/lineoa');
    }*/

    function detect_text($path)
    {
        //https://onlinelearningportal.website/google-vision-api-implementation-with-laravel-5-8/
        $key_path = storage_path('../public/CKartisan-c6f07fc70d07.json');
        $vision = new VisionClient(['keyFile' => json_decode(file_get_contents($key_path), true)]); 
        
        $image = $vision->image(file_get_contents($path), 
        [
            'TEXT_DETECTION'
        ]);
        
        $result = $vision->annotate($image);
        //print_r($result); exit;
        $texts = $result->text();
        $title = null;
        $description=[];
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
                    if($title){
                        if($temp < $title){
                            $title = $temp;
                        }
                    }else{
                        $title = $temp;
                    }
                }

                //echo $text->description() ;
                //print_r($text->info());
                /*$bounds = [];
                foreach ($text->boundingPoly()['vertices'] as $vertex) {
                    $bounds[] = sprintf('(%d,%d)', $vertex['x'], $vertex['y']);
                }
                print('Bounds: ' . join(', ',$bounds) . PHP_EOL);*/
                //echo "<br>";
            }
        }
        return [
            "title" => $title,
            "content" => json_encode($description, JSON_UNESCAPED_UNICODE ),
        ];
        // fetch text from image //
        //print_r($description);    

    }

    function cleanNumber($text){
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
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
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