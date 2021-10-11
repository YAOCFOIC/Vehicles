<?php

namespace App\Http\Controllers;

use App\Models\Vehicle;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;


class VehicleController extends Controller
{
    public function __construct()
    {
        $this->middleware('jwt', ['except' => ['index']]);
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
        
        if($request->input('typevehicle') == "vehiculos oficiales" || $request->input('typevehicle') == "residente" || $request->input('typevehicle') == "no residentes")
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
     * @param  \App\Models\vehicle $vehicle
     * @return \Illuminate\Http\Response
     */
    public function show($search)
    {
        //return for data
        $var = Vehicle::all('plaque','minute','total')
        ->where('plaque', $search);

        return response()->json(["data" => $var], 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\vehicle $vehicle
     * @return \Illuminate\Http\Response
     */
    public function edit(Vehicle $vehicle)
    {
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\vehicle $vehicle
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Vehicle $vehicle)
    {
        $request->validate([
            'datefinish'=>'required',
            'option'=>'required',
        ]);
        //type of vehicle
        $type = $vehicle->typevehicle;

        //Check-in
        $dateinit = $vehicle->dateinit;

        //Check-out
        $datefinish = $request->input('datefinish');

        //operation for get minute
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
                $vehicles->datefinish = $request->input('datefinish');
                $vehicles->minute = $time;
                $vehicles->total = $total;
            $vehicles->update();
            return response()->json(["data" => $vehicles], 200);
        }else if($type == "no residente")
        {
            $total = $time*1000;
            $vehicles = Vehicle::findOrFail($vehicle->id);
                $vehicles->option = $request->input('option');
                $vehicles->datefinish = $request->input('datefinish');
                $vehicles->minute = $time;
                $vehicles->total = $total;
            $vehicles->update();
            return response()->json(["data" => $vehicles], 200);
        }else if($type == "vehiculos oficiales")
        {
            $total = $time*0;
            $vehicles = Vehicle::findOrFail($vehicle->id);
                $vehicles->option = $request->input('option');
                $vehicles->datefinish = $request->input('datefinish');
                $vehicles->minute = $time;
                $vehicles->total = $total;
            $vehicles->update();
        }
        else{
            return response()->json(['error' => 'the type vehicle is not registered please check with database']);
        }
    }

    public function restart($newmonth)
    {

        if ($newmonth=="new_month")
        {
            $vehicles = Vehicle::where('typevehicle','vehiculos oficiales');
            $vehicles->delete();
            $newseason = Vehicle::where([['typevehicle', 'residente'], ['datefinish', '!=', null]])->update(['minute' => 0]);
            return response()->json(["data" => $vehicles], 200);
            return response()->json(["data" => $newseason], 200);
        }else
        {
            return response()->json(['error' => 'the type vehicle no regitre please verifed with database']);
        }
    }
}
