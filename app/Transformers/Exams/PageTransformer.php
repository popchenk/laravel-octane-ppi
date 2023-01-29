<?php

namespace App\Transformers\Exams;

use App\Models\Exam\Page;
use App\Models\Render;
use App\Models\Translation;
use App\Transformers\Languages\LanguageTransformer;
use App\Transformers\Render\RenderTransformer;
use Illuminate\Support\Facades\Log;
use League\Fractal\TransformerAbstract;

/**
 *
 */
class PageTransformer extends TransformerAbstract
{

    protected $defaultIncludes = ['questions'];

    /**
     * @param Page $model
     * @return array
     */
    public function transform(Page $model)
    {
        return [
            'id' => $model->id,
            'name' => $model->name,
            'content' => $model->content
        ];
    }

    public function includeQuestions(Page $model)
    {
        return $this->collection($model->questions, new QuestionTransformer());
    }


}
