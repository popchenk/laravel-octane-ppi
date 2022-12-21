<?php

namespace App\Transformers\Languages;

use App\Models\Language;
use App\Transformers\Translations\TranslationTransformer;
use League\Fractal\TransformerAbstract;

/**
 * Class UserTransformer.
 */
class LanguageTransformer extends TransformerAbstract
{

    /**
     * @var array
     */
    protected $defaultIncludes = ['translations'];

    /**
     * @param Language $model
     * @return array
     */
    public function transform(Language $model)
    {
        return [
            'id' => $model->id,
            'name' => $model->name,
            'abbreviation' => $model->abbreviation
        ];
    }

    /**
     * @param Language $model
     * @return \League\Fractal\Resource\Collection
     */
    public function includeTranslations(Language $model)
    {
        return $this->collection($model->translations, new TranslationTransformer());
    }

}
