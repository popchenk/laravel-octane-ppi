<?php

namespace App\Transformers\Translations;

use App\Models\Render;
use App\Models\Translation;
use App\Transformers\Languages\LanguageTransformer;
use App\Transformers\Render\RenderTransformer;
use Illuminate\Support\Facades\Log;
use League\Fractal\TransformerAbstract;

/**
 *
 */
class TranslationTransformer extends TransformerAbstract
{

    protected $defaultIncludes = ['renders'];

    /**
     * @param Translation $model
     * @return array
     */
    public function transform(Translation $model)
    {
        return [
            'id' => $model->id,
            'name' => $model->name,
            'abbreviation' => $model->abbreviation
        ];
    }

    public function includeRenders(Translation $model)
    {
        return $this->collection($model->renders, new RenderTransformer());
    }


}
