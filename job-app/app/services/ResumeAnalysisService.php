<?php

namespace App\Services;

use App\Services\OpenNetworkFileService;

abstract class ResumeAnalysisService
{
    static $filePath = '';
    public static function extractTextFromCloudResume(string $fileUrl, string $cloudPath): string
    {
        $tmpFile = tempnam(sys_get_temp_dir(), 'resume_');

        $pdfContent = OpenNetworkFileService::openFromCloud($fileUrl, $cloudPath);

        file_put_contents($tmpFile, $pdfContent);

        $text = PdfToTextService::extractText($tmpFile);

        unlink($tmpFile);
        return $text;
    }
}
