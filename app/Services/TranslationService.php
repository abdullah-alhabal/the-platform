<?php

declare(strict_types=1);

namespace App\Services;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

final class TranslationService
{
    public function index(string $lang): array
    {
        $backupPath = base_path('lang/backup.json');
        $langPath = base_path("lang/{$lang}.json");

        if ( ! File::exists($langPath)) {
            File::copy($backupPath, $langPath);
        }

        $backupData = json_decode(File::get($backupPath), true);
        $textData = json_decode(File::get($langPath), true);

        return [
            'backup_data' => $backupData,
            'text_data' => $textData,
        ];
    }

    public function update(Request $request, string $lang): array
    {
        $keys = $request->get('keys');
        $values = $request->get('values');

        $result = [];
        foreach ($keys as $key => $item) {
            $result[$item] = $values[$key];
        }

        $newJsonString = json_encode(
            value: $result,
            flags: JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PARTIAL_OUTPUT_ON_ERROR,
        );

        File::put(base_path("lang/{$lang}.json"), stripslashes($newJsonString));

        return [
            'message' => __('message_done'),
            'status' => true,
        ];
    }

    public function updateAjax(Request $request, string $lang): array
    {
        $filePath = base_path("lang/{$lang}.json");
        $data = json_decode(File::get($filePath), true);

        $data[$request->key] = $request->value;

        $newJsonString = json_encode(
            value: $data,
            flags: JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PARTIAL_OUTPUT_ON_ERROR,
        );

        File::put($filePath, stripslashes($newJsonString));

        return [
            'message' => __('message_done'),
            'status' => true,
        ];
    }
}
