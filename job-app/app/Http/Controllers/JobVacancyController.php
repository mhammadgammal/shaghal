<?php

namespace App\Http\Controllers;

use App\Http\Requests\ApplyJobRequest;
use App\Models\JobApplication;
use App\Models\JobVacancy;
use App\Models\Resume;
use Illuminate\Http\Request;
use OpenAI\Laravel\Facades\OpenAI;
class JobVacancyController extends Controller
{
    public function show(string $id)
    {
        $jobVacancy = JobVacancy::findOrFail($id);

        return view('job-vacancies.show', compact('jobVacancy'));
    }

    public function apply(string $id)
    {
        $jobVacancy = JobVacancy::findOrFail($id);

        return view('job-vacancies.apply', compact('jobVacancy'));
    }

    public function processApplication(ApplyJobRequest $request, string $id)
    {
        // resume meta data extraction    
        $resumeFile = $request->file('resume_file');
        $resumeExtension = $resumeFile->getClientOriginalExtension();
        $resumeOriginalName = $resumeFile->getClientOriginalName();
        $resumePath = 'resume_'.time().'.'.$resumeExtension;

        $path = $resumeFile->storeAs('resumes', $resumePath, 'cloud');

        // $fileUrl = config('filesystems.disks.cloud.url').'/'.$path;

        $resume = Resume::create([
            'filename' => $resumeOriginalName,
            'fileUri' => $path,
            'userId' => auth()->guard()->user()->id,
            'summary' => '',
            'skills' => '',
            'experience' => '',
            'education' => '',
            'contactDetails' => json_encode([
                'name' => auth()->guard()->user()->name,
                'email' => auth()->guard()->user()->email
            ])
        ]);

        JobApplication::create([
            'jobVacancyId' => $id,
            'userId' => auth()->guard()->user()->id,
            'resumeId' => $resume->id,
            'aiGeneratedScore' => 0,
            'aiGeneratedFeedback' => '',
        ]);

        return redirect()->route('job-applications.index')->with('success', 'Your application has been submitted successfully.');
    }

    public function testOpenAI()
    {
        $response = OpenAI::chat()->create([
            'model' => 'gpt-3.5-turbo', // or 'gpt-4'
            'messages' => [
                ['role' => 'user', 'content' => 'Hello!'],
            ],
        ]);

        echo $response['choices'][0]['message']['content'];
    }
}
