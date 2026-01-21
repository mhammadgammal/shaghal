<?php

namespace App\Services;

use Illuminate\Support\Facades\Storage;

abstract class OpenNetworkFileService
{
    static public function openFromCloud(string $fileUrl, string $cloudPath): mixed
    {

        $filePath = parse_url($fileUrl, PHP_URL_PATH);
        if (!$filePath) {
            throw new \Exception("Invalid file URL: $fileUrl");
        }
        $fileName = basename($filePath);

        $storagePath = "{$cloudPath}/{$fileName}";

        $cloudDisk = Storage::disk('cloud');
        if (!$cloudDisk->exists($storagePath)) {
            throw new \Exception("File does not exist in cloud storage: $storagePath");
        }

        $fileContent = $cloudDisk->get($storagePath);

        if (!$fileContent) {
            throw new \Exception("Failed to retrieve file from cloud storage: $storagePath");
        }

        return $fileContent;
    }
}
