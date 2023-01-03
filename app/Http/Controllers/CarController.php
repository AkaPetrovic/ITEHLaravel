<?php

namespace App\Http\Controllers;

use App\Models\Car;
use App\Models\Manufacturer;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Resources\CarResource;

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
    public function create()
    {
        $car = Car::factory()->create();
        if(isset($car) && $car != null){
            return response()->json([
                'message' => 'Car has been created successfully',
            ]);
        }
        else{
            return response()->json([
                'message' => 'Failed',
            ]);
        }
        
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
        $query = $request->query();
        $manufacturerNames = array_values((array) Manufacturer::pluck('name'))[0];
        $userNames = array_values((array) User::pluck('name'))[0];
        $carIds = array_values((array) Car::pluck('id'))[0];

        if(!in_array($car_id, $carIds)){
            return response()->json([
                'message' => 'Car ID does not exist',
            ]);
        }
        if(!in_array($query['manufacturer'], $manufacturerNames)){
            return response()->json([
                'message' => 'Manufacturer name does not exist',
            ]);
        }
        if(!in_array($query['user'], $userNames)){
            return response()->json([
                'message' => 'User name does not exist',
            ]);
        }

        $manufacturer = Manufacturer::where('name', $query['manufacturer'])->get();
        $user = User::where('name', $query['user'])->get();
        $car = Car::find($car_id);
        $car->manufacturer_id = $manufacturer[0]->id;
        $car->user_id = $user[0]->id;
        $car->model_name = $query['model_name'];
        $car->year = $query['year'];
        $car->save();
        return response()->json([
            'message' => 'Car updated successfully',
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
        ]);
    }
}
