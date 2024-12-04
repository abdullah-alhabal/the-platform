<?php

declare(strict_types=1);

namespace App\Observers;

use App\Models\Country;

final class CountryObserver
{
    /**
     * Handle the Country "creating" event.
     */
    public function creating(Country $country): void
    {
        $country->code = mb_strtoupper($country->code);
    }

    /**
     * Handle the Country "updating" event.
     */
    public function updating(Country $country): void
    {
        $country->code = mb_strtoupper($country->code);
    }
}
