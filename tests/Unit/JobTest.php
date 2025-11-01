<?php


namespace tests\Unit;
use App\Models\Job;
use App\Models\Employer;
use tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;



class JobTest extends TestCase{
    use RefreshDatabase;

    public function test_example(){
        expect(true)->toBeTrue();
    }


    public function test_job_with_employer(){
        $employer = Employer::factory()->create();
        $job = Job::factory()->create(['employer_id' => $employer->id]);
        expect($job->employer->is($employer))->toBeTrue();
    }

    public function test_job_with_tags(){
        $job = Job::factory()->create();
        $job->tag('frontend');

        expect($job->tags)->toHaveCount(1);

    }
}




// it('belongs to an employer', function () {
//     $employer = Employer::factory()->create();
//     $job = Job::factory()->create(['employer_id' => $employer->id]);
//     expect($job->employer->is($employer))->toBeTrue();
// });
