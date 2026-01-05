<?php

namespace Database\Seeders;

use App\Models\Company;
use App\Models\JobCategory;
use App\Models\JobVacancy;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::firstOrCreate(['email' => 'admin@admin.com'], [
            'name' => 'Admin',
            'email_verified_at' => now(),
            'password' => Hash::make('12345678'),
            'role' => 'admin',
        ]);

        // Seed data to test with
        $jsonData = json_decode(file_get_contents(database_path('data/job_data.json')), true);

        // create job categories
        foreach ($jsonData['jobCategories'] as $category) {
            JobCategory::firstOrCreate([
                'name' => $category
            ]);
        }

        // companies
        foreach ($jsonData['companies'] as $company) {

            // create owner user for company
            $ownerUser = User::firstOrCreate([
                'email' => fake()->unique()->safeEmail(),
            ], [
                'name' => fake()->name(),
                'password' => Hash::make('12345678'),
                'role' => 'company-owner',
                'email_verified_at' => now(),
            ]);
            Company::firstOrCreate([
                'name' => $company['name'],
            ], [
                'website' => $company['website'],
                'address' => $company['address'],
                'industry' => $company['industry'],
                'ownerId' => $ownerUser->id,
            ]);
        }


        foreach ($jsonData['jobVacancies'] as $jobVacancy) {
            // get company
            $company = Company::where('name', $jobVacancy['company'])->firstOrFail();

            // get category
            $category = JobCategory::where('name', $jobVacancy['category'])->firstOrFail();

            JobVacancy::firstOrCreate(['title' => $jobVacancy['title'],], [
                'title' => $jobVacancy['title'],
                'description' => $jobVacancy['description'],
                'location' => $jobVacancy['location'],
                'salary' => $jobVacancy['salary'],
                'type' => $jobVacancy['type'],
                'companyId' => $company->id,
                'jobCategoryId' => $category->id,
            ]);
        }
    }
}
