<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\MyLogOcr;
use Illuminate\Http\Request;

class MyLogOcrController extends Controller
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
            $mylogocr = MyLogOcr::where('json', 'LIKE', "%$keyword%")
                ->latest()->paginate($perPage);
        } else {
            $mylogocr = MyLogOcr::latest()->paginate($perPage);
        }

        return view('my-log-ocr.index', compact('mylogocr'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('my-log-ocr.create');
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
        
        MyLogOcr::create($requestData);

        return redirect('my-log-ocr')->with('flash_message', 'MyLogOcr added!');
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
        $mylogocr = MyLogOcr::findOrFail($id);

        return view('my-log-ocr.show', compact('mylogocr'));
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
        $mylogocr = MyLogOcr::findOrFail($id);

        return view('my-log-ocr.edit', compact('mylogocr'));
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
        
        $mylogocr = MyLogOcr::findOrFail($id);
        $mylogocr->update($requestData);

        return redirect('my-log-ocr')->with('flash_message', 'MyLogOcr updated!');
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
        MyLogOcr::destroy($id);

        return redirect('my-log-ocr')->with('flash_message', 'MyLogOcr deleted!');
    }
}
