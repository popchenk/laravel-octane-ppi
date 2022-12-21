<?php

namespace App\Transformers\Translations;

use App\Models\Translation;
use League\Fractal\TransformerAbstract;

/**
 * Class UserTransformer.
 */
class TranslationTransformer extends TransformerAbstract
{

    /**
     * @param Translation $model
     * @return array
     */
    public function transform(Translation $model)
    {
        return [
            'id' => $model->id,
            'name' => $model->name,
            'render' => $model->render
        ];
    }

}
