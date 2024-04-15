<?php

namespace App\Http\Api\Controllers\Client;

use App\Domains\Solicitation\Dtos\SolicitationData;
use App\Domains\Solicitation\Models\Solicitation;
use App\Http\Api\Request\Solicitation\SolicitationRequest;

class SolicitationController
{
    public function index()
    {
        return response()->json([
            'message' => 'Solicitations list',
        ]);
    }

    public function show(Solicitation $solicitation)
    {
        $solicitation->loadMissing('category');

        return response()->json([
            'message' => 'Solicitation details',
        ]);
    }

    public function store(SolicitationRequest $request)
    {
        $data = SolicitationData::from([
            'status' => 'pending',
            ...$request->validated()
        ]);
    }

    public function update(SolicitationRequest $request, Solicitation $solicitation)
    {
        return response()->json([
            'message' => 'Solicitation updated',
        ]);
    }

    public function destroy(int $id)
    {
        return response()->json([
            'message' => 'Solicitation deleted',
        ]);
    }
}
