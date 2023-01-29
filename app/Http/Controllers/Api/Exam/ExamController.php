<?php

namespace App\Http\Controllers\Api\Exam;

use App\Http\Controllers\Controller;
use App\Models\Exam\Answer;
use App\Models\Exam\Exam;
use App\Models\Exam\Page;
use App\Models\Exam\Question;
use App\Transformers\Exams\ExamTransformer;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Symfony\Component\ErrorHandler\Debug;
use function fractal;

/**
 * Class ExamController
 * @package  App\Http\Controllers\Api\Translation
 */
class ExamController extends Controller
{

    public function __construct(protected Exam $examModel, protected Page $pageModel, protected Question $questionModel, protected Answer $answerModel)
    {
    }

    /**
     * @OA\Post(
     *  operationId="createExam",
     *  summary="Create new Exam",
     *  description="Create new Exam",
     *  tags={"Exams"},
     *  path="/api/exam/store",
     *  @OA\RequestBody(
     *    description="Exam to store",
     *    required=true,
     *    @OA\MediaType(
     *      mediaType="application/json",
     *      @OA\Schema(
     *      @OA\Property(
     *      property="exam",
     *      ref="#/components/schemas/Exam"
     *      )
     *     ),
     *    ),
     *  ),
     *  @OA\Response(response="201",description="Exam stored",
     *     @OA\JsonContent(
     *      @OA\Property(
     *       title="data",
     *       property="data",
     *       type="object",
     *       ref="#/components/schemas/Exam"
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
    public function store(Request $request): JsonResponse
    {
        $this->validate($request, [
            'exam.name' => 'required',
            'exam.pages.data.*.name' => 'required',
            'exam.pages.data.*.content' => 'required',
            'exam.pages.data.*.questions.data.*.name' => 'required',
            'exam.pages.data.*.questions.data.*.answers.data.*.value' => 'required',
            'exam.pages.data.*.questions.data.*.answers.data.*.correct' => 'required'
        ]);
        $exam = $this->examModel->create(
            $request['exam']
        );
        foreach($request['exam']['pages']['data'] as $page){
            $pageMod = $exam->pages()->create($page);
            foreach($page['questions']['data'] as $question){
                $questionMod = $pageMod->questions()->create($question);
                foreach($question['answers']['data'] as $answer){
                    $answerMod = $questionMod->answers()->create($answer);
                }
            }
        }

        return fractal($exam, new ExamTransformer())->respond(201);
    }


    /**
     * @OA\Get(
     *  operationId="getExams",
     *  summary="Get all Exams",
     *  description="Get all Exams",
     *  tags={"Exams"},
     *  path="/api/exam/get",
     *  @OA\RequestBody(),
     *  @OA\Response(response="200",description="Get Exams",
     *     @OA\JsonContent(
     *      @OA\Property(
     *       title="data",
     *       property="data",
     *       type="object",
     *       ref="#/components/schemas/Exam"
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
        $paginator = $this->examModel->with('pages')->paginate($request->get('limit', config('app.pagination_limit')));
        if ($request->has('limit')) {
            $paginator->appends('limit', $request->get('limit'));
        }

        return fractal($paginator, new ExamTransformer())->respond();
    }

    /**
     * @OA\Get(
     *  operationId="getExamsByName",
     *  summary="Get all Exams by name",
     *  description="Get all Exams by name",
     *  tags={"Exams"},
     *  path="/api/exam/get-by-name/{name}",
     *  @OA\Parameter (
     *      parameter="name",
     *      name="name",
     *      description="The name to patch",
     *      @OA\Schema(
     *          type="string"
     *      ),
     *      in="path",
     *      required=true
     *  ),
     *  @OA\RequestBody(),
     *  @OA\Response(response="200",description="Get Exams by name",
     *     @OA\JsonContent(
     *      @OA\Property(
     *       title="data",
     *       property="data",
     *       type="object",
     *       ref="#/components/schemas/Exam"
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
    public function getByName(Request $request, $name){
        $paginator = $this->examModel->where('name', $name)->first()->with('pages')->paginate($request->get('limit', config('app.pagination_limit')));
        if ($request->has('limit')) {
            $paginator->appends('limit', $request->get('limit'));
        }

        return fractal($paginator, new ExamTransformer())->respond();
    }

    /**
     * @OA\Patch(
     *  operationId="patchExam",
     *  summary="Update Exam",
     *  description="Update Exam",
     *  tags={"Exams"},
     *  path="/api/exam/patch/{id}",
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
     *    description="Exam to store",
     *    required=true,
     *    @OA\MediaType(
     *      mediaType="application/json",
     *      @OA\Schema(
     *      @OA\Property(
     *      property="exam",
     *      ref="#/components/schemas/Exam"
     *      )
     *     ),
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
    public function patch(Request $request, $id){
        $this->validate($request, [
            'exam.name' => 'required',
            'exam.pages.data.*.name' => 'required',
            'exam.pages.data.*.content' => 'required',
            'exam.pages.data.*.questions.data.*.name' => 'required',
            'exam.pages.data.*.questions.data.*.answers.data.*.value' => 'required',
            'exam.pages.data.*.questions.data.*.answers.data.*.correct' => 'required'
        ]);
        $exam = $this->examModel->where('id', $id)->firstOrFail();
        $exam->update(
            $request['exam']
        );
        Log::debug($exam->id);
        $pages = $this->pageModel->where('exam_id', $exam->id)->get();
        Log::debug($pages);
        foreach($request['exam']['pages']['data'] as $pageKey => $page){
            $pageModify = $page;
            unset($pageModify['questions']);
            if(isset($pages[$pageKey])){
                $pageMod = $pages[$pageKey]->update($pageModify);
            } else{
                $pageMod = $this->pageModel->create($pageModify);
            }
            $questions = $this->questionModel->where('page_id', $pages[$pageKey]->id)->get();
            foreach($page['questions']['data'] as $questionKey => $question){
                $questionModify = $question;
                unset($questionModify['answers']);
                if(isset($pages[$pageKey])){
                    $questionMod = $questions[$questionKey]->update($questionModify);
                } else{
                    $questionMod = $this->questionModel->create($questionModify);
                }
                $answers = $this->questionModel->where('question_id', $questions[$questionKey]->id)->get();
                foreach($question['answers']['data'] as $answerKey => $answer){
                    if(isset($pages[$pageKey])){
                        $answerMod = $answers[$answerKey]->update($answer);
                    } else{
                        $answerMod = $this->answerModel->create($answer);
                    }
                }
            }
        }

        return fractal($exam, new ExamTransformer())->respond(201);
    }


}
