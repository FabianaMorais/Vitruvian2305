<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sensors\AdpdData;

class TestController extends Controller
{
    public function showAll()
   {
       return AdpdData::all();
   }

}