<?php

namespace App\Models;

use App\Support\HasRolesUuid;
use App\Support\HasSocialLogin;
use App\Support\UuidScopeTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

/**
 * @OA\Schema(
 *   description="User model",
 *   title="User",
 *   required={},
 *   @OA\Property(type="integer",description="id of User",title="id",property="id",example="1",readOnly="true"),
 *   @OA\Property(type="string",description="name of User",title="name",property="name",example="Jozef Bugal"),
 *   @OA\Property(type="string",description="email of User",title="email",property="email"),
 *   @OA\Property(type="password",description="password of User",title="password",property="password",example="pass12Erasd"),
 *   @OA\Property(type="password",description="password confirmation of User",title="password_confirmation",property="password_confirmation",example="pass12Erasd")
 * )
 *
 * @OA\Schema(
 *   schema="Users",
 *   title="Users",
 *   @OA\Property(title="data",property="data",type="array",
 *     @OA\Items(type="object",ref="#/components/schemas/User"),
 *   )
 * )
 *
 * @OA\Parameter(
 *      parameter="User--id",
 *      in="path",
 *      name="User_id",
 *      required=true,
 *      description="Id of User",
 *      @OA\Schema(
 *          type="integer",
 *          example="1",
 *      )
 * ),
 */
class User extends Authenticatable
{
    use Notifiable, UuidScopeTrait, HasFactory, HasApiTokens, HasRoles, SoftDeletes, HasSocialLogin, HasRolesUuid {
        HasRolesUuid::getStoredRole insteadof HasRoles;
    }

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
        'uuid',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function socialProviders()
    {
        return $this->hasMany(SocialProvider::class);
    }

    public static function create(array $attributes = [])
    {
        if (array_key_exists('password', $attributes)) {
            $attributes['password'] = Hash::make($attributes['password']);
        }

        $model = static::query()->create($attributes);

        return $model;
    }
}
