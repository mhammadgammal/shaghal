<?php

namespace App\Http\Controllers;

use App\Models\JobApplication;
use App\Models\JobVacancy;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        if (auth()->guard()->user()->role === 'admin') {
            $analytics = $this->adminAnalytics();
        } else {
            $analytics = $this->companyAnalytics();
        }

        // Most Applied Jobs
        return view("dashboard.index", compact('analytics'));
    }

    private function adminAnalytics()
    {
        // Last 30 days active users
        $activeUsers = User::where('last_login_at', '>=', now()->subDays(30))->where('role', 'job-seeker')->count();

        // Total job vacancies
        $totalJobs = JobVacancy::whereNull('deleted_at')->count();

        // total applications
        $totalApplications = JobApplication::whereNull('deleted_at')->count();


        // Most Applied Jobs
        $mostAppliedJobs = JobVacancy::withCount('jobApplications as totalCount')
            ->whereNull('deleted_at')
            ->orderByDesc('totalCount')
            ->limit(5)
            ->get();

        $conversionRates = JobVacancy::withCount('jobApplications as totalCount')
            ->having('totalCount', '>', 0)
            ->orderByDesc('totalCount')
            ->limit(5)
            ->get()
            ->map(function ($job) {
                if ($job->viewCount > 0) {
                    $job->conversion = round(($job->totalCount / $job->viewCount) * 100, 2);
                    return $job;
                } else {
                    $job->conversion = 0;
                    return $job;
                }
            });

        $analytics = [
            'activeUsers' => $activeUsers,
            'totalJobs' => $totalJobs,
            'totalApplications' => $totalApplications,
            'mostAppliedJobs' => $mostAppliedJobs,
            'conversionRates' => $conversionRates
        ];

        return $analytics;
    }

    private function companyAnalytics()
    {

        $company = auth()->guard()->user()->company;
        //filter active users by applying to company jobs in last 30 days

        $activeUsers = User::where(
            'last_login_at',
            '>=',
            now()->subDays(30)

        )->where('role', 'job-seeker')
            ->whereHas('jobApplications', function ($query) use ($company) {
                $query->whereIn('jobVacancyId', $company->jobVacancies->pluck('id'));
            })->count();


        $totalJobs = $company->jobVacancies()->whereNull('deleted_at')->count();

        $totalApplications = JobApplication::whereIn(
            'jobVacancyId',
            $company->jobVacancies->pluck('id')
        )->whereNull('deleted_at')->count();

        $mostAppliedJobs = $company->jobVacancies()
            ->withCount('jobApplications as totalCount')
            ->whereNull('deleted_at')
            ->orderByDesc('totalCount')
            ->limit(5)
            ->get();


        $conversionRates = JobVacancy::withCount('jobApplications as totalCount')
            ->having('totalCount', '>', 0)
            ->orderByDesc('totalCount')
            ->limit(5)
            ->get()
            ->map(function ($job) {
                if ($job->viewCount > 0) {
                    $job->conversion = round(($job->totalCount / $job->viewCount) * 100, 2);
                    return $job;
                } else {
                    $job->conversion = 0;
                    return $job;
                }
            });

        $analytics = [
            'activeUsers' => $activeUsers,
            'totalJobs' => $totalJobs,
            'totalApplications' => $totalApplications,
            'mostAppliedJobs' => $mostAppliedJobs,
            'conversionRates' => $conversionRates
        ];
        return $analytics;
    }
}
