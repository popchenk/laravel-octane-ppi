<?php

namespace App\Transformers\Exams;

use App\Models\Exam\Answer;
use League\Fractal\TransformerAbstract;

/**
 *
 */
class AnswerTransformer extends TransformerAbstract
{

    /**
     * @param Answer $model
     * @return array
     */
    public function transform(Answer $model)
    {
        return [
            'id' => $model->id,
            'value' => $model->value,
            'correct' => $model->correct
        ];
    }


}
