<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Location;
use Illuminate\Support\Facades\Auth;

class LocationController extends Controller
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
        /* example format of $requestData : http://staffgauge.ckartisan.com/api/ocr
        [
            "title" => "100",                //level of water
            "content" => [],                 //raw data (everything)
            "photo" => "https://......jpg" , //URL IMAGE
            "social_user_id" => "",          //line id
            "numbers" => [],                 //Array of only number
        ]
        */
        $requestData = $request->all();    
        //Location::create(["json_line" => json_encode( $requestData, JSON_UNESCAPED_UNICODE ) ]);
        //$data = json_decode( $requestData['address']);
        /*if ($request->has('address')) {
            $requestData['address'] = $requestData['address'];
        }
        if ($request->has('latitude')) {
            $requestData['latitude'] = json_encode( $requestData['latitude'], JSON_UNESCAPED_UNICODE );
        }
        if ($request->has('longitude')) {
            $requestData['longitude'] = json_encode( $requestData['longitude'], JSON_UNESCAPED_UNICODE );
        }
        if ($request->has('typegroup')) {
            $requestData['typegroup'] = json_encode( $requestData['typegroup'], JSON_UNESCAPED_UNICODE );
        }  
        if ($request->has('lineid')) {
            $requestData['lineid'] = json_encode( $requestData['lineid'], JSON_UNESCAPED_UNICODE );
        }*/
        //$text = json_encode( $requestData, JSON_UNESCAPED_UNICODE );
        Location::create($requestData);
        return  "{'status':'success'}";

        
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
