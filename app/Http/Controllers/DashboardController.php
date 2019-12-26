<?php

namespace App\Http\Controllers;

use App\Profile;
use App\Location;
use App\Staffgauge;
use App\Charts\UserChart;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use FarhanWazir\GoogleMaps\Facades\GMapsFacade;
use Khill\Lavacharts\Laravel\Lava;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $staffgauge = $request->all();
        // Staffgauge::findOrFail();

        $config['center'] = '14.039731691604512, 100.66684383908346';
        $config['zoom'] = '12';
        $config['map_height'] = '500px';
        // $config['map_width'] = '500px'
        $config['scrollwheel'] = false;
        $config['sensor'] = true;

        GMapsFacade::initialize($config);

        $marker1['position'] = '14.039731691604512, 100.66684383908346';
        $marker1['infowindow_content'] = `Home`;
        GmapsFacade::add_marker($marker1);

        $marker2['position'] = '14.13373938749426, 100.61768407876879';
        $marker2['infowindow_content'] = 'VRU';
        GmapsFacade::add_marker($marker2);

        $marker3['position'] = '13.989577152673931, 100.61710125020257';
        $marker3['infowindow_content'] = 'Future Park';
        GmapsFacade::add_marker($marker3);


        $map = GMapsFacade::create_map();

        // --------------------------------------

        // $lava = new Lavacharts; // See note below for Laravel

        /*
        $votes  = Lava::DataTable();

        $votes->addStringColumn('Food Poll')
            ->addNumberColumn('Votes')
            ->addRow(['Tacos',  rand(1000,5000)])
            ->addRow(['Salad',  rand(1000,5000)])
            ->addRow(['Pizza',  rand(1000,5000)])
            ->addRow(['Apples', rand(1000,5000)])
            ->addRow(['Fish',   rand(1000,5000)]);

        Lava::BarChart('Votes', $votes);
        */

        /*
        $usersChart = new UserChart;
        $usersChart->labels(['Jan', 'Feb', 'Mar']);
        $usersChart->dataset('Users by trimester', 'line', [10, 25, 13])
            ->color("rgb(255, 99, 132)")
            ->backgroundcolor("rgb(255, 99, 132)");
        // return view('users', [ 'usersChart' => $usersChart ] );
        */

        return view('dashboard.index', [ 'map' => $map ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        
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
        
    }
}
