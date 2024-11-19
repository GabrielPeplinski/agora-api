<?php
/*
 * This file contains all the helper functions used in the application
 */

use Illuminate\Support\Facades\Auth;

if (! function_exists('output_date_format')) {

    function output_date_format($date): string
    {
        return (new \Carbon\Carbon($date))->toIso8601String();
    }
}

if (! function_exists('current_user')) {
    /**
     * Retorna o usuário atual se estiver autenticado.
     *
     * @return \App\Domains\Account\Models\User|\Illuminate\Contracts\Auth\Authenticatable|null
     */
    function current_user(): ?App\Domains\Account\Models\User
    {
        return Auth::guard('sanctum')->user();
    }
}

if (! function_exists('array_keys_as')) {
    /**
     * Rename the keys from an array
     *
     * @param  array  $data  Array to be renamed
     * @param  array  $keysFromTo  The keys to be renamed
     * @return array The renamed array
     */
    function array_keys_as(array $data, array $keysFromTo): array
    {
        foreach ($keysFromTo as $oldKey => $newKey) {
            if (array_key_exists($oldKey, $data)) {
                $data[$newKey] = $data[$oldKey];
                unset($data[$oldKey]);
            }
        }

        return $data;
    }
}
