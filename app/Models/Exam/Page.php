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
 *   description="Page model",
 *   title="Page",
 *   required={},
 *   @OA\Property(type="integer",description="id of Page",title="id",property="id",example="1",readOnly="true"),
 *   @OA\Property(type="string",description="name of Page",title="name",property="name",example="stránka 1"),
 *   @OA\Property(type="string",description="content of Page",title="content",property="content",example="yesyeys"),
 *   @OA\Property(type="integer",description="id of Exam",title="exam_id",property="exam_id",example="1"),
 *   @OA\Property(
 *   property="questions",
 *   ref="#/components/schemas/Questions"
 *   )
 * )
 *
 * @OA\Schema(
 *   schema="Pages",
 *   title="Pages",
 *   @OA\Property(title="data",property="data",type="array",
 *     @OA\Items(type="object",ref="#/components/schemas/Page"),
 *   )
 * )
 *
 * @OA\Parameter(
 *      parameter="Page--id",
 *      in="path",
 *      name="Page_id",
 *      required=true,
 *      description="Id of Page",
 *      @OA\Schema(
 *          type="integer",
 *          example="1",
 *      )
 * ),
 */
class Page extends Model
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
        'content',
        'exam_id'
    ];

    public function questions(): HasMany
    {
        return $this->hasMany(Question::class);
    }

    public static function create(array $attributes = []): Model|Builder
    {

        return static::query()->create($attributes);
    }
}
