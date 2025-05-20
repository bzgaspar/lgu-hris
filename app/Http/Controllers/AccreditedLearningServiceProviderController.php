<?php

namespace App\Http\Controllers;

use App\Models\hr\AccreditedLearningServiceProvider;
use Illuminate\Http\Request;

class AccreditedLearningServiceProviderController extends Controller
{

    public function index()
    {

        return view('hr.providers');
    }
    public function show()
    {
        return AccreditedLearningServiceProvider::all();
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'provider_name' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'services' => 'required|string',
        ]);

        return AccreditedLearningServiceProvider::create($validated);
    }

    public function update(Request $request, $id)
    {
        $provider = AccreditedLearningServiceProvider::findOrFail($id);

        $validated = $request->validate([
            'provider_name' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'services' => 'required|string',
        ]);

        $provider->update($validated);

        return $provider;
    }

    public function destroy($id)
    {
        return AccreditedLearningServiceProvider::destroy($id);
    }
}
