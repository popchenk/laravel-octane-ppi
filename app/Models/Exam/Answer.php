<?php

namespace App\Models\Exam;

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
 *   description="Answer model",
 *   title="Answer",
 *   required={},
 *   @OA\Property(type="integer",description="id of Answer",title="id",property="id",example="1",readOnly="true"),
 *   @OA\Property(type="string",description="value of Answer",title="value",property="value",example="Pink"),
 *   @OA\Property(type="boolean",description="correct Answer",title="correct",property="correct",example="1"),
 *   @OA\Property(type="integer",description="id of Question",title="question_id",property="question_id",example="1")
 * )
 *
 * @OA\Schema(
 *   schema="Answers",
 *   title="Answers",
 *   @OA\Property(title="data",property="data",type="array",
 *     @OA\Items(type="object",ref="#/components/schemas/Answer"),
 *   )
 * )
 *
 * @OA\Parameter(
 *      parameter="Answer--id",
 *      in="path",
 *      name="Answer_id",
 *      required=true,
 *      description="Id of Answer",
 *      @OA\Schema(
 *          type="integer",
 *          example="1",
 *      )
 * ),
 */
class Answer extends Model
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
        'value',
        'correct',
        'question_id'
    ];

    public static function create(array $attributes = []): Model|Builder
    {

        return static::query()->create($attributes);
    }
}
