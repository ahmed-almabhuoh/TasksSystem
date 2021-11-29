<?php

namespace App\Http\Controllers;

use App\Models\City;
use GuzzleHttp\RedirectMiddleware;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response as HttpResponse;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Response;
use Symfony\Component\HttpFoundation\Response as HttpFoundationResponse;

class CityController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        // echo 'WE ARE IN INDEX -> CITIES';
        $data = City::all();
        return response()->view('cms.cities.index', ['cities'=>$data]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return response()->view('cms.cities.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $request->validate([
            'name'=>'required|string|min:3|max:30',
        ]);

        $city = new City();
        $city->name = $request->get('name');
        $isSaved = $city->save();
        if ($isSaved) {
            session()->flash('message', 'city created successfully.');
            // return redirect()->route('cities.index');
            return redirect()->back();
        }
        // echo $isSaved ? 'Saved Successfully' : 'Faild To Save';
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\City  $city
     * @return \Illuminate\Http\Response
     */
    public function show(City $city)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\City  $city
     * @return \Illuminate\Http\Response
     */
    public function edit(City $city)
    {
        //
        // return redirect()->view("cms.cities.edit");
        // echo 'WE ARE IN THE :: EDIT';
        // return view('cms.cities.edit');
        // return response()->view('cms.cities.edit', ['city'=>$city]);
        return response()->view('cms.cities.edit', ['city'=>$city]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\City  $city
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, City $city)
    {
        //
        $request->validate([
            'name'=>'required|string|min:3|max:30'
        ]);

        // $city = new City();
        $city->name = $request->get('name');
        $isUpdated = $city->save();

        if ($isUpdated) {
            session()->flash('message', 'City updated successfully.');
            return redirect()->back();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\City  $city
     * @return \Illuminate\Http\Response
     */
    public function destroy(City $city)
    {
        //
        // echo 'WE ARE IN THE :: DESTROY'; 
        $isDeleted = $city->delete();

        if ($isDeleted) {
            return response()->json([
                'title'=>'Deleted!',
                'text'=>'City deleted successfully.',
                'icon'=>'success'
            ], 200);   
        }else {
            return response()->json([
                'title'=>'Faild!',
                'text'=>'City deleted fild.',
                'icon'=>'error'
            ], 400);
        }

        // if ($isDeleted) {
        //     session()->flash('message', 'City deleted successfully.');
        //     return redirect()->back();
        // }
    }
}
