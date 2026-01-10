<?php

namespace App\Http\Controllers;

use App\Models\JobApplication;
use Illuminate\Http\Request;

class JobApplicationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $query = JobApplication::latest();
        if (request()->input("archived") == true) {
            $query->onlyTrashed();
        }
        $applications = $query->paginate(10)->onEachSide(1);

        return view("job-application.index", compact("applications"));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $application = JobApplication::findOrFail($id);

        return view("job-application.show", compact("application"));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $application = JobApplication::findOrFail($id);

        $application->update([
            'status' => $request->input('status')
        ]);

        return redirect()->route('job-applications.index')->with('success', 'Application status updated successfully');
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
        $application = JobApplication::onlyTrashed()->findOrFail($id);
        $application->restore();
        return redirect()->back();
    }
}
