<?php

namespace App\Http\Controllers;

use App\Http\Resources\StateResource;
use App\Models\State;

class StateController extends Controller
{
    /**
     * @OA\Get (
     *     path="/api/state",
     *     tags={"Unauthenticated"},
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
     *                 ),
     *                 @OA\Property(
     *                     property="letter",
     *                     type="string"
     *                 )
     *             )
     *         )
     *      )
     * )
     */
    public function index()
    {
        return StateResource::collection(State::where(function ($query) {
            if (request()->get('whereHas') === 'opportunity') {
                $query->whereHas('opportunities');
            }
            return $query;
        })->orderBy('title')->get());
    }
}
