<?php

namespace App\Http\Controllers\Api\Translation;

use App\Http\Controllers\Controller;
use App\Models\Translation;
use App\Transformers\Translations\TranslationTransformer;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use function fractal;

/**
 * Class RegisterController
 * @package  App\Http\Controllers\Api\Auth
 */
class TranslationController extends Controller
{
    protected $model;

    public function __construct(Translation $model)
    {
        $this->model = $model;
    }

    /**
     * @OA\Post(
     *  operationId="createTranslation",
     *  summary="Create new Translation",
     *  description="Create new Translation",
     *  tags={"Translations"},
     *  path="/api/translation/store",
     *  @OA\RequestBody(
     *    description="Translation to store",
     *    required=true,
     *    @OA\MediaType(
     *      mediaType="application/json",
     *      @OA\Schema(
     *      @OA\Property(type="integer",description="id of Translation",title="id",property="id",example="1",readOnly="true"),
     *      @OA\Property(type="string",description="name of Translation",title="name",property="name",example="Error 404 page"),
     *      @OA\Property(type="string",description="render Text",title="render",property="render",example="Bohužel, stránka se nepodařila načíst."),
     *      @OA\Property(type="integer",description="id of Language",title="language_id",property="language_id",example="1")
     *     )
     *    )
     *  ),
     *  @OA\Response(response="201",description="Translation stored",
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
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'render' => 'required',
            'language_id' => 'required'
        ]);
        $translation = $this->model->create($request->all());

        return fractal($translation, new TranslationTransformer())->respond(201);
    }

    /**
     * @OA\Get(
     *  operationId="getTranslations",
     *  summary="Get all Translations",
     *  description="Get all Translation",
     *  tags={"Translations"},
     *  path="/api/translation/get",
     *  @OA\RequestBody(),
     *  @OA\Response(response="200",description="Get Translations",
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
    public function get(Request $request)
    {
        $paginator = $this->model->with('languages')->paginate($request->get('limit', config('app.pagination_limit')));
        if ($request->has('limit')) {
            $paginator->appends('limit', $request->get('limit'));
        }

        return fractal($paginator, new TranslationTransformer())->respond();
    }

    /**
     * @OA\Patch(
     *  operationId="patchTranslation",
     *  summary="Update Translation",
     *  description="Update Translation",
     *  tags={"Translations"},
     *  path="/api/translation/patch/{id}",
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
     *    description="Translation to store",
     *    required=true,
     *    @OA\MediaType(
     *      mediaType="application/json",
     *      @OA\Schema(
     *      @OA\Property(type="string",description="name of Translation",title="name",property="name",example="Error 404 page"),
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
            'name' => 'required',
            'render' => 'required'
        ]);
        $translation->update($request->toArray());
        return fractal($translation, new TranslationTransformer())->respond();
    }

}
