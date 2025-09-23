<?php

namespace App\Http\Controllers;

use App\Http\Requests\OpportunityTypeRequest;
use App\Services\OpportunityTypeService;

class OpportunityTypeController extends Controller
{
    /**
     * @OA\Get (
     *     path="/api/opportunity-type",
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
    public function index(OpportunityTypeService $service)
    {
        return $service->index();
    }

    /**
     * @OA\Post (
     *     path="/api/opportunity-type",
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
    public function store(OpportunityTypeRequest $request, OpportunityTypeService $opportunityService)
    {
        return $opportunityService->store($request);
    }

    /**
     * @OA\Put (
     *     path="/api/opportunity-type/{opportunity_type_id}",
     *     tags={"Authenticated"},
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(
     *         in="path",
     *         name="opportunity_type_id",
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
    public function update($id, OpportunityTypeRequest $request, OpportunityTypeService $opportunityService)
    {
        return $opportunityService->update($request, $id);
    }

    /**
     * @OA\Delete (
     *     path="/api/opportunity-type/{opportunity_type_id}",
     *     tags={"Authenticated"},
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(
     *         in="path",
     *         name="opportunity_type_id",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *      @OA\Response(
     *          response=200,
     *          description="success"
     *      )
     * )
     */
    public function delete($id, OpportunityTypeService $opportunityService)
    {
        return $opportunityService->delete($id);
    }
}
