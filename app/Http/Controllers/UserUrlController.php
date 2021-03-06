<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ShortUrl;
use App\Models\Visit;

class UserUrlController extends Controller
{
    public function __construct(ShortUrl $shortUrl, Visit $visit) {
        $this->shortUrl = $shortUrl;
        $this->visit = $visit;
    }

    /**
     * List of User's Urls
     * @OA\Get (
     *     path="/api/v1/my-url",
     *     tags={"User Url"},
     *      @OA\Response(
     *          response=200,
     *          description="Success",
     *          @OA\JsonContent(
     *              @OA\Property(property="meta", type="object",
     *                  @OA\Property(property="code", type="number", example=200),
     *                  @OA\Property(property="status", type="string", example="success"),
     *                  @OA\Property(property="message", type="string", example="User's urls fetched successfully."),
     *              ),
     *              @OA\Property(property="data", type="array", collectionFormat="multi",
     *                  @OA\Items(
     *                      type="object",
     *                          @OA\Property(property="id", type="number", example=2),
     *                          @OA\Property(property="user_id", type="number", example=2),
     *                          @OA\Property(property="name", type="string", example="github"),
     *                          @OA\Property(property="original_url", type="string", example="http://github.com/fajarwz"),
     *                          @OA\Property(property="short_url", type="string", example="fajargithub"),
     *                          @OA\Property(property="created_at", type="string", example="2022-07-11 21:37:41"),
     *                          @OA\Property(property="updated_at", type="string", example="2022-07-11 21:37:41"),
     *                  )
     *              ),
     *          )
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Invalid token",
     *          @OA\JsonContent(
     *              @OA\Property(property="meta", type="object",
     *                  @OA\Property(property="code", type="number", example=422),
     *                  @OA\Property(property="status", type="string", example="error"),
     *                  @OA\Property(property="message", type="string", example="Unauthenticated."),
     *              ),
     *              @OA\Property(property="data", type="object", example={}),
     *          )
     *      ),
     *      security={
     *         {"Authorization": {}}
     *     }
     * )
     */
    public function index() {
        return successResponse($this->shortUrl::whereUserId(auth()->id())->get(), "User's urls fetched successfully.");
    }

    /**
     * List of User's Url Visits
     * @OA\Get (
     *     path="/api/v1/visit/{shortUrlId}",
     *     tags={"User Url"},
     *      @OA\Parameter(
     *          name="shortUrlId",
     *          in="path",
     *          required=true,
     *          @OA\Schema(
     *              type="number"
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Success",
     *          @OA\JsonContent(
     *              @OA\Property(property="meta", type="object",
     *                  @OA\Property(property="code", type="number", example=200),
     *                  @OA\Property(property="status", type="string", example="success"),
     *                  @OA\Property(property="message", type="string", example="User's urls fetched successfully."),
     *              ),
     *              @OA\Property(property="data", type="array", collectionFormat="multi",
     *                  @OA\Items(
     *                      type="object",
     *                          @OA\Property(property="id", type="number", example=2),
     *                          @OA\Property(property="user_id", type="number", example=2),
     *                          @OA\Property(property="name", type="string", example="github"),
     *                          @OA\Property(property="original_url", type="string", example="http://github.com/fajarwz"),
     *                          @OA\Property(property="short_url", type="string", example="fajargithub"),
     *                          @OA\Property(property="created_at", type="string", example="2022-07-11 21:37:41"),
     *                          @OA\Property(property="updated_at", type="string", example="2022-07-11 21:37:41"),
     *                  )
     *              ),
     *          )
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Invalid token",
     *          @OA\JsonContent(
     *              @OA\Property(property="meta", type="object",
     *                  @OA\Property(property="code", type="number", example=422),
     *                  @OA\Property(property="status", type="string", example="error"),
     *                  @OA\Property(property="message", type="string", example="Unauthenticated."),
     *              ),
     *              @OA\Property(property="data", type="object", example={}),
     *          )
     *      ),
     *      security={
     *         {"Authorization": {}}
     *     }
     * )
     */
    public function urlVisits($shortUrlId) {
        $url = $this->shortUrl::with('visits')->find($shortUrlId);

        if((int) $url->user_id === auth()->id()) 
            return successResponse($url, "User's urls fetched successfully.");

        return errorResponse([], 'Not found', 404);
    }
}
