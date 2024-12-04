<?php

declare(strict_types=1);

namespace App\Services\File;

use Illuminate\Http\UploadedFile;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpKernel\Exception\HttpException;

/**
 * Class BaseFileService
 * Service class to handle file-related operations such as generating URLs, validation, upload, and download.
 */
final class BaseFileService
{
    /**
     * Get the full URL for a given path.
     *
     * @param  string|null $path The file path to generate the URL for.
     * @return string|null The full URL or null if the path is invalid.
     *
     * @throws HttpException If the application or storage URL is not configured.
     */
    public function getFullUrl(?string $path): ?string
    {
        if (null === $path) {
            return null;
        }

        $appUrl = config('app.url');
        $storageUrl = config('app.storage_url');

        if (empty($appUrl) || empty($storageUrl)) {
            throw new HttpException(500, json_encode([
                'success' => false,
                'message' => 'Application URL or Storage URL is not configured. Please set APP_URL and STORAGE_URL in .env or app.url and app.storage_url in config.',
            ]));
        }

        if ($this->isValidUrl($path)) {
            return $path;
        }

        return sprintf('%s/%s', rtrim($storageUrl, '/'), ltrim($path, '/'));
    }

    /**
     * Validate a file against the given rules.
     *
     * @param  UploadedFile $file  The file to validate.
     * @param  array        $rules Validation rules.
     * @return bool         True if the file passes validation, false otherwise.
     */
    public function validateFile(UploadedFile $file, array $rules): bool
    {
        // TODO: Implement validation logic (e.g., using Laravel Validator)
        return true;
    }

    /**
     * Upload a file to the specified path.
     *
     * @param  UploadedFile $file The file to upload.
     * @param  string       $path The destination path for the file.
     * @return string       The stored file path.
     */
    public function uploadFile(UploadedFile $file, string $path): string
    {
        // Store the file and return the stored path
        return $file->store($path);
    }

    /**
     * Download a file from the specified path.
     *
     * @param  string             $path The file path in storage.
     * @return BinaryFileResponse The file response for downloading.
     */
    public function downloadFile(string $path): BinaryFileResponse
    {
        return response()->download(storage_path(sprintf('app/%s', ltrim($path, '/'))));
    }

    /**
     * Check if a path is a valid URL.
     *
     * @param  string $path The path to check.
     * @return bool   True if the path is a valid URL, false otherwise.
     */
    private function isValidUrl(string $path): bool
    {
        return false !== filter_var($path, FILTER_VALIDATE_URL);
    }
}
