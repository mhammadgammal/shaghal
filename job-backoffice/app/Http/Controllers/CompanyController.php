<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Company;
use App\Http\Requests\CompanyCreateRequest;
use App\Http\Requests\CompanyUpdateRequest;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class CompanyController extends Controller
{

    public $industries = ['Technology', 'Finance', 'HealthCare', 'Education', 'Retail', 'Manufacturing', 'Energy', 'Entertainment', 'Sports', 'Real Estate'];
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Company::latest();
        if ($request->input("archived") == true) {
            $query->onlyTrashed();
        }

        $companies = $query->paginate(10)->onEachSide(1);
        return view('company.index', compact('companies'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $industries = $this->industries;
        return view('company.create', compact('industries'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CompanyCreateRequest $request)
    {
        $validated = $request->validated();
        $owner = User::create([
            'name' => $validated['ownerName'],
            'email' => $validated['ownerEmail'],
            'password' => $validated['ownerPassword'],
            'role' => 'company-owner',
        ]);

        // return error if owner is not created
        if (!$owner) {
            return redirect()->route('companies.create')->with('error', 'Owner not created');
        }

        Company::create([
            'name' => $validated['name'],
            'address' => $validated['address'],
            'industry' => $validated['industry'],
            'website' => $validated['website'],
            'ownerId' => $owner->id,
        ]);

        return redirect()->route('companies.index')->with('success', 'Company created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id = null)
    {
        $company = $this->getCompany($id);

        return view('company.show', compact('company'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id = null)
    {
        $company = $this->getCompany($id);

        $industries = $this->industries;
        return view('company.edit', compact('company', 'industries'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CompanyUpdateRequest $request, string $id = null)
    {
        $validated = $request->validated();
        $company = $this->getCompany($id);

        $company->update([
            'name' => $validated['name'],
            'address' => $validated['address'],
            'industry' => $validated['industry'],
            'website' => $validated['website'],
        ]);

        $ownerData = [];

        $ownerData['name'] = $validated['ownerName'];
        if ($validated['ownerPassword']) {
            $ownerData['password'] = Hash::make($validated['ownerPassword']);
        }
        $company->owner->update($ownerData);

        if (auth()->guard()->user()->role == 'company-owner') {
            return redirect()->route('my-company.show')->with('success', 'Company updated successfully');
        }
        if ($request->query('redirectTo') == 'show') {
            return redirect()->route('companies.show', $company->id)->with('success', 'Company updated successfully');
        } else {
            return redirect()->route('companies.index')->with('success', 'Company updated successfully');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $company = Company::findOrFail($id);

        $company->delete();

        return redirect()->route('companies.index')->with('success', 'Company archived successfully');
    }

    public function restore(string $id)
    {
        $company = Company::withTrashed()->findOrFail($id);

        $company->restore();

        return redirect()->route('companies.index', ['archived' => true])->with('success', 'Company restored successfully');
    }

    private function getCompany(string $id = null): Company
    {
        if ($id) {
            return Company::findOrFail($id);
        } else {
            return Company::where('ownerId', auth()->guard()->user()->id)->first();
        }
    }
}
