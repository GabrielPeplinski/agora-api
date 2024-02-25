<?php

namespace App\Http\Api\Controllers\Auth;

class UpdatePersonalDataController
{
    public function __invoke()
    {
        $user = current_user();

        $data = request()->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email'],
        ]);

        $user->update($data);

        return response()->json([
            'message' => 'Suas informações foram atualizadas com sucesso',
        ]);
    }
}
