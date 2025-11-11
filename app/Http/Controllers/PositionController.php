<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Position;

class PositionController extends Controller
{
    //
    public function index()
    {
        //
        $positions= Position::all();
        return view('admin.position_index',['positions'=> $positions]);
    }
}
