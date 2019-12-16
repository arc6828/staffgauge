<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\LogOcr;
use Illuminate\Http\Request;

class LogOcrController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $keyword = $request->get('search');
        $perPage = 25;

        if (!empty($keyword)) {
            $logocr = LogOcr::where('json', 'LIKE', "%$keyword%")
                ->latest()->paginate($perPage);
        } else {
            $logocr = LogOcr::latest()->paginate($perPage);
        }

        return view('log-ocr.index', compact('logocr'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('log-ocr.create');
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
        
        $requestData = $request->all();
        
        LogOcr::create($requestData);

        return redirect('log-ocr')->with('flash_message', 'LogOcr added!');
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
        $logocr = LogOcr::findOrFail($id);

        return view('log-ocr.show', compact('logocr'));
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
        $logocr = LogOcr::findOrFail($id);

        return view('log-ocr.edit', compact('logocr'));
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
        
        $logocr = LogOcr::findOrFail($id);
        $logocr->update($requestData);

        return redirect('log-ocr')->with('flash_message', 'LogOcr updated!');
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
        LogOcr::destroy($id);

        return redirect('log-ocr')->with('flash_message', 'LogOcr deleted!');
    }
}
