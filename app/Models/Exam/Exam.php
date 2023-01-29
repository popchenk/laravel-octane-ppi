<?php

namespace App\Models\Exam;

use App\Support\HasRolesUuid;
use App\Support\HasSocialLogin;
use App\Support\UuidScopeTrait;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

/**
 * @OA\Schema(
 *   description="Exam model",
 *   title="Exam",
 *   required={},
 *   @OA\Property(type="integer",description="id of Exam",title="id",property="id",example="1",readOnly="true"),
 *   @OA\Property(type="string",description="name of Exam",title="name",property="name",example="AJ 1"),
 *   @OA\Property(
 *   property="pages",
 *   ref="#/components/schemas/Pages"
 *   )
 * )
 *
 * @OA\Schema(
 *   schema="Exams",
 *   title="Exams",
 *   @OA\Property(title="data",property="data",type="array",
 *     @OA\Items(type="object",ref="#/components/schemas/Exam"),
 *   )
 * )
 *
 * @OA\Parameter(
 *      parameter="Exam--id",
 *      in="path",
 *      name="Exam_id",
 *      required=true,
 *      description="Id of Exam",
 *      @OA\Schema(
 *          type="integer",
 *          example="1",
 *      )
 * ),
 */
class Exam extends Model
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
        'name'
    ];

    public function pages(): HasMany
    {
        return $this->hasMany(Page::class);
    }

    public static function create(array $attributes = []): Model|Builder
    {

        return static::query()->create($attributes);
    }
}
