<?php

namespace App\Http\Controllers;

use App\City;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Region;

class LocationController extends Controller{
    public function getCityByRegion($id){




        //return response()->json( Region::find($id)->getCities);
        return response()->json( City::where('region_id', $id)->get());



    }
}
