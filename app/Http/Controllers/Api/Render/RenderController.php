<?php

namespace App\Http\Controllers\Api\Render;

use App\Http\Controllers\Controller;
use App\Models\Render;
use App\Models\Translation;
use App\Transformers\Render\RenderTransformer;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use function fractal;

/**
 * Class RegisterController
 * @package  App\Http\Controllers\Api\Auth
 */
class RenderController extends Controller
{
    protected $model;

    public function __construct(Render $model)
    {
        $this->model = $model;
    }

    /**
     * @OA\Post(
     *  operationId="createRender",
     *  summary="Create new Render",
     *  description="Create new Render",
     *  tags={"Renders"},
     *  path="/api/render/store",
     *  @OA\RequestBody(
     *    description="Render to store",
     *    required=true,
     *    @OA\MediaType(
     *      mediaType="application/json",
     *      @OA\Schema(
     *      @OA\Property(type="integer",description="id of Render",title="id",property="id",example="1",readOnly="true"),
     *      @OA\Property(type="string",description="render Text",title="render",property="render",example="Bohužel, stránka se nepodařila načíst."),
     *      @OA\Property(type="integer",description="id of Language",title="language_id",property="language_id",example="1"),
     *      @OA\Property(type="integer",description="id of Translation",title="translation_id",property="translation_id",example="1")
     *     )
     *    )
     *  ),
     *  @OA\Response(response="201",description="Render stored",
     *     @OA\JsonContent(
     *      @OA\Property(
     *       title="data",
     *       property="data",
     *       type="object",
     *       ref="#/components/schemas/Render"
     *      ),
     *    ),
     *  ),
     *  @OA\Response(response=422,description="Validation exception"),
     * )
     *
     * @param Request $request
     * @return JsonResponse
     * @throws ValidationException
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'render' => 'required',
            'language_id' => 'required',
            'translation_id' => 'required'
        ]);
        $render = $this->model->create($request->all());

        return fractal($render, new RenderTransformer())->respond(201);
    }

    /**
     * @OA\Get(
     *  operationId="getRenders",
     *  summary="Get all Renders",
     *  description="Get all Renders",
     *  tags={"Renders"},
     *  path="/api/render/get",
     *  @OA\RequestBody(),
     *  @OA\Response(response="200",description="Get Renders",
     *     @OA\JsonContent(
     *      @OA\Property(
     *       title="data",
     *       property="data",
     *       type="object",
     *       ref="#/components/schemas/Render"
     *      ),
     *    ),
     *  ),
     *  @OA\Response(response=422,description="Validation exception"),
     * )
     *
     * @param Request $request
     * @return JsonResponse
     * @throws ValidationException
     */
    public function get(Request $request)
    {
        $paginator = $this->model->with('languages')->with('translations')->paginate($request->get('limit', config('app.pagination_limit')));
        if ($request->has('limit')) {
            $paginator->appends('limit', $request->get('limit'));
        }

        return fractal($paginator, new RenderTransformer())->respond();
    }

    /**
     * @OA\Patch(
     *  operationId="patchRender",
     *  summary="Update Render",
     *  description="Update Render",
     *  tags={"Renders"},
     *  path="/api/render/patch/{id}",
     *  @OA\Parameter (
     *          parameter="id",
     *          name="id",
     *          description="The ID to patch",
     *          @OA\Schema(
     *              type="integer"
     *          ),
     *          in="path",
     *          required=true
     *  ),
     *  @OA\RequestBody(
     *    description="Render to store",
     *    required=true,
     *    @OA\MediaType(
     *      mediaType="application/json",
     *      @OA\Schema(
     *      @OA\Property(type="string",description="render Text",title="render",property="render",example="Bohužel, stránka se nepodařila načíst.")
     *     )
     *    ),
     *  ),
     *  @OA\Response(response="201",description="Translation patched",
     *     @OA\JsonContent(
     *      @OA\Property(
     *       title="data",
     *       property="data",
     *       type="object",
     *       ref="#/components/schemas/Translation"
     *      ),
     *    ),
     *  ),
     *  @OA\Response(response=422,description="Validation exception"),
     * )
     *
     * @param Request $request
     * @return JsonResponse
     * @throws ValidationException
     */
    public function patch(Request $request, $id)
    {
        $translation = $this->model->where('id', $id)->firstOrFail();
        $this->validate($request, [
            'render' => 'required'
        ]);
        $translation->update($request->toArray());
        return fractal($translation, new RenderTransformer())->respond();
    }

}
