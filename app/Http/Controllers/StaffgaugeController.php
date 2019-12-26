<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Location;
use App\Staffgauge;
use App\Http\Controllers\Controller;
use App\Http\Requests;

use Illuminate\Support\Facades\Auth;
use App\Profile;
use App\User;

class StaffgaugeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $keyword = $request->get('search');
        $perPage = 25;

        if (!empty($keyword)) {
            $staffgauge = Staffguage::where('addressgauge', 'LIKE', "%$keyword%")
                ->orWhere('amphoe', 'LIKE', "%$keyword%")
                ->orWhere('district', 'LIKE', "%$keyword%")
                ->orWhere('province', 'LIKE', "%$keyword%")
                ->orWhere('latitudegauge', 'LIKE', "%$keyword%")
                ->orWhere('longitudegauge', 'LIKE', "%$keyword%")
                ->latest()->paginate($perPage);
        } else {
            $staffgauge = Staffgauge::latest()->paginate($perPage);
        }

        return view('staffgauge.index', compact('staffgauge'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('staffgauge.create');
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

        Staffgauge::create($requestData);

        return redirect('staffgauge')->with('flash_message', 'Staffgauge added!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $staffgauge = Staffgauge::findOrFail($id);

        return view('staffgauge.show', compact('staffgauge'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $staffgauge = Staffgauge::findOrFail($id);

        return view('staffgauge.edit', compact('staffgauge'));
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
        $requestData = $request->all();

        $staffgauge = Staffgauge::findOrFail($id);
        $staffgauge->update($requestData);

        return redirect('staffgauge')->with('flash_message', 'Staffgauge updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Staffgauge::destroy($id);

        return redirect('staffgauge')->with('flash_message', 'Staffgauge deleted!');
    }
}
