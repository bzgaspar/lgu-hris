<?php

namespace App\Http\Controllers;

use App\Models\hr\Separated;
use Illuminate\Http\Request;

class SeparatedController extends Controller
{
    public function index (){
        return view('hr.separeted');
    }
   public function show()
    {
        return Separated::with('user', 'department')->get();
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'position' => 'required|string',
            'department_id' => 'nullable|exists:departments,id',
            'date_separated' => 'required|date',
            'remarks' => 'required|in:resign,retired',
        ]);

        $separation = Separated::create($validated);

        return response()->json($separation, 201);
    }

    public function update(Request $request, $id)
    {
        $separation = Separated::findOrFail($id);

        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'position' => 'required|string',
            'department_id' => 'nullable|exists:departments,id',
            'date_separated' => 'required|date',
            'remarks' => 'required|in:resign,retired',
        ]);

        $separation->update($validated);

        return response()->json($separation);
    }

    public function destroy($id)
    {
        $separation = Separated::findOrFail($id);
        $separation->delete();

        return response()->json(['message' => 'Deleted']);
    }
}
