<?php

namespace App\Services;

use App\Http\Resources\OccupationAreaResource;
use App\Models\OccupationArea;

class OccupationAreaService
{
    public function index()
    {
        return OccupationAreaResource::collection(OccupationArea::status()->orderBy('title')->get());
    }

    public function store($request)
    {
        $request->merge(['status' => true]);
        return new OccupationAreaResource(OccupationArea::create($request->all()));
    }

    public function update($request, $id)
    {
        return OccupationArea::findOrFail($id)->update($request->all());
    }

    public function delete($id)
    {
        return OccupationArea::findOrFail($id)->delete();
    }
}
