<?php

namespace App\Http\Api\Controllers\Auth;

use App\Http\Api\Resources\MeResource;
use App\Http\Shared\Controllers\Controller;

class MeController extends Controller
{
    public function __invoke()
    {
        $user = current_user();

        return MeResource::make($user);
    }
}
