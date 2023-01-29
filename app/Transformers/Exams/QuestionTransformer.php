<?php

namespace App\Transformers\Exams;

use App\Models\Exam\Question;
use App\Models\Render;
use App\Models\Translation;
use App\Transformers\Languages\LanguageTransformer;
use App\Transformers\Render\RenderTransformer;
use Illuminate\Support\Facades\Log;
use League\Fractal\TransformerAbstract;

/**
 *
 */
class QuestionTransformer extends TransformerAbstract
{

    protected $defaultIncludes = ['answers'];

    /**
     * @param Question $model
     * @return array
     */
    public function transform(Question $model)
    {
        return [
            'id' => $model->id,
            'name' => $model->name,
            'abbreviation' => $model->abbreviation
        ];
    }

    public function includeAnswers(Question $model)
    {
        return $this->collection($model->answers, new AnswerTransformer());
    }


}
