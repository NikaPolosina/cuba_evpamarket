<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Region;

class LocationController extends Controller{
    public function getCityByRegion($id){

        return response()->json( Region::find($id)->getCities);



    }
}
