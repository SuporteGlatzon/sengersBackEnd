<?php

namespace App\Services;

use App\Http\Resources\OpportunityTypeResource;
use App\Models\OpportunityType;

class OpportunityTypeService
{
    public function index()
    {
        return OpportunityTypeResource::collection(OpportunityType::status()->orderBy('title')->get());
    }

    public function store($request)
    {
        $request->merge(['status' => true]);
        return new OpportunityTypeResource(OpportunityType::create($request->all()));
    }

    public function update($request, $id)
    {
        return OpportunityType::findOrFail($id)->update($request->all());
    }

    public function delete($id)
    {
        return OpportunityType::findOrFail($id)->delete();
    }
}
