<?php

namespace App\Http\Controllers;

use App\Http\Requests\EducationRequest;
use App\Http\Requests\OpportunityRequest;
use App\Http\Requests\OpportunityViewedRequest;
use App\Http\Requests\ProfileRequest;
use App\Services\EducationService;
use App\Services\OpportunityService;
use App\Services\ProfileService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Client;
use App\Models\Opportunity;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    /**
     * @OA\Get (
     *     path="/api/profile",
     *     tags={"Authenticated"},
     *     security={{"bearerAuth": {}}},
     *      @OA\Response(
     *          response=200,
     *          description="success",
     *          @OA\JsonContent(
     *               type="object",
     *               @OA\Property(
     *                   property="id",
     *                   type="integer"
     *               ),
     *               @OA\Property(
     *                   property="name",
     *                   type="string"
     *               ),
     *               @OA\Property(
     *                   property="cpf",
     *                   type="string"
     *               ),
     *               @OA\Property(
     *                   property="code_crea",
     *                   type="string"
     *               ),
     *               @OA\Property(
     *                   property="email",
     *                   type="string"
     *               ),
     *               @OA\Property(
     *                   property="image",
     *                   type="string"
     *               ),
     *               @OA\Property(
     *                   property="phone",
     *                   type="string"
     *               ),
     *               @OA\Property(
     *                   property="address",
     *                   type="string"
     *               ),
     *               @OA\Property(
     *                   property="complement",
     *                   type="string"
     *               ),
     *               @OA\Property(
     *                   property="state",
     *                   type="object",
     *                   @OA\Property(
     *                       property="id",
     *                       type="integer"
     *                   ),
     *                   @OA\Property(
     *                       property="title",
     *                       type="string"
     *                   ),
     *                   @OA\Property(
     *                       property="letter",
     *                       type="string"
     *                   ),
     *               ),
     *               @OA\Property(
     *                   property="city",
     *                   type="object",
     *                   @OA\Property(
     *                       property="id",
     *                       type="integer"
     *                   ),
     *                   @OA\Property(
     *                       property="title",
     *                       type="string"
     *                   ),
     *               ),
     *               @OA\Property(
     *                   property="description",
     *                   type="string"
     *               ),
     *               @OA\Property(
     *                   property="full_description",
     *                   type="string"
     *               ),
     *               @OA\Property(
     *                   property="link_site",
     *                   type="string"
     *               ),
     *               @OA\Property(
     *                   property="link_instagram",
     *                   type="string"
     *               ),
     *               @OA\Property(
     *                   property="link_twitter",
     *                   type="string"
     *               ),
     *               @OA\Property(
     *                   property="link_linkedin",
     *                   type="string"
     *               ),
     *               @OA\Property(
     *                   property="banner_profile",
     *                   type="string"
     *               ),
     *               @OA\Property(
     *                   property="curriculum",
     *                   type="string"
     *               ),
     *               @OA\Property(
     *                   property="educations",
     *                   type="array",
     *                   @OA\Items(
     *                       type="object",
     *                       @OA\Property(
     *                         property="id",
     *                         type="integer"
     *                       ),
     *                       @OA\Property(
     *                         property="course",
     *                         type="string"
     *                       ),
     *                       @OA\Property(
     *                         property="institution",
     *                         type="string"
     *                       ),
     *                       @OA\Property(
     *                         property="conclusion_at",
     *                         type="date"
     *                       ),
     *                       @OA\Property(
     *                         property="current_situation",
     *                         type="string"
     *                       ),
     *                       @OA\Property(
     *                         property="observation",
     *                         type="string"
     *                       )
     *                   )
     *               ),
     *               @OA\Property(
     *                   property="opportunities",
     *                   type="array",
     *                   @OA\Items(
     *                       type="object",
     *                       @OA\Property(
     *                           property="id",
     *                           type="integer"
     *                       ),
     *                       @OA\Property(
     *                           property="company",
     *                           type="string"
     *                       ),
     *                       @OA\Property(
     *                           property="cnpj",
     *                           type="string"
     *                       ),
     *                       @OA\Property(
     *                           property="state",
     *                           type="object",
     *                           @OA\Property(
     *                               property="id",
     *                               type="integer"
     *                           ),
     *                           @OA\Property(
     *                               property="title",
     *                               type="string"
     *                           ),
     *                           @OA\Property(
     *                               property="letter",
     *                               type="string"
     *                           )
     *                       ),
     *                       @OA\Property(
     *                           property="city",
     *                           type="object",
     *                           @OA\Property(
     *                               property="id",
     *                               type="integer"
     *                           ),
     *                           @OA\Property(
     *                               property="title",
     *                               type="string"
     *                           ),
     *                           @OA\Property(
     *                               property="letter",
     *                               type="string"
     *                           )
     *                       ),
     *                       @OA\Property(
     *                           property="title",
     *                           type="string"
     *                       ),
     *                       @OA\Property(
     *                           property="description",
     *                           type="string"
     *                       ),
     *                       @OA\Property(
     *                           property="full_description",
     *                           type="string"
     *                       ),
     *                       @OA\Property(
     *                           property="status",
     *                           type="boolean"
     *                       ),
     *                       @OA\Property(
     *                           property="situation",
     *                           type="string"
     *                       ),
     *                       @OA\Property(
     *                           property="date",
     *                           type="string",
     *                           format="date"
     *                       ),
     *                       @OA\Property(
     *                           property="salary",
     *                           type="string"
     *                       ),
     *                       @OA\Property(
     *                           property="published_by",
     *                           type="object",
     *                           @OA\Property(
     *                               property="id",
     *                               type="integer"
     *                           ),
     *                           @OA\Property(
     *                               property="name",
     *                               type="string"
     *                           ),
     *                           @OA\Property(
     *                               property="image",
     *                               type="string"
     *                           ),
     *                           @OA\Property(
     *                               property="phone",
     *                               type="string"
     *                           ),
     *                           @OA\Property(
     *                               property="address",
     *                               type="string"
     *                           ),
     *                           @OA\Property(
     *                               property="complement",
     *                               type="string"
     *                           ),
     *                           @OA\Property(
     *                               property="state",
     *                               type="object",
     *                               @OA\Property(
     *                                   property="id",
     *                                   type="integer"
     *                               ),
     *                               @OA\Property(
     *                                   property="title",
     *                                   type="string"
     *                               ),
     *                               @OA\Property(
     *                                   property="letter",
     *                                   type="string"
     *                               )
     *                           ),
     *                           @OA\Property(
     *                               property="city",
     *                               type="object",
     *                               @OA\Property(
     *                                   property="id",
     *                                   type="integer"
     *                               ),
     *                               @OA\Property(
     *                                   property="title",
     *                                   type="string"
     *                               ),
     *                               @OA\Property(
     *                                   property="letter",
     *                                   type="string"
     *                               )
     *                           ),
     *                           @OA\Property(
     *                               property="description",
     *                               type="string"
     *                           )
     *                       ),
     *                        @OA\Property(
     *                            property="candidates",
     *                            type="array",
     *                            @OA\Items(
     *                               @OA\Property(
     *                                   property="id",
     *                                   type="integer"
     *                               ),
     *                               @OA\Property(
     *                                   property="name",
     *                                   type="string"
     *                               ),
     *                               @OA\Property(
     *                                   property="email",
     *                                   type="string"
     *                               ),
     *                               @OA\Property(
     *                                   property="phone",
     *                                   type="string"
     *                               ),
     *                               @OA\Property(
     *                                   property="image",
     *                                   type="string"
     *                               ),
     *                               @OA\Property(
     *                                   property="created_at",
     *                                   type="string",
     *                                   format="date-time"
     *                               ),
     *                               @OA\Property(
     *                                   property="vewed_at",
     *                                   type="string",
     *                                   format="date"
     *                               )
     *                            )
     *                        ),
     *                        @OA\Property(
     *                            property="type",
     *                            type="object",
     *                            @OA\Property(
     *                                property="id",
     *                                type="integer"
     *                            ),
     *                            @OA\Property(
     *                                property="title",
     *                                type="string"
     *                            )
     *                        ),
     *                        @OA\Property(
     *                            property="occupation_area",
     *                            type="object",
     *                            @OA\Property(
     *                                property="id",
     *                                type="integer"
     *                            ),
     *                            @OA\Property(
     *                                property="title",
     *                                type="string"
     *                            )
     *                        )
     *                   )
     *               ),
     *               @OA\Property(
     *                   property="opportunities_applied",
     *                   type="array",
     *                   @OA\Items(
     *                       type="object",
     *                       @OA\Property(
     *                           property="id",
     *                           type="integer"
     *                       ),
     *                       @OA\Property(
     *                           property="company",
     *                           type="string"
     *                       ),
     *                       @OA\Property(
     *                           property="cnpj",
     *                           type="string"
     *                       ),
     *                       @OA\Property(
     *                           property="state",
     *                           type="object",
     *                           @OA\Property(
     *                               property="id",
     *                               type="integer"
     *                           ),
     *                           @OA\Property(
     *                               property="title",
     *                               type="string"
     *                           ),
     *                           @OA\Property(
     *                               property="letter",
     *                               type="string"
     *                           )
     *                       ),
     *                       @OA\Property(
     *                           property="city",
     *                           type="object",
     *                           @OA\Property(
     *                               property="id",
     *                               type="integer"
     *                           ),
     *                           @OA\Property(
     *                               property="title",
     *                               type="string"
     *                           ),
     *                           @OA\Property(
     *                               property="letter",
     *                               type="string"
     *                           )
     *                       ),
     *                       @OA\Property(
     *                           property="title",
     *                           type="string"
     *                       ),
     *                       @OA\Property(
     *                           property="description",
     *                           type="string"
     *                       ),
     *                       @OA\Property(
     *                           property="full_description",
     *                           type="string"
     *                       ),
     *                       @OA\Property(
     *                           property="status",
     *                           type="boolean"
     *                       ),
     *                       @OA\Property(
     *                           property="situation",
     *                           type="string"
     *                       ),
     *                       @OA\Property(
     *                           property="date",
     *                           type="string",
     *                           format="date"
     *                       ),
     *                       @OA\Property(
     *                           property="salary",
     *                           type="string"
     *                       ),
     *                       @OA\Property(
     *                           property="type",
     *                           type="object",
     *                           @OA\Property(
     *                               property="id",
     *                               type="integer"
     *                           ),
     *                           @OA\Property(
     *                               property="title",
     *                               type="string"
     *                           )
     *                       ),
     *                       @OA\Property(
     *                           property="occupation_area",
     *                           type="object",
     *                           @OA\Property(
     *                               property="id",
     *                               type="integer"
     *                           ),
     *                           @OA\Property(
     *                               property="title",
     *                               type="string"
     *                           )
     *                       )
     *                   )
     *               )
     *           )
     *      )
     * )
     */
    public function index(ProfileService $service)
    {
        $profile = Client::query()
            ->with([
                "state",
                "city",
                "educations",
                "opportunities.state",
                "opportunities.city",
                "candidates.state",
                "candidates.city",
                "opportunities",
                "candidates",
            ])
            ->find(Auth::id());

        return response()->json($profile);
    }

    /**
     * @OA\Post (
     *     path="/api/profile",
     *     tags={"Authenticated"},
     *     security={{"bearerAuth": {}}},
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="multipart/form-data",
     *             @OA\Schema(
     *                 @OA\Property(
     *                     property="_method",
     *                     type="string",
     *                     example="PUT"
     *                 ),
     *                 @OA\Property(
     *                     property="name",
     *                     type="string"
     *                 ),
     *                 @OA\Property(
     *                     property="cpf",
     *                     type="string"
     *                 ),
     *                 @OA\Property(
     *                     property="code_crea",
     *                     type="string"
     *                 ),
     *                 @OA\Property(
     *                     property="phone",
     *                     type="string"
     *                 ),
     *                 @OA\Property(
     *                     property="description",
     *                     type="string"
     *                 ),
     *                 @OA\Property(
     *                     property="full_description",
     *                     type="string"
     *                 ),
     *                 @OA\Property(
     *                     property="banner_profile",
     *                     type="string",
     *                     format="binary"
     *                 ),
     *                 @OA\Property(
     *                     property="senge_associate",
     *                     type="integer"
     *                 ),
     *                 @OA\Property(
     *                     property="curriculum",
     *                     type="string",
     *                     format="binary"
     *                 ),
     *                 @OA\Property(
     *                     property="state_id",
     *                     type="integer"
     *                 ),
     *                 @OA\Property(
     *                     property="city_id",
     *                     type="integer"
     *                 ),
     *                 @OA\Property(
     *                     property="address",
     *                     type="string"
     *                 ),
     *                 @OA\Property(
     *                     property="complement",
     *                     type="string"
     *                 ),
     *                 @OA\Property(
     *                     property="link_site",
     *                     type="string"
     *                 ),
     *                 @OA\Property(
     *                     property="link_instagram",
     *                     type="string"
     *                 ),
     *                 @OA\Property(
     *                     property="link_twitter",
     *                     type="string"
     *                 ),
     *                 @OA\Property(
     *                     property="link_linkedin",
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
    public function update(ProfileRequest $request, ProfileService $service)
    {
        try {
            return $service->update($request);
        } catch (\Illuminate\Validation\ValidationException $e) {
            \Illuminate\Support\Facades\Log::error(
                "Erro de validação ProfileController:",
                [
                    "errors" => $e->errors(),
                    "messages" => $e->getMessage(),
                ]
            );
            return response()->json(
                ["errors" => $e->errors(), "message" => $e->getMessage()],
                422
            );
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error(
                "Erro genérico no update ProfileController:",
                [
                    "error" => $e->getMessage(),
                ]
            );
            return response()->json(["message" => "Erro interno"], 500);
        }
    }

    /**
     * @OA\Post (
     *     path="/api/profile/opportunity",
     *     tags={"Authenticated"},
     *     security={{"bearerAuth": {}}},
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(
     *                     property="company",
     *                     type="string"
     *                 ),
     *                 @OA\Property(
     *                     property="cnpj",
     *                     type="string"
     *                 ),
     *                 @OA\Property(
     *                     property="title",
     *                     type="string"
     *                 ),
     *                 @OA\Property(
     *                     property="state_id",
     *                     type="integer"
     *                 ),
     *                 @OA\Property(
     *                     property="city_id",
     *                     type="integer"
     *                 ),
     *                 @OA\Property(
     *                     property="date",
     *                     type="string"
     *                 ),
     *                 @OA\Property(
     *                     property="salary",
     *                     type="string"
     *                 ),
     *                 @OA\Property(
     *                     property="description",
     *                     type="string"
     *                 ),
     *                 @OA\Property(
     *                     property="full_description",
     *                     type="string"
     *                 ),
     *                 @OA\Property(
     *                     property="opportunity_type_id",
     *                     type="integer"
     *                 ),
     *                 @OA\Property(
     *                     property="occupation_area_id",
     *                     type="integer"
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
    public function opportunity_store(OpportunityRequest $request)
    {
        try {
            $validatedData = $request->validate([
                "title" => "required|string|max:255",
                "company" => "required|string|max:255",
                "state_id" => "required|integer|exists:states,id",
                "city_id" => "required|integer|exists:cities,id",
                "description" => "required|string",
                "full_description" => "required|string",
                "date" => "required|date",
                "salary" => "required|numeric|min:0",
                "opportunity_type_id" =>
                "required|integer|exists:opportunity_types,id",
                "occupation_area_id" =>
                "required|integer|exists:occupation_areas,id",
                "cnpj" => "nullable|string|max:20",
            ]);

            if ($request->has("salary")) {
                $salario = intval($request->input("salary")); // Transforma em reais
                $validatedData["salary"] =
                    'R$' . number_format($salario, 0, ".", "");
            }

            $validatedData["user_id"] = auth()->id();

            // Create the opportunity
            $opportunity = Opportunity::create($validatedData);

            return response()->json(
                [
                    "message" => "Opportunity created successfully",
                    "opportunity" => $opportunity,
                ],
                201
            );
        } catch (\Exception $e) {
            return response()->json(["error" => $e->getMessage()], 500);
        }
    }

    /**
     * @OA\Get (
     *     path="/api/profile/opportunity/{opportunity_id}",
     *     tags={"Authenticated"},
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(
     *         in="path",
     *         name="opportunity_id",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="success",
     *          @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                  property="id",
     *                  type="integer"
     *              ),
     *              type="object",
     *              @OA\Property(
     *                  property="company",
     *                  type="string"
     *              ),
     *              @OA\Property(
     *                  property="cnpj",
     *                  type="string"
     *              ),
     *              @OA\Property(
     *                  property="state",
     *                  type="object",
     *                  @OA\Property(
     *                      property="id",
     *                      type="integer"
     *                  ),
     *                  @OA\Property(
     *                      property="title",
     *                      type="string"
     *                  ),
     *                  @OA\Property(
     *                      property="letter",
     *                      type="string"
     *                  )
     *              ),
     *              @OA\Property(
     *                  property="city",
     *                  type="object",
     *                  @OA\Property(
     *                      property="id",
     *                      type="integer"
     *                  ),
     *                  @OA\Property(
     *                      property="title",
     *                      type="string"
     *                  ),
     *                  @OA\Property(
     *                      property="letter",
     *                      type="string"
     *                  )
     *              ),
     *              @OA\Property(
     *                  property="title",
     *                  type="string"
     *              ),
     *              @OA\Property(
     *                  property="description",
     *                  type="string"
     *              ),
     *              @OA\Property(
     *                  property="full_description",
     *                  type="string"
     *              ),
     *              @OA\Property(
     *                  property="status",
     *                  type="boolean"
     *              ),
     *              @OA\Property(
     *                  property="situation",
     *                  type="string"
     *              ),
     *              @OA\Property(
     *                  property="date",
     *                  type="string",
     *                  format="date"
     *              ),
     *              @OA\Property(
     *                  property="salary",
     *                  type="string"
     *              ),
     *              @OA\Property(
     *                  property="published_by",
     *                  type="object",
     *                  @OA\Property(
     *                      property="id",
     *                      type="integer"
     *                  ),
     *                  @OA\Property(
     *                      property="name",
     *                      type="string"
     *                  ),
     *                  @OA\Property(
     *                      property="image",
     *                      type="string"
     *                  ),
     *                  @OA\Property(
     *                      property="phone",
     *                      type="string"
     *                  ),
     *                  @OA\Property(
     *                      property="address",
     *                      type="string"
     *                  ),
     *                  @OA\Property(
     *                      property="complement",
     *                      type="string"
     *                  ),
     *                  @OA\Property(
     *                      property="state",
     *                      type="object",
     *                      @OA\Property(
     *                          property="id",
     *                          type="integer"
     *                      ),
     *                      @OA\Property(
     *                          property="title",
     *                          type="string"
     *                      ),
     *                      @OA\Property(
     *                          property="letter",
     *                          type="string"
     *                      )
     *                  ),
     *                  @OA\Property(
     *                      property="city",
     *                      type="object",
     *                      @OA\Property(
     *                          property="id",
     *                          type="integer"
     *                      ),
     *                      @OA\Property(
     *                          property="title",
     *                          type="string"
     *                      ),
     *                      @OA\Property(
     *                          property="letter",
     *                          type="string"
     *                      )
     *                  ),
     *                  @OA\Property(
     *                      property="description",
     *                      type="string"
     *                  )
     *              ),
     *               @OA\Property(
     *                   property="candidates",
     *                   type="array",
     *                   @OA\Items(
     *                      @OA\Property(
     *                          property="id",
     *                          type="integer"
     *                      ),
     *                      @OA\Property(
     *                          property="name",
     *                          type="string"
     *                      ),
     *                      @OA\Property(
     *                          property="email",
     *                          type="string"
     *                      ),
     *                      @OA\Property(
     *                          property="phone",
     *                          type="string"
     *                      ),
     *                      @OA\Property(
     *                          property="image",
     *                          type="string"
     *                      ),
     *                      @OA\Property(
     *                          property="created_at",
     *                          type="string",
     *                          format="date-time"
     *                      ),
     *                      @OA\Property(
     *                          property="vewed_at",
     *                          type="string",
     *                          format="date"
     *                      )
     *                   )
     *               ),
     *               @OA\Property(
     *                   property="type",
     *                   type="object",
     *                   @OA\Property(
     *                       property="id",
     *                       type="integer"
     *                   ),
     *                   @OA\Property(
     *                       property="title",
     *                       type="string"
     *                   )
     *               ),
     *               @OA\Property(
     *                   property="occupation_area",
     *                   type="object",
     *                   @OA\Property(
     *                       property="id",
     *                       type="integer"
     *                   ),
     *                   @OA\Property(
     *                       property="title",
     *                       type="string"
     *                   )
     *               )
     *         )
     *      )
     * )
     */
    public function opportunity_show(
        Request $request,
        ProfileService $service,
        $opportunity_id
    ) {
        return $service->showOpportunity($request, $opportunity_id);
    }

    /**
     * @OA\Get (
     *     path="/api/profile/opportunities-applied/{opportunity_id}",
     *     tags={"Authenticated"},
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(
     *         in="path",
     *         name="opportunity_id",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="success",
     *          @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                  property="id",
     *                  type="integer"
     *              ),
     *              type="object",
     *              @OA\Property(
     *                  property="company",
     *                  type="string"
     *              ),
     *              @OA\Property(
     *                  property="cnpj",
     *                  type="string"
     *              ),
     *              @OA\Property(
     *                  property="state",
     *                  type="object",
     *                  @OA\Property(
     *                      property="id",
     *                      type="integer"
     *                  ),
     *                  @OA\Property(
     *                      property="title",
     *                      type="string"
     *                  ),
     *                  @OA\Property(
     *                      property="letter",
     *                      type="string"
     *                  )
     *              ),
     *              @OA\Property(
     *                  property="city",
     *                  type="object",
     *                  @OA\Property(
     *                      property="id",
     *                      type="integer"
     *                  ),
     *                  @OA\Property(
     *                      property="title",
     *                      type="string"
     *                  ),
     *                  @OA\Property(
     *                      property="letter",
     *                      type="string"
     *                  )
     *              ),
     *              @OA\Property(
     *                  property="title",
     *                  type="string"
     *              ),
     *              @OA\Property(
     *                  property="description",
     *                  type="string"
     *              ),
     *              @OA\Property(
     *                  property="full_description",
     *                  type="string"
     *              ),
     *              @OA\Property(
     *                  property="status",
     *                  type="boolean"
     *              ),
     *              @OA\Property(
     *                  property="situation",
     *                  type="string"
     *              ),
     *              @OA\Property(
     *                  property="date",
     *                  type="string",
     *                  format="date"
     *              ),
     *              @OA\Property(
     *                  property="salary",
     *                  type="string"
     *              ),
     *               @OA\Property(
     *                   property="type",
     *                   type="object",
     *                   @OA\Property(
     *                       property="id",
     *                       type="integer"
     *                   ),
     *                   @OA\Property(
     *                       property="title",
     *                       type="string"
     *                   )
     *               ),
     *               @OA\Property(
     *                   property="occupation_area",
     *                   type="object",
     *                   @OA\Property(
     *                       property="id",
     *                       type="integer"
     *                   ),
     *                   @OA\Property(
     *                       property="title",
     *                       type="string"
     *                   )
     *               )
     *         )
     *      )
     * )
     */
    public function opportunity_applied_show(
        Request $request,
        ProfileService $service,
        $opportunity_id
    ) {
        return $service->showOpportunityApplied($request, $opportunity_id);
    }

    /**
     * @OA\Put (
     *     path="/api/profile/opportunity/{opportunity_id}",
     *     tags={"Authenticated"},
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(
     *         in="path",
     *         name="opportunity_id",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(
     *                     property="company",
     *                     type="string"
     *                 ),
     *                 @OA\Property(
     *                     property="cnpj",
     *                     type="string"
     *                 ),
     *                 @OA\Property(
     *                     property="title",
     *                     type="string"
     *                 ),
     *                 @OA\Property(
     *                     property="state_id",
     *                     type="integer"
     *                 ),
     *                 @OA\Property(
     *                     property="city_id",
     *                     type="integer"
     *                 ),
     *                 @OA\Property(
     *                     property="date",
     *                     type="string"
     *                 ),
     *                 @OA\Property(
     *                     property="salary",
     *                     type="string"
     *                 ),
     *                 @OA\Property(
     *                     property="description",
     *                     type="string"
     *                 ),
     *                 @OA\Property(
     *                     property="full_description",
     *                     type="string"
     *                 ),
     *                 @OA\Property(
     *                     property="opportunity_type_id",
     *                     type="integer"
     *                 ),
     *                 @OA\Property(
     *                     property="occupation_area_id",
     *                     type="integer"
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
    public function opportunity_update(
        $id,
        OpportunityRequest $request,
        OpportunityService $opportunityService
    ) {
        return $opportunityService->update($request, $id);
    }

    /**
     * @OA\Delete (
     *     path="/api/profile/opportunity/{opportunity_id}",
     *     tags={"Authenticated"},
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(
     *         in="path",
     *         name="opportunity_id",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *      @OA\Response(
     *          response=200,
     *          description="success"
     *      )
     * )
     */
    public function opportunity_delete(
        $id,
        Request $request,
        OpportunityService $opportunityService
    ) {
        return $opportunityService->delete($request, $id);
    }

    /**
     * @OA\Post (
     *     path="/api/profile/opportunity/{opportunity_id}/associate",
     *     tags={"Authenticated"},
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(
     *         in="path",
     *         name="opportunity_id",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *      @OA\Response(
     *          response=200,
     *          description="success"
     *      )
     * )
     */
    public function opportunity_associate(
        OpportunityService $opportunityService,
        $opportunity_id
    ) {
        return $opportunityService->associate($opportunity_id);
    }
    /**
     * @OA\Post (
     *     path="/api/profile/opportunity/{opportunity_id}/viewed",
     *     tags={"Authenticated"},
     *     @OA\Parameter(
     *         in="path",
     *         name="opportunity_id",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     security={{"bearerAuth": {}}},
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(
     *                     property="candidate_id",
     *                     type="integer"
     *                 ),
     *             )
     *         )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="success"
     *      )
     * )
     */
    public function opportunity_viewed(
        OpportunityViewedRequest $request,
        OpportunityService $opportunityService,
        $opportunity_id
    ) {
        return $opportunityService->viewed(
            $opportunity_id,
            $request->get("candidate_id")
        );
    }
    /**
     * @OA\Delete (
     *     path="/api/profile/opportunity/{opportunity_id}/associate",
     *     tags={"Authenticated"},
     *     @OA\Parameter(
     *         in="path",
     *         name="opportunity_id",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     security={{"bearerAuth": {}}},
     *      @OA\Response(
     *          response=200,
     *          description="success"
     *      )
     * )
     */
    public function opportunity_disassociate(
        OpportunityService $opportunityService,
        $opportunity_id
    ) {
        return $opportunityService->disassociate($opportunity_id);
    }

    /**
     * @OA\Post (
     *     path="/api/profile/education",
     *     tags={"Authenticated"},
     *     security={{"bearerAuth": {}}},
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(
     *                     property="course",
     *                     type="string"
     *                 ),
     *                 @OA\Property(
     *                     property="institution",
     *                     type="string"
     *                 ),
     *                 @OA\Property(
     *                     property="conclusion_at",
     *                     type="date"
     *                 ),
     *                 @OA\Property(
     *                     property="current_situation",
     *                     type="string",
     *                     example="interrupted,in_progress,done"
     *                 ),
     *                 @OA\Property(
     *                     property="observation",
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
    public function education_store(
        EducationRequest $request,
        EducationService $educationService
    ) {
        return $educationService->store($request);
    }

    /**
     * @OA\Put (
     *     path="/api/profile/education/{education_id}",
     *     tags={"Authenticated"},
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(
     *         in="path",
     *         name="education_id",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(
     *                     property="course",
     *                     type="string"
     *                 ),
     *                 @OA\Property(
     *                     property="institution",
     *                     type="string"
     *                 ),
     *                 @OA\Property(
     *                     property="conclusion_at",
     *                     type="date"
     *                 ),
     *                 @OA\Property(
     *                     property="current_situation",
     *                     type="string",
     *                     example="interrupted,in_progress,done"
     *                 ),
     *                 @OA\Property(
     *                     property="observation",
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
    public function education_update(
        $id,
        EducationRequest $request,
        EducationService $educationService
    ) {
        return $educationService->update($request, $id);
    }

    /**
     * @OA\Delete (
     *     path="/api/profile/education/{education_id}",
     *     tags={"Authenticated"},
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(
     *         in="path",
     *         name="education_id",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *      @OA\Response(
     *          response=200,
     *          description="success"
     *      )
     * )
     */
    public function education_delete(
        $id,
        Request $request,
        EducationService $educationService
    ) {
        return $educationService->delete($request, $id);
    }

    public function deleteCurriculum($id)
    {
        // Locate the profile by ID
        $profile = Client::find($id);

        // Check if curriculum exists in the profile
        if ($profile->curriculum) {
            // Delete the curriculum file from storage if it exists
            if (Storage::exists($profile->curriculum)) {
                Storage::delete($profile->curriculum);
            }

            // Set the curriculum path to null in the database
            $profile->update(["curriculum" => null]);

            return response()->json(
                ["message" => "Curriculum removed successfully."],
                200
            );
        }

        return response()->json(["message" => "Curriculum not found."], 404);
    }

    /**
     * @OA\Post (
     *     path="/api/send-opportunity-email/{opportunity_id}",
     *     tags={"Authenticated"},
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(
     *         in="path",
     *         name="opportunity_id",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Email sent successfully."
     *     )
     * )
     */
    public function sendOpportunityEmail($opportunity_id)
    {
        if (!is_numeric($opportunity_id)) {
            return response()->json(["error" => "Invalid opportunity ID"], 400);
        }

        $opportunity = Opportunity::find($opportunity_id);
        if (!$opportunity) {
            return response()->json(["error" => "Opportunity not found"], 404);
        }

        return response()->json(["message" => "Email sent successfully."], 200);
    }
}
