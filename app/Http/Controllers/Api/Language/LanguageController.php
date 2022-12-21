<?php

namespace App\Http\Controllers\Api\Language;

use App\Http\Controllers\Controller;
use App\Models\Language;
use App\Transformers\Languages\LanguageTransformer;
use App\Transformers\Translations\TranslationTransformer;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use function fractal;

/**
 * Class LanguageController
 * @package  App\Http\Controllers\Api\Translation
 */
class LanguageController extends Controller
{
    protected $model;

    public function __construct(Language $model)
    {
        $this->model = $model;
    }

    /**
     * @OA\Post(
     *  operationId="createLanguage",
     *  summary="Create new Language",
     *  description="Create new Language",
     *  tags={"Languages"},
     *  path="/api/language/store",
     *  @OA\RequestBody(
     *    description="Language to store",
     *    required=true,
     *    @OA\MediaType(
     *      mediaType="application/json",
     *      @OA\Schema(
     *      @OA\Property(type="integer",description="id of Language",title="id",property="id",example="1",readOnly="true"),
     *      @OA\Property(type="string",description="name of Language",title="name",property="name",example="Czech"),
     *      @OA\Property(type="string",description="abbreviation of Language",title="abbreviation",property="abbreviation",example="CZ")
     *     )
     *    )
     *  ),
     *  @OA\Response(response="201",description="Language stored",
     *     @OA\JsonContent(
     *      @OA\Property(
     *       title="data",
     *       property="data",
     *       type="object",
     *       ref="#/components/schemas/Language"
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
            'abbreviation' => 'required'
        ]);
        $language = $this->model->create($request->all());

        return fractal($language, new LanguageTransformer())->respond(201);
    }

    /**
     * @OA\Get(
     *  operationId="getLanguages",
     *  summary="Get all Languages",
     *  description="Get all Languages",
     *  tags={"Languages"},
     *  path="/api/language/get",
     *  @OA\RequestBody(),
     *  @OA\Response(response="200",description="Get Languages",
     *     @OA\JsonContent(
     *      @OA\Property(
     *       title="data",
     *       property="data",
     *       type="object",
     *       ref="#/components/schemas/Language"
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
        $paginator = $this->model->with('translations')->paginate($request->get('limit', config('app.pagination_limit')));
        if ($request->has('limit')) {
            $paginator->appends('limit', $request->get('limit'));
        }

        return fractal($paginator, new LanguageTransformer())->respond();
    }


}
