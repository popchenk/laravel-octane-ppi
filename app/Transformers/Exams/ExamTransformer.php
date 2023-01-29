<?php

namespace App\Transformers\Exams;

use App\Models\Exam\Exam;
use App\Models\Render;
use App\Models\Translation;
use App\Transformers\Languages\LanguageTransformer;
use App\Transformers\Render\RenderTransformer;
use Illuminate\Support\Facades\Log;
use League\Fractal\TransformerAbstract;

/**
 *
 */
class ExamTransformer extends TransformerAbstract
{

    protected $defaultIncludes = ['pages'];

    /**
     * @param Exam $model
     * @return array
     */
    public function transform(Exam $model)
    {
        return [
            'id' => $model->id,
            'name' => $model->name
        ];
    }

    public function includePages(Exam $model)
    {
        return $this->collection($model->pages, new PageTransformer());
    }


}
