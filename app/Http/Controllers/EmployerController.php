<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Employer;
class EmployerController extends Controller
{
    //
    public function index(){
        $employers=Employer::all();
        return view('employers.index', ['employers'=>$employers]);  
    }

    public function show(Employer $employer){
        $jobs=$employer->jobs;
        return view('employers.show',['employer'=>$employer, 'jobs'=>$jobs]);
    }
}
