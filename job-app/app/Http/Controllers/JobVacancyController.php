<?php

namespace App\Http\Controllers;

use App\Http\Requests\ApplyJobRequest;
use App\Models\JobApplication;
use App\Models\JobVacancy;
use App\Models\Resume;
use App\Services\ResumeAnalysisService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
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
        $resumes = auth()->guard()->user()->resumes;
        return view('job-vacancies.apply', compact('jobVacancy', 'resumes'));
    }

    public function processApplication(ApplyJobRequest $request, string $id)
    {
        $resumeId = $request->input('resume_option') === 'new_resume'
            ? $this->processNewResume($request, $id)
            : $request->input('resume_option');

        $resume = Resume::findOrFail($resumeId);
        $jobVacancy = JobVacancy::findOrFail($id);

        $analysisResult = ResumeAnalysisService::analyzeResumeAgainstJobDescription(
            $jobVacancy,
            [
                'skills' => $resume->skills,
                'experience' => $resume->experience,
                'education' => $resume->education,
                'summary' => $resume->summary,
            ]
        );
        JobApplication::create([
            'jobVacancyId' => $id,
            'userId' => auth()->guard()->user()->id,
            'resumeId' => $resumeId,
            'aiGeneratedScore' => $analysisResult['aiGeneratedScore'],
            'aiGeneratedFeedback' => $analysisResult['aiGeneratedFeedback'],
        ]);
        return redirect()->route('job-applications.index')->with('success', 'Your application has been submitted successfully.');
    }

    private function processNewResume(ApplyJobRequest $request, string $id)
    {
        // resume meta data extraction
        $resumeFile = $request->file('resume_file');
        $resumeExtension = $resumeFile->getClientOriginalExtension();
        $resumeOriginalName = $resumeFile->getClientOriginalName();
        $resumePath = 'resume_' . time() . '.' . $resumeExtension;

        $path = $resumeFile->storeAs('resumes', $resumePath, 'cloud');

        $fileUrl = config('filesystems.disks.cloud.url') . '/' . $path;
        $resumeData = ResumeAnalysisService::getResumeInformation($fileUrl, 'resumes');
        $resume = Resume::create([
            'filename' => $resumeOriginalName,
            'fileUri' => $path,
            'userId' => auth()->guard()->user()->id,
            'summary' => $resumeData['summary'],
            'skills' => $resumeData['skills'],
            'experience' => $resumeData['experience'],
            'education' => $resumeData['education'],
            'contactDetails' => json_encode([
                'name' => auth()->guard()->user()->name,
                'email' => auth()->guard()->user()->email
            ])
        ]);
        return $resume->id;
    }
}
