<?php

declare(strict_types=1);

namespace App\Http\Requests\Api\V1\Admin\OurPartner;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Foundation\Http\FormRequest;

final class UpdateOurPartnerRequest extends FormRequest
{
    public function __construct(
        private readonly Application $application
    ) {
        parent::__construct();
    }

    public function rules(): array
    {
        $rules = [
            'image' => 'nullable|string',
            'link' => 'nullable|string',
        ];

        foreach ($this->getLocales() as $locale) {
            $rules["title_{$locale}"] = 'sometimes|required|string';
        }

        return $rules;
    }

    private function getLocales(): array
    {
        // Assuming your application uses the 'supported_locales' key in the configuration
        return $this->application->make('config')->get('app.supported_locales', []);
    }
}
