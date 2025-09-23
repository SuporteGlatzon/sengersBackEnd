<?php

namespace App\Http\Controllers;

use App\Services\SettingService;

class SettingController extends Controller
{
    /**
     * @OA\Get (
     *     path="/api/settings",
     *     tags={"Unauthenticated"},
     *      @OA\Response(
     *          response=200,
     *          description="success",
     *          @OA\JsonContent(
     *             type="array",
     *             @OA\Items(
     *                 type="object",
     *                 @OA\Property(
     *                     property="key",
     *                     type="string"
     *                 ),
     *                 @OA\Property(
     *                     property="value",
     *                     type="string"
     *                 ),
     *                 @OA\Property(
     *                     property="description",
     *                     type="string"
     *                 )
     *             )
     *         )
     *      )
     * )
     */
    public function index(SettingService $service)
    {
        return $service->index();
    }
}
