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
 *   description="Language model",
 *   title="Language",
 *   required={},
 *   @OA\Property(type="integer",description="id of Language",title="id",property="id",example="1",readOnly="true"),
 *   @OA\Property(type="string",description="name of Language",title="name",property="name",example="Czech"),
 *   @OA\Property(type="string",description="abbreviation of Language",title="abbreviation",property="CZ")
 * )
 *
 * @OA\Schema(
 *   schema="Languages",
 *   title="Languages",
 *   @OA\Property(title="data",property="data",type="array",
 *     @OA\Items(type="object",ref="#/components/schemas/Language"),
 *   )
 * )
 *
 * @OA\Parameter(
 *      parameter="Language--id",
 *      in="path",
 *      name="Language_id",
 *      required=true,
 *      description="Id of Language",
 *      @OA\Schema(
 *          type="integer",
 *          example="1",
 *      )
 * ),
 */
class Language extends Model
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
        'abbreviation'
    ];

    public function translations()
    {
        return $this->hasMany(Translation::class);
    }

    public static function create(array $attributes = []): Model|Builder
    {

        return static::query()->create($attributes);
    }
}
