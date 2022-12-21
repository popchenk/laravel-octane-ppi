<?php

namespace App\Models;

use App\Support\HasRolesUuid;
use App\Support\HasSocialLogin;
use App\Support\UuidScopeTrait;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

/**
 * @OA\Schema(
 *   description="Translation model",
 *   title="Translation",
 *   required={},
 *   @OA\Property(type="integer",description="id of Translation",title="id",property="id",example="1",readOnly="true"),
 *   @OA\Property(type="string",description="name of Translation",title="name",property="name",example="Error 404 page"),
 *   @OA\Property(type="string",description="what will be Rendered",title="render",property="render"),
 *   @OA\Property(type="integer",description="id of Language",title="language_id",property="language_id",example="1")
 * )
 *
 * @OA\Schema(
 *   schema="Translations",
 *   title="Translations",
 *   @OA\Property(title="data",property="data",type="array",
 *     @OA\Items(type="object",ref="#/components/schemas/Translation"),
 *   )
 * )
 *
 * @OA\Parameter(
 *      parameter="Translation--id",
 *      in="path",
 *      name="Translation_id",
 *      required=true,
 *      description="Id of Translation",
 *      @OA\Schema(
 *          type="integer",
 *          example="1",
 *      )
 * ),
 */
class Translation extends Model
{

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'deleted_at',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'render',
        'language_id'
    ];


    public function languages()
    {
        return $this->belongsTo(Language::class);
    }

    public static function create(array $attributes = []): Model|Builder
    {

        return static::query()->create($attributes);
    }
}
