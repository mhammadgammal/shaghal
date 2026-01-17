<?php

namespace App\Http\Controllers;

use App\Http\Requests\ApplyJobRequest;
use App\Models\JobVacancy;
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
