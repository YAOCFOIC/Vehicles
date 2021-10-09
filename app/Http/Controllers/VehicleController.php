<?php

namespace App\Http\Controllers;

use App\Models\Vehicle;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Crypt;

class VehicleController extends Controller
{
    public function __construct()
    {
        $this->middleware('jwt', ['except' => ['index','sotre']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //return for data
        return Vehicle::orderBy('id','DESC')
        ->where('typevehicle', "!=", "vehiculo oficial")
        ->paginate(7);
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
        //
        $request->validate([
            'typevehicle'=>'required',
            'plaque'=>'required',
            'dateinit'=>'required',
        ]);
        
        if($request->input('typevehicle') == "vehiculos oficales" || $request->input('typevehicle') == "residente" || $request->input('typevehicle') == "no residentes")
        {
            $vehicles = new Vehicle;
                $vehicles->typevehicle = $request->input('typevehicle');
                $vehicles->plaque = $request->input('plaque');
                $vehicles->dateinit = $request->input('dateinit');
            $vehicles->save();

            return response()->json(["data" => $vehicles], 200);
            
        }else
        {
            return response()->json(['error' => 'the type vehicle is not registered please check with database']);
        }
        
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\article  $article
     * @return \Illuminate\Http\Response
     */
    public function show(article $article)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\article  $article
     * @return \Illuminate\Http\Response
     */
    public function edit(Vehicle $vehicle)
    {
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\article  $article
     * @return \Illuminate\Http\Response
     */
    public function update(Rest $reqqueuest, Vehicle $vehicle)
    {
        //type of vehicle
        $type = Vehicle::findOrFail($vehicle->id)->where('typevehicle');

        //Check-in
        $dateinit = Vehicle::findOrFail($vehicle->id)->where('dateinit');

        //Check-out
        $datefinish = Vehicle::findOrFail($vehicle->id)->where('datefinish');

        //operation for get minutes
        $timeinit = strtotime("" . $dateinit . "");
        $timefinish = strtotime("" . $datefinish . "");
        $times = round(abs($timeinit - $timefinish) / 60);


        //convert var times in number integer
        $time = (int)$times;


        if ($type == "residente")
        {
            $total = $time*9.12;
            $vehicles = Vehicle::findOrFail($vehicle->id);
                $vehicles->option = $request->input('option');
                $vehicles->option = $request->input('datefinish');
                $vehicles->plaque = $request->input('plaque');
                $vehicles->dateinit = $total;
            $vehicles->update();
            return response()->json(["data" => $vehicles], 200);
        }else if($type == "no residentes")
        {
            $total = $time*1000;
            $vehicles = Vehicle::findOrFail($vehicle->id);
                $vehicles->option = $request->input('option');
                $vehicles->datefinish = $request->input('datefinish');
                $vehicles->total = $total;
            $vehicles->update();
            return response()->json(["data" => $vehicles], 200);
        }else{
            return response()->json(['error' => 'the type vehicle is not registered please check with database']);
        }
    }

    public function restart()
    {
        if ($request->input('new')=="new_month")
        {
            $vehicles = Vehicles::all()->where('typevehicle','no recidentes');
            $vehicles->delete();

            $newseason = Vehicles::query()->update(['confirmed' => 1]);
        }else
        {
            return response()->json(['error' => 'the type vehicle no regitre please verifed with database']);
        }
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\article  $article
     * @return \Illuminate\Http\Response
     */
    public function destroy(Vehicle $vehicle)
    {
        //
        
    }
}
