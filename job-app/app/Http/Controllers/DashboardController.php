<?php

namespace App\Http\Controllers;

use App\Models\JobVacancy;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $query = JobVacancy::query();

        if ($request->has('type') && $request->has('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('title', 'like', '%'.$request->search.'%')
                    ->orWhere('location', 'like', '%'.$request->search.'%')
                    ->orWhereHas('company', function ($q2) use ($request) {
                        $q2->where('name', 'like', '%'.$request->search.'%');
                    });
            })
                ->where('type', 'like', '%'.$request->type.'%');
        } else if ($request->has('type')) {
            // dd($request->type);
            $query->where('type', 'like', '%'.$request->type.'%');
        } else if ($request->has('search')) {
            $query->where('title', 'like', '%'.$request->search.'%')
                ->orWhere('location', 'like', '%'.$request->search.'%')
                ->orWhereHas('company', function ($q) use ($request) {
                    $q->where('name', 'like', '%'.$request->search.'%');
                });
        }
        $jobs = $query->latest()->paginate(10)->onEachSide(1);
        return view('dashboard', compact('jobs'));
    }
}
