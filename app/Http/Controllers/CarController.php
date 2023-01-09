<?php

namespace App\Http\Controllers;

use App\Models\Car;
use App\Models\Manufacturer;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Resources\CarResource;
use Illuminate\Support\Facades\Auth;

class CarController extends Controller
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
    public function create(Request $request)
    {
        $manufacturerNames = array_values((array) Manufacturer::pluck('name'))[0];
        if(!in_array($request->manufacturer, $manufacturerNames)){
            return response()->json([
                'message' => 'Manufacturer name does not exist',
            ]);
        }
        $manufacturer = Manufacturer::where('name', $request->manufacturer)->get()->first();

        $car = Car::create([
            'model_name' => $request->model_name,
            'year' => $request->year,
            'manufacturer_id' =>$manufacturer->id,
            'user_id' => Auth::user()->id,
        ]);

        return response()->json([
            'message' => 'Car has been created successfully',
            'car' => new CarResource($car),
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Car  $car
     * @return \Illuminate\Http\Response
     */
    public function show($car_id)
    {
        return new CarResource(Car::find($car_id));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Car  $car
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $car_id)
    {
        $manufacturerNames = array_values((array) Manufacturer::pluck('name'))[0];
        $carIds = array_values((array) Car::pluck('id'))[0];

        if(!in_array($car_id, $carIds)){
            return response()->json([
                'message' => 'Car ID does not exist',
            ]);
        }
        if(!in_array($request->manufacturer, $manufacturerNames)){
            return response()->json([
                'message' => 'Manufacturer name does not exist',
            ]);
        }

        $manufacturer = Manufacturer::where('name', $request->manufacturer)->get()->first();

        $car = Car::find($car_id);
        $car->manufacturer_id = $manufacturer->id;
        $car->user_id = Auth::user()->id;
        $car->model_name = $request->model_name;
        $car->year = $request->year;

        $car->save();

        return response()->json([
            'message' => 'Car updated successfully',
            'car' => new CarResource($car),
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Car  $car
     * @return \Illuminate\Http\Response
     */
    public function destroy($car_id)
    {
        $carIds = array_values((array) Car::pluck('id'))[0];

        if(!in_array($car_id, $carIds)){
            return response()->json([
                'message' => 'Car ID does not exist',
            ]);
        }

        $car = Car::find($car_id); 

        if (!$car->delete()) {
            return response()->json([
                'error' => 'Unable to delete the car'
            ]);
        }
        
        return response()->json([
            'message' => 'Car deleted successfully',
            'car' => new CarResource($car),
        ]);
    }
}
