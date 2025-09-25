<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\HomeAssociate;

class HomeAssociateController extends Controller
{
    /**
     * Lista todos os registros.
     */
    public function index()
    {
        return HomeAssociate::all()->map(function ($associate) {
            return [
                'id' => $associate->id,
                'name' => $associate->name,
                'position' => $associate->position,
                'image' => $associate->image ? asset('storage/' . $associate->image) : null,
            ];
        });
    }

    /**
     * Cria um novo registro.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'position' => 'nullable|string|max:255',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
        ]);

        $associate = new HomeAssociate();
        $associate->name = $request->name;
        $associate->position = $request->position;

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('home_associates', 'public');
            $associate->image = $path;
        }

        $associate->save();

        return response()->json([
            'message' => 'Home Associate criado com sucesso!',
            'associate' => [
                'id' => $associate->id,
                'name' => $associate->name,
                'position' => $associate->position,
                'image' => $associate->image ? asset('storage/' . $associate->image) : null,
            ]
        ], 201);
    }

    /**
     * Atualiza um registro existente.
     */
    public function update(Request $request, string $id)
    {
        $associate = HomeAssociate::findOrFail($id);

        $request->validate([
            'name' => 'sometimes|string|max:255',
            'position' => 'sometimes|string|max:255',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
        ]);

        if ($request->has('name')) $associate->name = $request->name;
        if ($request->has('position')) $associate->position = $request->position;

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('home_associates', 'public');
            $associate->image = $path;
        }

        $associate->save();

        return response()->json([
            'message' => 'Home Associate atualizado com sucesso!',
            'associate' => [
                'id' => $associate->id,
                'name' => $associate->name,
                'position' => $associate->position,
                'image' => $associate->image ? asset('storage/' . $associate->image) : null,
            ]
        ]);
    }

    /**
     * Remove um registro.
     */
    public function destroy(string $id)
    {
        $associate = HomeAssociate::findOrFail($id);
        $associate->delete();

        return response()->json([
            'message' => 'Home Associate removido com sucesso!'
        ]);
    }
}

