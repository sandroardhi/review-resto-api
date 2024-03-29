<?php

namespace App\Http\Controllers;

use App\Models\Resto;
use App\Http\Requests\StoreRestoRequest;
use App\Http\Requests\UpdateRestoRequest;

class RestoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Resto::all();
    }

    public function show_resto_profile($id)
    {
        return Resto::where('user_id', $id)->get();
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreRestoRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRestoRequest $request)
    {
        $this->validate($request, [
            'image' => 'nullable|image|mimes:jpg,png,jpeg,gif,svg',
        ]);
        if($request->image){
            $image_path = $request->file('image')->store('image', 'public');
        }
        if($request->image){
            return Resto::create([
                // ini kita langsung create data yang udah divalidate, divalidatenya itu ndek StoreRestoRequest (seng ndek parameter e ikulo, iku isuk di ctrl click terus nak njeroe isok di setting)
                ...$request->validated(),
                'image' => $image_path,
                'user_id' => $request->user()->id,
            ]);
        }
        else{
            return Resto::create([
                // ini kita langsung create data yang udah divalidate, divalidatenya itu ndek StoreRestoRequest (seng ndek parameter e ikulo, iku isuk di ctrl click terus nak njeroe isok di setting)
                ...$request->validated(),
                'user_id' => $request->user()->id,
            ]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Resto  $resto
     * @return \Illuminate\Http\Response
     */
    public function show(Resto $resto)
    {
        return $resto;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Resto  $resto
     * @return \Illuminate\Http\Response
     */
    public function edit(Resto $resto)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateRestoRequest  $request
     * @param  \App\Models\Resto  $resto
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRestoRequest $request, Resto $resto)
    {
        $resto->update($request->validated());

        return $resto->refresh();

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Resto  $resto
     * @return \Illuminate\Http\Response
     */
    public function destroy(Resto $resto)
    {
        $resto->delete();

        return $resto;
    }

    public function reviews(Resto $resto) 
    {
        return $resto->reviews->load('user');
    }
}
