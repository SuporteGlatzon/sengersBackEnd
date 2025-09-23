<?php

namespace App\Http\Controllers;

use App\Http\Resources\HomeAssociateResource;
use App\Http\Resources\HomeBookRoomResource;
use App\Http\Resources\HomeBannerResource;
use App\Http\Resources\HomeCardResource;
use App\Models\HomeAssociate;
use App\Models\HomeBanner;
use App\Models\HomeBookRoom;
use App\Models\HomeCard;

class HomeController extends Controller
{
    /**
     * @OA\Get (
     *     path="/api/home",
     *     tags={"Unauthenticated"},
     *      @OA\Response(
     *          response=200,
     *          description="success",
     *          @OA\JsonContent(
     *              @OA\Property(
     *                  property="banner",
     *                  type="array",
     *                  @OA\Items(
     *                      @OA\Property(
     *                          property="image",
     *                          type="string"
     *                      ),
     *                      @OA\Property(
     *                          property="title",
     *                          type="string"
     *                      ),
     *                      @OA\Property(
     *                          property="subtitle",
     *                          type="string"
     *                      ),
     *                      @OA\Property(
     *                          property="button_link",
     *                          type="string"
     *                      ),
     *                      @OA\Property(
     *                          property="button_text",
     *                          type="string"
     *                      )
     *                  )
     *              ),
     *              @OA\Property(
     *                  property="associates",
     *                  type="array",
     *                  @OA\Items(
     *                      @OA\Property(
     *                          property="title",
     *                          type="string"
     *                      ),
     *                      @OA\Property(
     *                          property="subtitle",
     *                          type="string"
     *                      ),
     *                      @OA\Property(
     *                          property="image",
     *                          type="string"
     *                      ),
     *                      @OA\Property(
     *                          property="description",
     *                          type="string"
     *                      ),
     *                      @OA\Property(
     *                          property="orange_text",
     *                          type="string"
     *                      ),
     *                      @OA\Property(
     *                          property="title_right",
     *                          type="string"
     *                      ),
     *                      @OA\Property(
     *                          property="button_link",
     *                          type="string"
     *                      ),
     *                      @OA\Property(
     *                          property="button_text",
     *                          type="string"
     *                      ),
     *                      @OA\Property(
     *                          property="advantages",
     *                          type="array",
     *                          @OA\Items(
     *                              anyOf={
     *                                  @OA\Schema(type="string"),
     *                                  @OA\Schema(type="string"),
     *                                  @OA\Schema(type="string")
     *                              }
     *                          )
     *                      )
     *                  )
     *              ),
     *              @OA\Property(
     *                  property="book_rooms",
     *                  type="array",
     *                  @OA\Items(
     *                      @OA\Property(
     *                          property="title",
     *                          type="string"
     *                      ),
     *                      @OA\Property(
     *                          property="image",
     *                          type="string"
     *                      ),
     *                      @OA\Property(
     *                          property="description",
     *                          type="string"
     *                      ),
     *                      @OA\Property(
     *                          property="orange_text",
     *                          type="string"
     *                      ),
     *                      @OA\Property(
     *                          property="title_right",
     *                          type="string"
     *                      ),
     *                      @OA\Property(
     *                          property="room",
     *                          type="array",
     *                          @OA\Items(
     *                              anyOf={
     *                                  @OA\Schema(type="string"),
     *                                  @OA\Schema(type="string"),
     *                                  @OA\Schema(type="string")
     *                              }
     *                          )
     *                      ),
     *                      @OA\Property(
     *                          property="button_link",
     *                          type="string"
     *                      ),
     *                      @OA\Property(
     *                          property="button_text",
     *                          type="string"
     *                      )
     *                  )
     *              )
     *          )
     *      )
     * )
     */
    public function index()
    {
        return [
            'banner' => HomeBannerResource::collection(HomeBanner::status()->get()),
            'associates' => HomeAssociateResource::collection(HomeAssociate::status()->get()),
            'book_rooms' => HomeBookRoomResource::collection(HomeBookRoom::status()->get()),
            'card' => HomeCardResource::collection(HomeCard::status()->get()),
        ];
    }
}
