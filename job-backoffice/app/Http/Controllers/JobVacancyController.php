<?php

namespace App\Http\Controllers;

use App\Http\Requests\JobVacancyCreateRequest;
use App\Http\Requests\JobVacancyUpdateRequest;
use App\Models\Company;
use App\Models\JobCategory;
use App\Models\JobVacancy;
use Illuminate\Http\Request;

class JobVacancyController extends Controller
{

    private $jobTypes = ['full-time', 'hybrid', 'contract', 'remote'];

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = JobVacancy::latest();
        if ($request->input("archived") == true) {
            $query->onlyTrashed();
        }

        $vacancies = $query->paginate(10)->onEachSide(1);
        return view("job-vacancy.index", compact("vacancies"));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $jobTypes = $this->jobTypes;
        $companies = Company::latest()->get();
        $categories = JobCategory::latest()->get();
        return view('job-vacancy.create', compact('jobTypes', 'companies', 'categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(JobVacancyCreateRequest $request)
    {
        $validated = $request->validated();
        JobVacancy::create([
            'title' => $validated['title'],
            'description' => $validated['description'],
            'location' => $validated['location'],
            'salary' => $validated['salary'],
            'type' => $validated['type'],
            'jobCategoryId' => $validated['category_id'],
            'companyId' => $validated['company_id'],
        ]);

        return redirect()->route('job-vacancies.index')->with('success', 'Job vacancy created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {

        $vacancy = JobVacancy::findOrFail($id);

        return view('job-vacancy.show', compact('vacancy'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $fromWhere = request()->query('from', 'index');
        $vacancy = JobVacancy::findOrFail($id);
        $companies = Company::latest()->get();
        $categories = JobCategory::latest()->get();

        $jobTypes = $this->jobTypes;

        return view('job-vacancy.edit', compact('vacancy', 'jobTypes', 'companies', 'categories', 'fromWhere'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(JobVacancyUpdateRequest $request, string $id)
    {

        $validated = $request->validated();

        $vacancy = JobVacancy::findOrFail($id);
        $vacancy->update($validated);

        if ($request->input('from_where') === 'show') {
            return redirect()->route('job-vacancies.show', $id)->with('success', 'Job vacancy updated successfully.');
        }
        return redirect()->route('job-vacancies.index')->with('success', 'Job vacancy updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function restore(string $id)
    {
        $vacancy = JobVacancy::withTrashed()->findOrFail($id);

        $vacancy->restore();

        return redirect()->route('job-vacancies.index', ['archived' => true])->with('success', 'Vacancy restored successfully');
    }
}
