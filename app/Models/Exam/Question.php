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
 *   description="Question model",
 *   title="Page",
 *   required={},
 *   @OA\Property(type="integer",description="id of Question",title="id",property="id",example="1",readOnly="true"),
 *   @OA\Property(type="string",description="name of Question",title="name",property="name",example="Růžová anglicky"),
 *   @OA\Property(type="integer",description="id of Page",title="page_id",property="page_id",example="1"),
 *   @OA\Property(
 *   property="answers",
 *   ref="#/components/schemas/Answers"
 *   )
 * )
 *
 * @OA\Schema(
 *   schema="Questions",
 *   title="Questions",
 *   @OA\Property(title="data",property="data",type="array",
 *     @OA\Items(type="object",ref="#/components/schemas/Question"),
 *   )
 * )
 *
 * @OA\Parameter(
 *      parameter="Question--id",
 *      in="path",
 *      name="Question_id",
 *      required=true,
 *      description="Id of Question",
 *      @OA\Schema(
 *          type="integer",
 *          example="1",
 *      )
 * ),
 */
class Question extends Model
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
        'page_id'
    ];

    public function answers(): HasMany
    {
        return $this->hasMany(Answer::class);
    }

    public static function create(array $attributes = []): Model|Builder
    {

        return static::query()->create($attributes);
    }
}
