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
use Illuminate\Support\Facades\Log;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

/**
 * @OA\Schema(
 *   description="Render model",
 *   title="Render",
 *   required={},
 *   @OA\Property(type="integer",description="id of Render",title="id",property="id",example="1",readOnly="true"),
 *   @OA\Property(type="string",description="text to be Rendered",title="render",property="render",example="Bohužel, stránka se nepodařila načíst."),
 *   @OA\Property(type="integer",description="id of Language",title="language_id",property="language_id"),
 *   @OA\Property(type="integer",description="id of Translation",title="translation_id",property="translation_id")
 * )
 *
 * @OA\Schema(
 *   schema="Renders",
 *   title="Renders",
 *   @OA\Property(title="data",property="data",type="array",
 *     @OA\Items(type="object",ref="#/components/schemas/Render"),
 *   )
 * )
 *
 * @OA\Parameter(
 *      parameter="Render--id",
 *      in="path",
 *      name="Render_id",
 *      required=true,
 *      description="Id of Render",
 *      @OA\Schema(
 *          type="integer",
 *          example="1",
 *      )
 * ),
 */
class Render extends Model
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
        'render',
        'language_id',
        'translation_id'
    ];

    public function translations()
    {
        return $this->belongsTo(Render::class);
    }

    public function languages()
    {
        return $this->belongsTo(Render::class);
    }

    public static function create(array $attributes = []): Model|Builder
    {

        return static::query()->create($attributes);
    }
}
