<?php

namespace App\Http\Controllers;

use App\Http\Requests\ShortUrl\CustomUrlRequest;
use App\Http\Requests\ShortUrl\StoreRequest;
use App\Models\ShortUrl;

class ShortUrlController extends Controller
{
    public function __construct(ShortUrl $shortUrl)
    {
        $this->shortUrl = $shortUrl;
    }

    /**
     * Shorten Url with random string
     * @OA\Post (
     *     path="/api/v1/short-url",
     *     tags={"Short Url"},
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(
     *                      type="object",
     *                      @OA\Property(
     *                          property="name",
     *                          type="string"
     *                      ),
     *                      @OA\Property(
     *                          property="original_url",
     *                          type="string"
     *                      )
     *                 ),
     *                 example={
     *                     "name":"my web",
     *                     "original_url":"http://example.com"
     *                }
     *             )
     *         )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Success",
     *          @OA\JsonContent(
     *              @OA\Property(property="meta", type="object",
     *                  @OA\Property(property="code", type="number", example=200),
     *                  @OA\Property(property="status", type="string", example="success"),
     *                  @OA\Property(property="message", type="string", example="Url shortened successfully."),
     *              ),
     *              @OA\Property(property="data", type="object",
     *                  @OA\Property(property="name", type="string", example="my web"),
     *                  @OA\Property(property="original_url", type="string", example="http://example.com"),
     *                  @OA\Property(property="short_url", type="string", example="MlzN1"),
     *              ),
     *          )
     *      ),
     *      @OA\Response(
     *          response=422,
     *          description="Validation error",
     *          @OA\JsonContent(
     *              @OA\Property(property="meta", type="object",
     *                  @OA\Property(property="code", type="number", example=422),
     *                  @OA\Property(property="status", type="string", example="error"),
     *                  @OA\Property(property="message", type="object", 
     *                      @OA\Property(property="original_url", type="array", collectionFormat="multi",
     *                        @OA\Items(
     *                          type="string",
     *                          example="The original url field is required.",
     *                          )
     *                      ),
     *                  ),
     *              ),
     *              @OA\Property(property="data", type="object", example={}),
     *          )
     *      ),
     * )
     */
    public function store(StoreRequest $request)
    {
        $createShortUrl = $this->shortUrl::create(array_merge(
            $request->validated(),
            [
                'user_id' => config('app.guest_id'),
                'original_url' => strpos($request->original_url, 'http') !== 0 ? "http://$request->original_url" : $request->original_url,
            ]
        ));

        if ($createShortUrl)
        {
            return successResponse([
                'name' => $createShortUrl['name'],
                'original_url' => $createShortUrl['original_url'],
                'short_url' => $createShortUrl['short_url'],
            ], "Url shortened successfully.");
        }

        return errorResponse([], 'Error! Please try again later', 500);

    }

    /**
     * Shorten Url with custom string
     * @OA\Post (
     *     path="/api/v1/custom-url",
     *     tags={"Short Url"},
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(
     *                      type="object",
     *                      @OA\Property(
     *                          property="name",
     *                          type="string"
     *                      ),
     *                      @OA\Property(
     *                          property="original_url",
     *                          type="string"
     *                      ),
     *                      @OA\Property(
     *                          property="short_url",
     *                          type="string"
     *                      )
     *                 ),
     *                 example={
     *                     "name":"github",
     *                     "original_url":"http://github.com/fajarwz",
     *                     "short_url":"fajargithub"
     *                }
     *             )
     *         )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Success",
     *          @OA\JsonContent(
     *              @OA\Property(property="meta", type="object",
     *                  @OA\Property(property="code", type="number", example=200),
     *                  @OA\Property(property="status", type="string", example="success"),
     *                  @OA\Property(property="message", type="string", example="Url shortened successfully."),
     *              ),
     *              @OA\Property(property="data", type="object",
     *                  @OA\Property(property="name", type="string", example="github"),
     *                  @OA\Property(property="original_url", type="string", example="http://github.com/fajarwz"),
     *                  @OA\Property(property="short_url", type="string", example="fajargithub"),
     *              ),
     *          )
     *      ),
     *      @OA\Response(
     *          response=422,
     *          description="Validation error",
     *          @OA\JsonContent(
     *              @OA\Property(property="meta", type="object",
     *                  @OA\Property(property="code", type="number", example=422),
     *                  @OA\Property(property="status", type="string", example="error"),
     *                  @OA\Property(property="message", type="object", 
     *                      @OA\Property(property="original_url", type="array", collectionFormat="multi",
     *                        @OA\Items(
     *                          type="string",
     *                          example="The original url field is required.",
     *                          )
     *                      ),
     *                  ),
     *              ),
     *              @OA\Property(property="data", type="object", example={}),
     *          )
     *      ),
     *      security={
     *         {"Authorization": {}}
     *      }
     * )
     */
    public function customUrl(CustomUrlRequest $request)
    {
        $createShortUrl = $this->shortUrl::create(array_merge(
            $request->validated(),
            ['user_id' => auth()->id()]
        ));

        if ($createShortUrl)
        {
            return successResponse([
                'name' => $createShortUrl['name'],
                'original_url' => $createShortUrl['original_url'],
                'short_url' => $createShortUrl['short_url'],
            ], "Url shortened successfully.");
        }

        return errorResponse([], 'Error! Please try again later', 500);

    }

}
