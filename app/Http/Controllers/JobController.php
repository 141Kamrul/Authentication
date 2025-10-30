<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Job;
use App\Models\Employer;
use Illuminate\Support\Facades\Gate;
class JobController extends Controller
{
    //
    public function index(){
        if(auth()->guest()){
            return redirect('login');
        }
        $jobs=Job::with('employer')->cursorPaginate(100);
        $employers=$jobs->pluck('id')->filter()->unique('id')->values();
        return view('jobs.index', ['jobs'=>$jobs, 'employers'=> $employers]);
    }

    public function create(){
        return view('jobs.create');
    }

    public function store(Request $request){
        $request->validate([
            'title'=>['required','min:3'],
            'salary'=>['required'],
        ]);
    
    
        Job::create([
            'title'=>$request->input('title'),
            'salary'=>$request->input('salary'),
            'employer_id'=>Employer::inRandomOrder()->value('id'),
        ]);
        return redirect('/jobs');
    }

    public function show(Job $job){
        $employer=$job->employer;
        return view('jobs.show',['job'=>$job,'employer'=>$employer, ]);
    }

    public function edit(Job $job)
    {
        // Simple authorization - automatically aborts with 403 if fails
        Gate::authorize('edit-job', $job);

        return view('jobs.edit', compact('job'));
    }

    public function update(Request $request, Job $job){
        $request->validate([
            'title'=>'required|min:3',
            'salary'=>'required',
        ]);
        
        //$job=Job::findOrFail( $id );

        $job->update([
            'title'=>$request->input('title'),
            'salary'=>$request->input('salary'),
        ]);
        return redirect("/jobs/{$job->id}");
    }

    public function destroy(Job $job){
        // if(!$job->employer->user->is(auth()->user())){
        //     abort(403,'Unauthorized');
        // }

        if (auth()->user()->cannot('delete-job',$job)){
            return redirect()->back()->with('error','Cannot authorize');
        }
         $job->delete();


        return redirect('/jobs');
    }
}
