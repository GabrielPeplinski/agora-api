<?php

namespace App\Http\Api\Controllers\Client;

use App\Http\Shared\Controllers\Controller;

class AddressController extends Controller
{
public function index()
    {
        current_user()->load('addresses.city.state');

        $addresses = auth()->user()->addresses()->with('city.state')->get();

        return response()->json($addresses);
    }

    public function store()
    {
        $address = auth()->user()->addresses()->create(request()->all());

        return response()->json($address);
    }

    public function show($id)
    {
        $address = auth()->user()->addresses()->with('city.state')->findOrFail($id);

        return response()->json($address);
    }

    public function update($id)
    {
        $address = auth()->user()->addresses()->findOrFail($id);

        $address->update(request()->all());

        return response()->json($address);
    }

    public function destroy($id)
    {
        $address = auth()->user()->addresses()->findOrFail($id);

        $address->delete();

        return response()->json($address);
    }
}
