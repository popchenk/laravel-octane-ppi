<?php

namespace App\Transformers\Render;

use App\Models\Render;
use App\Models\Translation;
use App\Transformers\Languages\LanguageTransformer;
use App\Transformers\Translations\TranslationTransformer;
use Illuminate\Support\Facades\Log;
use League\Fractal\TransformerAbstract;

/**
 * Class UserTransformer.
 */
class RenderTransformer extends TransformerAbstract
{

    /**
     * @param Render $model
     * @return array
     */
    public function transform(Render $model)
    {
        return [
            'id' => $model->id,
            'render' => $model->render,
            'language_id' => $model->language_id,
            'translation_id' => $model->translation_id,
        ];
    }


}
