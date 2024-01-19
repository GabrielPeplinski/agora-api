<?php
/*
 * This file contains all the helper functions used in the application
 */

if (! function_exists('output_date_format')) {

    function output_date_format($date): string
    {
        return (new \Carbon\Carbon($date))->toIso8601String();
    }
}

if (! function_exists('current_user')) {
    /**
     * Returns the current user
     *
     * @return \App\Domains\Account\Models\User|\Illuminate\Contracts\Auth\Authenticatable|null
     */
    function current_user(): ?App\Domains\Account\Models\User
    {
        return auth()->user();
    }
}
