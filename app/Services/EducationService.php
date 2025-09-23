<?php

namespace App\Services;

use App\Http\Resources\EducationResource;
use App\Models\Client;
use App\Models\Education;

class EducationService
{
    public function list()
    {
        return EducationResource::collection(
            Education::orderBy('id', 'desc')->get()
        );
    }

    public function store($request)
    {
        $client = Client::find($request->user()->id);
        $data = $request->all();
        $data['user_id'] = $request->user()->id;
        return new EducationResource($client->educations()->create($data));
    }

    public function update($request, $id)
    {
        $client = Client::find($request->user()->id);
        return $client->educations()->findOrFail($id)->update($request->all());
    }

    public function delete($request, $id)
    {
        $client = Client::find($request->user()->id);
        return $client->educations()->findOrFail($id)->delete();
    }
}
