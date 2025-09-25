<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\HomeBookRoom;

class HomeBookRoomController extends Controller
{
    /**
     * Lista todos os registros.
     */
    public function index()
    {
        return HomeBookRoom::all()->map(function ($room) {
            return [
                'id' => $room->id,
                'title' => $room->title,
                'description' => $room->description,
                'image' => $room->image ? asset('storage/' . $room->image) : null,
            ];
        });
    }

    /**
     * Cria um novo registro.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
        ]);

        $room = new HomeBookRoom();
        $room->title = $request->title;
        $room->description = $request->description;

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('home_book_rooms', 'public');
            $room->image = $path;
        }

        $room->save();

        return response()->json([
            'message' => 'Home Book Room criado com sucesso!',
            'room' => [
                'id' => $room->id,
                'title' => $room->title,
                'description' => $room->description,
                'image' => $room->image ? asset('storage/' . $room->image) : null,
            ]
        ], 201);
    }

    /**
     * Atualiza um registro existente.
     */
    public function update(Request $request, string $id)
    {
        $room = HomeBookRoom::findOrFail($id);

        $request->validate([
            'title' => 'sometimes|string|max:255',
            'description' => 'sometimes|string',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
        ]);

        if ($request->has('title')) $room->title = $request->title;
        if ($request->has('description')) $room->description = $request->description;

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('home_book_rooms', 'public');
            $room->image = $path;
        }

        $room->save();

        return response()->json([
            'message' => 'Home Book Room atualizado com sucesso!',
            'room' => [
                'id' => $room->id,
                'title' => $room->title,
                'description' => $room->description,
                'image' => $room->image ? asset('storage/' . $room->image) : null,
            ]
        ]);
    }

    /**
     * Remove um registro.
     */
    public function destroy(string $id)
    {
        $room = HomeBookRoom::findOrFail($id);
        $room->delete();

        return response()->json([
            'message' => 'Home Book Room removido com sucesso!'
        ]);
    }
}
