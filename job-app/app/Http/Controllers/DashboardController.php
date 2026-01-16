<?php

namespace App\Http\Controllers;

use App\Models\JobVacancy;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $jobs = JobVacancy::query()->latest()->paginate(10)->onEachSide(1);
        return view('dashboard', compact('jobs'));
    }
}
