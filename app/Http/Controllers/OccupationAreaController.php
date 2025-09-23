<?php

namespace App\Http\Controllers;

use App\Http\Requests\OccupationAreaRequest;
use App\Services\OccupationAreaService;

class OccupationAreaController extends Controller
{
    /**
     * @OA\Get (
     *     path="/api/occupation-area",
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
     *                 )
     *             )
     *         )
     *      )
     * )
     */
    public function index(OccupationAreaService $service)
    {
        return $service->index();
    }

    /**
     * @OA\Post (
     *     path="/api/occupation-area",
     *     tags={"Authenticated"},
     *     security={{"bearerAuth": {}}},
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(
     *                     property="title",
     *                     type="string"
     *                 )
     *             )
     *         )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="success"
     *      )
     * )
     */
    public function store(OccupationAreaRequest $request, OccupationAreaService $opportunityService)
    {
        return $opportunityService->store($request);
    }

    /**
     * @OA\Put (
     *     path="/api/occupation-area/{occupation_area_id}",
     *     tags={"Authenticated"},
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(
     *         in="path",
     *         name="occupation_area_id",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(
     *                     property="title",
     *                     type="string"
     *                 )
     *             )
     *         )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="success"
     *      )
     * )
     */
    public function update($id, OccupationAreaRequest $request, OccupationAreaService $opportunityService)
    {
        return $opportunityService->update($request, $id);
    }

    /**
     * @OA\Delete (
     *     path="/api/occupation-area/{occupation_area_id}",
     *     tags={"Authenticated"},
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(
     *         in="path",
     *         name="occupation_area_id",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *      @OA\Response(
     *          response=200,
     *          description="success"
     *      )
     * )
     */
    public function delete($id, OccupationAreaService $opportunityService)
    {
        return $opportunityService->delete($id);
    }
}
