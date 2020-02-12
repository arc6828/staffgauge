<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Auth;
use App\Profile;
use App\User;
use App\Ocr;
use Illuminate\Http\Request;
use Google\Cloud\Vision\VisionClient;

use Intervention\Image\ImageManagerStatic as Image;


class OcrController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        

        // Automatically generate a unique ID for file name...
        /*$path = 'https://i.stack.imgur.com/koFpQ.png';
            $filename = basename($path);
            $requestData['photo'] = storage_path('app/public/uploads/ocr/'.$filename);
            Image::make($path)->save($requestData['photo']);*/
/*
            $path = "https:\/\/firebasestorage.googleapis.com\/v0\/b\/royalirrigationfb.appspot.com\/o\/U239469c374d4e2337bbc5b4925938af8%2F10993624191976.jpg?alt=media&token=c7951209-1387-4eed-981e-919c86e82100";
            $path = str_replace("\/","/", $path);
            $new_path = storage_path('app/public/uploads/test.jpg');
            Image::make($path)->save($new_path);
            */
            //$requestData['photo'] = str_replace("\/","/", $requestData['photo']);

        $keyword = $request->get('search');
        $perPage = 25;

        switch(Auth::user()->profile->role){
            case "admin" : //FOR ADMIN SEE ALL
                if (!empty($keyword)) {
                    $ocr = Ocr::where('title', 'LIKE', "%$keyword%")
                        ->orWhere('staffgaugeid', 'LIKE', "%$keyword%")
                        ->orWhere('locationid', 'LIKE', "%$keyword%")
                        ->orWhere('content', 'LIKE', "%$keyword%")
                        ->orWhere('user_id', 'LIKE', "%$keyword%")
                        ->orWhere('photo', 'LIKE', "%$keyword%")
                        ->latest()->paginate($perPage);
                }
                else {
                    $ocr = Ocr::latest()->paginate($perPage);
                }
                break;
            default : //FOR NON ADMIN SEE ONLY SELF
                if (!empty($keyword)) {
                    $ocr = Ocr::where('user_id' , Auth::user()->id)
                        ->where(function($query) use ($keyword){
                            $query->where('title', 'LIKE', "%$keyword%")
                                ->orWhere('staffgaugeid', 'LIKE', "%$keyword%")
                                ->orWhere('locationid', 'LIKE', "%$keyword%")
                                ->orWhere('content', 'LIKE', "%$keyword%")
                                ->orWhere('user_id', 'LIKE', "%$keyword%")
                                ->orWhere('photo', 'LIKE', "%$keyword%");
                        })->latest()->paginate($perPage);
                }
                else {
                    $ocr = Ocr::where('user_id' , Auth::user()->id)->latest()->paginate($perPage);
                }
                break; 
        }

        return view('ocr.index', compact('ocr'));
    }

    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('ocr.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(Request $request)
    {
        //$this->store2($request);
        //return  "{'status':'success'}";

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
     *
     * @return \Illuminate\View\View
     */
    public function show($id)
    {
        $ocr = Ocr::findOrFail($id);

        return view('ocr.show', compact('ocr'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     *
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        $ocr = Ocr::findOrFail($id);

        return view('ocr.edit', compact('ocr'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param  int  $id
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(Request $request, $id)
    {
        
        $requestData = $request->all();
        if ($request->hasFile('photo')) {
            $requestData['photo'] = $request->file('photo')
                ->store('uploads/ocr', 'public');
        }

        $ocr = Ocr::findOrFail($id);
        $ocr->update($requestData);

        return redirect('ocr')->with('flash_message', 'Ocr updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function destroy($id)
    {
        Ocr::destroy($id);

        return redirect('ocr')->with('flash_message', 'Ocr deleted!');
    }
}
