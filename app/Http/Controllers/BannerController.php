<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Banner;

class BannerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Banner::all()->map(function ($banner) {
            return [
                'id' => $banner->id,
                'title' => $banner->title,
                'status' => $banner->status,
                'image' => $banner->image ? asset('storage/' . $banner->image) : null,
            ];
        });
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'status' => 'required|boolean',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
        ]);

        $banner = new Banner();
        $banner->title = $request->title;
        $banner->status = $request->status;

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('banners', 'public');
            $banner->image = $path;
        }

        $banner->save();

        return response()->json([
            'message' => 'Banner criado com sucesso!',
            'banner' => [
                'id' => $banner->id,
                'title' => $banner->title,
                'status' => $banner->status,
                'image' => $banner->image ? asset('storage/' . $banner->image) : null,
            ]
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $banner = Banner::findOrFail($id);

        return [
            'id' => $banner->id,
            'title' => $banner->title,
            'status' => $banner->status,
            'image' => $banner->image ? asset('storage/' . $banner->image) : null,
        ];
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $banner = Banner::findOrFail($id);

        $request->validate([
            'title' => 'sometimes|string|max:255',
            'status' => 'sometimes|boolean',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
        ]);

        if ($request->has('title')) {
            $banner->title = $request->title;
        }
        if ($request->has('status')) {
            $banner->status = $request->status;
        }

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('banners', 'public');
            $banner->image = $path;
        }

        $banner->save();

        return response()->json([
            'message' => 'Banner atualizado com sucesso!',
            'banner' => [
                'id' => $banner->id,
                'title' => $banner->title,
                'status' => $banner->status,
                'image' => $banner->image ? asset('storage/' . $banner->image) : null,
            ]
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $banner = Banner::findOrFail($id);
        $banner->delete();

        return response()->json([
            'message' => 'Banner removido com sucesso!'
        ]);
    }
}
