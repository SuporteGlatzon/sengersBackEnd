<?php

namespace App\Http\Controllers;

use App\Http\Resources\CityResource;
use App\Models\City;

class CityController extends Controller
{
    /**
     * @OA\Get (
     *     path="/api/city/{state_id}",
     *     tags={"Unauthenticated"},
     *     @OA\Parameter(
     *         in="path",
     *         name="state_id",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *      @OA\Response(
     *          response=200,
     *          description="success",
     *          @OA\JsonContent(
     *             type="array",
     *             @OA\Items(
     *                 type="object",
     *                 @OA\Property(
     *                     property="id",
     *                     type="integer"
     *                 ),
     *                 @OA\Property(
     *                     property="title",
     *                     type="string"
     *                 )
     *             )
     *         )
     *      )
     * )
     */
    public function index($state_id)
    {
        return CityResource::collection(City::where(function ($query) {
            if (request()->get('whereHas') === 'opportunity') {
                $query->whereHas('opportunities');
            }
            return $query;
        })->where('state_id', $state_id)->orderBy('title')->get());
    }
}
