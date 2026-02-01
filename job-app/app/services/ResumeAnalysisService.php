<?php

namespace App\Services;

use App\Services\OpenNetworkFileService;

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
}
