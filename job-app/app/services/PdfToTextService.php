<?php

namespace App\Services;

use Spatie\PdfToText\Pdf;

abstract class PdfToTextService
{

    public static function extractText(string $pdfFilePath): string {
        self::checkPdfToTextInstalled();
        return (new Pdf())->setPdf($pdfFilePath)->text();
    }
    private static function checkPdfToTextInstalled(): void
    {
        $pdfToTextPath = ['/opt/homebrew/bin/pdftotext', '/usr/bin/pdftotext', '/usr/local/bin/pdftotext'];
        $isAvailable = false;

        foreach ($pdfToTextPath as $path) {
            if (file_exists($path) && is_executable($path)) {
                $isAvailable = true;
                break;
            }
        }

        if (!$isAvailable) {
            throw new \Exception("pdftotext is not installed or not found in the specified paths.");
        }
    }
}
