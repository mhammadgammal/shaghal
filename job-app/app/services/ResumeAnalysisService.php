<?php

namespace App\Services;

use App\Services\OpenNetworkFileService;
use App\Services\OpenAIBaseService;
use Illuminate\Support\Facades\Log;

abstract class ResumeAnalysisService
{
    static $filePath = '';
    private static function extractTextFromCloudResume(string $fileUrl, string $cloudPath): string
    {
        $tmpFile = tempnam(sys_get_temp_dir(), 'resume_');

        $pdfContent = OpenNetworkFileService::openFromCloud($fileUrl, $cloudPath);

        file_put_contents($tmpFile, $pdfContent);

        $text = PdfToTextService::extractText($tmpFile);

        unlink($tmpFile);
        return $text;
    }

    static public function getResumeInformation(string $fileUrl, string $cloudPath): array
    {
        $resumeText = self::extractTextFromCloudResume($fileUrl, $cloudPath);
        $messages = [
            [
                'role' => 'system',
                'content' => 'You are an expert resume analyzer. Extract the following information from the resume text without adding additional interpretation or additional information. The output should be in JSON format: \'summary\', \'skills\', \'experience\', \'education\', email address, phone number, and a list of skills. Return the information in JSON format with keys: fullName, email, phone, skills (as an array). If any information is missing, use empty string for that field.',
            ],
            [
                'role' => 'user',
                'content' => "Resume Text:\n$resumeText",
            ],
        ];

        $response = (new OpenAIBaseService())->chat($messages, [
            'temperature' => 0.2,
            'max_tokens' => 500,
        ]);

        $data = json_decode($response, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new \Exception('Failed to parse JSON response from OpenAI: ' . json_last_error_msg());
        }

        $missingData = array_diff(
            ['education', 'experience', 'skills', 'summary'],
            array_keys($data)
        );

        if (empty($missingData)) {
            throw new \Exception('Missing expected fields in OpenAI response: ' . implode(', ', $missingData));
        }

        return [
            'summary' => $data['summary'] ?? '',
            'skills' => is_array($data['skills']) ? implode(', ', $data['skills']) : $data['skills'],
            'experience' => $data['experience'] ?? '',
            'education' => $data['education'] ?? '',
        ];
    }

    public static function analyzeResumeAgainstJobDescription($jobVacancy, $resumeData): array
    {
        try {
            $jobDetails = json_encode([
                'job_title' => $jobVacancy->title,
                'job_description' => $jobVacancy->description,
                'job_location' => $jobVacancy->location,
                'job_type' => $jobVacancy->type,
                'job_salary' => $jobVacancy->salary,
            ]);

            $resumeDetails = json_encode($resumeData);

            $messages = [
                [
                    'role' => 'system',
                    'content' => 'You are an expert job application analyzer. Compare the resume details against the job description and provide a score from 0 to 100 indicating how well the resume matches the job requirements. Additionally, provide constructive feedback on how the applicant can improve their resume to better fit the job description. Return the response in JSON format with keys: aiGeneratedScore, aiGeneratedFeedback.
                    Aigenerate feedback should be detailed and specific to the job and the candidate\'s resume.',
                ],
                [
                    'role' => 'user',
                    'content' => "Job Details:\n$jobDetails\n\nResume Details:\n$resumeDetails",
                ],
            ];
            $instance = new OpenAIBaseService();
            $response = $instance->chat(messages: $messages, options: [
                'response_format' => ['type' => 'json_object'],
                'temperature' => 0.1,
                'max_tokens' => 500,
            ]);

            Log::debug('OpenAI Response', ['response' => $response]);
            $data = json_decode($response, true);

            if (json_last_error() !== JSON_ERROR_NONE) {

                Log::debug('JSON decode error', ['response' => $response]);

                throw new \Exception('Failed to parse JSON response from OpenAI: ' . json_last_error_msg());
            }

            if (!isset($data['aiGeneratedScore']) || !isset($data['aiGeneratedFeedback'])) {
                Log::debug('Missing fields in OpenAI response', ['response' => $data]);
                throw new \Exception('Missing expected fields in OpenAI response.');
            }


            return [
                'aiGeneratedScore' => $data['aiGeneratedScore'],
                'aiGeneratedFeedback' => $data['aiGeneratedFeedback'],
            ];
        } catch (\Throwable $th) {
            Log::error('Error analyzing resume against job description', ['error' => $th->getMessage()]);
            return [
                'aiGeneratedScore' => 0,
                'aiGeneratedFeedback' => 'An error occurred while analyzing the resume.',
            ];
        }
    }
}
